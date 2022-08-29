<?php

namespace Rosie\PayPal;

use PDO;
use Rosie\Utils\Logging;

class StockUpdate
{
    public function __construct(
        private PDO $pdo,
        private Logging $logging
    ) {
    }

    public function updateStock(): void
    {
        $dbConn = $this->pdo;

        if (!empty($_SESSION['itemsDetails'])) {
            foreach ($_SESSION['itemsDetails'] as $productDetail) {
                $stmt1 = $dbConn->prepare('UPDATE cards SET stock=stock-:qty WHERE id=:id');
                $stmt1->bindParam(':qty', $productDetail['quantity']);
                $stmt1->bindParam(':id', $productDetail['id']);
                $stmt1->execute();
                $this->logging->logMessage(
                    'info',
                    "Stock updated for product id {$productDetail['id']}. 
                    Quantity subtracted: {$productDetail['quantity']}"
                );
            }
            $stmt1 = null;
        }
    }
}
