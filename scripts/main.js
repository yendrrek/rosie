'use strict';

import {controlBackToTopButton} from './modules/back-to-top-btn.js';
import {controlHeadingWithBreadcrumbs} from './modules/heading-with-breadcrumbs.js';
import {addProductToBasket} from './modules/adding-products-to-basket.js';
import {sendMessageViaContactForm} from './modules/contact-form.js';
import {dontResubmitContactFormWhenPageReloaded} from './modules/contact-form.js';
import {toggleSubNavigationOnTouchscreensWiderThan1170px} from './modules/control-activation-of-subnav-on-big-touchscreens.js';
import {openShopExtraImage} from './modules/extra-img-lightbox-in-shop.js';
import {closeShopExtraImage} from './modules/extra-img-lightbox-in-shop.js';
import {enableOutline} from './modules/enabled-outline-for-keyboard-users.js';
import {controlContactFormFieldsOutline} from './modules/contact-form-fields-outline.js';
import {tabThroughNavigationBar} from './modules/tabbing-through-nav.js';
import {insertFotorama} from './modules/fotorama.js';
import {removeFotorama} from './modules/fotorama.js';
import {toggleNavigationViaHamburgerIcon} from './modules/navigation-for-touchscreens-narrower-than-1170px.js';
import {toggleSubNavigation} from './modules/navigation-for-touchscreens-narrower-than-1170px.js';
import {controlBasket} from './modules/basket-operations.js';
import {openPostageAndReturnsPolicy} from './modules/postage-returns-policy-lightbox.js';
import {fixStylesInSafariOnly} from './modules/safari-fix-styles.js';
import {Slideshow} from './modules/slideshow.js';
import {hideOutline} from './modules/disabled-outline-for-keyboard-users.js';

export const tabbingFrom = {
  thumbnailImage: null,
  addToBasketButton: null
};

document.addEventListener('scroll', () => {
  controlBackToTopButton();
  controlHeadingWithBreadcrumbs();
});

$('form:not(.contact-form__items)').on('submit', event => {
  event.preventDefault();
  addProductToBasket(event);
});

$('.contact-form__items').on('submit', event => {
  event.preventDefault();
  sendMessageViaContactForm(event);
  dontResubmitContactFormWhenPageReloaded();
});

document.addEventListener('touchstart', event => {
  toggleSubNavigationOnTouchscreensWiderThan1170px(event);
});

(() => {
  if (window.location.href.includes('shop')) {
      const controlShopExtraImage = event => {
        openShopExtraImage(event);
        closeShopExtraImage(event);
      };
      ['click', 'keydown'].forEach(_event => document.addEventListener(_event, controlShopExtraImage));

      insertFotorama();
      window.addEventListener('resize', () => removeFotorama());
      window.addEventListener('resize', () => insertFotorama());
  }
})();

(() => {
  if (window.location.href.includes('contact')) {
    ['mousedown', 'keydown'].forEach(_event => document.addEventListener(_event, controlContactFormFieldsOutline));
  }
})();

document.addEventListener('keydown', tabThroughNavigationBar);

(() => {
  document.addEventListener('keydown', event => {
    if (event.key === 'Tab' || event.shiftKey && event.key === 'Tab') {
      enableOutline();
    }
  });

  document.addEventListener('mousedown', () => hideOutline());
})();

(() => {
  const hamburgerMenuIcon = document.querySelector('.hamburger');
  const subNavActivatorForScreensNarrowerThan1171px = document.querySelector('#small-subnav-activator');

  if (hamburgerMenuIcon) {
    hamburgerMenuIcon.addEventListener('click', () => {
      toggleNavigationViaHamburgerIcon();
      subNavActivatorForScreensNarrowerThan1171px.addEventListener('click', () => toggleSubNavigation());
    });
  }
})();

$('.btn-basket_remove-product-single, .btn-basket_remove-product-all').on('click', event => {
  event.preventDefault();
  controlBasket(event);
});
$('.table__product-qty-menu').on('change', event => {
  event.preventDefault();
  controlBasket(event);
});

(() => {
  const isShopOrBasketPage = () => ['shop', 'basket'].some(page => window.location.href.includes(page));
  if (isShopOrBasketPage()) {
    const postagePolicyActivators = Array.from(document.querySelectorAll('.policy-activator'));
    postagePolicyActivators.forEach(activator => activator.addEventListener('click', () => openPostageAndReturnsPolicy()));
  }
})();

(() => {
  const isSafari = () => /Apple Computer/.test(navigator.vendor) && (/Safari/.test(navigator.userAgent) || /Mobile/.test(navigator.userAgent));

  if (isSafari()) {
    fixStylesInSafariOnly();
  }
})();

(() => {
  const isArtworkPage = () => ['all-works', 'geometry', 'stained-glass', 'ceramic-tiles', 'paintings'].find(page => window.location.href.includes(page));

  if (isArtworkPage()) {
    ['click', 'keydown'].forEach(_event => document.addEventListener(_event,event => Slideshow.showSlideshow(event)));
    window.addEventListener('resize', () => Slideshow.hideFullPageImageIfResized());
  }
})();

