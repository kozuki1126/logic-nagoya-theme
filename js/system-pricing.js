/**
 * Interactions for the System & Pricing page.
 */

jQuery(function ($) {
  'use strict';

  const tabs = $('.pricing-tab');
  const contents = $('.pricing-content');

  if (tabs.length > 0) {
    initTabs();
  }

  initFAQ();

  /**
   * Initialise pricing tab behaviour with ARIA attributes.
   */
  function initTabs() {
    const tablist = $('<div class="pricing-tablist" role="tablist" aria-label="料金プラン"></div>');

    if (!$('.pricing-tabs').attr('role')) {
      $('.pricing-tabs').attr('role', 'tablist');
    }

    tabs.each(function (index) {
      const $tab = $(this);
      const tabId = `pricing-tab-${index}`;
      const panelId = `${$tab.data('tab')}-content`;

      $tab.attr({
        id: tabId,
        role: 'tab',
        tabindex: $tab.hasClass('active') ? 0 : -1,
        'aria-selected': $tab.hasClass('active'),
        'aria-controls': panelId
      });

      const $panel = contents.filter(`#${panelId}`);

      $panel.attr({
        role: 'tabpanel',
        'aria-labelledby': tabId,
        hidden: !$tab.hasClass('active')
      });
    });

    tabs.on('click', function () {
      activateTab($(this));
    });

    tabs.on('keydown', function (event) {
      const key = event.key;
      const currentIndex = tabs.index(this);
      let newIndex = null;

      if (key === 'ArrowRight' || key === 'ArrowDown') {
        newIndex = (currentIndex + 1) % tabs.length;
      } else if (key === 'ArrowLeft' || key === 'ArrowUp') {
        newIndex = (currentIndex - 1 + tabs.length) % tabs.length;
      } else if (key === 'Home') {
        newIndex = 0;
      } else if (key === 'End') {
        newIndex = tabs.length - 1;
      }

      if (newIndex !== null) {
        event.preventDefault();
        activateTab($(tabs.get(newIndex)));
      }
    });
  }

  /**
   * Activate a specific tab.
   *
   * @param {jQuery} $tab
   */
  function activateTab($tab) {
    const target = $tab.data('tab');
    const $panel = contents.filter(`#${target}-content`);

    if ($tab.hasClass('active')) {
      return;
    }

    tabs.removeClass('active').attr({
      'aria-selected': 'false',
      tabindex: -1
    });

    contents.removeClass('active').attr('hidden', true);

    $tab.addClass('active').attr({
      'aria-selected': 'true',
      tabindex: 0
    }).focus();

    $panel.addClass('active').attr('hidden', false);
  }

  /**
   * Initialise FAQ accordion behaviour for this page.
   */
  function initFAQ() {
    const faqItems = $('.faq-item');

    if (!faqItems.length) {
      return;
    }

    faqItems.each(function (index) {
      const $item = $(this);
      const $question = $item.find('.faq-question');
      const $answer = $item.find('.faq-answer');
      const questionId = `pricing-faq-question-${index}`;
      const answerId = `pricing-faq-answer-${index}`;

      $question.attr({
        id: questionId,
        role: 'button',
        tabindex: 0,
        'aria-expanded': 'false',
        'aria-controls': answerId
      });

      $answer.attr({
        id: answerId,
        role: 'region',
        'aria-labelledby': questionId,
        hidden: true
      });
    });

    $('.faq-question').on('click', function () {
      toggleFAQ($(this).closest('.faq-item'));
    });

    $('.faq-question').on('keydown', function (event) {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        toggleFAQ($(this).closest('.faq-item'));
      }
    });
  }

  /**
   * Toggle FAQ item visibility.
   *
   * @param {jQuery} $item
   */
  function toggleFAQ($item) {
    const $answer = $item.find('.faq-answer');
    const $question = $item.find('.faq-question');
    const isActive = $item.hasClass('active');

    $('.faq-item').not($item).removeClass('active').find('.faq-answer').slideUp(240).attr('hidden', true);
    $('.faq-item').not($item).find('.faq-question').attr('aria-expanded', 'false');

    if (isActive) {
      $item.removeClass('active');
      $answer.slideUp(240, function () {
        $answer.attr('hidden', true);
      });
      $question.attr('aria-expanded', 'false');
    } else {
      $item.addClass('active');
      $answer.slideDown(240, function () {
        $answer.attr('hidden', false);
      });
      $question.attr('aria-expanded', 'true');
    }
  }
});
