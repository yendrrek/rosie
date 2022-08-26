<?php

namespace Rosie\Controllers;

use Rosie\DependenciesContainers\PurchaseCompletedDepCont;

class PurchaseCompleted
{
    public function __construct(private PurchaseCompletedDepCont $purchaseCompletedDepCont)
    {
    }

    public function runPage(): void
    {
        $buyerName = $this->purchaseCompletedDepCont->purchaseCompleted->getBuyerName();

        include './views/basket-empty-purchase-completed.php';
    }
}
