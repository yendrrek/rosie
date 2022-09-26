'use strict';

import {
  stopFullPageElementJerk,
  restoreBodyScrollbar,
  restoreBodyAfterStoppingFullPageElementJerk
} from './helper-methods.js';

import { continuationOfTabbingFrom } from '../main.js';

export function addProductToBasket(event) {
  continuationOfTabbingFrom.addToBasketBtn = $(event.currentTarget).find($('.btn_add-to-basket'));
  $.ajax({
    url: 'basket',
    method: 'POST',
    data: $(event.currentTarget).serialize(),
    dataType: 'text',

    success: function(response) {
      const $stockLimitInfoOuterModal = $('#stock-limit-info-outer-modal');
      showQuantityInBasketIcon(response);
      if (quantityOfProductsAddedToBasketIsNotExceedingStockAmount(response)) {
        openAddedToBasketInfo();
        return;
      }
      openStockLimitInfoInfo($stockLimitInfoOuterModal, response);
    },

    error() {
      alert('Problem with receiving reply from the server.');
    }
  });
}

function showQuantityInBasketIcon(response) {
  $('.number span, .number_hidden span').replaceWith($('#number', response));
}

function quantityOfProductsAddedToBasketIsNotExceedingStockAmount(response) {
  return !$('#stock-limit-info-outer-modal', response).length;
}

function openAddedToBasketInfo() {
  stopFullPageElementJerk();
  showInfo('#added-to-basket-outer-modal, #added-to-basket-inner-modal', 'product-added-lightbox-visible');
  $('#added-to-basket-inner-modal').focus();
  $(document).on('click keydown', controlAddedToBasketInfo);
}

function controlAddedToBasketInfo(event) {
  const addedToBasketCloseButton = document.querySelector('#close-added-to-basket');

  if (event.key === 'Tab' || event.shiftKey && event.key === 'Tab') {
    event.preventDefault();
  }

  if (event.key === 'Escape' || event.target === addedToBasketCloseButton) {
    closeAddedToBasketInfo();
  }
}

function closeAddedToBasketInfo() {
  const addedToBasketLightbox = document.querySelectorAll('#added-to-basket-outer-modal, #added-to-basket-inner-modal');

  hideInfo(addedToBasketLightbox, 'product-added-lightbox-visible', 'product-added-confirmation-close-anim');
  restoreBodyAfterStoppingFullPageElementJerk();
  $(document).off('click keydown', controlAddedToBasketInfo);
  continueTabbing();
}

function openStockLimitInfoInfo($stockLimitInfoOuterModal, response) {
  removeStockLimitInfoOfPreviousProduct($stockLimitInfoOuterModal);
  stopFullPageElementJerk();
  insertStockLimitInfoIntoShopPage(response);
  showInfo('#stock-limit-info-outer-modal, .modal-inner_stock-info', 'stock-info-lightbox-visible');
  makeStockLimitInfoTabable();
  $(document).on('click keydown', controlStockLimitInfo);
}

function removeStockLimitInfoOfPreviousProduct($stockLimitInfoOuterModal) {
  if ($($stockLimitInfoOuterModal).length) {
    $($stockLimitInfoOuterModal).remove();
  }
}

function insertStockLimitInfoIntoShopPage(response) {
  $('.shop-info').append($('#stock-limit-info-outer-modal', response));
}

function makeStockLimitInfoTabable() {
  $('.modal-inner__stock-limit-info').focus();
  $('#stock-limit-info-close-btn').attr('tabindex', '0');
}

function controlStockLimitInfo(event) {
  const stockLimitInfoCloseBtn = document.querySelector('#stock-limit-info-close-btn');

  if (event.shiftKey && event.key === 'Tab' || event.key === 'Tab') {
    trapFocusInStockLimitInfo(event);
  }

  if (event.key === 'Escape' || event.target === stockLimitInfoCloseBtn && event.type === 'click') {
    closeStockLimitInfo();
    restoreBodyScrollbar();
  }
}

function trapFocusInStockLimitInfo(event) {
  const stockLimitInfoCloseButton = document.querySelector('#stock-limit-info-close-btn');
  const stockLimitInfoLinkToContactForm = document.querySelector('#stock-info-link');

  if (document.activeElement === stockLimitInfoCloseButton) {
    event.preventDefault();
    stockLimitInfoLinkToContactForm.focus();
    return;
  }
  event.preventDefault();
  stockLimitInfoCloseButton.focus();
}

function closeStockLimitInfo() {
  const stockLimitInfoLightbox = document.querySelectorAll('#stock-limit-info-outer-modal, .modal-inner__stock-limit-info');

  hideInfo(stockLimitInfoLightbox, 'stock-info-lightbox-visible', 'stock-info-lightbox-hidden');
  restoreBodyAfterStoppingFullPageElementJerk();
  $(document).off('click keydown', controlStockLimitInfo);
  continueTabbing();
}

function showInfo(lightbox, styleToShowLightbox) {
  $(lightbox).addClass(styleToShowLightbox);
}

function hideInfo(lightbox, styleToShowLightbox, styleToHideLightbox) {
  for (const modals of lightbox) {
    modals.classList.remove(styleToShowLightbox);
    modals.classList.add(styleToHideLightbox);
    endAnimationWhichHidesInfo(modals, 'animationend', styleToHideLightbox);
  }
}

function endAnimationWhichHidesInfo(modals, eventType, styleToHideLightbox) {
  modals.addEventListener(eventType, () => {
    modals.classList.remove(styleToHideLightbox);
  });
}

function continueTabbing() {
  const stockLimitInfoCloseBtn = document.querySelector('#stock-limit-info-close-btn');

  if (stockLimitInfoCloseBtn) {
    stockLimitInfoCloseBtn.setAttribute('tabindex', '-1');
  }

  continuationOfTabbingFrom.addToBasketBtn.focus();
}
