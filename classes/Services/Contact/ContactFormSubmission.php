<?php

namespace Rosie\Services\Contact;

use Rosie\Utils\EnvironmentVariables;
use Rosie\Utils\Logging;

class ContactFormSubmission
{
    public string $generalNotification = '';

    public function __construct(
        private Logging $logging,
        private ContactFormFields $contactFormFields
    ) {
    }

    public function sendMessage(): bool
    {
        $senderName = $this->contactFormFields->getSenderName();
        $senderEmailAddress = $this->contactFormFields->getSenderEmailAddress();
        $message = $this->contactFormFields->getMessage();

        $toEmail = EnvironmentVariables::$rosieEmail;
        $subject = 'Website contact form';
        $headers = 'From ' . $senderName . '<' . $senderEmailAddress . '>';

        if (mail($toEmail, $subject, $message, $headers)) {
            $this->generalNotification = 'Message sent. Thank you';
            $this->logging->logMessage('info', 'Message sent');
            return true;
        }

        $this->logging->logMessage('alert', 'Failed sending message from contact form');
        return false;
    }
}
