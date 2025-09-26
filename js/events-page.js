/**
 * Interactions for the Events page: tab switching, filtering, calendar rendering and modal details.
 */

jQuery(function ($) {
  'use strict';

  const $navItems = $('.events-nav-item');
  const $listView = $('#list-view');
  const $calendarView = $('#calendar-view');
  const $calendarBody = $('#calendar-body');
  const $calendarTitle = $('#calendar-title');
  const $eventGrid = $('.event-grid');
  const $cards = $eventGrid.find('.event-card');
  const $categoryFilter = $('#category-filter');
  const $sortFilter = $('#sort-filter');
  const $searchForm = $('#event-search-form');
  const $searchInput = $searchForm.find('.search-input');
  const $noEventsMessage = $('<div class="no-events-message" style="display:none;">現在表示できるイベントがありません。</div>');
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  if ($eventGrid.length) {
    $eventGrid.after($noEventsMessage);
  }

  const state = {
    mode: 'list',
    category: 'all',
    sort: 'date-desc',
    search: ''
  };

  const eventsData = buildEventDataset();

  let calendarReferenceDate = new Date(today.getFullYear(), today.getMonth(), 1);
  renderCalendar();

  attachNavEvents();
  attachFilterEvents();
  attachModalEvents();

  applyFilters();

  /**
   * Build an array of event metadata sourced from the DOM.
   */
  function buildEventDataset() {
    const dataset = [];

    $cards.each(function (index) {
      const $card = $(this);
      const title = $card.find('.event-title').text().trim();
      const dateText = $card.find('.event-date-badge').text().trim();
      const timeText = extractDetail($card, 'clock');
      const priceText = extractDetail($card, 'ticket');
      const categoryText = $card.find('.event-category').text().trim();
      const descriptionHtml = $card.find('.event-description').length ? $card.find('.event-description').html().trim() : '';
      const image = $card.find('.event-image img');
      const imageSrc = image.attr('src') || '';
      const imageAlt = image.attr('alt') || title;
      const link = $card.find('.event-btn').attr('href') || '';
      const descriptionText = $('<div>').html(descriptionHtml).text().trim();
      const performersHtml = $card.find('.event-performers').length ? $card.find('.event-performers').html().trim() : ($card.data('performers') || '');
      const categorySlug = slugify(categoryText) || 'uncategorized';
      const date = parseEventDate(dateText);
      const timestamp = date ? date.getTime() : null;
      const searchHaystack = [title, descriptionText, timeText, priceText, categoryText].join(' ').toLowerCase();

      const eventData = {
        id: index,
        $card,
        title,
        dateText,
        date,
        timestamp,
        time: timeText,
        price: priceText,
        category: categoryText,
        categorySlug,
        descriptionHtml,
        imageSrc,
        imageAlt,
        link,
        performers: performersHtml,
        searchHaystack
      };

      $card.attr({
        'data-category': categorySlug,
        'data-event-id': index
      });

      $card.data('event', eventData);
      dataset.push(eventData);
    });

    return dataset;
  }

  /**
   * Extract a detail value from the event info rows by icon name.
   */
  function extractDetail($card, iconKeyword) {
    let value = '';

    $card.find('.event-info').each(function () {
      const $info = $(this);
      const iconClass = $info.find('i').attr('class') || '';
      if (iconClass.includes(iconKeyword)) {
        value = $info.find('span').text().trim();
        return false;
      }

      // Fallback if there is no span element
      const text = $info.clone().children('i').remove().end().text().trim();
      if (!value && text && iconKeyword === 'clock') {
        value = text;
      }
    });

    return value;
  }

  /**
   * Convert string to slug.
   */
  function slugify(str) {
    if (!str) {
      return '';
    }

    return str
      .toString()
      .toLowerCase()
      .replace(/\s+/g, '-')
      .replace(/[^a-z0-9\-]+/g, '')
      .replace(/\-+/g, '-')
      .replace(/^-+|-+$/g, '');
  }

  /**
   * Parse event date string into Date object.
   */
  function parseEventDate(value) {
    if (!value) {
      return null;
    }

    let text = value.trim();
    text = text.replace(/[年月]/g, '-').replace(/日/g, '').replace(/[\.\/]/g, '-');
    const digits = text.match(/(\d{4})-?(\d{1,2})-?(\d{1,2})/);

    if (!digits) {
      return null;
    }

    const year = parseInt(digits[1], 10);
    const month = parseInt(digits[2], 10);
    const day = parseInt(digits[3], 10);

    if (!year || !month || !day) {
      return null;
    }

    return new Date(year, month - 1, day);
  }

  /**
   * Apply current filters and sorting to the event list.
   */
  function applyFilters() {
    sortCards();

    let visibleCount = 0;

    $cards.each(function () {
      const $card = $(this);
      const data = $card.data('event');
      let isVisible = true;

      if (!data) {
        return;
      }

      if (state.category !== 'all' && data.categorySlug !== state.category) {
        isVisible = false;
      }

      if (state.mode === 'upcoming' && data.timestamp !== null) {
        isVisible = data.timestamp >= today.getTime();
      }

      if (state.mode === 'past') {
        isVisible = data.timestamp !== null && data.timestamp < today.getTime();
      }

      if (state.search) {
        isVisible = isVisible && data.searchHaystack.includes(state.search);
      }

      $card.toggleClass('is-hidden', !isVisible);

      if (isVisible) {
        visibleCount += 1;
      }
    });

    if (visibleCount === 0) {
      $noEventsMessage.show();
    } else {
      $noEventsMessage.hide();
    }
  }

  /**
   * Sort event cards based on the selected ordering.
   */
  function sortCards() {
    const sortedCards = $cards.get().sort(function (a, b) {
      const dataA = $(a).data('event');
      const dataB = $(b).data('event');

      if (!dataA || !dataB) {
        return 0;
      }

      switch (state.sort) {
        case 'date-asc':
          return compareTimestamp(dataA, dataB);
        case 'date-desc':
          return compareTimestamp(dataB, dataA);
        case 'name-desc':
          return dataB.title.localeCompare(dataA.title, 'ja');
        case 'name-asc':
        default:
          return dataA.title.localeCompare(dataB.title, 'ja');
      }
    });

    $.each(sortedCards, function (_, card) {
      $eventGrid.append(card);
    });
  }

  /**
   * Compare helper respecting missing timestamps.
   */
  function compareTimestamp(a, b) {
    if (a.timestamp === null && b.timestamp === null) {
      return 0;
    }
    if (a.timestamp === null) {
      return 1;
    }
    if (b.timestamp === null) {
      return -1;
    }
    return a.timestamp - b.timestamp;
  }

  /**
   * Attach navigation interactions.
   */
  function attachNavEvents() {
    $navItems.each(function () {
      const $item = $(this);
      const view = $item.data('view');

      $item.attr({
        role: 'tab',
        tabindex: $item.hasClass('active') ? 0 : -1,
        'aria-selected': $item.hasClass('active')
      });

      $item.on('click', function () {
        activateView(view, $item);
      });

      $item.on('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
          event.preventDefault();
          activateView(view, $item);
        }
      });
    });
  }

  /**
   * Activate view (list/calendar/upcoming/past).
   */
  function activateView(view, $item) {
    $navItems.removeClass('active').attr({
      'aria-selected': 'false',
      tabindex: -1
    });

    $item.addClass('active').attr({
      'aria-selected': 'true',
      tabindex: 0
    }).focus();

    if (view === 'calendar') {
      $calendarView.addClass('active');
      $listView.removeClass('active');
      renderCalendar();
      return;
    }

    $calendarView.removeClass('active');
    $listView.addClass('active');

    if (view === 'upcoming' || view === 'past') {
      state.mode = view;
    } else {
      state.mode = 'list';
    }

    applyFilters();
  }

  /**
   * Attach form / dropdown filters.
   */
  function attachFilterEvents() {
    $categoryFilter.on('change', function () {
      state.category = $(this).val();
      applyFilters();
    });

    $sortFilter.on('change', function () {
      state.sort = $(this).val();
      applyFilters();
    });

    $searchForm.on('submit', function (event) {
      event.preventDefault();
    });

    $searchInput.on('input', function () {
      state.search = $(this).val().trim().toLowerCase();
      applyFilters();
    });

    $('#prev-month').on('click', function () {
      calendarReferenceDate.setMonth(calendarReferenceDate.getMonth() - 1);
      renderCalendar();
    });

    $('#next-month').on('click', function () {
      calendarReferenceDate.setMonth(calendarReferenceDate.getMonth() + 1);
      renderCalendar();
    });
  }

  /**
   * Render monthly calendar view based on events dataset.
   */
  function renderCalendar() {
    if (!$calendarBody.length) {
      return;
    }

    const year = calendarReferenceDate.getFullYear();
    const month = calendarReferenceDate.getMonth();
    const firstDay = new Date(year, month, 1);
    const startWeekday = firstDay.getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    $calendarTitle.text(`${year}年${month + 1}月`);
    $calendarBody.empty();

    let day = 1;

    for (let row = 0; row < 6; row += 1) {
      const $tr = $('<tr></tr>');

      for (let col = 0; col < 7; col += 1) {
        const cellIndex = row * 7 + col;
        const $td = $('<td></td>');
        const $dayContainer = $('<div class="calendar-day"></div>');

        if (cellIndex >= startWeekday && day <= daysInMonth) {
          const cellDate = new Date(year, month, day);
          $dayContainer.append(`<div class="calendar-day-number">${day}</div>`);

          const eventsForDay = eventsData.filter(function (event) {
            if (!event.date) {
              return false;
            }

            return event.date.getFullYear() === cellDate.getFullYear() &&
              event.date.getMonth() === cellDate.getMonth() &&
              event.date.getDate() === cellDate.getDate();
          });

          if (eventsForDay.length) {
            $dayContainer.addClass('has-event');
            eventsForDay.slice(0, 2).forEach(function (event) {
              const label = $('<div class="calendar-event"></div>').text(event.title);
              label.attr('data-event-id', event.id);
              $dayContainer.append(label);
            });
          }

          day += 1;
        }

        $td.append($dayContainer);
        $tr.append($td);
      }

      $calendarBody.append($tr);
    }
  }

  /**
   * Attach modal open/close events.
   */
  function attachModalEvents() {
    const $modal = $('#event-modal');

    if (!$modal.length) {
      return;
    }

    const $close = $modal.find('.modal-close');
    const $ticketLink = $('#modal-ticket-link');

    $ticketLink.attr({ target: '_blank', rel: 'noopener noreferrer' });
    $('#share-twitter, #share-facebook, #share-line').attr({ target: '_blank', rel: 'noopener noreferrer' });

    $eventGrid.on('click', '.event-btn', function (event) {
      event.preventDefault();
      const $card = $(this).closest('.event-card');
      const data = $card.data('event');
      openModal(data);
    });

    $modal.on('click', function (event) {
      if ($(event.target).is($modal)) {
        closeModal();
      }
    });

    $close.on('click', function () {
      closeModal();
    });

    $(document).on('keydown', function (event) {
      if (event.key === 'Escape' && $modal.hasClass('active')) {
        closeModal();
      }
    });
  }

  /**
   * Open modal with event information.
   */
  function openModal(data) {
    if (!data) {
      return;
    }

    $('#modal-img').attr({ src: data.imageSrc, alt: data.imageAlt || data.title });
    $('#modal-title').text(data.title || '');
    $('#modal-date').text(data.dateText || '未定');
    $('#modal-time').text(data.time || '未定');
    $('#modal-category').text(data.category || '');
    $('#modal-description').html(data.descriptionHtml || '<p>詳細情報は近日公開予定です。</p>');

    if (data.price) {
      $('#modal-tickets').html(`<div class="ticket-option"><span>${data.price}</span><span>Logic Nagoya</span></div>`);
    } else {
      $('#modal-tickets').html('<p>チケット情報はお問い合わせください。</p>');
    }

    $('#modal-performers-section').toggle(!!data.performers);

    if (data.performers) {
      $('#modal-performers').html(data.performers);
    } else {
      $('#modal-performers').empty();
    }

    const ticketLink = data.link || '';
    const $ticketLink = $('#modal-ticket-link');

    if (ticketLink) {
      $ticketLink.attr('href', ticketLink).removeClass('is-disabled');
    } else {
      $ticketLink.attr('href', '#').addClass('is-disabled');
    }

    updateShareLinks(data);

    $('#event-modal').addClass('active');
    $('body').addClass('modal-open');
    $('.modal-close').focus();
  }

  /**
   * Close modal view.
   */
  function closeModal() {
    $('#event-modal').removeClass('active');
    $('body').removeClass('modal-open');
  }

  /**
   * Update share links for the modal content.
   */
  function updateShareLinks(data) {
    const url = encodeURIComponent(data.link || window.location.href);
    const text = encodeURIComponent(`${data.title} | Logic Nagoya`);

    $('#share-twitter').attr('href', `https://twitter.com/intent/tweet?text=${text}&url=${url}`);
    $('#share-facebook').attr('href', `https://www.facebook.com/sharer/sharer.php?u=${url}`);
    $('#share-line').attr('href', `https://social-plugins.line.me/lineit/share?url=${url}`);
  }
});
