<?php
include 'includes/shop-info-header.html';

$result = $this->shopDepCont->runDependencies();
while ($rowCards = $result->fetch()) :
    ?>

<div class="shop">
    <span class="extra-img-activator word-more-pseudo shop__extra-img-activator
    extra-img-activator_hover extra-img-activator_outline fas fa-camera-retro" tabindex="0"></span>

    <?php
    include 'products-imgs-screens-1170-down.php';
    include 'products-imgs-screens-1171-up.php';
    ?>
        
    <div class="shop__horizontal-line"></div>
    <ul class="shop__product-details">
        <li class="shop__product-name">
            <?php echo $rowCards['product']; ?></li>
            
        <?php
        if (isset($rowCards['stock'])) :
            if ($rowCards['stock'] > 5) :
                ?>      

        <li class="shop__stock-info shop__stock-info_available">In stock</li>

                <?php
            elseif ($rowCards['stock'] > 0) :
                ?>

        <li class="shop__stock-info shop__stock-info_available">
            <span class="shop__stock-info_number"><?php echo $rowCards['stock']; ?></span> left</li> 

                <?php
            else :
                ?>
               
        <li class="shop__stock-info shop__stock-info_unavailable">Currently unavailable <br> 
        More on the way</li> 

                <?php
            endif;
        else :
            ?>

        <li class="shop__stock-info shop__stock-info_unavailable">An error has occurred <br> 
            Stock is unknown at the moment <br> Please return later</li>

            <?php
        endif;
        ?>

        <li class="shop__product-info">Size: A6</li>
        <li class="shop__product-dimension">105 x 148 mm (4&frac18; × 5&frac78; in)</li>
        <li class="shop__product-info">Printed on 300gsm paper</li>
        <li class="shop__product-info">Blank on the inside</li>
        <li class="shop__product-price-txt">Price:
            <span class="shop__product-price">
                £<?php echo $rowCards['retailPrice']; ?></span></li>
        <li class="shop__free-postage-txt">Free UK delivery</li>
        <li class="shop__form-as-list-item">
    
        <?php
        if (isset($rowCards['stock'])) :
            if ($rowCards['stock'] > 0) :
                include 'views/shop-form-active.php';
            else :
                include 'includes/shop-form-inactive-no-stock.html';
            endif;
        endif;
        ?>

        </li>
    </ul>
</div>

    <?php
    $shopProductsData[] = $rowCards;
endwhile;
// Accessed in 'basket.php' to extract individual prices.
$_SESSION['shopProductsData'] = $shopProductsData;
include 'includes/added-to-basket-lightbox.html';
include 'includes/payment-postage-returns-info-lightbox.html';
