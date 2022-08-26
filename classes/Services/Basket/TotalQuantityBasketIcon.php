<?php

namespace Rosie\Services\Basket;

class TotalQuantityBasketIcon extends BasketIcon
{
    public static function getTotalQuantity(): void
    {
        if (empty($_SESSION['basket'])) {
            return;
        }

        foreach ($_SESSION['basket'] as $product) {
            if (!isset(BasketIcon::$totalQty)) {
                self::getTotalQuantityWhenAddingProductFirstTime($product['productQuantity']);
            } else {
                self::getTotalQuantityWhenAddingProductAgain($product['productQuantity']);
            }
        }
    }

    private static function getTotalQuantityWhenAddingProductFirstTime($productQuantity): void
    {
        BasketIcon::$totalQty = $productQuantity;
    }

    private static function getTotalQuantityWhenAddingProductAgain($productQuantity): void
    {
        BasketIcon::$totalQty += $productQuantity;
    }
}
