<tbody>
<tr class='table__border-top-bottom'>
    <td class='table__product-img'>
        <img width='60'
             height='83'
             src="<?php echo $product['productBasketImg']; ?>"
             alt="<?php echo $product['productImgAlt']; ?>">
    </td>
    <td><?php echo "{$product['productName']} card"; ?>
        <span class="table__product-description">Size: A6.
            <span class="table__product-description-extension-big-screen"> Blank on the inside.</span>
        </span>
        <a class="btn-basket btn-basket_hover btn-basket_remove-product-single
        table__btn-basket_remove-product-single link link_visited btn-basket_outline"
           href="basket.php?action=removeSingleProduct&idOfProductRemovedWithBtn=<?php
            echo $product['productId']; ?>&productRemovedFromBasketWithButton=<?php
           echo str_replace('&', '%26', $product['productName']); ?>">Remove
        </a>
    </td>
    <td class="table__product-price-big-screen"><?php echo '£ ' . number_format($productRetailPrice, 2); ?></td>
    <td class="table__product-qty">
        <span class="table__product-price-small-screen">
            <?php echo '£ ' . number_format($productRetailPrice, 2); ?>
        </span>
        <form class="table__form-basket-qty-menu"
              id="<?php echo $product['productId']; ?>"
              method="post"
              action="basket.php">
            <span class="table__product-qty-txt-small-screen">Quantity:</span>
            <select id="<?php echo "productId{$product['productId']}";
            // Word 'productId' added to avoid duplication of id attribute used in <form>.?>"
                    class="table__product-qty-menu qty-box_outline" name="newQty">
                <option value="<?php echo $product['productQuantity']; ?>"
                        hidden><?php echo $product['productQuantity']; ?>
                </option>

                <?php
                for ($quantityOption = 0; $quantityOption <= $product['productStock']; $quantityOption++) :
                    ?>

                    <option value="<?php echo $quantityOption; ?>">

                        <?php
                        echo $quantityOption == 0 ? "$quantityOption (Remove)" : $quantityOption;
                        ?>

                    </option>

                    <?php
                endfor;
                ?>

            </select>
            <input type="hidden" name="nameOfProductWithQuantityUpdatedInBasket"
                   value="<?php echo $product['productName']; ?>">
            <input type="hidden" name="tokenCsrf" value="<?php echo $this->token->getCSRFToken(); ?>">
        </form>
    </td>
    <td class="table__product-total-price"><?php echo '£ ' . number_format($productTotal, 2); ?></td>
</tr>
</tbody>