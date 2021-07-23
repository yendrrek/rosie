'use strict';

import { HelperMethods } from './helper-methods.js';

import { continuationOfTabbingFrom } from '../main.js';

export const SlideshowLightbox = {

  centerOfScreen: document.body.clientWidth / 2,
  closeIcon: document.querySelector('.icon_close'),
  slides: document.querySelectorAll('.slide'),
  slideshow: document.querySelector('.slideshow'),
  slideshowImgs: document.querySelectorAll('.slide__img-rectangle, .slide__img-square'),
  slideshowLightbox: document.querySelector('.slideshow'),
  slideshowTappingArea: document.querySelector('.slideshow'),
  touchscreensLessThan1058pxWide: window.innerWidth < 1058,
  zoomInIcon: document.querySelector('.icon_zoom'),

  openSlideshowLightbox() {
    let currentSlide;
    const thumbnailImgs = document.querySelectorAll('.thumbnail-clickable-area');
    for (const [currentThumbnailImg] of thumbnailImgs.entries()) {
      if (event.target === thumbnailImgs[currentThumbnailImg]) {
        if (event.type === 'click' || event.key === 'Enter') {
          HelperMethods.preventJerkingOfLightbox();
          this.slideshowLightbox.classList.add('slideshow_visible');
          this.slideshowLightbox.focus();
          currentSlide = currentThumbnailImg;
          this.showCurrentSlide(currentSlide);
          this.setSlideshowLightboxNavigation();
        }
        if (event.key === 'Enter') {
          continuationOfTabbingFrom.thumbnailImgWhichOpenedSlideshow = event.target;
        }
      }
    } 
  },

  setSlideshowLightboxNavigation () {
    const zoomInAndCloseIcons = document.querySelectorAll('.icon_zoom, .icon_close');
    for (const iconWillBeFocusable of zoomInAndCloseIcons) {
      iconWillBeFocusable.setAttribute('tabindex', '0');
    }
    this.referenceToTabThroughZoomInAndCloseIconsInLoop = this.tabThroughZoomInAndCloseIconsInLoop.bind(this);
    document.addEventListener('keydown', this.referenceToTabThroughZoomInAndCloseIconsInLoop);
    this.referenceToControlSlideshowLightbox = this.controlSlideshowLightbox.bind(this);
    for (const event of ['click', 'keydown']) {
      document.addEventListener(event, this.referenceToControlSlideshowLightbox);
    }
  },

  showCurrentSlide (currentSlide) {
    if (this.slideshow) {
      for (const notCurrentSlide of this.slides) {
        notCurrentSlide.classList.remove('slide_visible');
        notCurrentSlide.classList.add('slide_hidden');
      }
      this.slides[currentSlide].classList.remove('slide_hidden');
      this.slides[currentSlide].classList.add('slide_visible');
      this.countSlides(currentSlide);
      this.currentSlide = currentSlide;
    }
  },

  countSlides (currentSlide) {
    const arrayNotFromZero = 1;
    const displayedSlide = currentSlide + arrayNotFromZero;
    const allSlides = this.slides.length;
    const currentSlideNumber = document.querySelector('#index');
    const totalNumberOfSlides = document.querySelector('#total');
    currentSlideNumber.innerHTML = displayedSlide;
    totalNumberOfSlides.innerHTML = allSlides;
  },

  tabThroughZoomInAndCloseIconsInLoop (event) {
  const zoomInIconIncludedInPage = (window.innerWidth > 1057 && window.innerWidth < 1921);
    if (zoomInIconIncludedInPage) {
      this.reactOnlyToEscKey(event);
      if (event.shiftKey && event.key === 'Tab') {
        this.focusCloseIcon(event);
      } else if (event.key === 'Tab') {
        this.focusZoomInIcon(event);
      }
    } 
  },

  reactOnlyToEscKey (event) {
    const imgFullPage = this.closeIcon.classList.contains('icon_close-img-fullpage');
    if ((event.key === 'Tab') || (event.shiftKey && event.key === 'Tab')) {
      if (imgFullPage) {
        event.preventDefault();
      }
    }
  },

  focusCloseIcon (event) {
    if (document.activeElement === this.zoomInIcon ||
      document.activeElement === this.slideshowLightbox) {
      event.preventDefault();
      this.closeIcon.focus();
    }
  },

  focusZoomInIcon (event) {
    if (document.activeElement === this.closeIcon) {
      event.preventDefault();
      this.zoomInIcon.focus();
    }
  },

  controlSlideshowLightbox () {
    this.goToPreviousOrNextImg();
    if (this.userWantsFullPageImg()) {
      this.showFullPageImg();
    } 
    if (this.userWantsToHideFullPageImg()) {
        this.hideFullPageImg();
    } else if (this.userWantsToCloseSlideshowLightbox()) {
        this.closeSlideshowLightbox();
    }
    this.showFullPageImgByClickingOnImg();
  },

  goToPreviousOrNextImg () {
    if (this.userWantsPreviousImg()) {
      this.goToPreviousImg();
      this.hideFullPageImg();
    } else if (this.userWantsNextImg()) {
      this.goToNextImg();
      this.hideFullPageImg();
    }
  },

  userWantsPreviousImg () {
    const leftHalfOfScreenTapped = (
      this.touchscreensLessThan1058pxWide &&
      event.target === this.slideshowTappingArea &&
      event.clientX < this.centerOfScreen
    );
    const previousImgIcon = document.querySelector('.slideshow__icon_arrow-previous');
    if (event.target === previousImgIcon || event.key === 'ArrowLeft' || leftHalfOfScreenTapped) {
      return true;
    }
  },
  
  goToPreviousImg () {
    const allSlides = this.slides.length;
    this.currentSlide = (this.currentSlide - 1 + allSlides) % allSlides;
    this.showCurrentSlide(this.currentSlide);
  },

  hideFullPageImg () {
    if (this.slideshowLightbox) {
      this.closeFullPageImg();
      this.preserveTabbingOrderIfUserClicksOnSlide();
      this.restoreSlideshowFunctionality();
    }
  },

  userWantsNextImg () {
    const nextImgIcon = document.querySelector('.slideshow__icon_arrow-next');
    const rightHalfOfScreenTapped = (
      this.touchscreensLessThan1058pxWide &&
      event.target === this.slideshowTappingArea &&
      event.clientX > this.centerOfScreen
    );
    if (event.target === nextImgIcon || event.key === 'ArrowRight' || rightHalfOfScreenTapped) {
      return true;
    }
  },

  goToNextImg () {
    const allSlides = this.slides.length;
    this.currentSlide = (this.currentSlide + 1) % allSlides;
    this.showCurrentSlide(this.currentSlide);
  },

  closeFullPageImg () {
    for (const img of this.slideshowImgs) {
      if (img.classList.contains('slide__img-rectangle_zoom-in')) {
        img.classList.remove('slide__img-rectangle_zoom-in');
        img.classList.add('slide__img-rectangle_zoom-out');
      } else if (img.classList.contains('slide__img-square_zoom-in')) {
        img.classList.remove('slide__img-square_zoom-in');
        img.classList.add('slide__img-square_zoom-out');
      }
    }
    this.makeSlideNotScrollable();
  },

  makeSlideNotScrollable () {
    for (const slide of this.slides) {
      if (slide.classList.contains('slide_scrollable')) {
        slide.classList.remove('slide_scrollable');
      }
    }
  },

  preserveTabbingOrderIfUserClicksOnSlide () {
    if (this.slideWithRecentFullPageImg) {
      this.slideWithRecentFullPageImg.removeAttribute('tabindex');
    }
  },

  restoreSlideshowFunctionality () {
    this.slideshowLightbox.focus();
    this.slideshowLightbox.classList.remove('slideshow_scrollbar_hidden');
    this.closeIcon.classList.remove('icon_close-img-fullpage');
  },

  userWantsFullPageImg () {
    if ((event.target === this.zoomInIcon && event.type === 'click') ||
      (document.activeElement === this.zoomInIcon && event.key === 'Enter')) {
      return true;
    }
  },

  showFullPageImg () {
    this.openFullPageImg();
    this.amendSlideshowFunctionality();
    this.makeSlideVerticallyScrollableWithArrowKeys();
  },

  openFullPageImg () {
    for (const img of this.slideshowImgs) {
      if (img.classList.contains('slide__img-rectangle')) {
        img.classList.remove('slide__img-rectangle_zoom-out');
        img.classList.add('slide__img-rectangle_zoom-in');
      } else if (img.classList.contains('slide__img-square')) {
        img.classList.remove('slide__img-square_zoom-out');
        img.classList.add('slide__img-square_zoom-in');
      }
    }
    this.makeFullPageImgScrollable();
  },

  makeFullPageImgScrollable () {
    for (const slide of this.slides) {
      if (slide.classList.contains('slide_visible')) {
        slide.classList.add('slide_scrollable');
      }
    }
  },

  amendSlideshowFunctionality () {
    this.slideshow.classList.add('slideshow_scrollbar_hidden');
    this.closeIcon.classList.add('icon_close-img-fullpage');
  },

  makeSlideVerticallyScrollableWithArrowKeys () {
    for (const slide of this.slides) {
      if (slide.classList.contains('slide_visible')) {
        slide.setAttribute('tabindex', '0');
        slide.focus();
        this.slideWithRecentFullPageImg = slide;
      }
    }
  },

  userWantsToHideFullPageImg () {
    const imgFullPage = this.closeIcon.classList.contains('icon_close-img-fullpage');
    if (imgFullPage &&
      ((event.target === this.closeIcon && event.type === 'click') ||
      (document.activeElement === this.closeIcon && event.key === 'Enter') ||
      (event.key === 'Escape'))
      ) {
      return true;
    }
  },

  userWantsToCloseSlideshowLightbox () {
    if ((event.target === this.closeIcon && event.type === 'click') ||
      (document.activeElement === this.closeIcon && event.key === 'Enter') ||
      (event.key === 'Escape')) {
      return true;
    }
  },

  closeSlideshowLightbox () {
    this.slideshowLightbox.classList.remove('slideshow_visible');
    this.slideshowLightbox.classList.add('slideshow_hidden');
    this.slideshowLightbox.addEventListener('animationend', () => {
      this.slideshowLightbox.classList.remove('slideshow_hidden');
    });
    document.removeEventListener('keydown', this.referenceToTabThroughZoomInAndCloseIconsInLoop);
    for (const event of ['click', 'keydown']) {
      document.removeEventListener(event, this.referenceToControlSlideshowLightbox);
    }
    HelperMethods.restoreBodyState();
  },

  showFullPageImgByClickingOnImg () {
    for (const imgToBeFullPage of this.slideshowImgs) {
      if (event.target === imgToBeFullPage) {
        this.showFullPageImg();
      }
    }
  },

  hideFullPageImgIfResized () {
    if (window.innerWidth < 1058 || window.innerWidth > 1920) {
      this.hideFullPageImg();
    }
  }

};
