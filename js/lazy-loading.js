/**
 * Lazy loading utility for images, iframes and videos.
 */

(function () {
  'use strict';

  const lazySelectors = 'img[data-src], img[data-srcset], iframe[data-src], video[data-src], source[data-srcset]';
  const elements = [].slice.call(document.querySelectorAll(lazySelectors));

  if (!elements.length) {
    return;
  }

  if ('loading' in HTMLImageElement.prototype) {
    elements.forEach(applyNativeLazyLoading);
  } else if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(onIntersection, {
      rootMargin: '150px 0px',
      threshold: 0.01
    });

    elements.forEach(function (element) {
      observer.observe(element);
    });
  } else {
    // Fallback for older browsers
    loadAllElements();
  }

  /**
   * Intersection observer callback.
   */
  function onIntersection(entries, observer) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting || entry.intersectionRatio > 0) {
        loadElement(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }

  /**
   * Load every element immediately.
   */
  function loadAllElements() {
    elements.forEach(loadElement);
  }

  /**
   * Apply native lazy loading attribute for supporting browsers.
   */
  function applyNativeLazyLoading(element) {
    if ('loading' in element) {
      element.loading = 'lazy';
    }
    loadElement(element);
  }

  /**
   * Load an element by swapping dataset attributes.
   */
  function loadElement(element) {
    const node = element;

    if (!node) {
      return;
    }

    const markLoaded = function () {
      if (node.parentElement && node.parentElement.classList) {
        node.parentElement.classList.add('is-loaded');
      }
      node.classList.add('is-loaded');
    };

    if (node.tagName === 'IMG') {
      node.addEventListener('load', markLoaded, { once: true });
      node.addEventListener('error', markLoaded, { once: true });
      if (node.complete) {
        markLoaded();
      }
    }

    if (node.dataset.srcset) {
      node.setAttribute('srcset', node.dataset.srcset);
      delete node.dataset.srcset;
    }

    if (node.dataset.src) {
      node.setAttribute('src', node.dataset.src);
      delete node.dataset.src;
    }

    if (node.dataset.sizes) {
      node.setAttribute('sizes', node.dataset.sizes);
      delete node.dataset.sizes;
    }

    if (node.tagName === 'VIDEO') {
      node.load();
    }

    if (node.tagName === 'SOURCE' && node.parentElement && node.parentElement.tagName === 'VIDEO') {
      node.parentElement.load();
    }

    if (node.tagName !== 'IMG') {
      markLoaded();
    }
  }
})();
