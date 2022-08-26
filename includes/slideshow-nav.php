<?php use Rosie\Utils\PageName; ?>

<div class="slideshow__navigation">
    <h2 class="slideshow__title"><?php echo PageName::fitSlideshowSectionNameOnSmallScreen()[0]; ?><!--
     --><br class="slideshow__title_vertical">
        <span class="slideshow__title_2nd-word"><!--
     --><?php echo PageName::fitSlideshowSectionNameOnSmallScreen()[1] ?? ''; ?></span>
    </h2>
    <div class="slideshow__counter-and-arrows">
        <span class="icon slideshow__icon slideshow__icon_arrow-previous icon_hover material-icons">chevron_left
        </span>
        <div class="counter">
            <span id="index"></span>
            <span>&#47;</span>
            <span id="total"></span>
        </div>
        <span class="icon slideshow__icon slideshow__icon_arrow-next icon_hover material-icons">chevron_right
        </span>
    </div>
    <span class="icon icon_zoom slideshow__icon slideshow__icon_zoom icon_hover
    material-icons icon_zoom-and-close_outline">zoom_in</span>
    <span class="icon icon_close slideshow__icon slideshow__icon_close icon_hover
    material-icons icon_zoom-and-close_outline">close</span>
</div>
