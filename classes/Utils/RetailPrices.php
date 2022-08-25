<?php

namespace Rosie\Utils;

class RetailPrices
{
    public static function getRetailPrices(): array
    {
        if (empty($_SESSION['shopProductsData'])) {
            return [];
        }

        foreach ($_SESSION['shopProductsData'] as $product) {
            $productsRetailPrices[] = $product['retailPrice'];
        }
        // Make the index of the array with retail prices start from 1.
        //That index is matched later against the id of a product being added to the basket,
        //so the relevant price can be displayed.
        array_unshift($productsRetailPrices, '');
        unset($productsRetailPrices[0]);
        return $productsRetailPrices;
    }
}
