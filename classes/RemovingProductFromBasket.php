<?php
class RemovingProductFromBasket
{
    public $removedProductFromBasketWillAmendDbNow;

    public function removeProductFromBasket()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['action'])) {
                if ($_GET['action'] == 'removeSingleProduct') {
                    if (isset($_SESSION['basket'][$_GET['productRemovedWithBtn']])) {
                        unset($_SESSION['basket'][$_GET['productRemovedWithBtn']]);
                    }
                } elseif ($_GET['action'] == 'removeAllProducts') {
                    if (isset($_SESSION['basket'])) {
                        unset($_SESSION['basket']);
                    } 
                }
                $this->removedProductFromBasketWillAmendDbNow = true;
            }
        }
    }
}