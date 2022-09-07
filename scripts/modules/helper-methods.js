'use strict';

import { continuationOfTabbingFrom } from '../main.js';

/* https://stackoverflow.com/a/7557433/12208549 */
export function isInViewport (element) {
  const positionOfElement = element.getBoundingClientRect();
  return (positionOfElement.top >= 0 &&
    positionOfElement.left >= 0 &&
    positionOfElement.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    positionOfElement.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

/* https://stackoverflow.com/a/41441587/12208549 */
export function preventJerkingOfFullPageElement () {
  const bodyWidthBeforeScrollbarRemoved = document.body.offsetWidth;
  removeBodyScrollbar();
  const bodyWidthAfterScrollbarRemoved = document.body.offsetWidth;
  document.body.style.marginRight = bodyWidthAfterScrollbarRemoved - bodyWidthBeforeScrollbarRemoved + 'px';
}

function removeBodyScrollbar () {
  document.body.style.overflow = 'hidden';
}

export function restoreBodyState () {
  const pageWithThumbnailImgs = document.querySelectorAll('.thumbnail-clickable-area')[0];
  const restoredBodyAfterFixingLightboxJerk = document.body;
  restoredBodyAfterFixingLightboxJerk.style.marginRight = '';
  restoreBodyScrollbar();
  if (pageWithThumbnailImgs) {
    if (continuationOfTabbingFrom.thumbnailImgWhichOpenedSlideshow) {
      continuationOfTabbingFrom.thumbnailImgWhichOpenedSlideshow.focus();
    }
  }
}

export function restoreBodyScrollbar () {
  document.body.style.overflow = 'initial';
}
