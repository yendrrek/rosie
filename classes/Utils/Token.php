<?php

namespace Rosie\Utils;

use Exception;

class Token
{
    public function __construct(private Logging $logging)
    {
    }

    public function setPayPalNonces(): string
    {
        try {
            return $_SESSION['noncePayPalSdk'] = $_SESSION['noncePayPalSmartBtn'] = bin2hex(random_bytes(64));
        } catch (Exception $e) {
            $this->logging->logMessage('alert', "Could not create PayPal SDK and Smart Button nonces >> $e");
            return false;
        }
    }

    public function getCSRFToken(): string
    {
        return $_SESSION['tokenCsrf'] ?? $this->setCSRFToken();
    }

    private function setCSRFToken(): string
    {
        try {
            return $_SESSION['tokenCsrf'] = bin2hex(random_bytes(64));
        } catch (Exception $e) {
            $this->logging->logMessage('alert', "Could not create a CSRF token >> $e");
            return false;
        }
    }
}
