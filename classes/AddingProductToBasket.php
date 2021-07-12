<?php
class AddingProductToBasket 
{ 
    public $productAddedToBasketWillAmendDbNow;
    public $showStockLimitInfoLightbox;
    
    public function addProductToBasket()
    {
        if (!empty($_POST['tokenCsrf'])) {
            if (hash_equals($_SESSION['tokenCsrf'], $_POST['tokenCsrf'])) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (!isset($_POST['qtyDropDownMenuId'])) {
                        if (empty($_SESSION['basket'][$_POST['id']])) {
                            $this->addProductToBasketFirstTime();
                        } else {
                            $this->addSameProductToBasketAgain();
                        }
                    $this->productAddedToBasketWillAmendDbNow = true;
                    }
                }
            } else {
                error_log('Token not validated in the shop at rosiepiontek.com', 1, 'yendrrek@gmail.com');
            } 
        }
    }

    private function addProductToBasketFirstTime()
    {
        $_SESSION['basket'][$_POST['id']] = [
            'productId'=>($_POST['id']),
            'productName'=>($_POST['nameOfProduct']),
            'productBasketImg'=>($_POST['basketImg']),
            'productImgAlt'=>($_POST['basketImgAlt']),
            'productsRetailPrices'=>($_SESSION['productsRetailPrices']),
            'productQty'=>($_POST['qty']),
            'productStock'=>($_POST['stock'])
        ];
    } 

    private function addSameProductToBasketAgain()
    {
        foreach ($_SESSION['basket'] as &$product) {
            if ($product['productId'] == $_POST['id']) {
                if ($_POST['qty'] + $product['productQty'] > $_POST['stock']) {
                    $this->showStockLimitInfoLightbox(); 
                    $product['productQty'] = $_POST['stock'];
                } else {
                    $product['productQty'] += $_POST['qty'];
                }
            } 
        } 
    }

    private function showStockLimitInfoLightbox()
    {
        $exceedingQty = $stockAmount = 0;
        $productName = '';

        foreach ($_SESSION['basket'] as &$product) {
            if ($product['productId'] == $_POST['id']) {
                $exceedingQty = $product['productQty'] + $_POST['qty'];
                $productName = $product['productName'];
                $stockAmount = $_POST['stock'];
                ob_start();
                include 'includes/stock-limit-info-lightbox.php';
                $this->showStockLimitInfoLightbox = ob_get_clean();
            }
        }
    }
}