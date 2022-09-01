<?php

namespace Rosie\Services\Contact;

use PDO;
use Rosie\Utils\Logging;
use Rosie\Utils\UserId;

class ContactFormDatabase
{
    public function __construct(
        private PDO $pdo,
        private Logging $logging,
        private ContactFormDatabaseDataPreparation $contactFormDatabaseDataPreparation,
        private UserId $userId
    ) {
    }

    public function insertContactFormDataIntoDatabase(): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO contactForm(userId, senderName, senderEmailAddress, message)
            VALUES (:userId, :senderName, :senderEmailAddress, :message)');

        $contactFormData = [
            ':userId' => $this->userId->getUserId(),
            ':senderName' => $this->contactFormDatabaseDataPreparation->prepareDataForDatabase()[0],
            ':senderEmailAddress' => $this->contactFormDatabaseDataPreparation->prepareDataForDatabase()[1],
            ':message' => $this->contactFormDatabaseDataPreparation->prepareDataForDatabase()[2]
        ];

        foreach ($contactFormData as $parameter => &$value) {
            $stmt->bindParam($parameter, $value);
        }

        $stmt->execute();
        $this->logging->logMessage('info', 'Message stored in database');
        $stmt = null;
    }
}
