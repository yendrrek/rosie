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
        $logger->pushHandler(new StreamHandler(EnvironmentVariables::$logFilePath, Logger::INFO));
        return $logger;
    }
}
