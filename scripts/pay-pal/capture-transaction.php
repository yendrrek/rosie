<?php

namespace Rosie\PayPal\PayPalSDK;

use Rosie\Config\DatabaseConnection;
use Rosie\PayPal\OrderInsertionIntoDatabase;
use Rosie\PayPal\PurchaseConfirmationEmail;
use Rosie\Utils\Logging;
use Rosie\Utils\NewLogger;

session_start();

require '../../vendor/autoload.php';
require 'paypal-client.php';

$newLogger = new NewLogger();

$dbConn = new DatabaseConnection(
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class DatabaseConnection'))
);
$dbConn = $dbConn->connectToDb();

$OrderIDJsonRowData = file_get_contents('php://input');
$OrderIDArray = json_decode($OrderIDJsonRowData, true);
$orderId = $OrderIDArray['orderID'];

if (!count(debug_backtrace())) {
    $captureOrder = new CaptureOrder(
        new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class CaptureOrder'))
    );
    $captureOrder->captureOrder($orderId);

    $orderInsertionDb = new OrderInsertionIntoDatabase(
        $dbConn,
        $captureOrder,
        new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class OrderInsertionIntoDatabase'))
    );
    $orderInsertionDb->insertOrderIntoDatabase();

    $customerEmail = new PurchaseConfirmationEmail(
        $captureOrder,
        $orderInsertionDb,
        new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class PurchaseConfirmationEmail'))
    );
    $customerEmail->notifyCustomer();
}
