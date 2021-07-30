'use strict';

export function controlContactFormFieldsOutline () {
  const contactFormFields = document.querySelectorAll(`
    input[name="senderName"],
    input[name="senderEmail"],
    textarea[name="msg"]
  `);
  for (const focusedField of contactFormFields) {
    if (focusedField.classList.contains('contact-form__error-outline_red')) {
      makeDefaultGreenNotOverlayErrorOutline(focusedField);
    } else {
      applyDefaultGreenOutline(focusedField);
    }
  }
}

function makeDefaultGreenNotOverlayErrorOutline (focusedField) {
  focusedField.classList.remove('contact-form-field-outline');
}

function applyDefaultGreenOutline (focusedField) {
  focusedField.classList.add('contact-form-field-outline'); 
}
