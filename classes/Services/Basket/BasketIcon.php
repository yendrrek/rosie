<?php

namespace Rosie\Services\Basket;

class BasketIcon
{
    protected static int $totalQty = 0;

    protected static function getBasketIcon(): void
    {
        TotalQuantityBasketIcon::getTotalQuantity();
        include './views/basket-icon.php';
    }
}
