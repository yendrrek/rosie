'use strict';

export function showOrHideSubNavOnTouchscreensWiderThan1170px (event) {
  const allWorksLink = document.querySelector('.link_all-works-more-margin-r');
  const subNav = document.querySelector('.subnav');
  if (subNav) {
    if (event.target === allWorksLink) {
      makeAllWorksItemNotBeLinkButActivatorOfSubNav();
    } else {
      if (letSubNavLinksDoTheirJob(event)) {
        return;
      }
      hideSubNavUponTappingAnywhere();
    }
  }
}

function makeAllWorksItemNotBeLinkButActivatorOfSubNav () {
  const allWorksLink = document.querySelector('.link_all-works-more-margin-r');
  const subNav = document.querySelector('.subnav');
  const allWorksItem = document.querySelector('#all-works');
  allWorksLink.removeAttribute('href');
  subNav.classList.toggle('subnav_visible');
  allWorksItem.classList.toggle('all-works-background-like-subnav');
}

function letSubNavLinksDoTheirJob (event) {
  const subNavLinks = document.querySelectorAll('.subnav__link');
  for (const linkWontReactToMethodHidingSubNav of subNavLinks) {
    if (event.target === linkWontReactToMethodHidingSubNav) {
      return true;
    }
  }
}

function hideSubNavUponTappingAnywhere () {
  const allWorksItem = document.querySelector('#all-works');
  const subNav = document.querySelector('.subnav');
  subNav.classList.remove('subnav_visible');
  allWorksItem.classList.remove('all-works-background-like-subnav');
  makeAllWorksItemBeLinkAgainOnNonTouchscreens();
}

export function makeAllWorksItemBeLinkAgainOnNonTouchscreens () {
  const allWorksLink = document.querySelector('.link_all-works-more-margin-r');
  if (!allWorksLink.hasAttribute('href')) {
    allWorksLink.setAttribute('href', 'all-works.php');
  }
}
