<?php
if (empty($_SESSION['basket'])):
    if (strpos($pageTitle, 'Purchase completed') !== false): ?>

    <div class="purchase-completed body__purchase-completed">
        <p>Dear 

            <?php 
            if (isset($_GET['buyerName'])):
                $buyerName = htmlspecialchars($_GET['buyerName'], ENT_QUOTES); 
                echo $buyerName . ',<br><br><br><br>'; 
            endif;
            ?>

        </p>
        <p>Thank you for your purchase.<br><br>
            Confirmation has been sent to your email address.<br><br><br><br>
            Basket is now empty.<br><br>
        </p>
        <a class="link_basket-empty link_basket-empty_hover link link_visited btn-basket_outline"
           href="shop.php">Back to shop</a><br>
        <a class="link_basket-empty link_basket-empty_hover link link_visited btn-basket_outline"
           href="all-works.php">Return to home page</a>
    </div>

    <?php 
    else:
    ?>

    <div class="basket-empty body__basket-empty">
        <p>Basket is empty.<br><br></p>
        <a class="link_basket-empty link_basket-empty_hover link link_visited btn-basket_outline"
           href="shop.php">Back to shop</a><br>
        <a class="link_basket-empty link_basket-empty_hover link link_visited btn-basket_outline"
           href="all-works.php">Return to home page</a>
    </div>

    <?php 
    endif; 
else:
    // Fetched via AJAX and received in 'shop.php'.
    if (isset($showStockLimitInfoLightbox)):
        echo $showStockLimitInfoLightbox;
    endif;
    ?>

    <div class="modal-outer" id="modal-outer">
        <div class="modal-inner pulsating-dot-pseudo" id="modal-inner" tabindex="-1">Processing, please wait</div>
    </div>
    <div class="body__table-container">
        <table class="table body__table" align="center">
            <thead>
                <tr>
                    <th class="table__header" colspan="2" scope="col">Product</th>
                    <th class="table__header table__header_align table__header_big-screen" scope="col">Price</th>
                    <th class="table__header table__header_align" scope="col">
                        <span class="table__header_product-price-small-screen">Price</span>
                        <span class="table__header_product-qty-big-screen">Quantity</span>
                    </th>
                    <th class="table__header table__header_product-total-big-screen" scope="col">Total</th>
                </tr>
            </thead>

            <?php
    $orderTotal = 0;
    $basketPrices = [];
    foreach ($_SESSION['basket'] as $product):
        foreach ($product['productsRetailPrices'] as $index => $price):
            if ($index == $product['productId']): /* Index starts from 1. */
                $productRetailPrice = $price;
                $productTotal = number_format($productRetailPrice * $product['productQty'], 2);
                $orderTotal += ($productRetailPrice * $product['productQty']);
                $basketPrices[] = $productRetailPrice;
            endif;
        endforeach;
        // Both supergloblas are accessed in PayPal's 'create-order.php'.
        $_SESSION['basketPrices'] = $basketPrices;
        $_SESSION['orderTotal'] = $orderTotal;
            ?>

            <tbody>
                <tr class="table__border-top-bottom">
                    <td class="table__product-img">
                        <img width="60" height="83" 
                             src="<?php echo $product['productBasketImg']; ?>" 
                             alt="<?php echo $product['productImgAlt']; ?>">
                    </td>
                    <td><?php echo $product['productName'] . ' card'; ?>
                        <span class="table__product-description">Size: A6.
                            <span class="table__product-description-extension-big-screen"> Blank on the inside.</span>
                        </span>
                        <a class="btn-basket btn-basket_hover btn-basket_remove-product-single table__btn-basket_remove-product-single link link_visited btn-basket_outline" 
                            href="basket.php?action=removeSingleProduct&productRemovedWithBtn=<?php 
                            echo $product['productId']; ?>">Remove
                        </a>
                    </td> 
                    <td class="table__product-price-big-screen">£ <?php echo $productRetailPrice; ?></td>
                    <td class="table__product-qty">
                        <span class="table__product-price-small-screen">£ <?php echo $productRetailPrice; ?></span>
                        <form class="table__form-basket-qty-menu" id="<?php echo $product['productId']; ?>"
                              method="post" action="basket.php">
                            <span class="table__product-qty-txt-small-screen">Quantity:</span>
                            <select id="<?php 
                            // Word 'productId' added to avoid duplication of id attribute used in <form>.
                            echo 'productId' . $product['productId']; ?>" 
                                    class="table__product-qty-menu qty-box_outline" name="newQty">
                                <option value="<?php echo $product['productQty']; ?>" 
                                        hidden><?php echo $product['productQty']; ?>
                                </option>

                                <?php
        for ($qtyOption = 0; $qtyOption <= $product['productStock']; $qtyOption++):
                                ?>

                                <option value="<?php echo $qtyOption; ?>">

                                <?php 
            if ($qtyOption == 0):
                echo $qtyOption . ' (Remove)';
            else:
                echo $qtyOption; 
            endif;
                                ?>

                                </option>

                                <?php
        endfor;
                                ?>

                            </select>
                            <input type="hidden" name="tokenCsrf" value="<?php echo $tokenCsrf; ?>">
                        </form>
                    </td>
                    <td class="table__product-total-price"><?php echo '£ ' . $productTotal; ?></td>
                </tr>

                <?php
    endforeach;
            ?>

            </tbody>
        </table>

        <?php
    if (count($_SESSION['basket']) > 1):
        ?>

        <a class="btn-basket btn-basket_hover btn-basket_outline btn-basket_remove-product-all table__btn-basket_remove-product-all link link_visited btn-basket_outline"
           href='basket.php?action=removeAllProducts'>Remove All
        </a>

        <?php
    endif;
        ?>

        <div class="table__checkout">
            <a class="btn-basket btn-basket_hover btn-basket-continue-shopping table__btn-basket-continue-shopping link link_visited btn-basket_outline" href="shop.php">Continue shopping</a>
            <span class="table__order-total-txt">Total:</span>
            <span class="table__order-total"><?php echo '£ ' . number_format($orderTotal, 2); ?></span>
            <span class="table__free-postage-txt">Free UK delivery</span>
            <span class="buyer-consent table__buyer-consent">By clicking 'PayPal Checkout' you accept
                <button class="policy-activator policy-activator_font-darker policy-activator_hover policy-activator_outline" 
                        type="button" value="returns">Returns</button> policy.</span>
            <div class="table__paypal-btn table__paypal-btn_before" id="paypal-btn-container"></div>
            <img class="table__payment-cards" src="img/png/paypal-logo.png" alt="PayPal logo">
        </div>
    </div>
 
    <?php 
    include 'includes/payment-postage-returns-info-lightbox.html';
endif;
