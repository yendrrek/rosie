<?php

namespace Rosie\PayPal;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Rosie\PayPal\PayPalSDK\OrderCapture;
use Rosie\Utils\EnvironmentVariables;
use Rosie\Utils\Logging;

class PurchaseConfirmationEmail
{
    public function __construct(
        public OrderCapture $orderCapture,
        public StockUpdate $orderInsertionIntoDatabase,
        private Logging $logging
    ) {
    }

    public function notifyCustomer(): void
    {
        EnvironmentVariables::getEnvVars();
        $payPalEnvironment = EnvironmentVariables::$environment;
        $sellerEmail = EnvironmentVariables::$sellerEmail;
        $sellerPhone = EnvironmentVariables::$sellerPhone;
        $sellerMobile = EnvironmentVariables::$sellerMobile;
        $host = EnvironmentVariables::$emailHost;
        $toEmail = EnvironmentVariables::$rosieEmail;

        $itemsDetails = $items = $products = $subtotal = $qtyArray = [];
        $amount = $totalQty = 0;

        if (!empty($_SESSION['itemsDetails'])) {
            foreach ($_SESSION['itemsDetails'] as $productDetail) {
                $product['name'] = $productDetail['name'];
                $product['qty'] = $productDetail['quantity'];
                $product['value'] = $productDetail['unit_amount']['value'];
                $products[] = $product;
            }
            $items[] = $products; // $items[] is used in purchase-confirmation-email.php
        }
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'TLS';
            $mail->Port = 587;
            $mail->Username = EnvironmentVariables::$emailUserName;
            $mail->Password = EnvironmentVariables::$emailPassword;
            $mail->setFrom($sellerEmail, 'Rosie Piontek Art');
            if ($payPalEnvironment === 'production') {
                $mail->addAddress($this->orderCapture->buyerEmail, $this->orderCapture->buyerName);
            } elseif ($payPalEnvironment === 'sandbox') {
                $mail->addAddress($toEmail, $this->orderCapture->buyerName);
            }
            $mail->addReplyTo($sellerEmail, 'Rosie Piontek Art');
            $mail->isHTML();
            $mail->Subject = 'Purchase confirmation from Rosie Piontek Art. Order ID: ' . $this->orderCapture->orderId;
            ob_start();
            include EnvironmentVariables::$purchaseConfirmationEmailPath . 'purchase-confirmation-email.php';
            $mail->Body = ob_get_clean();
            $mail->AltBody = 'Confirmation is in plain text for non-HTML email readers.';
            $mail->send();
        } catch (Exception $prettyPHPMailerErrorMessage) {
            $this->logging->logMessage('alert', $prettyPHPMailerErrorMessage->errorMessage());
        } catch (\Exception $standardErrorMessage) {
            $this->logging->logMessage('alert', $standardErrorMessage->getMessage());
        }
    }
}
