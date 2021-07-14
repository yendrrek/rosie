'use strict';

export const BackToTopButton = {
  
  backToTopBtn: document.querySelector('.back-to-top-btn'),

  controlBackToTopBtn () {
    const viewportHeight = window.innerHeight;
    const noOfPxsAtWhichBackToTopBtnAppears = viewportHeight * 4;
    const pageScrolledDownBy = document.documentElement.scrollTop;
    if (this.backToTopBtn) {
      if (pageScrolledDownBy >= noOfPxsAtWhichBackToTopBtnAppears) {
        this.showBackToTopBtn();
      } else {
        this.hideBackToTopBtn();
      }
    }
  },

  showBackToTopBtn () {
    if (this.backToTopBtn.classList.contains('back-to-top-btn_hidden')) {
      this.backToTopBtn.classList.remove('back-to-top-btn_hidden');
      this.backToTopBtn.classList.add('back-to-top-btn_visible');
    }
  },

  hideBackToTopBtn () {
    this.backToTopBtn.classList.remove('back-to-top-btn_visible');
    this.backToTopBtn.classList.add('back-to-top-btn_hidden');
  }

};
