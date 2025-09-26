(function () {
  'use strict';

  const header = document.querySelector('.header');
  const loader = document.querySelector('.loader');

  const updateHeaderState = function () {
    if (!header) {
      return;
    }

    const shouldBeScrolled = window.scrollY > 50;
    header.classList.toggle('scrolled', shouldBeScrolled);
  };

  window.addEventListener('scroll', updateHeaderState, { passive: true });
  updateHeaderState();

  window.addEventListener('load', function () {
    if (!loader) {
      return;
    }

    window.setTimeout(function () {
      loader.classList.add('loaded');
    }, 900);
  });
})();
