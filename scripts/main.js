<<<<<<< HEAD
/* All imports are object literals.
Data needed across different methods are stored in properties.
Data needed in only one method in a particular object are made variables.

All lightboxes are shown in full-page and consist of two animated modals, one is the background, the other is in the center and contains the content.

=======
/**
 * All modules are loaded dynamically. It is probably overkill as loading all code 
 * even if it is not immediately needed does not cause any performance issues but 
 * I wanted to practice dynamic loading. It also helped me simplify some parts of code. 
 *
 * All lightboxes are shown in full-page and consist of two animated modals, 
 * one is the background, the other is in the centre and contains the content.
>>>>>>> refactor
*/

'use strict';

export const continuationOfTabbingFrom = { 
  thumbnailImgWhichOpenedSlideshow: null,
  addToBasketBtnWhichOpenedAddedToBasketNotificationLightbox: null 
};

function loadModulesOnDemand () {
  loadModulesActivatedByScrollEvent();
  loadModule_AddingProductsToBasket_();
  loadModule_ContactForm_();
  loadModule_ControlActivationOfSubNavOnBigTouchscreens_();
  loadModule_ExtraImgLightboxInShop_();
  loadModulesForKeyboardUsers();
  loadModule_Fotorama_();
  loadModule_NavigationForTouchscreensNarrowerThan1171px_();
  loadModule_OperationsInsideBasket_();
  loadModule_PostageReturnsPolicyLightbox_();
  loadModule_SafariFixStyles_();
  loadModule_SlideshowLightbox_();
  document.addEventListener('mousedown', loadModule_ContactForm_FieldsOutline);
}

loadModulesOnDemand();

function loadModulesActivatedByScrollEvent () {
  document.addEventListener('scroll', () => {
    loadModule_BackToTopButton_();
    loadModule_HeadingWithBreadcrumbs_();
  });
}

function loadModule_BackToTopButton_ () {
  import('./modules/back-to-top-btn.js')
  .then(module => {
    module.controlBackToTopBtn();
  });
}

function loadModule_HeadingWithBreadcrumbs_ () {
  import('./modules/heading-with-breadcrumbs.js')
  .then(module => {
    module.controlHeadingWithBreadcrumbs();
  });
}

function loadModule_AddingProductsToBasket_ () {
  $('form:not(.contact-form__items)').on('submit', event => {
    stayOnPage();
    import('./modules/adding-products-to-basket.js')
    .then(module => {
      module.addProductToBasket(event);
    });
  });
}

function stayOnPage () {
  event.preventDefault();
}

function loadModule_ContactForm_ () {
  $('.contact-form__items').on('submit', event => {
    stayOnPage();
    import('./modules/contact-form.js')
    .then(module => {
      module.sendMessgeViaContactForm(event);
      module.dontResubmitContactFormWhenPageReloaded();
    });
  });
}

function loadModule_ControlActivationOfSubNavOnBigTouchscreens_ () {
  document.addEventListener('touchstart', event => {
    import('./modules/control-activation-of-subnav-on-big-touchscreens.js')
    .then(module => {
      module.showOrHideSubNavOnTouchscreensWiderThan1170px(event);
    });
  });
}

function loadModule_ExtraImgLightboxInShop_ () {
  if (window.location.href.includes('shop')) {
    import('./modules/extra-img-lightbox-in-shop.js')
    .then(module => {
      for (const event of ['click', 'keydown']) {
        document.addEventListener(event, () => module.openShopExtraImgLightbox());
        document.addEventListener(event, () => module.closeShopExtraImgLightbox()); 
      }
    });
  }
}

function loadModulesForKeyboardUsers () {
  document.addEventListener('keydown', event => {
    if (event.key === 'Tab' || (event.shiftKey && event.key === 'Tab')) {
      loadModule_EnabledOutlineForKeyboardUsers_();
      loadModule_ContactForm_FieldsOutline();
      loadModule_TabbingThroughNavigation_(event);
    }
  });
}

function loadModule_EnabledOutlineForKeyboardUsers_ () {
  import('./modules/enabled-outline-for-keyboard-users.js')
  .then(module => {
    module.enableOutline();
  });
}

function loadModule_ContactForm_FieldsOutline () {
  if (window.location.href.includes('contact')) {
    import('./modules/contact-form-fields-outline.js')
    .then(module => {
      module.controlContactFormFieldsOutline();
    });
  }
}

function loadModule_TabbingThroughNavigation_ (event) {
  import ('./modules/tabbing-through-nav.js')
  .then(module => {
    module.tabThroughNav(event);
  });
}

function loadModule_Fotorama_ () {
  if (window.location.href.includes('shop')) {
    import('./modules/fotorama.js')
    .then(module => {
      const fotoramaModule = module;
      module.insertFotoramaForScreensNarrowerThan1170px();
      reactToViewportSizeChangedInDevTools(module);
    });
  }
}

function loadModule_NavigationForTouchscreensNarrowerThan1171px_ () {
  const hamburgerMenuIcon = document.querySelector('.hamburger');
  const subNavActivatorForScreensNarrowerThan1171px = document.querySelector('#small-subnav-activator');
  if (hamburgerMenuIcon) {
    hamburgerMenuIcon.addEventListener('click', () => {
      import('./modules/navigation-for-touchscreens-narrower-than-1171px.js')
      .then(module => {
        module.openOrCloseHamburgerMenu();
        subNavActivatorForScreensNarrowerThan1171px.addEventListener('click', () => module.openOrCloseSubNav());
      });
    });
  }
}

function loadModule_OperationsInsideBasket_ () {
  $('.btn-basket_remove-product-single, .btn-basket_remove-product-all').on('click', event => {
    stayOnPage();
    importModule_OperationsInsideBasket_(event);
  });
  $('.table__product-qty-menu').on('change', event => {
    stayOnPage();
    importModule_OperationsInsideBasket_(event);
  });
}

function importModule_OperationsInsideBasket_ (event) {
  import('./modules/operations-inside-basket.js')
  .then(module => {
    module.controlBasket(event)
  });
}

function loadModule_PostageReturnsPolicyLightbox_ () {
  const policyActivators = document.querySelectorAll('.policy-activator');
  for (const activator of policyActivators) {
    activator.addEventListener('click', () => {
      import('./modules/postage-returns-policy-lightbox.js')
      .then(module => {
        module.openPPRPolicyLightbox();
      });
    });
  }
}

function loadModule_SafariFixStyles_() {
  const isSafari = (
    (
      /Apple Computer/.test(navigator.vendor) &&
      /Safari/.test(navigator.userAgent) || /Mobile/.test(navigator.userAgent)
    )
  );
  if (isSafari) {
    import('./modules/safari-fix-styles.js')
    .then(module => {
      module.fixStylesInSafariOnly();
    });
  }
}

function loadModule_SlideshowLightbox_ () {
  const pagesWithSlideshowGallery = (
    window.location.href.includes('all-works') ||
    window.location.href.includes('geometry') ||
    window.location.href.includes('stained-glass') ||
    window.location.href.includes('ceramic-tiles') ||
    window.location.href.includes('paintings')
  );
  if (pagesWithSlideshowGallery) {
    import('./modules/slideshow-lightbox.js')
    .then(module => {
      for (const event of ['click', 'keydown']) {
        document.addEventListener(event, () => module.SlideshowLightbox.openSlideshowLightbox(event));
      }
      reactToViewportSizeChangedInDevTools(module);
    });
  }
}

function reactToViewportSizeChangedInDevTools (module) {
  if (module.SlideshowLightbox) {
    window.addEventListener('resize', () => module.SlideshowLightbox.hideFullPageImgIfResized());
  } else if (module.insertFotoramaForScreensNarrowerThan1170px &&
    module.removeFotoramaForScreensWiderThan1169px) {
    window.addEventListener('resize', () => module.removeFotoramaForScreensWiderThan1169px());
    window.addEventListener('resize', () => module.insertFotoramaForScreensNarrowerThan1170px());
  }
}

import { hideOutline } from './modules/disabled-outline-for-keyboard-users.js';

document.addEventListener('mousedown', () => hideOutline());
