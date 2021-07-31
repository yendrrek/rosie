'use strict';

import { HelperMethods } from './helper-methods.js';

export function controlBasket (event) {
  const url = (event.type === 'click' && $(event.currentTarget).attr('href'));
  const removeProductOrRemoveAllLinkClicked = (url !== false);
  const qtyDropDownMenuID = (event.type === 'change' && $(event.currentTarget).attr('id').replace('productId', ''));
  const updatedQty = (event.type === 'change' && $(event.currentTarget).val());
  const formToken = (event.type === 'change' && $('input').val());
  $.ajax({
    url: url,
    method: 'POST',
    data: {
      qtyDropDownMenuId: qtyDropDownMenuID,
      newQty: updatedQty,
      tokenCsrf: formToken
    },
    success(response) {
      if (removeProductOrRemoveAllLinkClicked) {
        if (url.includes('removeSingleProduct')) {
          removeSingleProductFromBasket(event);
          loadElementsForBasketEmptyPage(response, url);
        } else if (url.includes('removeAllProducts')) {
          loadElementsForBasketEmptyPage(response, url);
        }
      } else if (updatedQty > 0) {
        increaseOrDecreaseQtyInBasket(response);
      } else {
        removeProductWithZeroQtyFromBasket(qtyDropDownMenuID);
        loadElementsForBasketEmptyPage(response, url);
      }
      updateTotalPriceOfOrderInBasket(response);
      makeTotalPriceVisibleIfNotInViewport();
      updateQtyInBasketIcon(response);
      hideRemoveAllBtn();
    },
    error() {
      alert('Problem with receiving reply from the server. Please come back later.');
    }
  });
}

function removeSingleProductFromBasket (event) {
  $('.btn-basket_remove-product-single').each(function (index) {
    if (event.target === $('.btn-basket_remove-product-single')[index]) {
      $('.btn-basket_remove-product-single')[index].closest('tbody').remove();
    }
  });
}

function loadElementsForBasketEmptyPage (response, url) {
  const basketEmptyPageHeader = $('<div/>').append(response).find('header').html();
  const basketEmptyPageBody = $('<div/>').append(response).find('.basket-empty');
  if ($('form').length === 0 || ($('form').length > 0 && url !== false && url.includes('removeAllProducts'))) {
    $('header').html(basketEmptyPageHeader);
    $('.body__table-container').replaceWith(basketEmptyPageBody);
    $('#breadcrumbs-basket-icon-qty').html('0');
    $('#paypal-smart-button-script, #paypal-sdk-head-script, #returns-policy-outer-modal').remove();
  }
}

function increaseOrDecreaseQtyInBasket (response) {
  $.each($('.table__product-total-price'), function () {
    $.each($('.table__product-total-price', response), function (index) {
      $($('.table__product-total-price')[index]).text($($('.table__product-total-price', response)[index]).text());
    });
  });
}

function removeProductWithZeroQtyFromBasket (qtyDropDownMenuID) {
  $.each($('.table__form-basket-qty-menu'), function (index) {
    if ($($('.table__form-basket-qty-menu')[index]).attr('id') === qtyDropDownMenuID) {
      $($('.table__form-basket-qty-menu')[index]).closest('tbody').remove();
    }
  });
}

function updateTotalPriceOfOrderInBasket (response) {
  $('.table__order-total').text($('.table__order-total', response).text());
}

function makeTotalPriceVisibleIfNotInViewport () {
  const totalPrice = document.querySelector('.table__order-total');
  const deviceOnWhichSingleTotalPricesNotSeen = (window.innerWidth <= 709);
  if (totalPrice && deviceOnWhichSingleTotalPricesNotSeen && HelperMethods.isInViewport(totalPrice) === false) {
    window.scrollBy({
      top: window.innerHeight,
      behavior: 'smooth'
    });
  }
}

function updateQtyInBasketIcon (response) {
  $('#number').text($('#number', response).text());
  $('#breadcrumbs-basket-icon-qty').html($('#breadcrumbs-basket-icon-qty', response).html());
}

function hideRemoveAllBtn () {
  if ($('.table__border-top-bottom').length < 2) {
    $('.btn-basket_remove-product-all').remove();
  }
}

