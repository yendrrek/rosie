'use strict';

export const Fotorama = {
 
  head: document.head,
  shopPageIsLoaded: (document.querySelector('.breadcrumbs__title').innerText === 'Shop'),
  fotoramaJsAlreadyInDom: () => document.querySelector('script[src*="fotorama"]'),
  fotoramaCssAlreadyInDom: () => document.querySelector('link[href*="fotorama"]'),

  insertFotoramaForScreensNarrowerThan1170px () {
    const fotoramaCss = document.createElement('link');
    const fotoramaJs = document.createElement('script');
    fotoramaCss.href = 'fotorama-4.6.4.dev/fotorama.dev.css';
    fotoramaCss.rel = 'stylesheet';
    fotoramaJs.src = 'fotorama-4.6.4.dev/fotorama.dev.js';
    if (!this.fotoramaJsAlreadyInDom() && !this.fotoramaCssAlreadyInDom()) {
      if (screen.width < 1170 && this.shopPageIsLoaded ) {
        this.head.append(fotoramaCss);
        this.head.append(fotoramaJs);
      }
    } 
  },

  removeFotoramaForScreensWiderThan1169px () {
    if (this.fotoramaJsAlreadyInDom() && this.fotoramaCssAlreadyInDom()) {
      if (screen.width > 1169 && this.shopPageIsLoaded) {
      this.fotoramaJsAlreadyInDom().remove();
      this.fotoramaCssAlreadyInDom().remove();
      }
    }
  }

};