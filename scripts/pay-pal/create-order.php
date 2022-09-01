<?php

namespace Rosie\PayPal\PayPalSDK;

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Rosie\Utils\Logging;
use Rosie\Utils\NewLogger;
use Rosie\Utils\UserId;

session_start();

require '../../vendor/autoload.php';
require 'paypal-client.php';

$newLogger = new NewLogger();

if (!count(debug_backtrace())) {
    $createOrder = new OrderCreation(
        new OrdersCreateRequest(),
        new Logging(
            $newLogger->injectNewLogger('OrderCreation'),
            new UserId()
        )
    );
    $createOrder->getOrder();
}
