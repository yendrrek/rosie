'use strict';

import { isInViewport } from './helper-methods.js';

export function sendMessgeViaContactForm (event) {
  event.preventDefault();
  $.ajax({
    method: 'POST',
    data: $(event.currentTarget).serialize(),
    dataType: 'text',
    success(response) {
      showMsgSentOrFailedNotification(response);
      makeNotificationVisibleIfNotInViewport();
      if ($('#sender-name-error', response).text()) {
        showNameError(response);
      } else {
        removeNameError(response);
      }
      if ($('#sender-email-error', response).text()) {
        showEmailError(response);
      } else {
        removeEmailError(response);
      }
      if ($('#msg-error', response).text()) {
        showMsgError(response);
      } else {
        removeMsgError(response);
      }
    }
  });
}

function showMsgSentOrFailedNotification (response) {
  if ($('form').is(':first-child')) {
    showNotificationFirstTime (response);
  } else if ($('.contact-form__msg-error').is(':first-child')) {
    showMsgSentIfFailedAlreadyDisplayed (response);
  } else if ($('.contact-form__msg-success').is(':first-child')) {
    showFailedIfMsgSentAlreadyDisplayed (response);
  }
}

function showNotificationFirstTime (response) {
  if ($('.contact-form__msg-error', response).text()) {
    $('.contact-form').prepend($('.contact-form__msg-error', response));
  } else if ($('.contact-form__msg-success', response).text()) {
    $('.contact-form').prepend($('.contact-form__msg-success', response));
  }
}

function showMsgSentIfFailedAlreadyDisplayed (response) {
  if ($('.contact-form__msg-success', response).text()) {
    $('.contact-form__msg-error').replaceWith($('.contact-form__msg-success', response));
  }
}

function showFailedIfMsgSentAlreadyDisplayed (response) {
  if ($('.contact-form__msg-error', response).text()) {
    $('.contact-form__msg-success').replaceWith($('.contact-form__msg-error', response));
  }
}

function makeNotificationVisibleIfNotInViewport () {
  const contactFormNotifications = document.querySelectorAll('.contact-form__msg-success, .contact-form__msg-error');
  for (const notification of contactFormNotifications) {
    if (isInViewport(notification) === false) {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    }
  }
}

function showNameError (response) {
  $('#sender-name-error').text($('#sender-name-error', response).text());
  $("input[name='senderName']").addClass('contact-form__error-outline_red');
}

function removeNameError () {
  $('#sender-name-error').text('');
  $("input[name='senderName']").removeClass('contact-form__error-outline_red');
}

function showEmailError (response) {
  $('#sender-email-error').text($('#sender-email-error', response).text());
  $("input[name='senderEmail']").addClass('contact-form__error-outline_red');
}

function removeEmailError () {
  $('#sender-email-error').text('');
  $("input[name='senderEmail']").removeClass('contact-form__error-outline_red');
}

function showMsgError (response) {
  $('#msg-error').text($('#msg-error', response).text());
  $("textarea[name='msg']").addClass('contact-form__error-outline_red');
}

function removeMsgError () {
  $('#msg-error').text('');
  $("textarea[name='msg']").removeClass('contact-form__error-outline_red');
}

export function dontResubmitContactFormWhenPageReloaded () {
  const contactFormPage = document.querySelector("input[name='name']");
  if (contactFormPage) {
    window.history.replaceState(null, null, window.location.href);
  }
}
