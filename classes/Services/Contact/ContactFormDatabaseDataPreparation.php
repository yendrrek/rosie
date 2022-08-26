<?php

namespace Rosie\Services\Contact;

class ContactFormDatabaseDataPreparation
{
    public function __construct(private ContactFormFields $contactFormFields)
    {
    }

    public function prepareDataForDatabase(): array
    {
        $senderName = $this->contactFormFields->getSenderName();
        $senderEmailAddress = $this->contactFormFields->getSenderEmailAddress();
        $message = $this->contactFormFields->getMessage();

        return [$senderName, $senderEmailAddress, $message];
    }
}
