    <nav class="nav-small header__nav-small nav-small_hidden">
        <ul class="nav-small__ul">

        <?php
        while ($rowSmallMainNav = $this->resultSmallMainNav->fetch()) :
            ?>

            <li class="nav-small__li">

            <?php
            if ($rowSmallMainNav['smallMainNavElements'] === 'Works') :
                ?>

                <div class="nav-small__link nav-small__link_hover" id="small-subnav-activator">

                <?php
            else :
                ?>

                <a class="nav-small__link nav-small__link_hover link link_visited" 
                   href="<?php echo $rowSmallMainNav['smallMainNavLinks']; ?>">

                <?php
            endif;
            ?>   

                    <?php echo $rowSmallMainNav['smallMainNavElements']; ?>

                <?php
                if ($rowSmallMainNav['smallMainNavElements'] === 'Works') :
                    ?>

                </div>

                    <?php
                else :
                    ?>

                </a>

                    <?php
                endif;
                if ($rowSmallMainNav['smallMainNavElements'] === 'Works') :
                    ?>

                <ul class="subnav-small nav__subnav-small subnav-small_hidden">

                    <?php
                    while ($rowSmallSubNav = $this->resultSmallSubNav->fetch()) :
                        ?>

                    <li class="subnav-small__items_hidden">
                        <a class="link_subnav-small link_subnav-small_hover subnav-small__link link link_visited" 
                           href="<?php echo $rowSmallSubNav['smallSubNavLinks']; ?>">
                            <?php echo $rowSmallSubNav['smallSubNavElements']; ?>
                        </a>

                        <?php
                        if ($rowSmallSubNav['smallSubNavElements'] !== 'Paintings') :
                            ?>

                        <hr class="subnav-small__line-horizontal">

                            <?php
                        endif;
                        ?>

                    </li>

                        <?php
                        $rowSmallSubNav = null;
                    endwhile;
                    ?>

                </ul>

                    <?php
                endif;
                ?>    

            </li>

            <?php
            $rowSmallMainNav = null;
        endwhile;
        ?>

        </ul>
    </nav>
</header>