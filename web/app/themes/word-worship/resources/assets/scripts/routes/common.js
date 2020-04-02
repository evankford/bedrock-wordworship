import 'lazysizes';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';
import rellax from 'rellax';

import Headroom from 'headroom.js';
import AOS from 'aos';

function initRellax() {
  rellax('.rellax-bg', {
    speed: -5,
    center: true,
  });
  rellax('.rellax', {
    speed: -3,
    center: false,
  });
}
function initAOS() {
  AOS.init({
    once: true,
  })
}

function initHeadroom() {

  var siteHeader = document.querySelector('header.banner');
  if (siteHeader) {
    var myHeadroom = new Headroom(siteHeader)
    myHeadroom.init();
  }
}

function initModules() {
  Array.from(document.querySelectorAll('[data-module]')).forEach(el => {
    const name = el.getAttribute('data-module')
    const Module = require(`../modules/${name}`).default
    new Module(el)
  })
}

export default {
  init() {
    // JavaScript to be fired on all pages
    initModules();
    initAOS();
    initHeadroom();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    window.addEventListener('load', initRellax)
  },
};
