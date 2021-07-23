'use strict';

import { HelperMethods } from './helper-methods.js';
  
export const AddingProductsToBasket = {

  stockLimitInfoCloseBtn: () => document.querySelector('#stock-limit-info-close-btn'),

  addProductToBasket (event) {
    const _this = AddingProductsToBasket;
    this.willContinueTabbingFromSameAddToBasketBtn = $(event.currentTarget).find('.btn_add-to-basket');
    $.ajax({
      url: 'basket',
      method: 'POST',
      data: $(event.currentTarget).serialize(),
      dataType: 'text',
      success: function(response) {
        _this.showQtyInBasketIcon();
        if ($('#stock-limit-info-outer-modal', response).length) {
          _this.openStockLimitInfoLightbox(response);
        } else {
          _this.openAddedToBasketLightbox();
        }
      },
      error() {
        alert('Problem with receiving reply from the server. Please come back later.');
      }
    });
  },

  showQtyInBasketIcon () {
    $('.number span, .number_hidden span').load('basket.php #number');
  },

  openStockLimitInfoLightbox (response) {
    this.removeStockLimitInfoLightboxOfPreviousProduct();
    HelperMethods.preventJerkingOfLightbox();
    $('.shop-info').append($('#stock-limit-info-outer-modal', response));
    $('#stock-limit-info-outer-modal, .modal-inner_stock-info').addClass('stock-info-lightbox-visible');
    this.makeStockLimitInfoLightboxTabable(); 
    this.referenceToControlStockLimitInfoLightbox = this.controlStockLimitInfoLightbox.bind(this);
    $(document).on('click keydown', this.referenceToControlStockLimitInfoLightbox);
  },

  removeStockLimitInfoLightboxOfPreviousProduct () {
    if ($('#stock-limit-info-outer-modal').length) {
      $('#stock-limit-info-outer-modal').remove();
    }
  },

  makeStockLimitInfoLightboxTabable () {
    $('.modal-inner__stock-limit-info').focus();
    $('#stock-limit-info-close-btn').attr('tabindex', '0');
  },

  controlStockLimitInfoLightbox () {
    if ((event.shiftKey && event.key === 'Tab') || (event.key === 'Tab')) {
      this.trapFocusInStockLimitInfoLightbox();
    } else if (this.userWantsToCloseStockLimitInfoLightbox()) {
      this.closeStockLimitInfoLightbox();
      HelperMethods.restoreBodyScrollbar();
    }
  },

  trapFocusInStockLimitInfoLightbox () {
    const stockLimitInfoLinkToContactForm = document.querySelector('#stock-info-link');
    if (document.activeElement === this.stockLimitInfoCloseBtn()) {
      event.preventDefault();
      stockLimitInfoLinkToContactForm.focus();
    } else {
      event.preventDefault();
      this.stockLimitInfoCloseBtn().focus();
    }
  },

  userWantsToCloseStockLimitInfoLightbox () {
    if (event.key === 'Escape' ||
      (event.key === 'Enter' && event.target === this.stockLimitInfoCloseBtn()) ||
      (event.type === 'click' && event.target === this.stockLimitInfoCloseBtn())) {
      return true;
    }
  },

  closeStockLimitInfoLightbox () {
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
    $(document).off('click keydown', this.referenceToControlStockLimitInfoLightbox);
    this.continueTabbing();
  },

  continueTabbing () {
    if (this.stockLimitInfoCloseBtn()) {
      this.stockLimitInfoCloseBtn().setAttribute('tabindex', '-1');
    }
    this.willContinueTabbingFromSameAddToBasketBtn.focus();
  },

  openAddedToBasketLightbox () {
    HelperMethods.preventJerkingOfLightbox();
    $('#added-to-basket-outer-modal, #added-to-basket-inner-modal').addClass('product-added-lightbox-visible');
    $('#added-to-basket-inner-modal').focus();
    this.referenceToControlAddedToBasketLightbox = this.controlAddedToBasketLightbox.bind(this);
    $(document).on('click keydown', this.referenceToControlAddedToBasketLightbox);
  },

  controlAddedToBasketLightbox () {
    if ((event.key === 'Tab') || (event.shiftKey && event.key === 'Tab')) {
      event.preventDefault();
    } else if (this.userWantsToCloseAddedToBasketLightbox()) {
      this.closeAddedToBasketLightbox();
    }
  },

  userWantsToCloseAddedToBasketLightbox () {
    const addedToBasketCloseBtn = document.querySelector('#close-added-to-basket');
    if (event.key === 'Escape' || event.target === addedToBasketCloseBtn) {
      return true;
    }
  },

  closeAddedToBasketLightbox () {
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
    $(document).off('click keydown', this.referenceToControlAddedToBasketLightbox);
    this.continueTabbing();
  }
  
};
