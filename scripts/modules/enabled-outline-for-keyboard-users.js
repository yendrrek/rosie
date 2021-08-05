'use strict';

/**
 * Function expression used instead of a variable to get the up to date 'focusableElements'
 * imported in the module 'disabled-outline-for-keyboard-users.js' when updating the HTML
 * layer of the page after an ajax call. Otherwise, clicked 'focusableElements' will get
 * outlined, which should only happen when using keyboard.
*/

export const focusableElements = () => document.querySelectorAll(`
  .arrow_outline, 
  .basket_outline,
  .btn_add-to-basket_outline,
  .btn-basket_outline,
  .btn_send-contact-form_outline,
  .close-popup-btn_outline,
  .extra-img-activator_outline,
  .icon_zoom-and-close_outline,
  .link_breadcrumbs-home_outline,
  .link_font_outline,
  .link_instagram_outline,
  .link_shop-info-font_italic_outline,
  .logo_outline, 
  .nav__link_outline,
  .policy-activator_outline,
  .subnav__link_outline,
  .thumbnail-clickable-area_outline,
  .qty-box_outline
`);

export function enableOutline () {
  document.addEventListener('focusin', showOutline());
}

function showOutline () {
  for (const elements of focusableElements()) {
    elements.classList.remove('outline-none');
  }
}
