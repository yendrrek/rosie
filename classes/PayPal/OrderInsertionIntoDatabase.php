<?php

namespace Rosie\PayPal;

use PDO;
use Rosie\Utils\Logging;
use Rosie\Utils\UserId;
use Rosie\PayPal\PayPalSDK\CaptureOrder;

class OrderInsertionIntoDatabase
{
    public function __construct(
        private PDO $pdo,
        public CaptureOrder $captureOrder,
        private Logging $logging
    ) {
    }

    public function insertOrderIntoDatabase(): void
    {
        $dbConn = $this->pdo;
        $userId = UserId::setUserId();

        if (!empty($_SESSION['itemsDetails'])) {
            foreach ($_SESSION['itemsDetails'] as $productDetail) {
                $stmt1 = $dbConn->prepare('UPDATE cards SET stock=stock-:qty WHERE id=:id');
                $stmt1->bindParam(':qty', $productDetail['quantity']);
                $stmt1->bindParam(':id', $productDetail['id']);
                $stmt1->execute();
            }
        }

        $stmt2 = $dbConn->prepare(
            'INSERT INTO customers (name, userId, address, email, orderId)
                VALUES (:buyerName, :userId, :buyerFullAddress, :buyerEmail, :orderId)'
        );
        $stmt2->bindParam(':buyerName', $this->captureOrder->buyerName);
        $stmt2->bindParam(':userId', $userId);
        $stmt2->bindParam(':buyerFullAddress', $this->captureOrder->buyerFullAddress);
        $stmt2->bindParam(':buyerEmail', $this->captureOrder->buyerEmail);
        $stmt2->bindParam(':orderId', $this->captureOrder->orderId);
        $stmt2->execute();

        $stmt3 = $dbConn->prepare(
            'INSERT INTO orders (userId, orderId, priceGBP)
                VALUES (:userId, :orderId, :totalPrice)'
        );
        $stmt3->bindParam(':userId', $userId);
        $stmt3->bindParam(':orderId', $this->captureOrder->orderId);
        $stmt3->bindParam(':totalPrice', $this->captureOrder->totalPrice);
        $stmt3->execute();

        $dbConn->query("CALL removeFromBasket('$userId', 0)");

        $stmt1 = null;
        $stmt2 = null;
        $stmt3 = null;
        $dbConn = null;
    }
}
