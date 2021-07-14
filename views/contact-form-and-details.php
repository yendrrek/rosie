<div class="body__contact-form-container">
    <div class="contact-form body__contact-form">

    <?php if ($generalNotification === 'Message not sent, please see below.'): ?>

        <span class="contact-form__msg-error"><?php echo $generalNotification; ?></span>

    <?php elseif ($generalNotification === 'Message sent. Thank you.'): ?>

        <span class="contact-form__msg-success"><?php echo $generalNotification; ?></span>

    <?php endif; ?> 

        <form class="contact-form__items" name="contact" 
              action="contact.php" method="post">
            <label class="contact-form__asterisk-before">Name:
                <span class="contact-form__error" id="sender-name-error"><!--
              --><?php if (isset($senderNameError)) echo $senderNameError; ?><!--
             --></span><br>
                <input class="contact-form__input contact-form-field-outline

                <?php
                if (!empty($senderNameError)) echo 'contact-form__error-outline_red';
                ?>"

                       type="text" maxlength="50" name="senderName" size="50" required 
                       value="<?php echo $senderName; ?>">
            </label><br>
            <label class="contact-form__asterisk-before">E-mail address:
                <span class="contact-form__error" id="sender-email-error"><!--
             --><?php if (isset($senderEmailError)) echo $senderEmailError; ?><!--
             --></span><br>
                <input class="contact-form__input contact-form-field-outline

                <?php 
                if (!empty($senderEmailError)) echo 'contact-form__error-outline_red'; 
                ?>"

                       type="email" name="senderEmail" size="50" maxlength="254" required 
                       value="<?php echo $senderEmail; ?>">
            </label><br>
            <label class="contact-form__asterisk-before">Message:
                <span class="contact-form__error" id="msg-error"><!--
             --><?php if (isset($msgError)) echo $msgError; ?><!--
             --></span><br>
                <textarea class="contact-form__msg-field contact-form-field-outline

                <?php 
                if (!empty($msgError)) echo 'contact-form__error-outline_red'; 
                ?>"

                          name="msg" rows="10" cols="60" wrap="hard" required><?php echo $msg; ?></textarea>
            </label><br>
            <input class="btn contact-form__btn btn_send-contact-form contact-form__btn_hover ff-inner-ring-hidden btn_send-contact-form_outline" 
                   type="submit" value="Send">
            <input type="hidden" name="tokenCsrf" value="<?php echo $tokenCsrf; ?>">
        </form>
    </div>

    <?php include 'includes/phone-location-email-rosie.php'; ?>
    
</div>