<?php

namespace Rosie\Utils;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class NewLogger
{
    public function injectNewLogger($name): Logger
    {
        $logger = new Logger($name);
        // Full path as otherwise PayPal files from directory 'scripts/paypal' can't write to 'rosie.log'.
        $logger->pushHandler(new StreamHandler('/home/andrzej/dev/rosie/log/rosie.log', Logger::INFO));
        return $logger;
    }
}
