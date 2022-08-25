<?php

namespace Rosie\Services\Basket;

use Rosie\Utils\FormValidation;
use Rosie\Utils\Logging;

class AddingProductBasket
{
    public function __construct(
        private Logging $logging,
        private FormValidation $formValidation
    ) {
    }

    public string $stockLimitInfoLightbox = '';

    public function addProductToBasket(): bool
    {
        $invalidCsrfTokenMessage = 'Invalid or no token when adding product to basket';
        $isNotProductQuantityBeingAmendedFromShop = isset($_POST['quantityDropDownMenuIdInBasket']);

        if (!$this->formValidation->validateForm(
            'post',
            $invalidCsrfTokenMessage,
            $isNotProductQuantityBeingAmendedFromShop
        )) {
            return false;
        }

        if (!empty($_SESSION['basket'][$_POST['id']])) {
            $this->addSameProductToBasketAgain();
            return true;
        }

        $this->addProductToBasketFirstTime();
        return true;
    }

    private function addProductToBasketFirstTime(): void
    {
        $_SESSION['basket'][$_POST['id']] = [
            'productId' => ($_POST['id']),
            'productName' => ($_POST['productName']),
            'productBasketImg' => ($_POST['basketImg']),
            'productImgAlt' => ($_POST['basketImgAlt']),
            'productsRetailPrices' => ($_SESSION['productsRetailPrices']),
            'productQuantity' => ($_POST['quantity']),
            'productStock' => ($_POST['stock'])
        ];

        $this->logging->logMessage(
            'info',
            "Adding '{$_SESSION['basket'][$_POST['id']]['productName']}' first time to basket"
        );
    }

    private function addSameProductToBasketAgain(): void
    {
        foreach ($_SESSION['basket'] as &$product) {
            if ($product['productId'] == $_POST['id']) {
                if ($_POST['quantity'] + $product['productQuantity'] > $_POST['stock']) {
                    $this->showStockLimitInfoLightbox($product['productQuantity'], $product['productName']);
                    $product['productQuantity'] = $_POST['stock'];
                    return;
                }

                $product['productQuantity'] += $_POST['quantity'];

                $this->logging->logMessage('info', "Adding '{$product['productName']}' to basket again");
            }
        }
    }

    private function showStockLimitInfoLightbox($productQuantity, $productName): void
    {
        $exceedingQuantity = $productQuantity + $_POST['quantity'];
        $stockAmount = $_POST['stock'];

        ob_start();
        include 'includes/stock-limit-info-lightbox.php';
        $this->stockLimitInfoLightbox = ob_get_clean();

        $this->logging->logMessage('info', "Trying to add more '$productName' than in stock");
    }
}
