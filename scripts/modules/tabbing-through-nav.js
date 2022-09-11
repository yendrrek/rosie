'use strict';

import { makeAllWorksItemBeLinkAgainOnNonTouchscreens } from './control-activation-of-subnav-on-big-touchscreens.js';

export function tabThroughNavigationBar() {
  const about = document.querySelector('nav a[href="about.php"]');
  const allWorks = document.querySelector('.link_all-works-more-margin-r');
  const arrow = document.querySelector('.arrow');

  if (!arrow) {
    return;
  }

  if (document.activeElement === allWorks || document.activeElement === about) {
    toggleTababilityOfElement(arrow, on());
  }

  arrow.addEventListener('keydown', showSubNavigation);
  document.addEventListener('keydown', hideSubNavigationWithEscKey);

   // Link 'ALL WORKS' is deactivated on touchscreens wider than 1170px
   // and acts only as an activator of the subnavigation. If a laptop with
   // touchscreen is used, switching to keyboard navigation will restore
   // 'ALL WORKS' link's functionality. Edge case.
  makeAllWorksItemBeLinkAgainOnNonTouchscreens();
}

function showSubNavigation(event) {
  const allWorks = document.querySelector('#all-works');
  const subNavigation = document.querySelector('.subnav');
  const subNavigationLinks = document.querySelectorAll('.subnav__link');

  if (event.key === 'Enter') {
    subNavigation.classList.add('subnav_visible');
    allWorks.classList.add('all-works-background-like-subnav');
    for (const link of subNavigationLinks) {
      toggleTababilityOfElement(link, on());
    }
    document.addEventListener('keydown', trapFocusInSubNavigation);
    document.addEventListener('click', hideSubNavigationUponClickingAnywhere);
  }
}

function hideSubNavigationWithEscKey(event) {
  const arrow = document.querySelector('.arrow');

  if (event.key === 'Escape') {
    hideSubNavigation();
    toggleTababilityOfElement(arrow, off());
  }
}

function hideSubNavigation() {
  const allWorks = document.querySelector('#all-works');
  const subNavigation = document.querySelector('.subnav');
  const subNavigationLinks = document.querySelectorAll('.subnav__link');

  allWorks.classList.remove('all-works-background-like-subnav');
  subNavigation.classList.remove('subnav_visible');

  for (const link of subNavigationLinks) {
    toggleTababilityOfElement(link, off());
  }

  document.removeEventListener('keydown', trapFocusInSubNavigation);
  document.removeEventListener('keydown', hideSubNavigation);
}

function trapFocusInSubNavigation(event) {
  if (event.shiftKey && event.key === 'Tab') {
    focusPaintingsLink(event);
    return;
  }

  if (event.key === 'Tab') {
    focusGeometryLink(event);
  }
}

function focusPaintingsLink(event) {
  const geometrySubNavigationLink = document.querySelectorAll('.subnav__link')[0];
  const arrow = document.querySelector('.arrow');
  const paintingsSubNavigationLink = document.querySelectorAll('.subnav__link')[3];

  if (document.activeElement === arrow || document.activeElement === geometrySubNavigationLink) {
    event.preventDefault();
    paintingsSubNavigationLink.focus();
  }
}

function focusGeometryLink(event) {
  const geometrySubNavigationLink = document.querySelectorAll('.subnav__link')[0];
  const paintingsSubNavigationLink = document.querySelectorAll('.subnav__link')[3];

  if (document.activeElement === paintingsSubNavigationLink) {
    event.preventDefault();
    geometrySubNavigationLink.focus();
  }
}

function hideSubNavigationUponClickingAnywhere() {
  const subNavigationActivatedWithKeyboard = document.querySelector('.subnav');

  if (subNavigationActivatedWithKeyboard && subNavigationActivatedWithKeyboard.classList.contains('subnav_visible')) {
    hideSubNavigation();
  }
}

function toggleTababilityOfElement(element, onOff) {
  element.setAttribute('tabindex', onOff);
}

const on = () =>'0';
const off = () => '-1';
