<a class="basket nav__basket link link_visited basket_outline" href="basket.php">
    <div class="basket__icon-and-txt-wrapper">
        <img class="basket__icon" src="img/png/basket1a1a1a.png" alt="Basket">
        <span class="basket__txt">basket</span>
    </div>
    <div class="number basket__number basket__number_main-nav">

    <?php
    if (!empty($_SESSION['basket'])):
        foreach($_SESSION['basket'] as $product):
            if (!isset($totalQty)):
                $totalQty = $product['productQty'];
            else:
                $totalQty += $product['productQty'];
            endif;
        endforeach; 
        ?>

        <span id="number"><?php echo $totalQty; ?></span>

        <?php
    else: 
        ?>

        <span>0</span>

        <?php 
    endif; 
    ?>

    </div>
</a>
