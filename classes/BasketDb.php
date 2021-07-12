<?php
class BasketDb
{
	private $dbc;

	public function __construct(\PDO $pdo)
	{
        $this->dbc = $pdo;
	}

    public function addProductToBasketDb(UserId $userId)
    { 
        $addedProductId = $addedQty = 0;

    	$this->userId = $userId->userId;
        $addedProductId = (int)$_POST['id'];
	    $addedQty =  (int)$_POST['qty'];
        $this->dbc->query("CALL addToBasket('$this->userId', '$addedProductId', '$addedQty')"); 
        $this->dbc = null;
    }

    public function removeProductFromBasketDb(UserId $userId)
    {
        $productRemovedFromBasket = 0;

    	$this->userId = $userId->userId;
        if (isset($_GET['productRemovedWithBtn'])) {
            $productRemovedFromBasket = (int)$_GET['productRemovedWithBtn'];
        } elseif (isset($_POST['qtyDropDownMenuId'])) { /* if qty === 0 */
            $productRemovedFromBasket = (int)$_POST['qtyDropDownMenuId'];
        }
	    $this->dbc->query("CALL removeFromBasket('$this->userId', '$productRemovedFromBasket')");
	    $this->dbc = null;
    }

    public function updateQtyViaBasketDropDownMenuDb(UserId $userId)
    {
        $productInBasket = $newQty = 0;

    	$this->userId = $userId->userId;
        $productInBasket = (int)$_POST['qtyDropDownMenuId'];
        $newQty = (int)$_POST['newQty'];
        $this->dbc->query("CALL updateBasket('$this->userId', '$productInBasket', '$newQty')");
        $this->dbc = null;
    }
}