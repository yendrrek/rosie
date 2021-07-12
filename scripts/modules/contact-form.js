'use strict';

import { HelperMethods } from './helper-methods.js';

export const ContactForm = {

  sendMessgeViaContactForm (event) {
    const _this = ContactForm;
    event.preventDefault();
    $.ajax({
      method: 'POST',
      data: $(event.currentTarget).serialize(),
      dataType: 'text',
      success(response) {
        _this.showMsgSentOrFailedNotification(response);
        _this.makeNotificationVisibleIfNotInViewport();
        if ($('#sender-name-error', response).text()) {
          _this.showNameError(response);
        } else {
          _this.removeNameError(response);
        }
        if ($('#sender-email-error', response).text()) {
          _this.showEmailError(response);
        } else {
          _this.removeEmailError(response);
        }
        if ($('#msg-error', response).text()) {
          _this.showMsgError(response);
        } else {
          _this.removeMsgError(response);
        }
      }
    });
  },

  showMsgSentOrFailedNotification (response) {
    if ($('form').is(':first-child')) {
      this.showNotificationFirstTime (response);
    } else if ($('.contact-form__msg-error').is(':first-child')) {
      this.showMsgSentIfFailedAlreadyDisplayed (response);
    } else if ($('.contact-form__msg-success').is(':first-child')) {
      this.showFailedIfMsgSentAlreadyDisplayed (response);
    }
  },

  showNotificationFirstTime (response) {
    if ($('.contact-form__msg-error', response).text()) {
      $('.contact-form').prepend($('.contact-form__msg-error', response));
    } else if ($('.contact-form__msg-success', response).text()) {
      $('.contact-form').prepend($('.contact-form__msg-success', response));
    }
  },

  showMsgSentIfFailedAlreadyDisplayed (response) {
    if ($('.contact-form__msg-success', response).text()) {
      $('.contact-form__msg-error').replaceWith($('.contact-form__msg-success', response));
    }
  },

  showFailedIfMsgSentAlreadyDisplayed (response) {
    if ($('.contact-form__msg-error', response).text()) {
      $('.contact-form__msg-success').replaceWith($('.contact-form__msg-error', response));
    }
  },

  makeNotificationVisibleIfNotInViewport () {
    const contactFormNotifications = document.querySelectorAll('.contact-form__msg-success, .contact-form__msg-error');
    for (const notification of contactFormNotifications) {
      if (HelperMethods.isInViewport(notification) === false) {
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      }
    }
  },

  showNameError (response) {
    $('#sender-name-error').text($('#sender-name-error', response).text());
    $("input[name='senderName']").addClass('contact-form__error-outline_red');
  },

  removeNameError () {
    $('#sender-name-error').text('');
    $("input[name='senderName']").removeClass('contact-form__error-outline_red');
  },

  showEmailError (response) {
    $('#sender-email-error').text($('#sender-email-error', response).text());
    $("input[name='senderEmail']").addClass('contact-form__error-outline_red');
  },

  removeEmailError () {
    $('#sender-email-error').text('');
    $("input[name='senderEmail']").removeClass('contact-form__error-outline_red');
  },

  showMsgError (response) {
    $('#msg-error').text($('#msg-error', response).text());
    $("textarea[name='msg']").addClass('contact-form__error-outline_red');
  },

  removeMsgError () {
    $('#msg-error').text('');
    $("textarea[name='msg']").removeClass('contact-form__error-outline_red');
  },
  
  dontResubmitContactFormWhenPageReloaded () {
    const contactFormPage = document.querySelector("input[name='name']");
    if (contactFormPage) {
      window.history.replaceState(null, null, window.location.href);
    }
  }

};


