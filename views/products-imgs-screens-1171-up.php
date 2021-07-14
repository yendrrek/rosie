<div class="shop__img-container">
    <div class="shop__vertical-line shop__vertical-line_dashed">
        <img class="shop__img" width="287" height="400" 
             src="<?php echo $rowCards['imgBackUrl']; ?>"
             alt="<?php echo $rowCards['imgBackAlt']; ?>">
    </div>
    <span class="shop__img-bottom-info">Back</span>
</div>
<div class="shop__img-container">
    <div class="shop__vertical-line shop__vertical-line_solid">
        <img class="shop__img" width="287" height="400" 
             src="<?php echo $rowCards['imgFrontUrl']; ?>"
             alt="<?php echo $rowCards['imgFrontAlt']; ?>">
    </div>
    <span class="shop__img-bottom-info">Front</span>
</div>
<div class="shop__extra-img-modal-outer" tabindex="-1">
    <div class="shop__extra-img-modal-inner" tabindex="-1">
        <button class="close-popup-btn close-popup-btn_shop-extra-image shop__close-popup-btn material-icons ff-inner-ring-hidden" type="button" value="close" tabindex="-1">close</button>
        <img class="shop__extra-img" width="500" height="377" 
             src="<?php echo $rowCards['shopExtraImgUrl']; ?>"
             alt="<?php echo $rowCards['shopExtraImgAlt']; ?>">
    </div>
</div>