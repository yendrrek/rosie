<div class="slideshow" tabindex="-1">
    
    <?php
    include 'includes/slideshow-nav.php';
    while ($rowSlideshowImgs = $resultSlideshowImgs->fetch()): 
    ?>

    <div class="slide">
        <img class="
            
            <?php
            $slideshowImgSquare = [12, 13, 14, 15, 20, 22, 23, 24, 28];
            if (in_array($rowSlideshowImgs['id'], $slideshowImgSquare)):
                echo 'slide__img-square';
            else:
                echo 'slide__img-rectangle';
            endif; 
            ?>"
             
            srcset="<?php echo $rowSlideshowImgs['414px']; ?> 414w,
                    <?php echo $rowSlideshowImgs['768px']; ?> 768w,
                    <?php echo $rowSlideshowImgs['1366px']; ?> 1366w"
            sizes="(min-width: 17.5em) 100vw,
                   (min-width: 25.875em) 100vw,
                   (min-width: 80em) 100vw" 
            src="<?php echo $rowSlideshowImgs['414px']; ?>"
            alt="<?php echo $rowSlideshowImgs['slideshowImgAlt']; ?>"
            loading="lazy">
        <div class="slide__info">
            <div class="slide__artwork-title"> 
                
                <?php echo $rowSlideshowImgs['slideshowImgTitle']; ?>

            </div>
            <div class="slide__artwork-materials">

                <?php echo $rowSlideshowImgs['slideshowImgDesc']; ?>

            </div>
            <div class="slide__artwork-dimensions">

                <?php echo $rowSlideshowImgs['slideshowImgDimm']; ?>
                
            </div>

            <?php 
        $slideshowImgSoldInfo = [1, 2, 3, 4, 6, 9, 11, 12, 16, 17, 19, 24];
        if  (in_array($rowSlideshowImgs['id'], $slideshowImgSoldInfo)): 
            ?>

            <div class="slide__artwork-more-info"><?php echo $rowSlideshowImgs['slideshowSoldInfo']; ?></div>

            <?php
        endif;
            ?>

        </div>
    </div>

    <?php
    endwhile;
    ?>

</div>
