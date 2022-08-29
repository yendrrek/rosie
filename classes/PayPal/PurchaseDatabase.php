<?php

namespace Rosie\PayPal;

use PDO;
use Rosie\PayPal\PayPalSDK\CaptureOrder;
use Rosie\Utils\Logging;
use Rosie\Utils\UserId;

class PurchaseDatabase
{
    public function __construct(
        private PDO $pdo,
        public CaptureOrder $captureOrder,
        private Logging $logging
    ) {
    }

    public function processPurchaseDataInDatabase(): void
    {
        $dbConn = $this->pdo;
        $userId = UserId::setUserId();

        $this->insertCustomerIntoDatabase($dbConn, $userId);
        $this->insertOrderIntoDatabase($dbConn, $userId);
        $this->removeProductFromBasketDatabase($dbConn);
    }

    private function insertCustomerIntoDatabase($dbConn, $userId): void
    {
        $stmt1 = $dbConn->prepare(
            'INSERT INTO customers (name, userId, address, email, orderId)
                VALUES (:buyerName, :userId, :buyerFullAddress, :buyerEmail, :orderId)'
        );

        $customerData = [
            ':buyerName' => $this->captureOrder->buyerName,
            ':userId' => $userId,
            ':buyerFullAddress' => $this->captureOrder->buyerFullAddress,
            ':buyerEmail' => $this->captureOrder->buyerEmail,
            ':orderId' => $this->captureOrder->orderId
        ];

        $this->insertDataIntoDatabase($customerData, $stmt1);
        $this->logging->logMessage('info', "Inserting customer $userId into database.");
        $stmt1 = null;
    }

    private function insertOrderIntoDatabase($dbConn, $userId): void
    {
        $stmt2 = $dbConn->prepare(
            'INSERT INTO orders (userId, orderId, priceGBP)
                VALUES (:userId, :orderId, :totalPrice)'
        );

        $orderData = [
            ':userId' => $userId,
            ':orderId' => $this->captureOrder->orderId,
            ':totalPrice' => $this->captureOrder->totalPrice
        ];

        $this->insertDataIntoDatabase($orderData, $stmt2);
        $this->logging->logMessage('info', "Inserting order {$this->captureOrder->orderId} into database.");
        $stmt2 = null;
    }

    private function insertDataIntoDatabase($data, $stmt): void
    {
        foreach ($data as $parameter => &$value) {
            $stmt->bindParam($parameter, $value);
        }
        $stmt->execute();
    }

    private function removeProductFromBasketDatabase($dbConn): void
    {
        $userId = UserId::setUserId();
        $dbConn->query("CALL removeFromBasket('$userId', 0)");
        $this->logging->logMessage('info', 'Removing all products from basket in database after successful purchase.');
    }
}
