<?php

namespace Rosie\Services\Basket;

use Rosie\Utils\Token;

class BasketDetails
{
    protected float $orderTotal = 0;

    public function __construct(public Token $token)
    {
    }

    protected function getBasketDetails(): void
    {
        foreach ($_SESSION['basket'] as $product) {
            foreach ($product['productsRetailPrices'] as $index => $price) {
                if ($index == $product['productId']) { /* Index starts from 1. */
                    $productRetailPrice = $price;
                    $productTotal = $productRetailPrice * $product['productQuantity'];
                    $this->orderTotal += ($productRetailPrice * $product['productQuantity']);
                }
            }
            // $_SESSION['orderTotal'] is accessed in PayPal's 'create-order.php'.
            $_SESSION['orderTotal'] = $this->orderTotal;

            include './views/basket-details.php';
        }
    }
}
