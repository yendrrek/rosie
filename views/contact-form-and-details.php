<div class="contact-form-container">
    <div class="contact-form">
        <?php
        if (!empty($this->contactDepCont->generalNotification)) :
            $suffixes = [true => 'success', false => 'error'];
            ?>

        <span class='contact-form__msg-<?php
        echo $suffixes[str_contains($this->contactDepCont->generalNotification, 'Message sent')];?>'>
            <?php echo $this->contactDepCont->generalNotification; ?>
        </span>
        <?php endif; ?>
        <!-- If you try to make the below lines shorter and break them it will give unexpected results; for example,
        if the 'name' field's outline is red, and then corrected, the red outline will remain.
        I tried commenting out the white space after breaking those lines, but it didn't help. -->
        <form class="contact-form__items" name="contact" action="contact.php" method="post">
            <label class="contact-form__asterisk-before">Name:
                <span class="contact-form__error" id="sender-name-error"><?php echo $this->contactDepCont->contactFormValidation->contactFormErrors->setSenderNameError();?></span><br>
                <input class="contact-form__input contact-form__input-and-msg-field contact-form-field-outline
                <?php echo !empty($this->contactFormValidation->senderNameError) ? 'contact-form__error-outline_red' : null; ?>"
                       type="text" maxlength="50" name="senderName" size="50" required value="<?php echo $this->contactDepCont->contactFormValidation->contactFormFields->getSenderName(); ?>">
            </label><br>
            <label class="contact-form__asterisk-before">E-mail address:
                <span class="contact-form__error" id="sender-email-error"><?php echo $this->contactDepCont->contactFormValidation->contactFormErrors->setSenderEmailAddressError(); ?></span><br>
                <input class="contact-form__input contact-form__input-and-msg-field contact-form-field-outline
                <?php echo !empty($this->contactFormValidation->senderEmailAddressError) ? 'contact-form__error-outline_red' : null; ?>"
                       type="email" name="senderEmail" size="50" maxlength="254" required value="<?php echo $this->contactDepCont->contactFormValidation->contactFormFields->getSenderEmailAddress(); ?>">
            </label><br>
            <label class="contact-form__asterisk-before">Message:
                <span class="contact-form__error" id="msg-error"><?php echo $this->contactDepCont->contactFormValidation->contactFormErrors->setMessageError(); ?></span><br>
                <textarea class="contact-form__msg-field contact-form__input-and-msg-field contact-form-field-outline
                <?php echo !empty($this->contactDepCont->contactFormValidation->messageError) ? 'contact-form__error-outline_red' : null; ?>"
                          name="msg" rows="10" cols="60" wrap="hard" required><?php echo $this->contactDepCont->contactFormValidation->contactFormFields->getMessage(); ?></textarea>
            </label><br>
            <input class="btn contact-form__btn btn_send-contact-form contact-form__btn_hover ff-inner-ring-hidden btn_send-contact-form_outline"
                   type="submit" value="Send" name="contactFormButton">
            <input type="hidden" name="tokenCsrf" value="<?php echo $this->contactDepCont->token->getCSRFToken(); ?>">
        </form>
    </div>

    <?php include 'includes/phone-location-email-rosie.php'; ?>
    
</div>