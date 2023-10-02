<?php

namespace Rosie\Services\Contact;

use JetBrains\PhpStorm\Pure;

class ContactFormDatabaseDataPreparation
{
    public function __construct(private ContactFormFields $contactFormFields)
    {
    }

    #[Pure] public function prepareDataForDatabase(): array
    {
        $senderName = $this->contactFormFields->getSenderName();
        $senderEmailAddress = $this->contactFormFields->getSenderEmailAddress();
        $message = $this->contactFormFields->getMessage();

        return [$senderName, $senderEmailAddress, $message];
    }
}
