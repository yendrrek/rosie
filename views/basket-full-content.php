<div class='modal-outer' id='modal-outer'>
    <div class='modal-inner pulsating-dot-pseudo' id='modal-inner' tabindex='-1'>Processing, please wait</div>
</div>

<div class='table-container'>
    <table class='table'>
        <thead>
        <tr>
            <th class='table__header' colspan='2' scope='col'>Product</th>
            <th class='table__header table__header_align table__header_big-screen' scope='col'>Price</th>
            <th class='table__header table__header_align' scope='col'>
                <span class='table__header_product-price-small-screen'>Price</span>
                <span class='table__header_product-qty-big-screen'>Quantity</span>
            </th>
            <th class='table__header table__header_product-total-big-screen' scope='col'>Total</th>
        </tr>
        </thead>

        <?php
        $this->getBasketDetails();
        ?>
    </table>

    <?php
    if ($isAddedRemoveAllProductsButton) :
        ?>

        <a class="btn-basket btn-basket_hover btn-basket_outline btn-basket_remove-product-all
        table__btn-basket_remove-product-all link link_visited btn-basket_outline"
           href='basket.php?action=removeAllProducts'>Remove All
        </a>

        <?php
    endif;
    ?>

    <div class="table__checkout">
        <a class="btn-basket btn-basket_hover btn-basket-continue-shopping
        table__btn-basket-continue-shopping link link_visited btn-basket_outline"
           href="shop.php">Continue shopping</a>
        <span class="table__order-total-txt">Total:</span>
        <span class="table__order-total"><?php echo '£ ' . number_format($this->orderTotal, 2); ?>
        </span>
        <span class="table__free-postage-txt">Free UK delivery</span>
        <span class="buyer-consent table__buyer-consent">By clicking 'PayPal Checkout' you accept
                <button class="policy-activator policy-activator_font-darker
                policy-activator_hover policy-activator_outline"
                        type="button" value="returns">Returns</button> policy.</span>
        <div class="table__paypal-btn table__paypal-btn_before" id="paypal-btn-container"></div>
        <img class="table__payment-cards" src="../img/png/paypal-logo.png" alt="PayPal logo">
    </div>
</div>