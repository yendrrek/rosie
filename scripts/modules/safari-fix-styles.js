'use strict';

export function fixElementsInSafariOnly() {
  fix('.btn_add-to-basket', 'btn_add-to-basket_safari-font-fix');
  fix('.extra-img-activator', 'word-more-pseudo_safari-position-fix');
  fix('.slide__img-rectangle, .slide__img-square', 'slide__img_dont-apply-chrome-fix-in-safari');
}

function fix(selector, fixingStyle) {
  const elementsToFix = document.querySelectorAll(selector);
  elementsToFix.forEach(element => element.classList.add(fixingStyle));
}
  