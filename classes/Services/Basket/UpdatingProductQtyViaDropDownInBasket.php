<?php

namespace Rosie\Services\Basket;

use Rosie\Utils\FormValidation;
use Rosie\Utils\Logging;

class UpdatingProductQtyViaDropDownInBasket
{
    public function __construct(
        private Logging $logging,
        private FormValidation $formValidation
    ) {
    }

    public function updateProductQuantityViaBasketDropDownMenu(): bool
    {
        $invalidCsrfTokenMessage = 'Invalid or no token when updating product in basket';
        $isNotProductQuantityBeingAmendedFromInsideBasket = !isset($_POST['quantityDropDownMenuIdInBasket']);

        if (
            !$this->formValidation->validateForm(
                'post',
                $invalidCsrfTokenMessage,
                $isNotProductQuantityBeingAmendedFromInsideBasket
            )
        ) {
            return false;
        }

        foreach ($_SESSION['basket'] as &$product) {
            if ($product['productId'] == $_POST['quantityDropDownMenuIdInBasket']) {
                $product['productQuantity'] = $_POST['newQty'];

                $this->logging->logMessage(
                    'info',
                    "Updating quantity of '{$product['productName']}' in basket to {$product['productQuantity']}"
                );

                if ($product['productQuantity'] == 0) {
                    $this->removeProductWithZeroQuantityFromBasket(
                        $product['productId']
                    );
                }

                return true;
            }
        }
        return false;
    }

    private function removeProductWithZeroQuantityFromBasket($productId): void
    {
        unset($_SESSION['basket'][$productId]);
    }
}
