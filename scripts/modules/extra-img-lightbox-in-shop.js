'use strict';

import { HelperMethods } from './helper-methods.js'; 

export function openShopExtraImgLightbox () {
  const extraImgInnerModal = document.querySelectorAll('.shop__extra-img-modal-inner');
  const extraImgOuterModal = document.querySelectorAll('.shop__extra-img-modal-outer');
  const extraImgActivators = document.querySelectorAll('.extra-img-activator');
  for (const [index] of extraImgActivators.entries()) {
    const extraImgLightbox = [
      extraImgInnerModal[index],
      extraImgOuterModal[index]
    ];
    if (event.target === extraImgActivators[index] && (event.type === 'click' || event.key === 'Enter')) {
      for (const modals of extraImgLightbox) {
        modals.classList.add('shop__extra-img_visible');
      }
      HelperMethods.preventJerkingOfLightbox();
      const currentExtraImgInnerModal = extraImgInnerModal[index];
      trapFocusInShopExtraImgLightbox(currentExtraImgInnerModal);
    }
  }
}

function trapFocusInShopExtraImgLightbox (currentExtraImgInnerModal) {
  if ((event.key === 'Tab') || (event.shiftKey && event.key === 'Tab')) {
    if (currentExtraImgInnerModal.classList.contains('shop__extra-img_visible')) {
      event.preventDefault();
    }
  }
}

export function closeShopExtraImgLightbox () {
  const extraImgInnerModal = document.querySelectorAll('.shop__extra-img-modal-inner');
  const extraImgOuterModal = document.querySelectorAll('.shop__extra-img-modal-outer');
  const extraImgCloseBtns = document.querySelectorAll('.close-popup-btn_shop-extra-image');
  for (const [index] of extraImgCloseBtns.entries()) {
    const extraImgLightbox = [
      extraImgInnerModal[index],
      extraImgOuterModal[index]
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
