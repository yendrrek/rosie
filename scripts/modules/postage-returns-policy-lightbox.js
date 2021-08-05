'use strict';

import { preventJerkingOfLightbox, restoreBodyState } from './helper-methods.js';  

export function openPPRPolicyLightbox () {
  const policyLightbox = document.querySelectorAll('#returns-policy-outer-modal, #returns-policy-inner-modal');
  for (const modals of policyLightbox) {
    modals.classList.add('policy-open-anim');
  }
  preventJerkingOfLightbox();
  preparePPRPolicyLightboxKeyboardNavigation();    
}

function preparePPRPolicyLightboxKeyboardNavigation () {
const policyInnerModal = document.querySelector('#returns-policy-inner-modal');
  policyInnerModal.focus();
  makePPRPolicyLightboxClickableElementsFocusable();        
  for (const event of ['click', 'keydown']) {
    document.addEventListener(event, controlPPRPolicyLightbox);
  }
}

function makePPRPolicyLightboxClickableElementsFocusable () {
  const policyLightboxClickableElements = document.querySelectorAll(`
    #return-policy-close-btn,
    #first-contact-form-link,
    #second-contact-form-link,
    #third-contact-form-link
  `);
  for (const contactFormLinksAndCloseBtn of policyLightboxClickableElements) {
    contactFormLinksAndCloseBtn.setAttribute('tabindex', '0');
  }
}

function controlPPRPolicyLightbox () {
  const policyCloseBtn = document.querySelector('#return-policy-close-btn');
  trapFocusInPPRPolicyLightbox();
  if ((event.type === 'click' && event.target === policyCloseBtn) || event.key === 'Escape') {
    closePPRPolicyLightbox();
    makePPRPolicyLightboxClickableElementsNotFocusable();
  }
}

function trapFocusInPPRPolicyLightbox () {
  const policyCloseBtn = document.querySelector('#return-policy-close-btn');
  const policyGetInTouchLink = document.querySelector('#third-contact-form-link');
  if (event.shiftKey && event.key === 'Tab') {
    focusGetInTouchLink();
  } else if (event.key === 'Tab') {
    if (document.activeElement === policyGetInTouchLink) {
      event.preventDefault();
      policyCloseBtn.focus();
    }
  } 
}

function focusGetInTouchLink () {
  const policyCloseBtn = document.querySelector('#return-policy-close-btn');
  const policyGetInTouchLink = document.querySelector('#third-contact-form-link');
  const policyInnerModal = document.querySelector('#returns-policy-inner-modal');
  const policyOuterModal = document.querySelector('#returns-policy-outer-modal');
  const userClicksAnywhere = (document.activeElement === policyOuterModal ||
    document.activeElement === policyInnerModal
  );
  if (document.activeElement === policyCloseBtn || userClicksAnywhere) {
    event.preventDefault();
    policyGetInTouchLink.focus();
  }
}

function closePPRPolicyLightbox () {
  const policyLightbox = document.querySelectorAll('#returns-policy-outer-modal, #returns-policy-inner-modal');
  for (const modals of policyLightbox) {
    modals.classList.remove('policy-open-anim');
    modals.classList.add('policy-close-anim');
    modals.addEventListener('animationend', () => {
      modals.classList.remove('policy-close-anim');
    });
  }
  restoreBodyState();
  for (const event of ['click', 'keydown']) {
    document.removeEventListener(event, controlPPRPolicyLightbox);
  }
}

function makePPRPolicyLightboxClickableElementsNotFocusable () {
const policyLightboxClickableElements = document.querySelectorAll(`
  #return-policy-close-btn,
  #first-contact-form-link,
  #second-contact-form-link,
  #third-contact-form-link
`);
  for (const contactFormLinksAndCloseBtn of policyLightboxClickableElements) {
    contactFormLinksAndCloseBtn.setAttribute('tabindex', '-1');
  }  
}
  