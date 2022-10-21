'use strict';

import { stopFullPageElementJerk, restoreBodyAfterStoppingFullPageElementJerk } from './helper-methods.js';

export function openShopExtraImage(event) {
  const extraImageActivators = document.querySelectorAll('.extra-img-activator');

  for (const [index] of extraImageActivators.entries()) {
    if (isExtraImageActivated(event, extraImageActivators, index)) {
      runOpeningAnimation(index);
      stopFullPageElementJerk();
      enableTrappingFocus(index);
    }
  }
}

function isExtraImageActivated(event, extraImageActivators, index) {
  return event.target === extraImageActivators[index] && (event.type === 'click' || event.key === 'Enter');
}

function runOpeningAnimation(index) {
  for (const modals of getCurrentExtraImage(index)) {
    modals.classList.add('shop__extra-img_visible');
  }
}

function getCurrentExtraImage(index) {
  const extraImageInnerModal = document.querySelectorAll('.shop__extra-img-modal-inner');
  const extraImageOuterModal = document.querySelectorAll('.shop__extra-img-modal-outer');

  return [extraImageInnerModal[index], extraImageOuterModal[index]];
}

function enableTrappingFocus(index) {
  document.addEventListener('keydown', event =>
      trapFocus(event, getCurrentExtraImage(index)[0]));
}

function trapFocus(event, currentExtraImageInnerModal) {
  if (event.key === 'Tab' || event.shiftKey && event.key === 'Tab') {
    if (currentExtraImageInnerModal.classList.contains('shop__extra-img_visible')) {
      event.preventDefault();
    }
  }
}

export function closeShopExtraImage(event) {
  const extraImageCloseButtons = document.querySelectorAll('.close-popup-btn_shop-extra-image');

  for (const [index] of extraImageCloseButtons.entries()) {
    if (event.target === extraImageCloseButtons[index] && event.type === 'click' || event.key === 'Escape') {
      runClosingAnimation(index);
      restoreBodyAfterStoppingFullPageElementJerk();
    }
  }
}

function runClosingAnimation(index) {
  for (const modals of getCurrentExtraImage(index)) {
    if (modals.classList.contains('shop__extra-img_visible')) {
      modals.classList.remove('shop__extra-img_visible');
      modals.classList.add('shop__extra-img_hidden');
      modals.addEventListener('animationend', () => {
        modals.classList.remove('shop__extra-img_hidden');
      });
    }
  }
}
