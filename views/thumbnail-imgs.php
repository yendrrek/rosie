<div class="thumbnail-container

    <?php
    if (str_contains($pageTitle, 'Geometry')) :
        echo 'thumbnail-container_two-column';
    endif;
    ?>">

<?php
while ($rowThumbnailImgs = $resultThumbnailImages->fetch()) :
    ?>
    
    <div class="thumbnail-position

        <?php
        $thumbnailImgs = [10, 11, 12, 13, 14, 15, 28, 29];
        if (in_array($rowThumbnailImgs['id'], $thumbnailImgs)) :
            echo 'thumbnail-position_width_50pct';
        endif;
        ?>">

        <div class="thumbnail-clickable-area thumbnail-clickable-area
        thumbnail-clickable-area_hover thumbnail-clickable-area_outline" tabindex="0">
            <img class="thumbnail-clickable-area__img

                <?php
                if ($rowThumbnailImgs['id'] == 20) :
                    echo 'thumbnail-clickable-area__img_more-margin';
                endif;
                ?>" 

                src="<?php echo $rowThumbnailImgs['thumbSrc']; ?>" alt="<?php echo $rowThumbnailImgs['thumbAlt']; ?>" 
                width="<?php
                       list($width, $height) = getimagesize($rowThumbnailImgs['thumbSrc']);
                       echo $width;
                ?>" 
                height="<?php
                        list($width, $height) = getimagesize($rowThumbnailImgs['thumbSrc']);
                        echo $height;
                ?>">
            <div class="thumbnail-clickable-area__title"><?php echo $rowThumbnailImgs['thumbTitle']; ?></div>
            <div class="thumbnail-clickable-area__description"><?php echo $rowThumbnailImgs['thumbDesc']; ?></div>
            <div class="thumbnail-clickable-area__description"><?php echo $rowThumbnailImgs['thumbDim']; ?></div>
            <div class="thumbnail-clickable-area__additional-info"><?php echo $rowThumbnailImgs['thumbAdditional']; ?></div>
        </div>
    </div>

    <?php
endwhile;
?>

</div>
