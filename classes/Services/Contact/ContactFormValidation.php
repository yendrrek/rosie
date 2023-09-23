<?php

namespace Rosie\Services\Contact;

use Rosie\Utils\FormValidation;
use Rosie\Utils\Logging;

class ContactFormValidation
{
    public string $generalNotification = '';

    public function __construct(
        private Logging $logging,
        private FormValidation $formValidation,
        public ContactFormErrors $contactFormErrors,
        public ContactFormFields $contactFormFields
    ) {
    }

    private string $messageNotSent = 'Message not sent';

    public function validateContactForm(): bool
    {
        if (!$this->formValidation->validateForm('post', 'Invalid or no token in contact form')) {
            return false;
        }

        return $this->validateFields();
    }

    private function validateFields(): bool
    {
        $isBotSendingMessage = $this->contactFormFields->isBotSendingMessage();
        if ($isBotSendingMessage) {
            $this->logging->logMessage('alert', 'Spam bot trapped in honey pot. Message not sent');
            return false;
        }

        $errors = [
            $this->contactFormErrors->setSenderNameError(),
            $this->contactFormErrors->setSenderEmailAddressError(),
            $this->contactFormErrors->setMessageError()
        ];

        if (in_array(true, $errors)) {
            $this->generalNotification = "$this->messageNotSent, please see below";
            $this->logging->logMessage('info', "$this->messageNotSent." . join('', $this->getFieldErrorForLogging($errors)));
            return false;
        }

        $this->logging->logMessage('info', 'Message validated');
        return true;
    }

    private function getFieldErrorForLogging($errors): array
    {
        $errorsForLogging = [];
        foreach ($errors as $error) {
            if ($error) {
                $errorsForLogging[] = " $error.";
            }
        }
        return $errorsForLogging;
    }
}
