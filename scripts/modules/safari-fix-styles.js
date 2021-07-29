'use strict';

export const SafariFixStyles = {

  fixStylesInSafariOnly () {
    this.fixAddToBasketBtn();
    this.fixExtraImgActivatorInShop();
    this.disableChromeImgFix();
  },

  fixAddToBasketBtn () {
    const addToBasketBtns = document.querySelectorAll('.btn_add-to-basket');
    for (const btn of addToBasketBtns) {
      btn.classList.add('btn_add-to-basket_safari-font-fix');
    }
  },

  fixExtraImgActivatorInShop () {
    const extraImgActivators = document.querySelectorAll('.extra-img-activator');
    for (const activator of extraImgActivators) {
      activator.classList.add('word-more-pseudo_safari-position-fix');
    }
  },

  disableChromeImgFix () {
    const slideshowImgs = document.querySelectorAll('.slide__img-rectangle, .slide__img-square');
    for (const img of slideshowImgs) {
      img.classList.add('slide__img_dont-apply-chrome-fix-in-safari');
    }
  }
  
};
