'use strict';

export const HeadingWithBreadcrumbs = {

  headingWithBreadCrumbs: document.querySelector('.body__breadcrumbs'),
  basketIcon: document.querySelector('.basket__icon_breadcrumbs_hidden'),
  wordBasket: document.querySelector('.basket__txt_hidden'),
  productQty: document.querySelector('.number_hidden'),

  controlHeadingWithBreadcrumbs () {
    const scrollDownPosition = document.documentElement.scrollTop;
    if (this.headingWithBreadCrumbs) {
      if (scrollDownPosition > 118) {
        this.makeHeadingWithBreadcrumbsFixed();
      } else {
        this.unfixHeadingWithBreadcrumbs();
      }
    }
  },

  makeHeadingWithBreadcrumbsFixed () {
    this.headingWithBreadCrumbs.classList.add('heading-with-breadcrumbs_fixed');
    this.basketIcon.classList.add('heading-with-breadcrumbs__basket-icon_visible');
    this.wordBasket.classList.add('heading-with-breadcrumbs__word-basket_visible');
    this.productQty.classList.add('heading-with-breadcrumbs__product-qty_visible');
  },

  unfixHeadingWithBreadcrumbs () {
    this.headingWithBreadCrumbs.classList.remove('heading-with-breadcrumbs_fixed');
    this.basketIcon.classList.remove('heading-with-breadcrumbs__basket-icon_visible');
    this.wordBasket.classList.remove('heading-with-breadcrumbs__word-basket_visible');
    this.productQty.classList.remove('heading-with-breadcrumbs__product-qty_visible');
  }

};