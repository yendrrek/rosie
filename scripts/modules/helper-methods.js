'use strict';

import { continuationOfTabbingFrom } from '../main.js';

export const HelperMethods = {

  /* https://stackoverflow.com/a/7557433/12208549 */
  isInViewport (element) {
    const positionOfElement = element.getBoundingClientRect();
    return (positionOfElement.top >= 0 &&
      positionOfElement.left >= 0 &&
      positionOfElement.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
      positionOfElement.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
  },

  /* https://stackoverflow.com/a/41441587/12208549 */
  preventJerkingOfLightbox () {
    const bodyWidthBeforeScrollbarRemoved = document.body.offsetWidth;
    this.removeBodyScrollbar();
    const bodyWidthAfterScrollbarRemoved = document.body.offsetWidth;
    document.body.style.marginRight = bodyWidthAfterScrollbarRemoved - bodyWidthBeforeScrollbarRemoved + 'px';
  },

  removeBodyScrollbar () {
    document.body.style.overflow = 'hidden';
  },

  restoreBodyState () {
    const pageWithThumbnailImgs = document.querySelectorAll('.thumbnail-clickable-area')[0];
    const restoredBodyAfterFixingLightboxJerk = document.body;
    restoredBodyAfterFixingLightboxJerk.style.marginRight = '';
    this.restoreBodyScrollbar();
    if (pageWithThumbnailImgs) {
      if (continuationOfTabbingFrom.thumbnailImgWhichOpenedSlideshow) {
        continuationOfTabbingFrom.thumbnailImgWhichOpenedSlideshow.focus();
      }
    }
  },

  restoreBodyScrollbar () {
    document.body.style.overflow = 'initial';
  }

};