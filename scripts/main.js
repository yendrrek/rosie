/* All imports are object literals.
Data needed across different methods are stored in properties.
Data needed in only one method in a particular object are made variables.

All lightboxes are shown in full-page and consist of two animated modals, one is the background, the other is in the center and contains the content.

'Resize' event is fired when changing viewport width via developer tools.
*/

'use strict';

export const continuationOfTabbingFrom = { thumbnailImgWhichOpenedSlideshow: null };

function loadModulesOnDemand () {
  loadModuleSafariFixStyles();
  loadModulesActivatedByScrollEvent();
  loadModuleSlideshowLightbox();
  loadModuleFotorama();
  loadModuleContactForm();
  loadModuleExtraImgLightboxInShop();
  loadModulePostageReturnsPolicyLightbox();
  loadModuleAddingProductsToBasket();
}

loadModulesOnDemand();

function loadModuleSafariFixStyles() {
  const isSafari = (
    (
      /Apple Computer/.test(navigator.vendor) &&
      /Safari/.test(navigator.userAgent) || /Mobile/.test(navigator.userAgent)
    )
  );
  if (isSafari) {
    import('./modules/safari-fix-styles.js')
    .then(module => {
      module.SafariFixStyles.fixStylesInSafariOnly();
    });
  }
}

function loadModulesActivatedByScrollEvent () {
  document.addEventListener('scroll', () => {
    loadModuleBackToTopButton();
    loadModuleHeadingWithBreadcrumbs();
  });
}

function loadModuleBackToTopButton () {
  import('./modules/back-to-top-btn.js')
  .then(module => {
    module.BackToTopButton.controlBackToTopBtn();
  });
}

function loadModuleHeadingWithBreadcrumbs () {
  import('./modules/heading-with-breadcrumbs.js')
  .then(module => {
    module.HeadingWithBreadcrumbs.controlHeadingWithBreadcrumbs();
  });
}

function loadModuleSlideshowLightbox () {
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
  } else if (module.Fotorama) {
    window.addEventListener('resize', () => module.Fotorama.removeFotoramaForScreensWiderThan1169px());
    window.addEventListener('resize', () => module.Fotorama.insertFotoramaForScreensNarrowerThan1170px());
  }
}

function loadModuleFotorama () {
  if (window.location.href.includes('shop')) {
    import('./modules/fotorama.js')
    .then(module => {
      module.Fotorama.insertFotoramaForScreensNarrowerThan1170px();
      reactToViewportSizeChangedInDevTools(module);
    });
  }
}

function loadModuleContactForm () {
  $('.contact-form__items').on('submit', event => {
    stayOnPage();
    import('./modules/contact-form.js')
    .then(module => {
      module.ContactForm.sendMessgeViaContactForm(event);
      module.ContactForm.dontResubmitContactFormWhenPageReloaded();
    });
  });
}

function stayOnPage () {
  event.preventDefault();
}

function loadModuleExtraImgLightboxInShop () {
  if (window.location.href.includes('shop')) {
    import('./modules/extra-img-lightbox-in-shop.js')
    .then(module => {
      for (const event of ['click', 'keydown']) {
        document.addEventListener(event, () => module.ExtraImgLightboxInShop.openShopExtraImgLightbox());
        document.addEventListener(event, () => module.ExtraImgLightboxInShop.closeShopExtraImgLightbox()); 
      }
    });
  }
}

function loadModulePostageReturnsPolicyLightbox () {
  const policyActivators = document.querySelectorAll('.policy-activator');
  for (const activator of policyActivators) {
    activator.addEventListener('click', () => {
      import('./modules/postage-returns-policy-lightbox.js')
      .then(module => {
        module.PostageReturnsPolicyLightbox.openPPRPolicyLightbox();
      });
    });
  }
}

function loadModuleAddingProductsToBasket () {
  $('form:not(.contact-form__items)').on('submit', event => {
    stayOnPage();
    import('./modules/adding-products-to-basket.js')
    .then(module => {
      module.AddingProductsToBasket.addProductToBasket(event);
    });
  });
}

import * as module from './modules/other-modules.js';

document.addEventListener('keydown', () =>  module.Navigation.tabThroughMainNav(event));
document.addEventListener('click', () =>  module.Navigation.hideSubNavUponClickingAnywhere());
document.addEventListener('focusin', () =>  module.Navigation.tabFromMainNavToThumbnailImgsAndViceVersa());
document.addEventListener('touchstart', () =>  module.Navigation.showOrHideSubNavOnTouchscreensWiderThan1170px(event));
module.Navigation.setHamburgerMenuActivation();
module.Navigation.setSubNavActivation();

$('.btn-basket_remove-product-single').on('click', module.OperationsInsideBasket.controlBasket);
$('.btn-basket_remove-product-all').on('click', module.OperationsInsideBasket.controlBasket);
$('.table__product-qty-menu').on('change', module.OperationsInsideBasket.controlBasket);

document.addEventListener('keydown', () => module.OutlineForKeyboardUsers.enableOutline(event));
document.addEventListener('mousedown', () => module.OutlineForKeyboardUsers.hideOutline());
