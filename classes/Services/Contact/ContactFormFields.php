<?php

namespace Rosie\Services\Contact;

use JetBrains\PhpStorm\Pure;

class ContactFormFields
{
    #[Pure] public function getSenderName(): string
    {
        return !empty($_POST['senderName']) ? $this->sanitize($_POST['senderName']) : false;
    }

    #[Pure] public function getSenderEmailAddress(): string
    {
        return !empty($_POST['senderEmail']) ? $this->sanitize($_POST['senderEmail']) : false;
    }

    #[Pure] public function getMessage(): string
    {
        return !empty($_POST['msg']) ? $this->sanitize($_POST['msg']) : false;
    }

    #[Pure] public function isBotSendingMessage(): bool
    {
        return !empty($this->sanitize($_POST['website']));
    }

    private function sanitize($userInput): string
    {
        return trim(stripslashes(htmlspecialchars($userInput)));
    }
}
