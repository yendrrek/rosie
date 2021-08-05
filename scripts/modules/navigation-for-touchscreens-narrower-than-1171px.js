'use strict';

export function openOrCloseHamburgerMenu () {
  const hamburgerMenuIcon = document.querySelector('.hamburger');
  const mainNav = document.querySelector('.nav-small');
  hamburgerMenuIcon.classList.toggle('active');
  mainNav.classList.toggle('nav-small_visible');
}

export function openOrCloseSubNav () {
  const subNavSmall = document.querySelector('.subnav-small');
  const subNavSmallListItems = document.querySelectorAll('.subnav-small__items_hidden');
  subNavSmall.classList.toggle('subnav-small_visible');
  for (const items of subNavSmallListItems) {
    items.classList.toggle('subnav-small__items_visible');
  }
}
