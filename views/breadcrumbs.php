<ul class="breadcrumbs">

<?php

use Rosie\Services\Basket\BasketIcon;

$pageTitles = ['Geometry', 'Stained Glass', 'Ceramic Tiles', 'Paintings', 'About', 'Contact', 'Shop' ];

if (in_array($pageName, $pageTitles)) :
    ?>

    <li class="breadcrumbs__item greater-than-sign-pseudo">
        <a class="link link_breadcrumbs-home link_visited link_breadcrumbs-home_outline" href="all-works.php">Home</a>
    </li>

    <?php
endif;
?>

    <li class="breadcrumbs__item">
        <h2 class="breadcrumbs__title

        <?php
        if ($pageName == 'Basket' || $pageName == 'All Works') :
            echo 'breadcrumbs__title_margin-left_smaller';
        endif;
        ?>">
        <?php echo $pageName; ?>

        </h2>
    </li>
    <li class="breadcrumbs__item">
        <a class="basket breadcrumbs__basket link link_visited" href="basket.php" tabindex="-1">
            <img class="basket__icon basket__icon_hover basket__icon_breadcrumbs_hidden" 
                 src="../img/png/basket1a1a1a.png" alt="Basket icon">
            <div class="number basket__number number_hidden">
                <span id="breadcrumbs-basket-icon-qty"><?php echo BasketIcon::$totalQty; ?></span>
            </div>
            <span class="basket__txt basket__txt_hidden">basket</span>
        </a>
    </li>
</ul>
