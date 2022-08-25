<?php

namespace Rosie\Services\Basket;

use PDO;
use Rosie\Utils\Logging;
use Rosie\Utils\UserId;

class BasketDatabase
{
    public function __construct(
        private PDO                           $pdo,
        private BasketDatabaseDataPreparation $basketDataPreparationForDatabase,
        private Logging                       $logging,
    ) {
    }

    public function insertProductAddedToBasketIntoDatabase(): void
    {
        $productAddedToBasket = $this->basketDataPreparationForDatabase->prepareDataForDatabase()[0];
        $addedQuantity = $this->basketDataPreparationForDatabase->prepareDataForDatabase()[1];

        $this->queryDatabase('addToBasket', $productAddedToBasket, $addedQuantity);
        $this->logging->logMessage('info', "Added '{$this->getProductName()}' to basket");
    }

    public function removeFromDatabaseProductRemovedFromBasket(): void
    {
        $productRemovedFromBasket = $this->basketDataPreparationForDatabase->prepareDataForDatabase()[2];
        $singleProductRemovedMessage = "Removed '{$this->getProductName()}' from basket";
        $allProductsRemovedMessage = 'Removed all products from basket';

        $this->queryDatabase('removeFromBasket', $productRemovedFromBasket);

        $logMessage = !empty($this->getProductName()) ? $singleProductRemovedMessage : $allProductsRemovedMessage;
        $this->logging->logMessage('info', $logMessage);
    }

    public function updateProductQuantityFromBasketInDatabase(): void
    {
        $productInBasket = $this->basketDataPreparationForDatabase->prepareDataForDatabase()[3];
        $newQuantity = $this->basketDataPreparationForDatabase->prepareDataForDatabase()[4];
        $updatedQuantityMessage = "Updated quantity of '{$this->getProductName()}' in basket to $newQuantity";

        if ($newQuantity == 0) {
            $this->removeFromDatabaseProductRemovedFromBasket();
        } else {
            $this->queryDatabase('updateBasket', $productInBasket, $newQuantity);

            $this->logging->logMessage('info', $updatedQuantityMessage);
        }
    }

    private function getProductName(): ?string
    {
        return $this->basketDataPreparationForDatabase->prepareDataForDatabase()[5];
    }

    private function executeMySqlStoredProcedure($procedure, $productId, $quantity = null): string
    {
        $userId = UserId::setUserId();
        $removeProductProcedure  = "CALL $procedure('$userId', '$productId')";
        $updateQuantityProcedure = "CALL $procedure('$userId', '$productId', '$quantity')";

        $this->logging->logMessage('info', "Executing stored procedure '$procedure'");

        return !$quantity ? $removeProductProcedure : $updateQuantityProcedure;
    }

    private function queryDatabase($procedure, $productId, $quantity = null): void
    {
        $dbConn = $this->pdo;
        $dbConn->query($this->executeMySqlStoredProcedure($procedure, $productId, $quantity));
        $dbConn = null;
    }
}
