'use strict';

import { makeAllWorksItemBeLinkAgainOnNonTouchscreens } from './control-activation-of-subnav-on-big-touchscreens.js';

export function tabThroughNav () {
  const aboutLink = document.querySelector("nav a[href='about.php']");
  const allWorksLink = document.querySelector('.link_all-works-more-margin-r');
  const mainNavArrow = document.querySelector('.arrow');
  const mainNavArrowWillReceiveFocus = document.querySelector('.arrow');
  const pageHasMainNavWithArrow = document.querySelector('.arrow');
  if (pageHasMainNavWithArrow) {
    if (document.activeElement === allWorksLink ||
      document.activeElement === aboutLink) {
      mainNavArrowWillReceiveFocus.setAttribute('tabindex', 0);
    }
    mainNavArrow.addEventListener('keydown', showSubNav);
    document.addEventListener('keydown', hideSubNavWithEscKey);
    /* Link 'ALL WORKS' is deactivated on touchscreens wider than 1170px and acts only as the activator of subnavigation. If a laptop with touchscreen is used, switching to keyboard navigation will restore 'ALL WORKS' link's functionality. Edge case. */
    makeAllWorksItemBeLinkAgainOnNonTouchscreens();
  } 
}

function showSubNav (event) {
  const allWorksItem = document.querySelector('#all-works');
  const subNav = document.querySelector('.subnav');
  const subNavLinks = document.querySelectorAll('.subnav__link');
  if (event.key === 'Enter') {
    subNav.classList.add('subnav_visible');
    allWorksItem.classList.add('all-works-background-like-subnav');
    for (const linkWillBeFocusable of subNavLinks) {
      linkWillBeFocusable.setAttribute('tabindex', '0');
    }
    document.addEventListener('keydown', trapFocusInSubnav);
    document.addEventListener('click', hideSubNavUponClickingAnywhere);
  }
}

function hideSubNavWithEscKey (event) {
  const mainNavArrowWontReceiveFocus = document.querySelector('.arrow');
  if (event.key === 'Escape') {
    hideSubNav();
    mainNavArrowWontReceiveFocus.setAttribute('tabindex', '-1');
  }
}

function hideSubNav () {
  const allWorksItem = document.querySelector('#all-works');
  const subNav = document.querySelector('.subnav');
  const subNavLinks = document.querySelectorAll('.subnav__link');
  allWorksItem.classList.remove('all-works-background-like-subnav');
  subNav.classList.remove('subnav_visible');
  for (const linkWontBeFocusable of subNavLinks) {
    linkWontBeFocusable.setAttribute('tabindex', '-1');
  }
  document.removeEventListener('keydown', trapFocusInSubnav);
  document.removeEventListener('keydown', hideSubNav);
}

function trapFocusInSubnav (event) {
  if (event.shiftKey && event.key === 'Tab') {
    focusPaintingsLink(event);
  } else if (event.key === 'Tab') {
    focusGeometryLink(event);
  }
}

function focusPaintingsLink (event) {
  const geometrySubNavLink = document.querySelectorAll('.subnav__link')[0];
  const mainNavArrow = document.querySelector('.arrow');
  const paintingsSubNavLink = document.querySelectorAll('.subnav__link')[3];
  if (document.activeElement === mainNavArrow ||
    document.activeElement === geometrySubNavLink) {
    event.preventDefault();
    paintingsSubNavLink.focus();
  }
}

function focusGeometryLink (event) {
  const geometrySubNavLink = document.querySelectorAll('.subnav__link')[0];
  const paintingsSubNavLink = document.querySelectorAll('.subnav__link')[3];
  if (document.activeElement === paintingsSubNavLink) {
    event.preventDefault();
    geometrySubNavLink.focus();
  }
}

function hideSubNavUponClickingAnywhere () {
  const subNavActivatedWithKeyboard = document.querySelector('.subnav');
  if (subNavActivatedWithKeyboard && subNavActivatedWithKeyboard.classList.contains('subnav_visible')) {
    hideSubNav();
  }
}
