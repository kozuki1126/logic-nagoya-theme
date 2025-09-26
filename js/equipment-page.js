/**
 * Interactions for the Equipment list page.
 */

jQuery(function ($) {
  'use strict';

  const $tabs = $('.equipment-tab');
  const $contents = $('.equipment-content');
  const $cards = $('.equipment-card');
  const $searchInput = $('.equipment-search input');
  const $exportButton = $('.equipment-export');
  const $tools = $('.equipment-tools');
  const $noResults = $('<div class="no-results-message equipment-no-results" style="display:none;">該当する機材が見つかりません。</div>');
  const $exportStatus = $('<span class="equipment-export-status" role="status" aria-live="polite"></span>');
  let exportMessageTimeout = null;

  if ($tools.length) {
    $tools.after($noResults);
    $tools.append($exportStatus);
  }

  initTabs();
  initSearch();
  initExport();
  filterEquipment();

  /**
   * Initialise tab switching behaviour.
   */
  function initTabs() {
    $tabs.each(function (index) {
      const $tab = $(this);
      const target = $tab.data('tab');
      const panelId = `${target}-content`;
      const tabId = `equipment-tab-${index}`;

      $tab.attr({
        id: tabId,
        role: 'tab',
        tabindex: $tab.hasClass('active') ? 0 : -1,
        'aria-controls': panelId,
        'aria-selected': $tab.hasClass('active')
      });

      $contents.filter(`#${panelId}`).attr({
        role: 'tabpanel',
        'aria-labelledby': tabId,
        hidden: !$tab.hasClass('active')
      });

      $tab.on('click', function () {
        activateTab($tab);
      });

      $tab.on('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
          event.preventDefault();
          activateTab($tab);
        }
      });
    });
  }

  /**
   * Activate a specific equipment tab.
   */
  function activateTab($tab) {
    const target = $tab.data('tab');

    $tabs.removeClass('active').attr({
      'aria-selected': 'false',
      tabindex: -1
    });

    $contents.removeClass('active').attr('hidden', true);

    $tab.addClass('active').attr({
      'aria-selected': 'true',
      tabindex: 0
    }).focus();

    $contents.filter(`#${target}-content`).addClass('active').attr('hidden', false);
    filterEquipment();
  }

  /**
   * Initialise equipment search filtering.
   */
  function initSearch() {
    if (!$searchInput.length) {
      return;
    }

    $searchInput.on('input', function () {
      filterEquipment();
    });
  }

  /**
   * Filter equipment cards based on search input.
   */
  function filterEquipment() {
    const term = $searchInput.length ? $searchInput.val().trim().toLowerCase() : '';
    const $activeContent = $contents.filter('.active');
    let visibleCount = 0;

    $cards.each(function () {
      const $card = $(this);
      const matches = !term || $card.text().toLowerCase().includes(term);

      $card.toggle(matches);
      $card.toggleClass('equipment-highlight', matches && term.length >= 2);
    });

    if ($activeContent.length) {
      visibleCount = $activeContent.find('.equipment-card:visible').length;
    } else {
      visibleCount = $('.equipment-card:visible').length;
    }

    if (term && visibleCount === 0) {
      $noResults.show();
    } else {
      $noResults.hide();
    }
  }

  /**
   * Initialise export button behaviour (copy visible items to clipboard).
   */
  function initExport() {
    if (!$exportButton.length) {
      return;
    }

    $exportButton.on('click', function (event) {
      event.preventDefault();

      const exportText = buildExportText();

      copyToClipboard(exportText)
        .then(function () {
          showExportMessage('機材リストをコピーしました。');
        })
        .catch(function () {
          showExportMessage('コピーに失敗しました。', true);
        });
    });
  }

  /**
   * Create export text from visible equipment cards.
   */
  function buildExportText() {
    const lines = [];
    const $activeCards = $('.equipment-content.active .equipment-card:visible');
    const $targetCards = $activeCards.length ? $activeCards : $('.equipment-card:visible');

    $targetCards.each(function () {
      const $card = $(this);
      const title = $card.find('.equipment-title').text().trim();
      const items = $card.find('.equipment-list .equipment-item').map(function () {
        return ` - ${$(this).text().trim()}`;
      }).get();

      lines.push(title);
      lines.push(...items);
      lines.push('');
    });

    if (!lines.length) {
      lines.push('Logic Nagoya Equipment List');
    }

    return lines.join('\n');
  }

  /**
   * Copy helper supporting browsers without navigator.clipboard.
   */
  function copyToClipboard(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      return navigator.clipboard.writeText(text);
    }

    return new Promise(function (resolve, reject) {
      const textarea = $('<textarea style="position:absolute;left:-9999px;top:-9999px;"></textarea>');
      textarea.val(text);
      $('body').append(textarea);
      textarea[0].select();

      try {
        const successful = document.execCommand('copy');
        textarea.remove();
        if (successful) {
          resolve();
        } else {
          reject(new Error('Copy command unsuccessful'));
        }
      } catch (error) {
        textarea.remove();
        reject(error);
      }
    });
  }

  /**
   * Display export status message.
   */
  function showExportMessage(message, isError) {
    if (!$exportStatus.length) {
      return;
    }

    $exportStatus.text(message);
    $exportStatus.toggleClass('is-visible', true);

    if (isError) {
      $exportStatus.css('color', '#f7b267');
    } else {
      $exportStatus.css('color', 'rgba(241, 250, 238, 0.65)');
    }

    if (exportMessageTimeout) {
      clearTimeout(exportMessageTimeout);
    }

    exportMessageTimeout = setTimeout(function () {
      $exportStatus.removeClass('is-visible').text('');
    }, 4000);
  }
});
