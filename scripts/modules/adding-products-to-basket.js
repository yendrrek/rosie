'use strict';

import { HelperMethods } from './helper-methods.js';

import { continuationOfTabbingFrom } from '../main.js';

export function addProductToBasket (event) {
  continuationOfTabbingFrom.addToBasketBtnWhichOpenedAddedToBasketNotificationLightbox = $(
    event.currentTarget).find('.btn_add-to-basket');
  $.ajax({
    url: 'basket',
    method: 'POST',
    data: $(event.currentTarget).serialize(),
    dataType: 'text',
    success: function(response) {
      showQtyInBasketIcon();
      if ($('#stock-limit-info-outer-modal', response).length) {
        openStockLimitInfoLightbox(response);
      } else {
        openAddedToBasketLightbox();
      }
    },
    error() {
      alert('Problem with receiving reply from the server. Please come back later.');
    }
  });
}

function showQtyInBasketIcon () {
  $('.number span, .number_hidden span').load('basket.php #number');
}

function openStockLimitInfoLightbox (response) {
  removeStockLimitInfoLightboxOfPreviousProduct();
  HelperMethods.preventJerkingOfLightbox();
  $('.shop-info').append($('#stock-limit-info-outer-modal', response));
  $('#stock-limit-info-outer-modal, .modal-inner_stock-info').addClass('stock-info-lightbox-visible');
  makeStockLimitInfoLightboxTabable(); 
  $(document).on('click keydown', controlStockLimitInfoLightbox);
}

function removeStockLimitInfoLightboxOfPreviousProduct () {
  if ($('#stock-limit-info-outer-modal').length) {
    $('#stock-limit-info-outer-modal').remove();
  }
}

function makeStockLimitInfoLightboxTabable () {
  $('.modal-inner__stock-limit-info').focus();
  $('#stock-limit-info-close-btn').attr('tabindex', '0');
}

function controlStockLimitInfoLightbox () {
  if ((event.shiftKey && event.key === 'Tab') || (event.key === 'Tab')) {
    trapFocusInStockLimitInfoLightbox();
  } else if (userWantsToCloseStockLimitInfoLightbox()) {
    closeStockLimitInfoLightbox();
    HelperMethods.restoreBodyScrollbar();
  }
}

function trapFocusInStockLimitInfoLightbox () {
  const stockLimitInfoCloseBtn = document.querySelector('#stock-limit-info-close-btn');
  const stockLimitInfoLinkToContactForm = document.querySelector('#stock-info-link');
  if (document.activeElement === stockLimitInfoCloseBtn) {
    event.preventDefault();
    stockLimitInfoLinkToContactForm.focus();
  } else {
    event.preventDefault();
    stockLimitInfoCloseBtn.focus();
  }
}

function userWantsToCloseStockLimitInfoLightbox () {
  const stockLimitInfoCloseBtn = document.querySelector('#stock-limit-info-close-btn');
  if (event.key === 'Escape' ||
    (event.key === 'Enter' && event.target === stockLimitInfoCloseBtn) ||
    (event.type === 'click' && event.target === stockLimitInfoCloseBtn)) {
    return true;
  }
}

function closeStockLimitInfoLightbox () {
  const stockLimitInfoLightbox = document.querySelectorAll(
    '#stock-limit-info-outer-modal, .modal-inner__stock-limit-info'
  );
  for (const modals of stockLimitInfoLightbox) {
    modals.classList.remove('stock-info-lightbox-visible');
    modals.classList.add('stock-info-lightbox-hidden');
    modals.addEventListener('animationend', () => {
      modals.classList.remove('stock-info-lightbox-hidden');
    });
  }
  HelperMethods.restoreBodyState();
  $(document).off('click keydown', controlStockLimitInfoLightbox);
  continueTabbing();
}

function continueTabbing () {
  const stockLimitInfoCloseBtn = document.querySelector('#stock-limit-info-close-btn');
  if (stockLimitInfoCloseBtn) {
    stockLimitInfoCloseBtn.setAttribute('tabindex', '-1');
  }
  continuationOfTabbingFrom.addToBasketBtnWhichOpenedAddedToBasketNotificationLightbox.focus();
}

function openAddedToBasketLightbox () {
  HelperMethods.preventJerkingOfLightbox();
  $('#added-to-basket-outer-modal, #added-to-basket-inner-modal').addClass('product-added-lightbox-visible');
  $('#added-to-basket-inner-modal').focus();
  $(document).on('click keydown', controlAddedToBasketLightbox);
}

function controlAddedToBasketLightbox () {
  if ((event.key === 'Tab') || (event.shiftKey && event.key === 'Tab')) {
    event.preventDefault();
  } else if (userWantsToCloseAddedToBasketLightbox()) {
    closeAddedToBasketLightbox();
  }
}

function userWantsToCloseAddedToBasketLightbox () {
  const addedToBasketCloseBtn = document.querySelector('#close-added-to-basket');
  if (event.key === 'Escape' || event.target === addedToBasketCloseBtn) {
    return true;
  }
}

function closeAddedToBasketLightbox () {
  const addedToBasketLightbox = document.querySelectorAll(
    '#added-to-basket-outer-modal, #added-to-basket-inner-modal'
  );
  for (const modals of addedToBasketLightbox) {
    modals.classList.remove('product-added-lightbox-visible');
    modals.classList.add('product-added-confirmation-close-anim');
    modals.addEventListener('animationend', () => {
      modals.classList.remove('product-added-confirmation-close-anim');
    });
  }
  HelperMethods.restoreBodyState();
  $(document).off('click keydown', controlAddedToBasketLightbox);
  continueTabbing();
}
  