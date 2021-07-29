/* All imports are object literals.
Data needed across different methods are stored in properties.
Data needed in only one method in a particular object are made variables.

All lightboxes are shown in full-page and consist of two animated modals, one is the background, the other is in the center and contains the content.

'Resize' event is fired when changing viewport width via developer tools.
*/

'use strict';

export const continuationOfTabbingFrom = { thumbnailImgWhichOpenedSlideshow: null };

function loadModulesOnDemand () {
  loadModulesActivatedByScrollEvent();
  loadModuleSlideshowLightbox();
  loadModuleBackToTopButton();
  loadModuleFotorama();
}

loadModulesOnDemand();

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

function loadModuleBackToTopButton () {
  document.addEventListener('scroll', () => {
    import('./modules/back-to-top-btn.js')
    .then(module => {
      module.BackToTopButton.controlBackToTopBtn();
    });
  });
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

import * as module from './modules/other-modules.js';

document.addEventListener('scroll', () => module.HeadingWithBreadcrumbs.controlHeadingWithBreadcrumbs());

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

document.addEventListener('click', () => module.PostageReturnsPolicyLightbox.openPPRPolicyLightbox());

module.SafariFixStyles.fixStylesInSafariOnly();
