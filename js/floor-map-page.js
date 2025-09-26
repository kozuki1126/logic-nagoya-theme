/**
 * Enhancements for the Floor map & Access page.
 */

jQuery(function ($) {
  'use strict';

  initFloorMapToolbar();
  initDetailHighlights();
  initAddressCopy();

  /**
   * Create toolbar controls for the floor map image.
   */
  function initFloorMapToolbar() {
    const $image = $('#floormap-img');
    const $container = $image.closest('.floormap-container');

    if (!$image.length || !$container.length) {
      return;
    }

    const $toolbar = $('<div class="floormap-toolbar" role="group" aria-label="フロアマップ操作"></div>');
    const $zoomButton = $('<button type="button" class="floormap-toolbar-button" aria-pressed="false" aria-label="フロアマップを拡大"><i class="fas fa-search-plus"></i></button>');
    const $resetButton = $('<button type="button" class="floormap-toolbar-button" aria-label="拡大をリセット"><i class="fas fa-sync-alt"></i></button>');
    const $downloadButton = $('<a class="floormap-toolbar-button" aria-label="フロアマップを新しいタブで開く" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i></a>');

    $downloadButton.attr('href', $image.attr('src'));

    $toolbar.append($zoomButton, $resetButton, $downloadButton);
    $container.append($toolbar);

    $zoomButton.on('click', function () {
      const isZoomed = $image.toggleClass('is-zoomed').hasClass('is-zoomed');
      $zoomButton.attr('aria-pressed', isZoomed);
    });

    $resetButton.on('click', function () {
      $image.removeClass('is-zoomed');
      $zoomButton.attr('aria-pressed', 'false');
    });

    $image.on('dblclick', function () {
      $zoomButton.trigger('click');
    });
  }

  /**
   * Highlight detail blocks on hover/focus to improve readability.
   */
  function initDetailHighlights() {
    const $detailItems = $('.floormap-detail-item');

    if (!$detailItems.length) {
      return;
    }

    $detailItems.attr('tabindex', 0);

    $detailItems.on('mouseenter focusin', function () {
      $(this).addClass('is-highlighted');
    });

    $detailItems.on('mouseleave focusout', function () {
      $(this).removeClass('is-highlighted');
    });
  }

  /**
   * Provide copy-to-clipboard button for the access address.
   */
  function initAddressCopy() {
    const $address = $('.access-address');

    if (!$address.length) {
      return;
    }

    const addressText = $('<div>').html($address.html()).text().replace(/\s+/g, ' ').trim();
    const $cta = $('<div class="access-cta"></div>');
    const $copyButton = $('<button type="button" class="btn btn-outline"><i class="fas fa-copy" aria-hidden="true"></i> <span>住所をコピー</span></button>');
    const $confirmation = $('<span class="access-copy-confirmation" role="status" aria-live="polite"></span>');

    $cta.append($copyButton, $confirmation);
    $address.after($cta);

    $copyButton.on('click', function () {
      copyToClipboard(addressText)
        .then(function () {
          showCopyMessage($confirmation, '住所をコピーしました。');
        })
        .catch(function () {
          showCopyMessage($confirmation, 'コピーに失敗しました。', true);
        });
    });
  }

  /**
   * Copy helper supporting navigator.clipboard fallback.
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
          reject(new Error('Copy failed'));
        }
      } catch (error) {
        textarea.remove();
        reject(error);
      }
    });
  }

  /**
   * Show confirmation message below the address.
   */
  function showCopyMessage($element, message, isError) {
    $element.text(message).addClass('is-visible');

    if (isError) {
      $element.css('color', '#f7b267');
    } else {
      $element.css('color', 'rgba(241, 250, 238, 0.7)');
    }

    setTimeout(function () {
      $element.removeClass('is-visible').text('');
    }, 4000);
  }
});
