'use strict';

import { isInViewport } from './helper-methods.js';

export function controlBasket(event) {
  const removeButtonURL = $(event.currentTarget).attr('href');
  const quantityDropDownMenuIdInBasket = getQuantityDropDownMenuIdInBasket(event);
  const updatedQuantity = event.type === 'change' ? $(event.currentTarget).val() : null;
  const formToken = $(event.currentTarget).siblings('input[name="tokenCsrf"]').val();
  const removeProductButton = $(event.currentTarget).attr('href') ? $('.btn-basket_remove-product-single') : null;
  const containerFormOfQuantityDropDownMenu = $('.table__form-basket-qty-menu');

  $.ajax({
    url: removeButtonURL,
    method: 'POST',
    data: {
      quantityDropDownMenuIdInBasket: quantityDropDownMenuIdInBasket,
      nameOfProductWithQuantityUpdatedInBasket: getProductName(event.currentTarget),
      newQty: updatedQuantity,
      tokenCsrf: formToken
    },

    success: function(response) {
      if (isToBeRemovedSingleProduct(removeButtonURL, updatedQuantity)) {
        removeSingleProduct(
            event,
            removeProductButton || containerFormOfQuantityDropDownMenu,
            quantityDropDownMenuIdInBasket
        );
      } else {
        updateProductQuantityInBasket(response);
      }

      if (isBasketEmpty(removeButtonURL)) {
        loadElementsForBasketEmptyPage(response);
      }

      updateTotalPriceOfOrderInBasket(response);
      showTotalPriceIfNotInSmallerScreensViewport();
      updateQuantityInBasketIcon(response);
      hideRemoveAllBtn();
    },
    error() {
      console.error('Problem with receiving reply from the server.');
    }
  });
}

function getQuantityDropDownMenuIdInBasket(event) {
  if (event.type === 'change') {
    return removeSuffixAddedToAvoidIdDuplication($(event.currentTarget).attr('id'));
  }
}

function removeSuffixAddedToAvoidIdDuplication(quantityDropDownMenuIdWithSuffix) {
  return quantityDropDownMenuIdWithSuffix.replace('productId', '');
}

function getProductName(eventCurrentTarget) {
  return getNameWhenQuantityUpdatedUsingDropDownMenu(eventCurrentTarget) || getNameWhenProductRemovedWithButton();
}

function getNameWhenQuantityUpdatedUsingDropDownMenu(eventTarget) {
  return $(eventTarget).siblings('input[name="nameOfProductWithQuantityUpdatedInBasket"]').val();
}

function getNameWhenProductRemovedWithButton() {
  return $('input[name="nameOfProductWithQuantityUpdatedInBasket"]').val();
}

function isToBeRemovedSingleProduct(removeButtonURL, updatedQuantity) {
  return removeButtonURL && removeButtonURL.includes('removeSingleProduct') || updatedQuantity === '0';
}

function removeSingleProduct(event, removingElement, quantityDropDownMenuIdInBasket) {
  removingElement.each(index => {
    if (isUsedButton(event, removingElement[index])) {
      return;
    }

    useDropDownMenu(quantityDropDownMenuIdInBasket, removingElement[index]);
  });
}

function isUsedButton(event, removeButton) {
  if (event.type === 'change') {
    return false;
  }

  if (event.target === removeButton) {
    removeButton.closest('tbody').remove();
  }
  return true;
}

function useDropDownMenu(quantityDropDownMenuIdInBasket, containerFormOfQuantityDropDownMenu) {
  if ($(containerFormOfQuantityDropDownMenu).attr('id') === quantityDropDownMenuIdInBasket) {
    containerFormOfQuantityDropDownMenu.closest('tbody').remove();
  }
}

function updateProductQuantityInBasket(response) {
  $('.table__product-total-price').each( index => {
      $($('.table__product-total-price')[index]).text(getUpdatedProductQuantityInBasketFromServer(response, index));
  });
}

function getUpdatedProductQuantityInBasketFromServer(response, index) {
  return $($('.table__product-total-price', response)[index]).text();
}

function isBasketEmpty(removeButtonURL) {
  return $('form').length === 0 || removeButtonURL && removeButtonURL.includes('removeAllProducts');
}

function loadElementsForBasketEmptyPage(response) {
  loadHeader(response);
  loadNavigationButtons(response);
  showZeroInBreadcrumbsBasketIcon();
  removePayPalElements();
}

function loadHeader(response) {
  return $('header').html($($('header', response)).html());
}

function loadNavigationButtons(response) {
  return $('.table-container').replaceWith($($('.basket-empty', response)));
}

function showZeroInBreadcrumbsBasketIcon() {
  return $('#breadcrumbs-basket-icon-qty').html('0');
}

function removePayPalElements() {
  return $('#paypal-smart-button-script, #paypal-sdk-head-script, #returns-policy-outer-modal').remove();
}

function updateTotalPriceOfOrderInBasket(response) {
  $('.table__order-total').text($('.table__order-total', response).text());
}

function showTotalPriceIfNotInSmallerScreensViewport() {
  const totalPrice = document.querySelector('.table__order-total');

  if (!totalPrice || isInViewport(totalPrice) || window.innerWidth > 709) {
    return;
  }

  window.scrollBy({
    top: window.innerHeight,
    behavior: 'smooth'
  });
}

function updateQuantityInBasketIcon(response) {
  inHeader(response);
  inBreadcrumbs(response);
}

const inHeader = response => $('#number').text($('#number', response).text());
const inBreadcrumbs = response => $('#breadcrumbs-basket-icon-qty').html($('#breadcrumbs-basket-icon-qty', response).html());

function hideRemoveAllBtn() {
  if (isOneProductInBasket()) {
    $('.btn-basket_remove-product-all').remove();
  }
}

function isOneProductInBasket() {
  return $('.table__border-top-bottom').length < 2;
}
