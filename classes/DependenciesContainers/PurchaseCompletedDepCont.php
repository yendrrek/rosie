<?php

namespace Rosie\DependenciesContainers;

use Rosie\Services\PurchaseCompleted\PurchaseCompleted;

class PurchaseCompletedDepCont
{
    public function __construct(public PurchaseCompleted $purchaseCompleted)
    {
    }

    public function runDependencies(): void
    {
        $this->purchaseCompleted->emptyBasketAfterCompletingPurchase();
    }
}
