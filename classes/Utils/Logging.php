<?php

namespace Rosie\Utils;

use Monolog\Logger;

// Injects Monolog instance for better reusability
class Logging
{
    public function __construct(
        private Logger $logger,
        private UserId $userId
    ) {
    }

    public function logMessage($messageType, $message): void
    {
        $userId = $this->userId->getUserId();
        $this->logger->$messageType("User id: $userId >> $message");
    }
}
