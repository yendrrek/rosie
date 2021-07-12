<header class="header body__header">

<?php
include 'includes/logo.html';
    ?>

    <nav class="header__nav">
        <ul>

        <?php
        while ($rowMainNav = $resultMainNav->fetch()):
            ?>

            <li id="all-works" class="list-item nav__list-item list-item_hover">
                <a class="link 

                <?php
                if ($rowMainNav['mainNavElements'] === 'All works') echo 'link_all-works-more-margin-r'; 
                ?> 

                nav__link nav__link_hover link_visited nav__link_outline" href="<?php echo $rowMainNav['mainNavLinks']; ?>">
            
                <?php echo $rowMainNav['mainNavElements']; ?>

                </a>
        
                <?php
            if ($rowMainNav['mainNavElements'] === 'All works'):
                include 'includes/triangular-outline-arrow-all-works.html';
                ?>

                <ul class="subnav subnav_hidden nav__subnav">

                <?php
                while ($rowSubNav = $resultSubNav->fetch()):
                    ?>

                    <li class="subnav__item

                    <?php 
                    if ($rowSubNav['subNavElements'] === 'Paintings'):
                        echo 'subnav__item_padding-bottom_more';
                    endif;    
                    ?>">

                        <a class="subnav__link subnav__link_hover link link_visited subnav__link_outline" 
                           href="<?php echo $rowSubNav['subNavLinks']; ?>" tabindex="-1">

                        <?php echo $rowSubNav['subNavElements'];

                    if ($rowSubNav['subNavElements'] !== 'Paintings'):
                        ?>   

                        <hr class="subnav__line-horizontal">

                        <?php 
                    endif; 
                        ?>

                        </a>
                    </li> 

                    <?php 
                endwhile;
                ?>

                </ul>  

                <?php 
            endif; 
            ?>

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