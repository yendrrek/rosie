'use strict';
  
export function controlBackToTopBtn () {
  const backToTopBtn = document.querySelector('.back-to-top-btn');
  const viewportHeight = window.innerHeight;
  const noOfPxsAtWhichBackToTopBtnAppears = viewportHeight * 4;
  const pageScrolledDownBy = document.documentElement.scrollTop;
  if (backToTopBtn) {
    if (pageScrolledDownBy >= noOfPxsAtWhichBackToTopBtnAppears) {
      showBackToTopBtn(backToTopBtn);
    } else {
      hideBackToTopBtn(backToTopBtn);
    }
  }
}

function showBackToTopBtn (backToTopBtn) {
  if (backToTopBtn.classList.contains('back-to-top-btn_hidden')) {
    backToTopBtn.classList.remove('back-to-top-btn_hidden');
    backToTopBtn.classList.add('back-to-top-btn_visible');
  }
}

function hideBackToTopBtn (backToTopBtn) {
  backToTopBtn.classList.remove('back-to-top-btn_visible');
  backToTopBtn.classList.add('back-to-top-btn_hidden');
}
