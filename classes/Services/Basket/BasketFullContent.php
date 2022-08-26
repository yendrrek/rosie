<?php

namespace Rosie\Services\Basket;

class BasketFullContent extends BasketDetails
{
    public function getBasketFullContent(): void
    {
        $isAddedRemoveAllProductsButton = count($_SESSION['basket']) > 1;

        include './views/basket-full-content.php';
    }
}
