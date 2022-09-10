'use strict';

export function controlHeadingWithBreadcrumbs() {
  const show = (element, style) => element.classList.add(style);
  const hide = (element, style) => element.classList.remove(style);

  if (document.documentElement.scrollTop > 118) {
    toggleBreadcrumbsVisibility(show);
    return;
  }
  toggleBreadcrumbsVisibility(hide);
}

function toggleBreadcrumbsVisibility(method) {
  const headingWithBreadCrumbs = document.querySelector('.breadcrumbs');
  const basketIcon = document.querySelector('.basket__icon_breadcrumbs_hidden');
  const wordBasket = document.querySelector('.basket__txt_hidden');
  const productQty = document.querySelector('.number_hidden');

  if (!headingWithBreadCrumbs) {
    return;
  }

  method(headingWithBreadCrumbs, 'heading-with-breadcrumbs_fixed');
  method(basketIcon, 'heading-with-breadcrumbs__basket-icon_visible');
  method(wordBasket, 'heading-with-breadcrumbs__word-basket_visible');
  method(productQty, 'heading-with-breadcrumbs__product-qty_visible');
}
