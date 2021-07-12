<div class="modal-outer" id="stock-limit-info-outer-modal">
    <div class="modal-inner modal-inner_stock-info">
        <div class="modal-inner__stock-limit-info" tabindex="-1">
            <button class="close-popup-btn close-popup-btn_stock-limit-info close-popup-btn_outline material-icons ff-inner-rig-hidden" id="stock-limit-info-close-btn" type="button" tabindex="-1">close
            </button>
            You have tried to add <?php echo $exceedingQty;?> <i><?php echo $productName; ?></i> cards to the basket, but currently only <?php echo $stockAmount; ?> are available.<br> If you wish to order more, please 
            <a class="link link_font_italic-darker link_font_outline link_font_hover link-visited" id="stock-info-link" href="contact.php" tabindex="-1">
                <span tabindex="-1">let me know</span><!--
         --></a>.
        </div>
    </div>
</div>
