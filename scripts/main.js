/* All imports are object literals.
Data needed across different methods are stored in properties.
Data needed in only one method in a particular object are made variables.

All lightboxes are shown in full-page and consist of two animated modals, one is the background, the other is in the center and contains the content.

'Resize' event is fired when changing viewport width via developer tools.
*/

'use strict';

export const continuationOfTabbingFrom = { thumbnailImgWhichOpenedSlideshow: null };

$('form:not(.contact-form__items)').on('submit', event => {
  const stayOnPage = () => event.preventDefault();
  stayOnPage();
  import('./modules/adding-products-to-basket.js')
  .then((module) => {
    module.AddingProductsToBasket.addProductToBasket(event);
  });
});

import * as module from './modules/all-modules.js';

document.addEventListener('scroll', () => module.BackToTopButton.controlBackToTopBtn());

$('.contact-form__items').on('submit', () => module.ContactForm.sendMessgeViaContactForm(event));
module.ContactForm.dontResubmitContactFormWhenPageReloaded();

for (const event of ['click', 'keydown']) {
  document.addEventListener(event, () => module.ExtraImgLightboxInShop.openShopExtraImgLightbox());
  document.addEventListener(event, () => module.ExtraImgLightboxInShop.closeShopExtraImgLightbox());
  document.addEventListener(event, () => module.SlideshowLightbox.openSlideshowLightbox(event));
}

module.Fotorama.insertFotoramaForScreensNarrowerThan1170px();
window.addEventListener('resize', () => module.Fotorama.removeFotoramaForScreensWiderThan1169px());
window.addEventListener('resize', () => module.Fotorama.insertFotoramaForScreensNarrowerThan1170px());

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

window.addEventListener('resize', () => module.SlideshowLightbox.hideFullPageImgIfResized());

module.SafariFixStyles.fixStylesInSafariOnly();
