/**
 * Enhancements for the About page template.
 */

jQuery(function ($) {
  'use strict';

  initScrollAnimations();
  initTimelineAccessibility();
  initSmoothAnchors();

  $(window).on('load', function () {
    window.setTimeout(function () {
      $('.about-intro').addClass('is-visible');
    }, 400);
  });

  /**
   * Apply intersection observer to feature cards and timeline items.
   */
  function initScrollAnimations() {
    const $featureCards = $('.feature-card');
    const $timelineItems = $('.timeline-item');
    const $animatedItems = $featureCards.add($timelineItems);

    if (!$animatedItems.length) {
      return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReducedMotion) {
      $animatedItems.addClass('is-visible');
      $('.about-intro').addClass('is-visible');
      return;
    }

    const observer = new IntersectionObserver(function (entries, observerRef) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          const $target = $(entry.target);
          let delay = 0;

          if ($target.hasClass('feature-card')) {
            delay = $featureCards.index(entry.target) * 120;
          } else if ($target.hasClass('timeline-item')) {
            delay = $timelineItems.index(entry.target) * 160;
          }

          window.setTimeout(function () {
            $target.addClass('is-visible');
          }, delay);

          observerRef.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2, rootMargin: '0px 0px -10%' });

    $animatedItems.each(function () {
      observer.observe(this);
    });
  }

  /**
   * Provide keyboard accessibility to the timeline blocks.
   */
  function initTimelineAccessibility() {
    const $timelineItems = $('.timeline-item');

    if (!$timelineItems.length) {
      return;
    }

    $timelineItems.attr({ tabindex: 0, role: 'listitem', 'aria-expanded': 'false' });

    $timelineItems.on('keydown', function (event) {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        toggleExpanded($(this));
      }
    });

    $timelineItems.on('click', function () {
      toggleExpanded($(this));
    });
  }

  /**
   * Toggle expanded state for a timeline entry.
   */
  function toggleExpanded($item) {
    const isExpanded = $item.attr('aria-expanded') === 'true';
    const newState = !isExpanded;

    $item.attr('aria-expanded', newState);
    $item.toggleClass('is-expanded', newState);
  }

  /**
   * Smooth scroll for in-page anchor links (if any).
   */
  function initSmoothAnchors() {
    $('a[href^="#"]').on('click', function (event) {
      const targetId = $(this).attr('href');
      if (!targetId || targetId === '#') {
        return;
      }

      const $target = $(targetId);

      if ($target.length) {
        event.preventDefault();
        $('html, body').animate({ scrollTop: $target.offset().top - 80 }, 500);
      }
    });
  }
});
