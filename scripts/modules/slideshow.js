'use strict';

import { stopFullPageElementJerk, restoreBodyAfterStoppingFullPageElementJerk } from './helper-methods.js';
import { tabbingFrom } from '../main.js';

export const Slideshow = {
  current: null,
  boundTabThroughZoomAndCloseIcons: null,
  boundControlSlideshowLightbox: null,
  slides: document.querySelectorAll('.slide'),
  slideshow: document.querySelector('.slideshow'),
  images: document.querySelectorAll('.slide__img-rectangle, .slide__img-square'),
  closeIcon: document.querySelector('.icon_close'),
  zoomIcon: document.querySelector('.icon_zoom'),
  icons: document.querySelectorAll('.icon_zoom, .icon_close'),
  screenCenter: document.body.clientWidth / 2,
  isTouchscreenNarrowerThan1058px: window.innerWidth < 1058,

  showSlideshow(event) {
    const thumbnailImages = document.querySelectorAll('.thumbnail-clickable-area');

    for (const [currentImage] of thumbnailImages.entries()) {
      if (this.isActivatedThumbnailImage(event, thumbnailImages[currentImage])) {
        stopFullPageElementJerk();

        this.slideshow.classList.add('slideshow_visible');

        this.showCurrentSlide(currentImage);

        this.prepareSlideshowNavigation();

        this.rememberWhichThumbnailImageOpenedSlideshow(event);

      }
    }
  },

  isActivatedThumbnailImage(event, thumbnailImage) {
    return event.target === thumbnailImage && (event.type === 'click' || event.key === 'Enter');
  },

  showCurrentSlide(currentSlide) {
    if (!this.slideshow) {
      return;
    }

    this.hideAllOtherSlides();

    this.toggleVisibility(this.slides[currentSlide], 'slide_visible', 'slide_hidden');

    this.runSlideshowCounter(currentSlide);

    this.current = currentSlide;
  },

  hideAllOtherSlides() {
    for (const notCurrentSlide of this.slides) {
      this.toggleVisibility(notCurrentSlide, 'slide_hidden', 'slide_visible');
    }
  },

  toggleVisibility(element, styleAdded, styleRemoved) {
    element.classList.remove(styleRemoved);
    element.classList.add(styleAdded);
  },

  runSlideshowCounter(currentSlide) {
    this.showCurrentSlideNumber(currentSlide);
    this.showTotalNumberOfSlides();
  },

  showCurrentSlideNumber(currentSlide) {
    document.querySelector('#index').innerHTML = currentSlide + 1;
  },

  showTotalNumberOfSlides() {
    document.querySelector('#total').innerHTML = this.slides.length;
  },

  prepareSlideshowNavigation() {
    this.slideshow.focus();
    
    this.makeSlideshowZoomAndCloseIconsFocusable();

    this.boundTabThroughZoomAndCloseIcons = this.tabThroughZoomAndCloseIcons.bind(this);
    document.addEventListener('keydown', this.boundTabThroughZoomAndCloseIcons);

    this.boundControlSlideshowLightbox = this.controlSlideshowLightbox.bind(this);
    for (const event of ['click', 'keydown']) {
      document.addEventListener(event, this.boundControlSlideshowLightbox);
    }
  },

  makeSlideshowZoomAndCloseIconsFocusable() {
    for (const icon of this.icons) {
      icon.setAttribute('tabindex', '0');
    }
  },

  tabThroughZoomAndCloseIcons(event) {
    if (!this.isDeviceUsingZoom()) {
      return;
    }

    if (this.isOnlyCloseIconWhenFullPageImage()) {
      this.limitKeyboardNavigationToEscKey(event);
      return;
    }

    this.trapFocus(event);
  },

  isDeviceUsingZoom() {
    return window.innerWidth > 1057 && window.innerWidth < 1921;
  },

  isOnlyCloseIconWhenFullPageImage() {
    return this.closeIcon.classList.contains('icon_close-img-fullpage');
  },

  limitKeyboardNavigationToEscKey(event) {
    if (event.key === 'Tab' || event.shiftKey && event.key === 'Tab') {
      event.preventDefault();
    }
  },

  trapFocus(event) {
    if (event.shiftKey && event.key === 'Tab') {
      this.focusCloseIcon(event);
    } else if (event.key === 'Tab') {
      this.focusZoomIcon(event);
    }
  },

  focusCloseIcon(event) {
    if (document.activeElement === this.zoomIcon || document.activeElement === this.slideshow) {
      event.preventDefault();
      this.closeIcon.focus();
    }
  },

  focusZoomIcon(event) {
    if (document.activeElement === this.closeIcon) {
      event.preventDefault();
      this.zoomIcon.focus();
    }
  },

  controlSlideshowLightbox(event) {
    if (this.userSelectedPreviousImage(event)) {
      return;
    }

    if (this.userSelectedNextImage(event)) {
      return;
    }

    if (this.userWantsFullPageImage(event)) {
      this.showFullPageImage();
      return;
    }

    if (this.userWantsToHideFullPageImage(event)) {
      this.closeFullPageImage();
      return;
    }

    if (this.userWantsToCloseSlideshowLightbox(event)) {
      this.hideSlideshow();
    }
  },

  userSelectedPreviousImage(event) {
    if (this.isLeftArrowUsed(event) || this.isLeftHalfOfScreenTapped(event)) {
      if (this.isRectangleImageFullPage() || this.isSquareImageFullPage()) {
        this.closeFullPageImage();
      }
      this.goToPreviousImage();
      return true;
    }
  },

  userSelectedNextImage(event) {
    if (this.isRightArrowUsed(event) || this.isRightHalfOfScreenTapped(event)) {
      if (this.isRectangleImageFullPage() || this.isSquareImageFullPage()) {
        this.closeFullPageImage();
      }
      this.goToNextImage();
      return true;
    }
  },

  isLeftArrowUsed(event) {
    const previous = document.querySelector('.slideshow__icon_arrow-previous');
    return event.target === previous || event.key === 'ArrowLeft';
  },

  isLeftHalfOfScreenTapped(event) {
    return this.isTouchscreenNarrowerThan1058px && event.target === this.slideshow && event.clientX < this.screenCenter;
  },
  
  goToPreviousImage() {
    const totalNumberOfSlides = this.slides.length;
    this.current = (this.current - 1 + totalNumberOfSlides) % totalNumberOfSlides;
    this.showCurrentSlide(this.current);
  },

  isRectangleImageFullPage() {
    return this.images[this.current].classList.contains('slide__img-rectangle_zoom-in');
  },

  isSquareImageFullPage() {
    return this.images[this.current].classList.contains('slide__img-square_zoom-in');
  },

  closeFullPageImage() {
    if (!this.slideshow) {
      return;
    }

    if (this.isRectangleImageFullPage()) {
      this.toggleVisibility(this.images[this.current], 'slide__img-rectangle_zoom-out', 'slide__img-rectangle_zoom-in');
    } else if (this.isSquareImageFullPage()) {
      this.toggleVisibility(this.images[this.current], 'slide__img-square_zoom-out', 'slide__img-square_zoom-in');
    }

    this.makeSlideNotScrollable(this.current);

    this.makeSlideUnfocusableToPreserveTabbingThroughZoomAndCloseIconsIfUserClicksAnywhereOnSlide(this.current);

    this.restoreSlideshowFunctionality();
  },

  makeSlideNotScrollable(currentSlide) {
    this.slides[currentSlide].classList.remove('slide_scrollable');
  },

  makeSlideUnfocusableToPreserveTabbingThroughZoomAndCloseIconsIfUserClicksAnywhereOnSlide(currentSlide) {
    this.slides[currentSlide].removeAttribute('tabindex');
  },

  restoreSlideshowFunctionality() {
    this.slideshow.focus();
    this.slideshow.classList.remove('slideshow_scrollbar_hidden');
    this.closeIcon.classList.remove('icon_close-img-fullpage');
  },

  isRightArrowUsed(event) {
    const nextImgIcon = document.querySelector('.slideshow__icon_arrow-next');
    return event.target === nextImgIcon || event.key === 'ArrowRight';
  },

  isRightHalfOfScreenTapped(event) {
    return this.isTouchscreenNarrowerThan1058px && event.target === this.slideshow && event.clientX > this.screenCenter;
  },

  goToNextImage() {
    const totalNumberOfSlides = this.slides.length;
    this.current = (this.current + 1) % totalNumberOfSlides;
    this.showCurrentSlide(this.current);
  },

  userWantsFullPageImage(event) {
    if (event.target === this.zoomIcon && event.type === 'click' ||
        document.activeElement === this.zoomIcon && event.key === 'Enter' ||
        this.isClickedImage(event)) {
      return true;
    }
  },

  isClickedImage(event) {
    if (event.target === this.images[this.current]) {
      return true;
    }
  },

  showFullPageImage() {
    if (this.images[this.current].classList.contains('slide__img-rectangle')) {
      this.toggleVisibility(this.images[this.current], 'slide__img-rectangle_zoom-in', 'slide__img-rectangle_zoom-out');
    } else if (this.images[this.current].classList.contains('slide__img-square')) {
      this.toggleVisibility(this.images[this.current], 'slide__img-square_zoom-in', 'slide__img-square_zoom-out');
    }

    this.makeFullPageImgScrollable();

    this.adjustSlideshowFunctionalityToFullPageImage();

    this.makeSlideVerticallyScrollableWithArrowKeys();
  },

  makeFullPageImgScrollable() {
    if (this.slides[this.current].classList.contains('slide_visible')) {
      this.slides[this.current].classList.add('slide_scrollable');
    }
  },

  adjustSlideshowFunctionalityToFullPageImage() {
    this.slideshow.classList.add('slideshow_scrollbar_hidden');
    this.closeIcon.classList.add('icon_close-img-fullpage');
  },

  makeSlideVerticallyScrollableWithArrowKeys() {
    if (this.slides[this.current].classList.contains('slide_visible')) {
      this.slides[this.current].setAttribute('tabindex', '0');
      this.slides[this.current].focus();
    }
  },

  userWantsToHideFullPageImage(event) {
    if (!this.isOnlyCloseIconWhenFullPageImage()) {
      return false;
    }

    if (event.target === this.closeIcon && event.type === 'click' || event.key === 'Escape') {
      return true;
    }
  },

  userWantsToCloseSlideshowLightbox(event) {
    if (event.target === this.closeIcon && event.type === 'click' ||
      document.activeElement === this.closeIcon && event.key === 'Enter' ||
      event.key === 'Escape') {
      return true;
    }
  },

  hideSlideshow() {
    this.toggleVisibility(this.slideshow, 'slideshow_hidden', 'slideshow_visible');

    this.terminateClosingAnimation();

    this.makeZoomAndCloseIconsNotFocusable();

    document.removeEventListener('keydown', this.boundTabThroughZoomAndCloseIcons);

    for (const event of ['click', 'keydown']) {
      document.removeEventListener(event, this.boundControlSlideshowLightbox);
    }

    restoreBodyAfterStoppingFullPageElementJerk();

    this.continueTabbingFromThumbnailImageWhichOpenedSlideshow();
  },

  terminateClosingAnimation() {
    this.slideshow.addEventListener('animationend', () => {
      this.slideshow.classList.remove('slideshow_hidden');
    });
  },

  makeZoomAndCloseIconsNotFocusable() {
    for (const icon of this.icons) {
      icon.removeAttribute('tabindex');
    }
  },

  continueTabbingFromThumbnailImageWhichOpenedSlideshow() {
    tabbingFrom.thumbnailImage.focus();
  },

  hideFullPageImageIfResized() {
    if (this.isDeviceWithFullPageImageUnavailable()) {
      this.closeFullPageImage();
    }
  },

  isDeviceWithFullPageImageUnavailable() {
    return window.innerWidth < 1058 || window.innerWidth > 1920;
  },

  rememberWhichThumbnailImageOpenedSlideshow(event) {
    tabbingFrom.thumbnailImage = event.target;
  },
};
