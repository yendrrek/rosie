'use strict';

export function toggleNavigationViaHamburgerIcon() {
  const hamburgerMenuIcon = document.querySelector('.hamburger');
  const smallMainNavigation = document.querySelector('.nav-small');

  hamburgerMenuIcon.classList.toggle('active');
  smallMainNavigation.classList.toggle('nav-small_visible');
}

export function toggleSubNavigation() {
  const smallSubNavigation = document.querySelector('.subnav-small');
  const listItemsOfSmallSubNavigation = document.querySelectorAll('.subnav-small__items_hidden');

  smallSubNavigation.classList.toggle('subnav-small_visible');

  for (const listItem of listItemsOfSmallSubNavigation) {
    listItem.classList.toggle('subnav-small__items_visible');
  }
}
