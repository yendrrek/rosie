<nav class='header__nav'>
    <ul>

        <?php

        use Rosie\Services\Basket\BasketIcon;

        while ($rowBasket = $this->resultBasket->fetch()) :
            ?>

            <li class="list-item nav__list-item list-item_hover">
                <a class="link nav__link nav__link_hover link_visited nav__link_outline"
                   href="<?php echo $rowBasket['basketMainNavLinks']; ?>">
                    <span tabindex="-1"><?php echo $rowBasket['basketMainNavElements']; ?></span>
                </a>
            </li>

            <?php
        endwhile;
        ?>

        <li class="nav__list-item-basket">

            <?php BasketIcon::getBasketIcon(); ?>

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
        while ($rowBasketSmallNav = $this->resultBasketSmallNav->fetch()) :
            ?>

            <li class="nav-small__li">
                <a href="<?php echo $rowBasketSmallNav['basketSmallMainNavLinks'] ?>"
                   class="nav-small__link nav-small__link_hover link link_visited">
                    <?php echo $rowBasketSmallNav['basketSmallMainNavElements'] ?></a>
            </li>

            <?php
        endwhile;
        ?>

    </ul>
</nav>
