'use strict';

export const Navigation = {

  allWorksItem: document.querySelector('#all-works'),
  allWorksLink: document.querySelector('.link_all-works-more-margin-r'),
  geometrySubNavLink: document.querySelectorAll('.subnav__link')[0],
  hamburgerMenuIcon: document.querySelector('.hamburger'),
  mainNavArrow: document.querySelector('.arrow'),
  paintingsSubNavLink: document.querySelectorAll('.subnav__link')[3],
  subNav: document.querySelector('.subnav'),
  subNavLinks: document.querySelectorAll('.subnav__link'),

   showOrHideSubNavOnTouchscreensWiderThan1170px () {
    if (this.subNav) {
      if (event.target === this.allWorksLink) {
        this.makeAllWorksItemNotBeLinkButActivatorOfSubNav();
      } else {
        if (this.letSubNavLinksDoTheirJob()) {
          return;
        }
        this.hideSubNavUponTappingAnywhere();
      }
    }
  },

  letSubNavLinksDoTheirJob () {
    for (const linkWontReactToMethodHidingSubNav of this.subNavLinks) {
      if (event.target === linkWontReactToMethodHidingSubNav) {
        return true;
      }
    }
  },

  hideSubNavUponTappingAnywhere () {
    this.subNav.classList.remove('subnav_visible_if-touchstart');
    this.allWorksItem.classList.remove('list-item_all-works_background-like-subnav');
  },

  makeAllWorksItemNotBeLinkButActivatorOfSubNav () {
    this.allWorksLink.removeAttribute('href');
    this.subNav.classList.toggle('subnav_visible_if-touchstart');
    this.allWorksItem.classList.toggle('list-item_all-works_background-like-subnav');
  },

  tabThroughMainNav () {
    const pageHasMainNavWithArrow = this.mainNavArrow;
    const mainNavArrowWillReceiveFocus = this.mainNavArrow;
    const aboutLink = document.querySelector("nav a[href='about.php']");
    if (pageHasMainNavWithArrow) {
      this.showSubNav(event);
      this.hideSubNav(event);
      if (document.activeElement === this.allWorksLink ||
        document.activeElement === aboutLink) {
        mainNavArrowWillReceiveFocus.setAttribute('tabindex', 0);
      }
      this.makeAllWorksItemBeLinkAgainOnNonTouchscreens();
    } 
  },

  showSubNav (event) {
    if (event.target === this.mainNavArrow && event.key === 'Enter') {
      this.subNav.classList.add('subnav_visible');
      this.allWorksItem.classList.add('all-works-background-like-subnav');
      for (const linkWillBeFocusable of this.subNavLinks) {
        linkWillBeFocusable.setAttribute('tabindex', '0');
      }
      this.referenceToTrapFocusInSubnav = this.trapFocusInSubnav.bind(this);
      document.addEventListener('keydown', this.referenceToTrapFocusInSubnav);
    }
  },

  hideSubNav (event) {
    const mainNavArrowWontReceiveFocus = document.querySelector('.arrow');
    if (event.key === 'Escape') {
      this.subNav.classList.remove('subnav_visible');
      this.allWorksItem.classList.remove('all-works-background-like-subnav');
      for (const linkWontBeFocusable of this.subNavLinks) {
        linkWontBeFocusable.setAttribute('tabindex', '-1');
      }
      mainNavArrowWontReceiveFocus.setAttribute('tabindex', '-1');
      document.removeEventListener('keydown', this.referenceToTrapFocusInSubnav);
    }
  },

  makeAllWorksItemBeLinkAgainOnNonTouchscreens () {
    if (!this.allWorksLink.hasAttribute('href')) {
      this.allWorksLink.setAttribute('href', 'all-works.php');
    }
  },

  trapFocusInSubnav (event) {
    if (event.shiftKey && event.key === 'Tab') {
      this.focusPaintingsLink(event);
    } else if (event.key === 'Tab') {
      this.focusGeometryLink(event);
    }
  },

  focusPaintingsLink (event) {
    if (document.activeElement === this.mainNavArrow ||
      document.activeElement === this.geometrySubNavLink) {
      event.preventDefault();
      this.paintingsSubNavLink.focus();
    }
  },

  focusGeometryLink (event) {
    if (document.activeElement === this.paintingsSubNavLink) {
      event.preventDefault();
      this.geometrySubNavLink.focus();
    }
  },

  hideSubNavUponClickingAnywhere () {
    const subNavActivatedWithKeyboard = document.querySelector('.subnav');
    if (subNavActivatedWithKeyboard && subNavActivatedWithKeyboard.classList.contains('subnav_visible')) {
      this.subNavActivatedWithKeyboard.classList.remove('subnav_visible');
      for (const linkWontBeFocusable of this.subNavLinks) {
        linkWontBeFocusable.setAttribute('tabindex', '-1');
        document.removeEventListener('keydown', this.referenceToTrapFocusInSubnav);
      }
    }
  },

  tabFromMainNavToThumbnailImgsAndViceVersa () {
    const thumbnailImgs = document.querySelectorAll('.thumbnail-clickable-area');
    const firstThumbnailImg = thumbnailImgs[0];
    const lastItemInMainNav = document.querySelector('.nav__basket');
    const slideshowLightbox = document.querySelector('.slideshow');
    if (slideshowLightbox && !slideshowLightbox.classList.contains('slideshow_visible')) {
      if (document.activeElement === lastItemInMainNav ||
        document.activeElement === firstThumbnailImg) {
        this.skipHiddenSlideshowLightboxIcons();
      }
    }
  },

  skipHiddenSlideshowLightboxIcons () {
    const zoomInAndCloseIcons = document.querySelectorAll('.icon_zoom, .icon_close');
    for (const iconWontBeFocusable of zoomInAndCloseIcons) {
      iconWontBeFocusable.setAttribute('tabindex', '-1');
    }
  },

  setHamburgerMenuActivation() {
    if (this.hamburgerMenuIcon) {
      this.hamburgerMenuIcon.addEventListener('click', () => this.openOrCloseHamburgerMenu());
    }
  },

  openOrCloseHamburgerMenu () {
    const mainNav = document.querySelector('.nav-small');
    this.hamburgerMenuIcon.classList.toggle('active');
    mainNav.classList.toggle('nav-small_visible');
  },

  setSubNavActivation() {
    const subNavActivatorForScreensNarrowerThan1171px = document.querySelector('#small-subnav-activator');
    if (subNavActivatorForScreensNarrowerThan1171px) {
      subNavActivatorForScreensNarrowerThan1171px.addEventListener('click', () => this.openOrCloseSubNav());
    }
  },

  openOrCloseSubNav () {
    const subNavSmall = document.querySelector('.subnav-small');
    const subNavSmallListItems = document.querySelectorAll('.subnav-small__items_hidden');
    subNavSmall.classList.toggle('subnav-small_visible');
    for (const items of subNavSmallListItems) {
      items.classList.toggle('subnav-small__items_visible');
    }
  }

};