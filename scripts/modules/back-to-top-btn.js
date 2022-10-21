'use strict';
  
export function controlBackToTopButton() {
  const backToTopButton = document.querySelector('.back-to-top-btn');
  const isVisibleBackToTopButton = () => document.documentElement.scrollTop >= window.innerHeight * 4;
  const styles = isVisibleBackToTopButton() ? ['back-to-top-btn_visible', 'back-to-top-btn_hidden'] : ['back-to-top-btn_hidden', 'back-to-top-btn_visible'];

  if (!backToTopButton) {
    return;
  }

  backToTopButton.classList.remove(styles[1]);
  backToTopButton.classList.add(styles[0]);
}
