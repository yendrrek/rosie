'use strict';

export function toggleSubNavigationOnTouchscreensWiderThan1170px(event) {
  const allWorksLink = document.querySelector('.link_all-works-more-margin-r');
  const subNavigation = document.querySelector('.subnav');

  if (!subNavigation) {
    return;
  }

  if (event.target === allWorksLink) {
    toggleSubNavigation();
    return;
  }

  hideSubNavigationUponTappingAnywhereApartFromSubNavigationLinks(event);
}

function toggleSubNavigation() {
  const allWorksLink = document.querySelector('.link_all-works-more-margin-r');
  const subNavigation = document.querySelector('.subnav');
  const allWorksItem = document.querySelector('#all-works');

  disableAllWorksLinkToPreventRedirecting(allWorksLink);
  subNavigation.classList.toggle('subnav_visible');
  styleAllWorksItemBackground(allWorksItem);
}

function disableAllWorksLinkToPreventRedirecting(allWorksLink) {
  allWorksLink.removeAttribute('href');
}

function styleAllWorksItemBackground(allWorksItem) {
  allWorksItem.classList.toggle('all-works-background-like-subnav');
}

function hideSubNavigationUponTappingAnywhereApartFromSubNavigationLinks(event) {
  const subNav = document.querySelector('.subnav');

  if (isShownSubNavigationToMakeLinksWork(event)) {
    return;
  }

  subNav.classList.remove('subnav_visible');
  removeAllWorksItemBackgroundStyle();
  makeAllWorksItemBeLinkAgainOnNonTouchscreens();
}

function isShownSubNavigationToMakeLinksWork(event) {
  const subNavigationLinks = Array.from(document.querySelectorAll('.subnav__link'));
  return subNavigationLinks.some(link => event.target === link);
}

function removeAllWorksItemBackgroundStyle() {
  const allWorksItem = document.querySelector('#all-works');

  allWorksItem.classList.remove('all-works-background-like-subnav');
}

export function makeAllWorksItemBeLinkAgainOnNonTouchscreens() {
  const allWorksLink = document.querySelector('.link_all-works-more-margin-r');

  if (!allWorksLink.hasAttribute('href')) {
    allWorksLink.setAttribute('href', 'all-works.php');
  }
}
