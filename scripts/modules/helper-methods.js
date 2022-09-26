'use strict';

// https://stackoverflow.com/a/7557433/12208549
// https://developer.mozilla.org/en-US/docs/Web/API/Element/getBoundingClientRect
export function isInViewport(element) {
  const elementPosition = element.getBoundingClientRect();

  return elementPosition.top >= 0 &&
    elementPosition.left >= 0 &&
    elementPosition.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    elementPosition.right <= (window.innerWidth || document.documentElement.clientWidth);
}

// https://stackoverflow.com/a/41441587/12208549
export function stopFullPageElementJerk() {
  const bodyWidthBeforeScrollbarRemoved = document.body.offsetWidth;
  removeScrollbar();
  const bodyWidthAfterScrollbarRemoved = document.body.offsetWidth;
  document.body.style.marginRight = extendMargin(bodyWidthAfterScrollbarRemoved, bodyWidthBeforeScrollbarRemoved);
}

function removeScrollbar() {
  document.body.style.overflow = 'hidden';
}

function extendMargin(widerBody, narrowerBody) {
  return widerBody - narrowerBody + 'px';
}

export function restoreBodyAfterStoppingFullPageElementJerk() {
  const pageWithThumbnailImages = document.querySelectorAll('.thumbnail-clickable-area')[0];

  if (!pageWithThumbnailImages) {
    return;
  }

  restoreMargin();
  restoreBodyScrollbar();
}

function restoreMargin() {
  document.body.style.marginRight = '';
}

export function restoreBodyScrollbar() {
  document.body.style.overflow = 'initial';
}
