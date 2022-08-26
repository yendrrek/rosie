<?php

namespace Rosie\Utils;

use Monolog\Logger;

// Injects Monolog instance for better reusability
class Logging
{
    public function __construct(private Logger $logger)
    {
    }

    public function logMessage($messageType, $message): void
    {
        $userId = UserId::setUserId();
        $this->logger->$messageType("User id: $userId >> $message");
    }
}
