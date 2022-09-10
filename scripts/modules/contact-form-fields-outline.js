'use strict';

export function controlContactFormFieldsOutline() {
  const contactFormFields = document.querySelectorAll(`
    input[name="senderName"],
    input[name="senderEmail"],
    textarea[name="msg"]
  `);
  const makeDefaultGreenNotOverlayErrorOutline = field => field.classList.remove('contact-form-field-outline');
  const applyDefaultGreenOutline = field => field.classList.add('contact-form-field-outline');

  for (const focusedField of contactFormFields) {
    if (focusedField.classList.contains('contact-form__error-outline_red')) {
      makeDefaultGreenNotOverlayErrorOutline(focusedField);
      return;
    }
    applyDefaultGreenOutline(focusedField);
  }
}
