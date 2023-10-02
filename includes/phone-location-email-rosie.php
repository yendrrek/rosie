<?php use Rosie\Utils\EnvironmentVariables; ?>

<div class="contact contact">
    <div class="contact__container">
        <h3 class="contact__name">Rosie Piontek</h3>
        <p class="contact__details">
            Carluke, United Kingdom <br>
            <?php echo EnvironmentVariables::$sellerPhone;?><br>
            <?php echo EnvironmentVariables::$sellerMobile;?><br>
            <?php echo EnvironmentVariables::$sellerEmail;?>
        </p>
    </div>
</div>