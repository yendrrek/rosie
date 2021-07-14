'use strict';

import { HelperMethods } from './helper-methods.js'; 

export const ExtraImgLightboxInShop = {

  extraImgInnerModal: document.querySelectorAll('.shop__extra-img-modal-inner'),
  extraImgOuterModal: document.querySelectorAll('.shop__extra-img-modal-outer'),

  openShopExtraImgLightbox () {
    const extraImgActivators = document.querySelectorAll('.extra-img-activator');
    for (const [index] of extraImgActivators.entries()) {
      const extraImgLightbox = [
        this.extraImgOuterModal[index],
        this.extraImgInnerModal[index]
      ];
      if (event.target === extraImgActivators[index] && (event.type === 'click' || event.key === 'Enter')) {
        for (const modals of extraImgLightbox) {
          modals.classList.add('shop__extra-img_visible');
        }
        HelperMethods.preventJerkingOfLightbox();
        this.currentExtraImgInnerModal = this.extraImgInnerModal[index];
        this.trapFocusInShopExtraImgLightbox();
      }
    }
  },

  trapFocusInShopExtraImgLightbox () {
    if ((event.key === 'Tab') || (event.shiftKey && event.key === 'Tab')) {
      if (this.currentExtraImgInnerModal.classList.contains('shop__extra-img_visible')) {
        event.preventDefault();
      }
    }
  },

  closeShopExtraImgLightbox () {
    const extraImgCloseBtns = document.querySelectorAll('.close-popup-btn_shop-extra-image');
    for (const [index] of extraImgCloseBtns.entries()) {
      const extraImgLightbox = [
        this.extraImgOuterModal[index],
        this.extraImgInnerModal[index]
      ];
      if ((event.target === extraImgCloseBtns[index] && event.type === 'click') || event.key === 'Escape') {
        for (const modals of extraImgLightbox) {
          if (modals.classList.contains('shop__extra-img_visible')) {
            modals.classList.remove('shop__extra-img_visible');
            modals.classList.add('shop__extra-img_hidden');
            modals.addEventListener('animationend', () => {
              modals.classList.remove('shop__extra-img_hidden');
            });
          }
        }
        HelperMethods.restoreBodyState();
      } 
    }
  }

};