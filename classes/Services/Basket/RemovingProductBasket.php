<?php

namespace Rosie\Services\Basket;

use Rosie\Utils\Logging;

class RemovingProductBasket
{
    public function __construct(private Logging $logging)
    {
    }

    public function removeProductsFromBasket(): bool
    {
        if (!isset($_GET['action'])) {
            return false;
        }

        return $_GET['action'] == 'removeSingleProduct' ? $this->removeSingleProduct() : $this->removeAllProducts();
    }

    private function removeSingleProduct(): bool
    {
        $this->logging->logMessage('info', "Removing '{$_GET['productRemovedFromBasketWithButton']}' from basket");
        unset($_SESSION['basket'][$_GET['idOfProductRemovedWithBtn']]);
        return true;
    }

    private function removeAllProducts(): bool
    {
        $this->logging->logMessage('info', 'Removing all products from basket');
        unset($_SESSION['basket']);
        return true;
    }
}
