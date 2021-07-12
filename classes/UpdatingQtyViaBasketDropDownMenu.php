<?php
class UpdatingQtyViaBasketDropDownMenu
{
    public $updatedQtyWillAmendDbNow;
    public $zeroQtySelectedWillAmendDbNow;

	public function updateQtyViaBasketDropDownMenu()
	{
		if (!empty($_POST['tokenCsrf'])) {
		    if (hash_equals($_SESSION['tokenCsrf'], $_POST['tokenCsrf'])) {
		        if ($_SERVER['REQUEST_METHOD'] == "POST") {
		            if (isset($_POST['qtyDropDownMenuId'])) {
		                foreach($_SESSION['basket'] as &$product) {
		                    if ($product['productId'] == $_POST['qtyDropDownMenuId']) {
		                    	$product['productQty'] = $_POST['newQty'];
		                        $this->updatedQtyWillAmendDbNow = true;
		                        $this->removeProductFromBasket(); 
		                    } 
		                }
		            }
		        }
		    } else {
		        error_log('Token not validated in the basket at rosiepiontek.com', 1, 'yendrrek@gmail.com');
		    } 
        }     
	}

	private function removeProductFromBasket()
	{
		foreach($_SESSION['basket'] as &$product) {
			if ($product['productQty'] == 0) {
		        unset($_SESSION['basket'][$product['productId']]);
		        $this->zeroQtySelectedWillAmendDbNow = true;
		    }
		}
	}
}