<?php

namespace Rosie\DependenciesContainers;

use Rosie\Services\Basket\AddingProductBasket;
use Rosie\Services\Basket\BasketDatabase;
use Rosie\Services\Basket\BasketFullContent;
use Rosie\Services\Basket\RemovingProductBasket;
use Rosie\Services\Basket\UpdatingProductQtyViaDropDownInBasket;

class BasketDepCont
{
    public function __construct(
        public AddingProductBasket $addingProductBasket,
        private RemovingProductBasket $removingProductBasket,
        private UpdatingProductQtyViaDropDownInBasket $updatingProductQtyViaDropDownInBasket,
        private BasketDatabase $basketDatabase,
        public BasketFullContent $basketFull
    ) {
    }

    public function runDependencies(): void
    {
        $isAddedProductToBasket = $this->addingProductBasket->addProductToBasket();
        $isRemovedProductFromBasket = $this->removingProductBasket->removeProductsFromBasket();
        $isUpdatedQty = $this->updatingProductQtyViaDropDownInBasket->updateProductQuantityViaBasketDropDownMenu();

        if ($isAddedProductToBasket) {
            $this->basketDatabase->insertProductAddedToBasketIntoDatabase();
        } elseif ($isRemovedProductFromBasket) {
            $this->basketDatabase->removeFromDatabaseProductRemovedFromBasket();
        } elseif ($isUpdatedQty) {
            $this->basketDatabase->updateProductQuantityFromBasketInDatabase();
        }
    }
}
