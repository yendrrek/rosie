<header class="header body__header">

<?php
include 'includes/logo.html';
if (!empty($_SESSION['basket'])):
    ?>

    <nav class="header__nav">
        <ul>

        <?php
    while ($rowBasket = $resultBasket->fetch()): 
            ?>

            <li class="list-item nav__list-item list-item_hover">
                <a class="link nav__link nav__link_hover link_visited nav__link_outline" href="<?php echo $rowBasket['basketMainNavLinks']; ?>">
                    <span tabindex="-1"><?php echo $rowBasket['basketMainNavElements']; ?></span>
                </a>
            </li>

            <?php
    endwhile;
            ?>

            <li class="nav__list-item-basket">
            
            <?php 
    include 'basket-icon.php';
            ?>

            </li>
            <li class="nav__list-item-hamburger">

            <?php
    include 'includes/hamburger-menu-screens-1170px-down.html';
            ?>

            </li>

        </ul>
    </nav>
    <nav class="nav-small header__nav-small nav-small_hidden">
        <ul class="nav-small__ul">

        <?php
    while($rowBasketSmallNav = $resultBasketSmallNav->fetch()):
            ?>

            <li class="nav-small__li">
                <a href="<?php echo $rowBasketSmallNav['basketSmallMainNavLinks']?>" 
                   class="nav-small__link nav-small__link_hover link link_visited">
                   <?php echo $rowBasketSmallNav['basketSmallMainNavElements']?></a>
            </li>

            <?php 
    endwhile;
        ?>

        </ul>
    </nav>

    <?php
else:
    ?>

    <nav class="header__nav">
        <a class="basket nav__basket nav__basket_margin-right_smaller link link_visited basket_outline" 
        href="basket.php">
            <div class="basket__icon-and-txt-wrapper">
                <img class="basket__icon" src="img/png/basket1a1a1a.png" alt="Basket">
                <span class="basket__txt">basket</span>
            </div>
            <div class="number basket__number">
                <span>0</span>
            </div>
        </a>
    </nav>

    <?php
endif; 
?>
    
</header>