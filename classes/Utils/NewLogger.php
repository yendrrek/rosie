<?php

namespace Rosie\Utils;

use DateTimeZone;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class NewLogger
{
    public function injectNewLogger($className): Logger
    {
        $logger = new Logger($className, [], [], new DateTimeZone('Europe/London'));
        // Full path as otherwise PayPal files from directory 'scripts/paypal' can't write to 'rosie.log'.
        $logger->pushHandler(new StreamHandler('/home/andrzej/dev/rosie/log/rosie.log', Logger::INFO));
        return $logger;
    }
}
