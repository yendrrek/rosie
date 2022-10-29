'use strict';

import { isInViewport } from './helper-methods.js';

export function sendMessageViaContactForm(event) {
  event.preventDefault();
  $.ajax({
    method: 'POST',
    data: $(event.currentTarget).serialize(),
    dataType: 'text',
    success(response) {
      toggleGeneralNotifications(response);
      toggleFieldErrors(response);
      showGeneralNotificationIfNotInViewport();
    }
  });
}

function toggleGeneralNotifications(response) {
  const selectors = ['.contact-form__msg-error', '.contact-form__msg-success'];

  $(selectors).each(index => {
    if ($(selectors[index], response).text()) {
      if (notificationWillBeShownFirstTime()) {
        showNotificationFirstTime($(selectors[index], response));
        return false;
      }

      replaceOppositeNotification($(selectors[index === 0 ? 1 : 0]), $(selectors[index], response));
    }
  });
}

const notificationWillBeShownFirstTime = () => $('form').is(':first-child');
const showNotificationFirstTime = selector => $('.contact-form').prepend(selector);
const replaceOppositeNotification = (oppositeSelector, selector) => oppositeSelector.replaceWith(selector);

function toggleFieldErrors(response) {
  const selectors = ['#sender-name-error', '#sender-email-error', '#msg-error'];
  const fields = [$('input[name="senderName"]'), $('input[name="senderEmail"]'), $('textarea[name="msg"]')];

  $(selectors).each(index => {
    if ($(selectors[index], response).text()) {
      showFieldError(response, selectors[index], fields[index]);
    } else {
      hideFieldError(selectors[index], fields[index]);
    }
  });
}

function showFieldError(response, selector, field) {
  $(selector).text($(selector, response).text());
  showRedOutline(field);
}

function hideFieldError(selector, field) {
  $(selector).text('');
  hideRedOutline(field);
}

const showRedOutline = field => field.addClass('contact-form__error-outline_red');
const hideRedOutline = field => field.removeClass('contact-form__error-outline_red');

function showGeneralNotificationIfNotInViewport() {
  const notifications = document.querySelectorAll('.contact-form__msg-success, .contact-form__msg-error');

  for (const notification of notifications) {
    if (isInViewport(notification)) {
      return;
    }

    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }
}

export function dontResubmitContactFormWhenPageReloaded() {
  const contactFormPage = document.querySelector('input[name="name"]');

  if (!contactFormPage) {
    return;
  }

  window.history.replaceState(null, null, window.location.href);
}
