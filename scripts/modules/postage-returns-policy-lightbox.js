'use strict';

import { stopFullPageElementJerk, restoreBodyAfterStoppingFullPageElementJerk } from './helper-methods.js';

export function openPostageAndReturnsPolicy() {
  const policyLightbox = document.querySelectorAll('#returns-policy-outer-modal, #returns-policy-inner-modal');

  for (const modals of policyLightbox) {
    modals.classList.add('policy-open-anim');
  }

  stopFullPageElementJerk();

  preparePostageAndReturnsPolicyKeyboardNavigation();
}

function preparePostageAndReturnsPolicyKeyboardNavigation() {
  const innerModal = document.querySelector('#returns-policy-inner-modal');

  innerModal.focus();

  toggleItemFocusability(0);

  for (const event of ['click', 'keydown']) {
    document.addEventListener(event, navigatePostageAndReturnPolicy);
  }
}

function toggleItemFocusability(tabindexValue) {
  const items = document.querySelectorAll(`
    #return-policy-close-btn,
    #first-contact-form-link,
    #second-contact-form-link,
    #third-contact-form-link
  `);

  for (const item of items) {
    item.setAttribute('tabindex', tabindexValue);
  }
}

function navigatePostageAndReturnPolicy(event) {
  const closeButton = document.querySelector('#return-policy-close-btn');

  trapFocusInPostageAndReturnPolicy(event);

  if (event.type === 'click' && event.target === closeButton || event.key === 'Escape') {
    closePostageAndReturnPolicy();

    toggleItemFocusability(-1);
  }
}

function trapFocusInPostageAndReturnPolicy(event) {
  const closeButton = document.querySelector('#return-policy-close-btn');
  const getInTouchLink = document.querySelector('#third-contact-form-link');

  if (event.shiftKey && event.key === 'Tab') {
    focusGetInTouchLink(event, closeButton, getInTouchLink);
    return;
  }

  if (event.key === 'Tab') {
    focusCloseButton(event, closeButton, getInTouchLink);
  }
}

function focusGetInTouchLink(event, closeButton, getInTouchLink) {
  if (document.activeElement === closeButton || isUserClickingAnywhere()) {
    event.preventDefault();
    getInTouchLink.focus();
  }
}

function isUserClickingAnywhere() {
  const policyInnerModal = document.querySelector('#returns-policy-inner-modal');
  const policyOuterModal = document.querySelector('#returns-policy-outer-modal');

  return document.activeElement === policyOuterModal || document.activeElement === policyInnerModal;
}

function focusCloseButton(event, closeButton, getInTouchLink) {
  if (document.activeElement === getInTouchLink) {
    event.preventDefault();
    closeButton.focus();
  }
}

function closePostageAndReturnPolicy() {
  const policyLightbox = document.querySelectorAll('#returns-policy-outer-modal, #returns-policy-inner-modal');

  for (const modals of policyLightbox) {
    modals.classList.remove('policy-open-anim');
    modals.classList.add('policy-close-anim');
    modals.addEventListener('animationend', () => {
      modals.classList.remove('policy-close-anim');
    });
  }

  restoreBodyAfterStoppingFullPageElementJerk();

  for (const event of ['click', 'keydown']) {
    document.removeEventListener(event, navigatePostageAndReturnPolicy);
  }
}
  