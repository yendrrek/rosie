<?php
if (empty($_SESSION['basket'])) :
    ?>
    <div class='basket-empty'>
        <p>Basket is empty.<br><br></p>
        <a class='link_basket-empty link_basket-empty_hover link link_visited btn-basket_outline'
           href='shop.php'>Back to shop</a><br>
        <a class='link_basket-empty link_basket-empty_hover link link_visited btn-basket_outline'
           href='all-works.php'>Return to home page</a>
    </div>

    <?php
else :
    if (!empty($this->basketDepCont->addingProductBasket->stockLimitInfoLightbox)) :
        echo $this->basketDepCont->addingProductBasket->stockLimitInfoLightbox;
    endif;

    $this->basketDepCont->basketFull->getBasketFullContent();

    include 'includes/payment-postage-returns-info-lightbox.html';
endif;
?>
