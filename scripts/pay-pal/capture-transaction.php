<?php

namespace Rosie\PayPal\PayPalSDK;

use Rosie\Config\DatabaseConnection;
use Rosie\PayPal\PurchaseDatabase;
use Rosie\PayPal\StockUpdate;
use Rosie\PayPal\PurchaseConfirmationEmail;
use Rosie\Utils\Logging;
use Rosie\Utils\NewLogger;

session_start();

require '../../vendor/autoload.php';
require 'paypal-client.php';

$newLogger = new NewLogger();

$databaseConnection = new DatabaseConnection(
    new Logging($newLogger->injectNewLogger('DatabaseConnection'))
);
$databaseConnection = $databaseConnection->connectToDb();

$OrderIDJsonRowData = file_get_contents('php://input');
$OrderIDArray = json_decode($OrderIDJsonRowData, true);
$orderId = $OrderIDArray['orderID'];

if (!count(debug_backtrace())) {
    $captureOrder = new CaptureOrder(
        new Logging($newLogger->injectNewLogger('CaptureOrder'))
    );

    if ($captureOrder->captureOrder($orderId)) {
        $stockUpdate = new StockUpdate(
            $databaseConnection,
            new Logging($newLogger->injectNewLogger('StockUpdate'))
        );
        $stockUpdate->updateStock();

        $purchaseDatabase = new PurchaseDatabase(
            $databaseConnection,
            $captureOrder,
            new Logging($newLogger->injectNewLogger('PurchaseDatabase'))
        );
        $purchaseDatabase->processPurchaseDataInDatabase();

        $customerEmail = new PurchaseConfirmationEmail(
            $captureOrder,
            $stockUpdate,
            new Logging($newLogger->injectNewLogger('PurchaseConfirmationEmail'))
        );
        $customerEmail->notifyCustomer();
    }
}
