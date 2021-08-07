'use strict';

import { preventJerkingOfLightbox, restoreBodyState } from './helper-methods.js'; 

export function openShopExtraImgLightbox (index) {
  const extraImgActivators = document.querySelectorAll('.extra-img-activator');
  for (const [index] of extraImgActivators.entries()) {
    if (event.target === extraImgActivators[index] && (event.type === 'click' || event.key === 'Enter')) {
      runAnimationOpeningShopExtraImgLightbox(index);
      preventJerkingOfLightbox();
      const currentExtraImgInnerModal = getShopExtraImgLightbox(index)[0];
      trapFocusInShopExtraImgLightbox(currentExtraImgInnerModal);
    }
  }
}

function runAnimationOpeningShopExtraImgLightbox (index) {
  for (const modals of getShopExtraImgLightbox(index)) {
    modals.classList.add('shop__extra-img_visible');
  }
}

function getShopExtraImgLightbox (index) {
  const extraImgInnerModal = document.querySelectorAll('.shop__extra-img-modal-inner');
  const extraImgOuterModal = document.querySelectorAll('.shop__extra-img-modal-outer');
  const extraImgLightbox = [
    extraImgInnerModal[index],
    extraImgOuterModal[index]
  ];
  return extraImgLightbox;
}

function trapFocusInShopExtraImgLightbox (currentExtraImgInnerModal) {
  if ((event.key === 'Tab') || (event.shiftKey && event.key === 'Tab')) {
    if (currentExtraImgInnerModal.classList.contains('shop__extra-img_visible')) {
      event.preventDefault();
    }
  }
}

export function closeShopExtraImgLightbox () {
  const extraImgCloseBtns = document.querySelectorAll('.close-popup-btn_shop-extra-image');
  for (const [index] of extraImgCloseBtns.entries()) {
    if ((event.target === extraImgCloseBtns[index] && event.type === 'click') || event.key === 'Escape') {
      runAnimationClosingShopExtraImgLightbox(index)
      restoreBodyState();
    } 
  }
}

function runAnimationClosingShopExtraImgLightbox (index) {
  for (const modals of getShopExtraImgLightbox(index)) {
    if (modals.classList.contains('shop__extra-img_visible')) {
      modals.classList.remove('shop__extra-img_visible');
      modals.classList.add('shop__extra-img_hidden');
      modals.addEventListener('animationend', () => {
        modals.classList.remove('shop__extra-img_hidden');
      });
    }
  }
}
