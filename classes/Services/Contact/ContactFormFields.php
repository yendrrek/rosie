<?php

namespace Rosie\Services\Contact;

class ContactFormFields
{
    public function getSenderName(): string
    {
        return !empty($_POST['senderName']) ? $this->sanitize($_POST['senderName']) : false;
    }

    public function getSenderEmailAddress(): string
    {
        return !empty($_POST['senderEmail']) ? $this->sanitize($_POST['senderEmail']) : false;
    }

    public function getMessage(): string
    {
        return !empty($_POST['msg']) ? $this->sanitize($_POST['msg']) : false;
    }

    private function sanitize($userInput): string
    {
        return trim(stripslashes(htmlspecialchars($userInput)));
    }
}
