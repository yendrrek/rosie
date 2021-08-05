'use strict';

export function controlHeadingWithBreadcrumbs () {
  const headingWithBreadCrumbs = document.querySelector('.body__breadcrumbs');
  const basketIcon = document.querySelector('.basket__icon_breadcrumbs_hidden');
  const wordBasket = document.querySelector('.basket__txt_hidden');
  const productQty = document.querySelector('.number_hidden');
  const scrollDownPosition = document.documentElement.scrollTop;
  if (headingWithBreadCrumbs) {
    if (scrollDownPosition > 118) {
      makeHeadingWithBreadcrumbsFixed(headingWithBreadCrumbs, basketIcon, wordBasket, productQty);
    } else {
      unfixHeadingWithBreadcrumbs(headingWithBreadCrumbs, basketIcon, wordBasket, productQty);
    }
  }
}

function makeHeadingWithBreadcrumbsFixed (headingWithBreadCrumbs, basketIcon, wordBasket, productQty) {
  headingWithBreadCrumbs.classList.add('heading-with-breadcrumbs_fixed');
  basketIcon.classList.add('heading-with-breadcrumbs__basket-icon_visible');
  wordBasket.classList.add('heading-with-breadcrumbs__word-basket_visible');
  productQty.classList.add('heading-with-breadcrumbs__product-qty_visible');
}

function unfixHeadingWithBreadcrumbs (headingWithBreadCrumbs, basketIcon, wordBasket, productQty) {
  headingWithBreadCrumbs.classList.remove('heading-with-breadcrumbs_fixed');
  basketIcon.classList.remove('heading-with-breadcrumbs__basket-icon_visible');
  wordBasket.classList.remove('heading-with-breadcrumbs__word-basket_visible');
  productQty.classList.remove('heading-with-breadcrumbs__product-qty_visible');
}
