<?php

namespace Rosie\PayPal\PayPalSDK;

use Rosie\Config\DatabaseConnection;
use Rosie\PayPal\PurchaseDatabase;
use Rosie\PayPal\StockUpdate;
use Rosie\PayPal\PurchaseConfirmationEmail;
use Rosie\Utils\Logging;
use Rosie\Utils\NewLogger;
use Rosie\Utils\UserId;

session_start();

require '../../vendor/autoload.php';
require 'paypal-client.php';

$newLogger = new NewLogger();
$userId = new UserId();

$databaseConnection = new DatabaseConnection(
    new Logging($newLogger->injectNewLogger('DatabaseConnection'), $userId)
);
$databaseConnection = $databaseConnection->connectToDb();

$OrderIDJsonRowData = file_get_contents('php://input');
$OrderIDArray = json_decode($OrderIDJsonRowData, true);
$orderId = $OrderIDArray['orderID'];

if (!count(debug_backtrace())) {
    $orderCapture = new OrderCapture(
        new Logging($newLogger->injectNewLogger('CaptureOrder'), $userId)
    );

    if ($orderCapture->captureOrder($orderId)) {
        $stockUpdate = new StockUpdate(
            $databaseConnection,
            new Logging($newLogger->injectNewLogger('StockUpdate'), $userId)
        );
        $stockUpdate->updateStock();

        $purchaseDatabase = new PurchaseDatabase(
            $databaseConnection,
            $orderCapture,
            new Logging($newLogger->injectNewLogger('PurchaseDatabase'), $userId),
            $userId
        );
        $purchaseDatabase->processPurchaseDataInDatabase();

        $customerEmail = new PurchaseConfirmationEmail(
            $orderCapture,
            $stockUpdate,
            new Logging($newLogger->injectNewLogger('PurchaseConfirmationEmail'), $userId)
        );
        $customerEmail->notifyCustomer();
    }
}
