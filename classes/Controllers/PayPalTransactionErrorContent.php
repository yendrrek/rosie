<?php

namespace Rosie\Controllers;

class PayPalTransactionErrorContent
{
    public static function showPayPalTransactionErrorInfo(): bool
    {
        $currentPageUrl = $_SERVER['REQUEST_URI'];

        if (str_contains($currentPageUrl, 'transaction-error')) {
            include './views/capture-transaction-error.html';
            return true;
        }
        return false;
    }
}
