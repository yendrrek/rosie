<?php

namespace Rosie\Services\PurchaseCompleted;

class PurchaseCompleted
{
    public function getBuyerName(): string
    {
        return isset($_GET['buyerName']) ? htmlspecialchars($_GET['buyerName'], ENT_QUOTES) : 'Customer';
    }

    public function emptyBasketAfterCompletingPurchase(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
