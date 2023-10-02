<?php

namespace Rosie\DependenciesContainers;

use Rosie\Services\Contact\ContactFormDatabase;
use Rosie\Services\Contact\ContactFormSubmission;
use Rosie\Services\Contact\ContactFormValidation;
use Rosie\Services\ContentDatabaseQuery\ContentDatabaseQuery;
use Rosie\Utils\Token;

class ContactDepCont
{
    public string $generalNotification = '';

    public function __construct(
        private ContentDatabaseQuery $contentDatabaseQuery,
        public Token $token,
        public ContactFormValidation $contactFormValidation,
        private ContactFormSubmission $contactFormSubmission,
        private ContactFormDatabase $contactFormDatabase
    ) {
    }

    public function runDependencies(): void
    {
        $isValidatedContactForm = $this->contactFormValidation->validateContactForm();
        $this->generalNotification = $this->contactFormValidation->generalNotification;
        if ($isValidatedContactForm) {
            $isSentMessage = $this->contactFormSubmission->sendMessage();
            $this->generalNotification = $this->contactFormSubmission->generalNotification;
            if ($isSentMessage) {
                $this->contactFormDatabase->insertContactFormDataIntoDatabase();
            }
        }
    }
}
