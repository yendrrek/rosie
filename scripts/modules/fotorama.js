'use strict';

/**
 * External library 'Fotorama' for showing photos of products in the shop on smaller touchscreen 
 * devices. It requires JavaScript and CSS code which get inserted in <head> dynamically
 * depending on the screen size. 
 * https://fotorama.io/
*/

export function insertFotoramaForScreensNarrowerThan1170px () {
  const head = document.head;
  const fotoramaCss = document.createElement('link');
  const fotoramaJs = document.createElement('script');
  const fotoramaJsAlreadyInDom = document.querySelector('script[src*="fotorama"]');
  const fotoramaCssAlreadyInDom = document.querySelector('link[href*="fotorama"]');
  const shopPageIsLoaded = (document.querySelector('.breadcrumbs__title').innerText === 'Shop');
  fotoramaCss.href = 'fotorama-4.6.4.dev/fotorama.dev.css';
  fotoramaCss.rel = 'stylesheet';
  fotoramaJs.src = 'fotorama-4.6.4.dev/fotorama.dev.js';
  if (!fotoramaJsAlreadyInDom && !fotoramaCssAlreadyInDom) {
    if (screen.width < 1170 && shopPageIsLoaded ) {
      head.append(fotoramaCss);
      head.append(fotoramaJs);
    }
  } 
}

export function removeFotoramaForScreensWiderThan1169px () {
  const fotoramaJsAlreadyInDom = document.querySelector('script[src*="fotorama"]');
  const fotoramaCssAlreadyInDom = document.querySelector('link[href*="fotorama"]');
  const shopPageIsLoaded = (document.querySelector('.breadcrumbs__title').innerText === 'Shop');
  if (fotoramaJsAlreadyInDom && fotoramaCssAlreadyInDom) {
    if (screen.width > 1169 && shopPageIsLoaded) {
      fotoramaJsAlreadyInDom.remove();
      fotoramaCssAlreadyInDom.remove();
    }
  }
}
