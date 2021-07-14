'use strict';

export const OutlineForKeyboardUsers = {

  focusableElements: () => document.querySelectorAll(`
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
 `),

  enableOutline () {
    if (event.key === 'Tab' || (event.shiftKey && event.key === 'Tab')) {
      document.addEventListener('focusin', this.showOutline());
    }
  },

  showOutline () {
    for (const elements of this.focusableElements()) {
      elements.classList.remove('outline-none');
    }
    this.controlContactFormFieldOutline(); 
  },

  controlContactFormFieldOutline () {
    const contactFormFields = document.querySelectorAll(`
      input[name="senderName"],
      input[name="senderEmail"],
      textarea[name="msg"]
    `);
    for (const field of contactFormFields) {
      if (event.target === field) {
        if (field.classList.contains('contact-form__error-outline_red')) {
          field.classList.remove('contact-form-field-outline');
        } else {
          field.classList.add('contact-form-field-outline');
        }
      }
    }
  },

  hideOutline () {
    for (const elements of this.focusableElements()) {
      elements.classList.add('outline-none');
    }
    document.removeEventListener('focusin', this.showOutline);
    this.controlContactFormFieldOutline();  
  }
  
};
