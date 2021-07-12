'use strict';

function isExplorerOrOldEdge (userAgent) {
  userAgent = userAgent || navigator.userAgent;
  return userAgent.indexOf('MSIE ') > -1 || userAgent.indexOf('Trident/') > -1 || userAgent.indexOf('Edge/') > -1;
}

function alertUserOnlyOnce (doNotAlertAgain) {
  if (isExplorerOrOldEdge()) {
    doNotAlertAgain = window.sessionStorage.getItem('doNotAlertAgain');
    if (doNotAlertAgain !== 'applied') {
      alert('Thank you for visiting www.rosiepiontek.com.\n\nFor safe and smooth experience please consider using any of the modern browsers like Firefox, Opera, Brave or Chrome.\n\nInternet Explorer and older versions of Edge pose a security risk and unfortunately this website will not work properly with any of them.');
      window.sessionStorage.setItem('doNotAlertAgain', 'applied');
    }
  }
}

alertUserOnlyOnce();
