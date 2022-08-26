<form method="post" action="basket.php">
    <div class="shop__qty-option">
        <span class="shop__qty-txt">Quantity:</span>
        <select class="shop__qty-box qty-box_outline" name="quantity">
            
        <?php
        if (isset($rowCards)) :
            for ($availableQty = 1; $availableQty <= $rowCards['stock']; $availableQty++) :
                ?>

                <option value="<?php echo $availableQty; ?>"><?php echo $availableQty; ?></option>

                <?php
            endfor;
        endif;
        ?>

        </select>
    </div>
    
    <input type="hidden" name="id" value="<?php echo $rowCards['id']; ?>">
    <input type="hidden" name="basketImg" value="<?php echo $rowCards['imgBasket']; ?>">
    <input type="hidden" name="basketImgAlt" value="<?php echo $rowCards['imgFrontAlt']; ?>">
    <input type="hidden" name="productName" value="<?php echo $rowCards['product']; ?>">
    <input type="hidden" name="stock" value="<?php echo $rowCards['stock']; ?>">
    <button class="btn btn_add-to-basket btn_add-to-basket_outline ff-inner-ring-hidden" type="submit">
        <span class="fas fa-shopping-basket"></span>&nbsp;&nbsp;&nbsp;Add to basket</button>
    <input type="hidden" name="tokenCsrf" value="<?php echo $this->shopDepCont->token->getCSRFToken(); ?>">
</form>