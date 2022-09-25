'use strict';

// https://fotorama.io/

export function insertFotorama () {
  if (!isDeviceUsingFotorama()) {
    return;
  }

  if (!isShop) {
    return;
  }

  if (!getFotoramaSourcingElements().includes(null)) {
    return;
  }

  includeFotoramaSourcingElements();
}

function isDeviceUsingFotorama() {
  return document.body.clientWidth < 1169;
}

function isShop() {
  const pageName = document.querySelector('.breadcrumbs__title').innerText;
  return pageName === 'Shop';
}

function getFotoramaSourcingElements() {
  const fotoramaJS = document.querySelector('script[src*="fotorama"]');
  const fotoramaCSS = document.querySelector('link[href*="fotorama"]');

  return [fotoramaJS, fotoramaCSS];
}

function includeFotoramaSourcingElements() {
  document.head.append(makeStyleSheetElement());
  document.head.append(makeScriptElement());
}

function makeStyleSheetElement() {
  const fotoramaCSS = document.createElement('link');

  fotoramaCSS.setAttribute('href', 'fotorama-4.6.4.dev/fotorama.dev.css');
  fotoramaCSS.setAttribute('rel', 'stylesheet');

  return fotoramaCSS;
}

function makeScriptElement() {
  const fotoramaJS = document.createElement('script');

  fotoramaJS.setAttribute('src', 'fotorama-4.6.4.dev/fotorama.dev.js');

  return fotoramaJS;
}

export function removeFotorama() {
  if (isDeviceUsingFotorama()) {
    return;
  }

  if (!isShop()) {
    return;
  }

  if (getFotoramaSourcingElements().includes(null)) {
    return;
  }

  for (const element of getFotoramaSourcingElements()) {
    element.remove();
  }
}
