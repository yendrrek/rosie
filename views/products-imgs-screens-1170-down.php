<div class="fotorama"
     data-arrows="false"
     data-loop="true"
     data-margin="3"
     data-navposition="top"
     data-ratio="288/420"
     data-shadows="false">
    <div> 
        <img src="<?php echo $rowCards['imgFrontUrl']; ?>" alt="<?php echo $rowCards['imgFrontAlt']; ?>">
        <span class="shop__img-bottom-info">Front</span>
    </div>
    <div> 
        <img src="<?php echo $rowCards['imgBackUrl']; ?>" alt="<?php echo $rowCards['imgBackAlt']; ?>">
        <span class="shop__img-bottom-info">Back</span>
    </div>
    <div>
        <img src="<?php echo $rowCards['imgMoreUrl']; ?>" alt="<?php echo $rowCards['imgMoreAlt']; ?>">
    </div>
</div>