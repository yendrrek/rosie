<?php

namespace Rosie\Services\Basket;

class BasketDatabaseDataPreparation
{
    public function prepareDataForDatabase(): array
    {
        $productAddedToBasket = $_POST['id'] ?? null;
        $addedQty = $_POST['quantity'] ?? null;
        $newQty = $_POST['newQty'] ?? null;
        $productRemovedFromBasket = $productInBasket = $this->getIdOfProductUpdatedFromWithinBasket();
        $productName = $this->getProductName();

        return [$productAddedToBasket, $addedQty, $productRemovedFromBasket, $productInBasket, $newQty, $productName];
    }

    private function getIdOfProductUpdatedFromWithinBasket(): int
    {
        if (isset($_GET['idOfProductRemovedWithBtn'])) {
            return (int)$_GET['idOfProductRemovedWithBtn'];
        }

        if (isset($_POST['quantityDropDownMenuIdInBasket'])) {
            return (int)$_POST['quantityDropDownMenuIdInBasket'];
        }

        return 0;
    }

    private function getProductName(): string
    {
        if (isset($_GET['productRemovedFromBasketWithButton'])) {
            return $_GET['productRemovedFromBasketWithButton'];
        }

        if (isset($_POST['productName'])) {
            return $_POST['productName'];
        }

        if (isset($_POST['nameOfProductWithQuantityUpdatedInBasket'])) {
            return $_POST['nameOfProductWithQuantityUpdatedInBasket'];
        }

        return false;
    }
}
