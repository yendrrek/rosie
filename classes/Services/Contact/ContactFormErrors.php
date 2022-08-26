<?php

namespace Rosie\Services\Contact;

class ContactFormErrors
{
    public function __construct(public ContactFormFields $contactFormFields)
    {
    }

    public function setSenderNameError(): string
    {
        if ($this->isContactFormFieldEmpty($this->contactFormFields->getSenderName())) {
            return false;
        }

        $pattern = "/^[A-Za-z .,'-]+$/";
        return $this->setInvalidCharactersError(
            'preg_match',
            $pattern,
            $this->contactFormFields->getSenderName(),
            'Name contains invalid characters'
        );
    }

    public function setSenderEmailAddressError(): string
    {
        if ($this->isContactFormFieldEmpty($this->contactFormFields->getSenderEmailAddress())) {
            return false;
        }

        return $this->setInvalidCharactersError(
            'filter_var',
            FILTER_VALIDATE_EMAIL,
            $this->contactFormFields->getSenderEmailAddress(),
            'Email is invalid'
        );
    }

    public function setMessageError(): string
    {
        if ($this->isContactFormFieldEmpty($this->contactFormFields->getMessage())) {
            return false;
        }

        $pattern = '/^[A-Za-z\d_: .,;!?@\'’“+()-]+$/m';
        return $this->setInvalidCharactersError(
            'preg_match',
            $pattern,
            $this->contactFormFields->getMessage(),
            'Message contains invalid characters'
        );
    }

    private function isContactFormFieldEmpty($field): bool
    {
        return !$field ?? true;
    }

    private function setInvalidCharactersError($validationMethod, $validationType, $fieldContent, $errorMessage): string
    {
        $parametersList = [$fieldContent, $validationType];
        $parametersApplied = ($validationMethod == 'filter_var') ? $parametersList : array_reverse($parametersList);
        if (!$validationMethod($parametersApplied[0], $parametersApplied[1])) {
            return $errorMessage;
        }
        return false;
    }
}
