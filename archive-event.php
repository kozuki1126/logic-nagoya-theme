<?php
/**
 * The template for displaying event archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Logic_Nagoya
 */

get_header();
?>

  <!-- Page Header -->
  <section class="page-header">
    <div class="page-header-content">
      <h1 class="page-title"><?php esc_html_e('EVENTS', 'logic-nagoya'); ?></h1>
      <p class="page-subtitle"><?php echo esc_html(get_theme_mod('logic_nagoya_events_subtitle', 'Logic Nagoyaで開催される様々なイベント情報。ライブ、トークショー、配信イベントなど、多彩なラインナップをご紹介します。')); ?></p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="main-content">
    <div class="container content-container">
      <!-- Events Navigation -->
      <div class="events-nav">
        <div class="events-nav-item active" data-view="list"><?php esc_html_e('リスト表示', 'logic-nagoya'); ?></div>
        <div class="events-nav-item" data-view="calendar"><?php esc_html_e('カレンダー表示', 'logic-nagoya'); ?></div>
        <div class="events-nav-item" data-view="upcoming"><?php esc_html_e('今後のイベント', 'logic-nagoya'); ?></div>
        <div class="events-nav-item" data-view="past"><?php esc_html_e('過去のイベント', 'logic-nagoya'); ?></div>
      </div>

      <!-- Events Filter -->
      <div class="events-filter">
        <span class="filter-label"><?php esc_html_e('カテゴリー：', 'logic-nagoya'); ?></span>
        <select class="filter-dropdown" id="category-filter">
          <option value="all"><?php esc_html_e('すべて', 'logic-nagoya'); ?></option>
          <?php
          $event_categories = get_terms(array(
            'taxonomy' => 'event_category',
            'hide_empty' => true,
          ));
          
          if (!empty($event_categories) && !is_wp_error($event_categories)) {
            foreach ($event_categories as $category) {
              echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
            }
          } else {
            // デフォルトのカテゴリーを表示
            ?>
            <option value="live"><?php esc_html_e('ライブ', 'logic-nagoya'); ?></option>
            <option value="talk"><?php esc_html_e('トークイベント', 'logic-nagoya'); ?></option>
            <option value="streaming"><?php esc_html_e('配信', 'logic-nagoya'); ?></option>
            <option value="workshop"><?php esc_html_e('ワークショップ', 'logic-nagoya'); ?></option>
            <?php
          }
          ?>
        </select>

        <span class="filter-label"><?php esc_html_e('並び替え：', 'logic-nagoya'); ?></span>
        <select class="filter-dropdown" id="sort-filter">
          <option value="date-desc"><?php esc_html_e('開催日（新しい順）', 'logic-nagoya'); ?></option>
          <option value="date-asc"><?php esc_html_e('開催日（古い順）', 'logic-nagoya'); ?></option>
          <option value="name-asc"><?php esc_html_e('イベント名（A-Z）', 'logic-nagoya'); ?></option>
          <option value="name-desc"><?php esc_html_e('イベント名（Z-A）', 'logic-nagoya'); ?></option>
        </select>

        <form class="search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
          <input type="hidden" name="post_type" value="event">
          <input type="text" class="search-input" placeholder="<?php esc_attr_e('イベントを検索...', 'logic-nagoya'); ?>" name="s" value="<?php echo get_search_query(); ?>">
          <button type="submit" class="search-button">
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>

      <!-- Calendar View -->
      <div class="calendar-view" id="calendar-view">
        <div class="calendar-header">
          <div class="calendar-nav">
            <div class="calendar-nav-button" id="prev-month">
              <i class="fas fa-chevron-left"></i>
            </div>
            <h3 class="calendar-title"><?php echo esc_html(date_i18n('Y年n月')); ?></h3>
            <div class="calendar-nav-button" id="next-month">
              <i class="fas fa-chevron-right"></i>
            </div>
          </div>
        </div>

        <table class="calendar-table">
          <thead>
            <tr>
              <th><?php esc_html_e('日', 'logic-nagoya'); ?></th>
              <th><?php esc_html_e('月', 'logic-nagoya'); ?></th>
              <th><?php esc_html_e('火', 'logic-nagoya'); ?></th>
              <th><?php esc_html_e('水', 'logic-nagoya'); ?></th>
              <th><?php esc_html_e('木', 'logic-nagoya'); ?></th>
              <th><?php esc_html_e('金', 'logic-nagoya'); ?></th>
              <th><?php esc_html_e('土', 'logic-nagoya'); ?></th>
            </tr>
          </thead>
          <tbody id="calendar-body">
            <!-- JS will populate this -->
            <?php 
            // カレンダープレースホルダーとして1行だけ表示
            ?>
            <tr>
              <td colspan="7" style="height:100px;text-align:center;padding-top:40px;"><?php esc_html_e('カレンダーを読み込み中...', 'logic-nagoya'); ?></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Events List -->
      <div class="events-list active" id="list-view">
        <?php if (have_posts()) : ?>
          <div class="event-grid">
            <?php
            while (have_posts()) :
              the_post();
              
              // Get event meta data
              $event_date = get_post_meta(get_the_ID(), 'event_date', true);
              $event_time = get_post_meta(get_the_ID(), 'event_time', true);
              $event_ticket_price = get_post_meta(get_the_ID(), 'event_ticket_price', true);
              
              // Format date if it exists
              if ($event_date) {
                  $formatted_date = date_i18n('Y.m.d', strtotime($event_date));
              } else {
                  $formatted_date = esc_html__('Coming Soon', 'logic-nagoya');
              }
              
              // Get event category
              $event_categories = get_the_terms(get_the_ID(), 'event_category');
              $category_name = '';
              if (!empty($event_categories) && !is_wp_error($event_categories)) {
                  $category_name = $event_categories[0]->name;
              }
            ?>
              <div class="event-card">
                <div class="event-image">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
                  <?php else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/event-placeholder.jpg'); ?>" alt="<?php the_title_attribute(); ?>">
                  <?php endif; ?>
                </div>
                <div class="event-content">
                  <span class="event-date-badge"><?php echo esc_html($formatted_date); ?></span>
                  <h3 class="event-title"><?php the_title(); ?></h3>
                  <div class="event-details">
                    <?php if ($event_time) : ?>
                    <div class="event-info">
                      <i class="far fa-clock"></i>
                      <span><?php echo esc_html($event_time); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($event_ticket_price) : ?>
                    <div class="event-info">
                      <i class="fas fa-ticket-alt"></i>
                      <span><?php echo esc_html($event_ticket_price); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <p class="event-description">
                      <?php echo get_the_excerpt(); ?>
                    </p>
                  </div>
                  <div class="event-footer">
                    <?php if ($category_name) : ?>
                      <span class="event-category"><?php echo esc_html($category_name); ?></span>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline event-btn"><?php esc_html_e('詳細を見る', 'logic-nagoya'); ?></a>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          </div>
          
          <div class="pagination">
            <?php
            // カスタムページネーション
            $pagination = paginate_links(array(
              'prev_text' => '<i class="fas fa-chevron-left"></i>',
              'next_text' => '<i class="fas fa-chevron-right"></i>',
              'type' => 'array',
              'mid_size' => 1,
            ));
            
            if (!empty($pagination)) :
              foreach ($pagination as $page) :
                // Wrap each pagination item in our custom div
                echo '<div class="pagination-item' . (strpos($page, 'current') ? ' active' : '') . '">' . $page . '</div>';
              endforeach;
            endif;
            ?>
          </div>
          
        <?php else : ?>
          <div class="no-events">
            <p><?php esc_html_e('現在予定されているイベントはありません。また後日確認してください。', 'logic-nagoya'); ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Event Modal (for JavaScript use) -->
  <div class="event-modal" id="event-modal">
    <div class="modal-content">
      <span class="modal-close"><i class="fas fa-times"></i></span>
      
      <div class="modal-image">
        <img src="" alt="" id="modal-img">
      </div>
      
      <div class="modal-body">
        <h2 class="event-modal-title" id="modal-title"></h2>
        
        <div class="event-modal-meta">
          <div class="event-meta-item">
            <div class="event-meta-icon">
              <i class="far fa-calendar-alt"></i>
            </div>
            <div class="event-meta-info">
              <h4><?php esc_html_e('開催日', 'logic-nagoya'); ?></h4>
              <p id="modal-date"></p>
            </div>
          </div>
          
          <div class="event-meta-item">
            <div class="event-meta-icon">
              <i class="far fa-clock"></i>
            </div>
            <div class="event-meta-info">
              <h4><?php esc_html_e('時間', 'logic-nagoya'); ?></h4>
              <p id="modal-time"></p>
            </div>
          </div>
          
          <div class="event-meta-item">
            <div class="event-meta-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="event-meta-info">
              <h4><?php esc_html_e('会場', 'logic-nagoya'); ?></h4>
              <p>Logic Nagoya</p>
            </div>
          </div>
          
          <div class="event-meta-item">
            <div class="event-meta-icon">
              <i class="fas fa-tag"></i>
            </div>
            <div class="event-meta-info">
              <h4><?php esc_html_e('カテゴリー', 'logic-nagoya'); ?></h4>
              <p id="modal-category"></p>
            </div>
          </div>
        </div>
        
        <div class="event-details-section">
          <h3 class="event-details-title"><?php esc_html_e('イベント詳細', 'logic-nagoya'); ?></h3>
          <div class="event-details-content" id="modal-description"></div>
        </div>
        
        <div class="event-details-section">
          <h3 class="event-details-title"><?php esc_html_e('出演者', 'logic-nagoya'); ?></h3>
          <div class="event-details-content" id="modal-performers"></div>
        </div>
        
        <div class="event-details-section">
          <h3 class="event-details-title"><?php esc_html_e('チケット情報', 'logic-nagoya'); ?></h3>
          <div class="ticket-options" id="modal-tickets"></div>
        </div>
        
        <div class="modal-footer">
          <div class="share-links">
            <span style="margin-right: 10px;"><?php esc_html_e('このイベントをシェア：', 'logic-nagoya'); ?></span>
            <a href="#" class="share-link" id="share-twitter">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="share-link" id="share-facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="share-link" id="share-line">
              <i class="fab fa-line"></i>
            </a>
          </div>
          
          <a href="#" class="btn btn-accent" id="modal-ticket-link"><?php esc_html_e('チケットを予約する', 'logic-nagoya'); ?></a>
        </div>
      </div>
    </div>
  </div>

<?php
get_footer();

// イベントカレンダー生成のためのスクリプトをフッターに追加
function logic_nagoya_event_calendar_scripts() {
  if (is_post_type_archive('event')) {
    ?>
    <script>
    jQuery(document).ready(function($) {
      // View Toggle
      $('.events-nav-item').on('click', function() {
        // Remove active class from all nav items
        $('.events-nav-item').removeClass('active');
        
        // Add active class to clicked nav item
        $(this).addClass('active');
        
        // Handle view switching
        const view = $(this).data('view');
        
        if (view === 'list' || view === 'upcoming' || view === 'past') {
          $('#calendar-view').removeClass('active');
          $('#list-view').addClass('active');
          
          // ここでAjaxを使用して、viewに基づいて異なるイベントを読み込むことができます
          // 例：upcoming または past のイベントを読み込む
          
        } else if (view === 'calendar') {
          $('#list-view').removeClass('active');
          $('#calendar-view').addClass('active');
          generateCalendar(new Date());
        }
      });
      
      // Filter Change
      $('#category-filter, #sort-filter').on('change', function() {
        // ここでAjaxを使用して、フィルターに基づいてイベントをフィルタリングできます
      });
      
      // Calendar Navigation
      let currentDate = new Date();
      
      $('#prev-month').on('click', function() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        generateCalendar(currentDate);
      });
      
      $('#next-month').on('click', function() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        generateCalendar(currentDate);
      });
      
      // Generate Calendar Function
      function generateCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        
        // Update calendar title
        const monthNames = [
          '1月', '2月', '3月', '4月', '5月', '6月',
          '7月', '8月', '9月', '10月', '11月', '12月'
        ];
        $('.calendar-title').text(year + '年' + monthNames[month]);
        
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        
        const startingDay = firstDay.getDay(); // 0 = Sunday
        const totalDays = lastDay.getDate();
        
        // Get previous month's last days
        const prevMonthLastDay = new Date(year, month, 0).getDate();
        
        let html = '';
        
        // Calendar rows
        let day = 1;
        let nextMonthDay = 1;
        
        // Create calendar grid
        for (let i = 0; i < 6; i++) {
          html += '<tr>';
          
          for (let j = 0; j < 7; j++) {
            if (i === 0 && j < startingDay) {
              // Previous month's days
              const prevMonthDay = prevMonthLastDay - startingDay + j + 1;
              html += `
                <td>
                  <div class="calendar-day other-month">${prevMonthDay}</div>
                </td>
              `;
            } else if (day > totalDays) {
              // Next month's days
              html += `
                <td>
                  <div class="calendar-day other-month">${nextMonthDay}</div>
                </td>
              `;
              nextMonthDay++;
            } else {
              // Current month's days
              html += `
                <td>
                  <div class="calendar-day">${day}</div>
                  <div class="calendar-events" data-date="${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}">
                  </div>
                </td>
              `;
              day++;
            }
          }
          
          html += '</tr>';
          
          if (day > totalDays && i < 5) {
            break; // Stop creating rows if we've displayed all days
          }
        }
        
        $('#calendar-body').html(html);
        
        // Load events for the current month (AJAX call would go here)
        loadMonthEvents(year, month + 1);
      }
      
      // Load events for a specific month
      function loadMonthEvents(year, month) {
        // This would typically be an AJAX call to get events for this month
        // For demo purposes, we'll just add some example events
        // In a real implementation, you would fetch this data from your server
        
        const exampleEvents = [
          {
            id: 1,
            title: 'アコースティックナイト',
            date: '2025-03-01',
            url: '<?php echo esc_url(home_url('/event/acoustic-night/')); ?>'
          },
          {
            id: 2,
            title: 'ロックライブ',
            date: '2025-03-08',
            url: '<?php echo esc_url(home_url('/event/rock-live/')); ?>'
          },
          {
            id: 3,
            title: 'ジャズセッション',
            date: '2025-03-14',
            url: '<?php echo esc_url(home_url('/event/jazz-session/')); ?>'
          }
          // 他のイベントも同様に追加
        ];
        
        // 各イベントをカレンダーに表示
        exampleEvents.forEach(event => {
          const eventDate = event.date;
          const cell = $(`.calendar-events[data-date="${eventDate}"]`);
          
          if (cell.length) {
            cell.append(`
              <div class="calendar-event" data-event-id="${event.id}">
                <a href="${event.url}">${event.title}</a>
              </div>
            `);
          }
        });
        
        // カレンダーイベントのクリックハンドラ
        $('.calendar-event a').on('click', function(e) {
          e.preventDefault();
          window.location.href = $(this).attr('href');
        });
      }
      
      // Animation on Scroll
      function animateOnScroll() {
        const eventCards = document.querySelectorAll('.event-card:not(.animate)');
        
        const triggerBottom = window.innerHeight * 0.8;
        
        eventCards.forEach((card, index) => {
          const cardTop = card.getBoundingClientRect().top;
          
          if (cardTop < triggerBottom) {
            setTimeout(() => {
              card.classList.add('animate');
            }, index * 150);
          }
        });
      }
      
      // Scroll event for animations
      $(window).on('scroll', animateOnScroll);
      
      // Initial animation
      animateOnScroll();
    });
    </script>
    <?php
  }
}
add_action('wp_footer', 'logic_nagoya_event_calendar_scripts');
