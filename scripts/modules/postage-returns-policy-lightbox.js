'use strict';

import { HelperMethods } from './helper-methods.js';

export const PostageReturnsPolicyLightbox = {

  policyCloseBtn: document.querySelector('#return-policy-close-btn'),
  policyGetInTouchLink: document.querySelector('#third-contact-form-link'),
  policyInnerModal: document.querySelector('#returns-policy-inner-modal'),
  policyLightbox: document.querySelectorAll('#returns-policy-outer-modal, #returns-policy-inner-modal'),
  policyLightboxClickableElements: document.querySelectorAll('#return-policy-close-btn, #first-contact-form-link, #second-contact-form-link, #third-contact-form-link'),

  openPPRPolicyLightbox () {
    for (const modals of this.policyLightbox) {
      modals.classList.add('policy-open-anim');
    }
    HelperMethods.preventJerkingOfLightbox();
    this.preparePPRPolicyLightboxKeyboardNavigation();    
  },

  preparePPRPolicyLightboxKeyboardNavigation () {
    this.policyInnerModal.focus();
    this.makePPRPolicyLightboxClickableElementsFocusable();        
    this.referenceToControlPPRPolicyLightbox = this.controlPPRPolicyLightbox.bind(this);
    for (const event of ['click', 'keydown']) {
      document.addEventListener(event, this.referenceToControlPPRPolicyLightbox);
    }
  },

  makePPRPolicyLightboxClickableElementsFocusable () {
    for (const contactFormLinksAndCloseBtn of this.policyLightboxClickableElements) {
      contactFormLinksAndCloseBtn.setAttribute('tabindex', '0');
    }
  },

  controlPPRPolicyLightbox () {
    this.trapFocusInPPRPolicyLightbox();
    if ((event.type === 'click' && event.target === this.policyCloseBtn) || event.key === 'Escape') {
      this.closePPRPolicyLightbox();
      this.makePPRPolicyLightboxClickableElementsNotFocusable();
    }
  },

  trapFocusInPPRPolicyLightbox () {
    if (event.shiftKey && event.key === 'Tab') {
      this.focusGetInTouchLink();
    } else if (event.key === 'Tab') {
      if (document.activeElement === this.policyGetInTouchLink) {
        event.preventDefault();
        this.policyCloseBtn.focus();
      }
    } 
  },

  focusGetInTouchLink () {
    const policyOuterModal = document.querySelector('#returns-policy-outer-modal');
    const userClicksAnywhere = (document.activeElement === policyOuterModal ||
      document.activeElement === this.policyInnerModal
    );
    if (document.activeElement === this.policyCloseBtn || userClicksAnywhere) {
      event.preventDefault();
      this.policyGetInTouchLink.focus();
    }
  },

  closePPRPolicyLightbox () {
    for (const modals of this.policyLightbox) {
      modals.classList.remove('policy-open-anim');
      modals.classList.add('policy-close-anim');
      modals.addEventListener('animationend', () => {
        modals.classList.remove('policy-close-anim');
      });
    }
    HelperMethods.restoreBodyState();
    for (const event of ['click', 'keydown']) {
      document.removeEventListener(event, this.referenceToControlPPRPolicyLightbox);
    }
  },

  makePPRPolicyLightboxClickableElementsNotFocusable () {
    for (const contactFormLinksAndCloseBtn of this.policyLightboxClickableElements) {
      contactFormLinksAndCloseBtn.setAttribute('tabindex', '-1');
    }  
  }
  
};
