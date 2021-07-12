<?php
namespace Sample\CaptureIntentExamples;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

session_start();

require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/Exception.php';
require '../PHPMailer/SMTP.php';
require __DIR__ . '/vendor/autoload.php';
require 'paypal-client.php';
require '../config/db-conn.php';

spl_autoload_register(function($classToLoad) {
    $classLoaded = stream_resolve_include_path('../classes/' . $classToLoad . '.php');
    if ($classLoaded !== false) {
        include $classLoaded;
    }
});

$OrderIDjsonRowData = file_get_contents('php://input');
$OrderIDArr = [];
$OrderIDArr = json_decode($OrderIDjsonRowData, true);
$orderId = $OrderIDArr['orderID'];

class CaptureOrder 
{
    public $buyerName;
    public $buyerFullAddress;
    public $buyerEmail;
    public $orderId;
    public $totalPrice;

    
    public function captureOrder($orderId) 
    {
        $request = new OrdersCaptureRequest($orderId);
        
        // Call PayPal to capture an authorization.
        $client = PayPalClient::client();
        $response = $client->execute($request);
        
        $this->orderId = $response->result->id;
        $this->totalPrice = $response->result->purchase_units[0]->payments->captures[0]->amount->value;
        $this->buyerEmail = $response->result->payer->email_address;
        $this->buyerName = $response->result->purchase_units[0]->shipping->name->full_name;
        $this->buyerFirstName = $response->result->payer->name->given_name;
        $this->address1 = $response->result->purchase_units[0]->shipping->address->address_line_1;
        $this->address2 = $response->result->purchase_units[0]->shipping->address->admin_area_2;
        $this->address3 = $response->result->purchase_units[0]->shipping->address->admin_area_1;
        $this->address4 = $response->result->purchase_units[0]->shipping->address->postal_code;
        $this->address5 = $response->result->purchase_units[0]->shipping->address->country_code;
        $this->buyerFullAddress =  $this->address1 . ', ' . $this->address2 . ', ' . $this->address3 . ', ' . $this->address4 . ', ' . $this->address5;
    
        echo json_encode($response->result);
    }
}

class OrderInsertionDb
{
    private $dbc;
    
    public function __construct(\PDO $pdo)
    {
        $this->dbc = $pdo;
    }
    
    public function insertOrderDb(CaptureOrder $captureOrder, \UserId $userId)
    {   
        $itemsDetails = [];

        $this->buyerName = $captureOrder->buyerName;
        $this->buyerFullAddress = $captureOrder->buyerFullAddress;
        $this->buyerEmail = $captureOrder->buyerEmail;
        $this->orderId = $captureOrder->orderId;
        $this->totalPrice = $captureOrder->totalPrice;
        $this->userId = $userId->userId;
        
        if (!empty($_SESSION['itemsDetails'])) {
            foreach ($_SESSION['itemsDetails'] as $productDetail) {
                $stmt = $this->dbc->prepare('UPDATE cards SET stock=stock-:qty WHERE id=:id');
                $stmt->bindParam(':qty', $productDetail['quantity']);
                $stmt->bindParam(':id', $productDetail['id']);
                $stmt->execute();
            }
        }

        $stmt1 = $this->dbc->prepare('INSERT INTO customers (name, userId, address, email, orderId) VALUES (:buyerName, :userId, :buyerFullAddress, :buyerEmail, :orderId)');
        $stmt1->bindParam(':buyerName', $this->buyerName);
        $stmt1->bindParam(':userId', $this->userId);
        $stmt1->bindParam(':buyerFullAddress', $this->buyerFullAddress);
        $stmt1->bindParam(':buyerEmail', $this->buyerEmail);
        $stmt1->bindParam(':orderId', $this->orderId);
        $stmt1->execute();
        
        $stmt2 = $this->dbc->prepare('INSERT INTO orders (userId, orderId, priceGBP) VALUES (:userId, :orderId, :totalPrice)');
        $stmt2->bindParam(':userId', $this->userId);
        $stmt2->bindParam(':orderId', $this->orderId);
        $stmt2->bindParam(':totalPrice', $this->totalPrice);
        $stmt2->execute();

        if ($stmt1 === false && $stmt2 === false && $stmt === false) {
            $this->email = 'Could not insert purchase data into database after successful transaction at www.rosiepiontek.com. PayPal order ID: ' . $this->orderId . '. Purchased products are still in the "basket" table. User ID: ' . $this->userId . '.'; 
            error_log($this->email, 1, 'yendrrek@gmail.com');
        } else {
            $this->dbc->query("CALL removeFromBasket('$this->userId', 0)");
        }

        $stmt = $stmt1 = $stmt2 = $this->dbc = null;
    }
}

class PurchaseConfirmationEmail
{   
    public function notifyCustomer(CaptureOrder $captureOrder, OrderInsertionDb $orderInsertionDb)
    {
        \EnvironmentVariablesValidation::validatePayPalEnvVars();
        $payPalEnvironment = \EnvironmentVariablesValidation::$payPalEnvironment;

        \EnvironmentVariablesValidation::validatePHPMailerEnvVars();
        $sellerEmail = \EnvironmentVariablesValidation::$sellerEmail;
        $sellerPhone = \EnvironmentVariablesValidation::$sellerPhone;
        $sellerMobile = \EnvironmentVariablesValidation::$sellerMobile;
        if ($payPalEnvironment === 'production') {
            $sellerEmailUsername = \EnvironmentVariablesValidation::$sellerEmailUsername;
            $sellerEmailPassword = \EnvironmentVariablesValidation::$sellerEmailPassword;
        }

        $itemsDetails = $items = $products = $subtotal = $qtyArray = [];
        $amount = $totalQty = 0;

        $this->buyerName = $captureOrder->buyerName;
        $this->buyerFirstName = $captureOrder->buyerFirstName;
        $this->buyerFullAddress = $captureOrder->buyerFullAddress;
        $this->orderId = $captureOrder->orderId;
        $this->totalPrice = $captureOrder->totalPrice;
        if ($payPalEnvironment === 'production') {
            $this->buyerEmail = $captureOrder->buyerEmail;
        }
        if (!empty($_SESSION['itemsDetails'])) {
            foreach ($_SESSION['itemsDetails'] as $productDetail) {
                $product['name'] = $productDetail['name'];
                $product['qty'] = $productDetail['quantity'];
                $product['value'] = $productDetail['unit_amount']['value'];  
                $products[] = $product;
            }
            $items[] = $products;
        }
        $mail = new PHPMailer(true);
        if ($payPalEnvironment === 'production') {
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.co.uk';
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = $sellerEmailUsername;
            $mail->Password = $sellerEmailPassword;
        }
        $mail->setFrom($sellerEmail, 'Rosie Piontek Art');
        if ($payPalEnvironment === 'production') {
            $mail->addAddress($this->buyerEmail, $this->buyerName);  
        } elseif ($payPalEnvironment === 'sandbox') {  
            $mail->addAddress('yendrrek@gmail.com', $this->buyerName);
        }  
        $mail->addReplyTo($sellerEmail, 'Rosie Piontek Art');
        $mail->isHTML(true);
        $mail->Subject = 'Purchase confirmation from Rosie Piontek Art. Order ID: ' . $this->orderId;
        ob_start();
        include '../views/purchase-confirmation-email.php';
        $mail->Body = ob_get_clean();
        $mail->AltBody = 'Confirmation is in plain text for non-HTML email readers.'; 
        try {
            $mail->send(); 
        } catch (phpmailerException $e) {
             $mailErrorPretty = $e->errorMessage();
             error_log($mailErrorPretty, 1, 'yendrrek@gmail.com');       
        } catch (Exception $e) {
            $mailError = $e->getMessage();
            error_log($mailError, 1, 'yendrrek@gmail.com');
        }
    }
}

if (!count(debug_backtrace())) {
    $captureOrder = new CaptureOrder();
    $captureOrder->captureOrder($orderId, true);

    $userId = new \UserId();
    $userId->setUserId();
    
    $orderInsertionDb = new OrderInsertionDb($pdo);
    $orderInsertionDb->insertOrderDb($captureOrder, $userId);
    
    $customerEmail = new PurchaseConfirmationEmail();
    $customerEmail->notifyCustomer($captureOrder, $orderInsertionDb);
}
