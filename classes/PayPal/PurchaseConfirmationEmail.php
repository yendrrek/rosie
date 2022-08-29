<?php

namespace Rosie\PayPal;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Rosie\PayPal\PayPalSDK\CaptureOrder;
use Rosie\Utils\EnvironmentVariables;
use Rosie\Utils\Logging;

class PurchaseConfirmationEmail
{
    public function __construct(
        public CaptureOrder $captureOrder,
        public StockUpdate $orderInsertionIntoDatabase,
        private Logging $logging
    ) {
    }

    public function notifyCustomer(): void
    {
        EnvironmentVariables::getEnvVars();

        $payPalEnvironment = EnvironmentVariables::$payPalEnvironment;
        $sellerEmail = EnvironmentVariables::$sellerEmail;
        $sellerPhone = EnvironmentVariables::$sellerPhone;
        $sellerMobile = EnvironmentVariables::$sellerMobile;

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
        if ($payPalEnvironment === 'production') {
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.co.uk';
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = EnvironmentVariables::$sellerEmailUsername;
            $mail->Password = EnvironmentVariables::$sellerEmailPassword;
        }

        try {
            $mail->setFrom($sellerEmail, 'Rosie Piontek Art');
            if ($payPalEnvironment === 'production') {
                $mail->addAddress($this->captureOrder->buyerEmail, $this->captureOrder->buyerName);
            } elseif ($payPalEnvironment === 'sandbox') {
                $mail->addAddress('testRosie@protonmail.com', $this->captureOrder->buyerName);
            }
            $mail->addReplyTo($sellerEmail, 'Rosie Piontek Art');
            $mail->isHTML();
            $mail->Subject = 'Purchase confirmation from Rosie Piontek Art. Order ID: ' . $this->captureOrder->orderId;
            ob_start();
            include '/home/andrzej/dev/rosie/views/purchase-confirmation-email.php';
            $mail->Body = ob_get_clean();
            $mail->AltBody = 'Confirmation is in plain text for non-HTML email readers.';
            $mail->send();
            // https://github.com/PHPMailer/PHPMailer/blob/master/examples/exceptions.phps
        } catch (Exception $prettyPHPMailerErrorMessage) {
            $this->logging->logMessage('alert', $prettyPHPMailerErrorMessage->errorMessage());
        } catch (\Exception $standardErrorMessage) {
            $this->logging->logMessage('alert', $standardErrorMessage->getMessage());
        }
    }
}
