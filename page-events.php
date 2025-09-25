<?php
/**
 * Template Name: イベント一覧
 * 
 * The template for displaying the Events page
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
      <h1 class="page-title"><?php the_title(); ?></h1>
      <p class="page-subtitle"><?php echo esc_html(get_post_meta(get_the_ID(), 'page_subtitle', true) ?: 'Logic Nagoyaで開催される様々なイベント情報。ライブ、トークショー、配信イベントなど、多彩なラインナップをご紹介します。'); ?></p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="main-content">
    <div class="container content-container">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php if (get_the_content()) : ?>
          <div class="intro-text">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>
      <?php endwhile; endif; ?>

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
          $categories = get_terms(array(
            'taxonomy' => 'event_category',
            'hide_empty' => true,
          ));
          
          if (!empty($categories) && !is_wp_error($categories)) {
            foreach ($categories as $category) {
              echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
            }
          } else {
            // Default categories if taxonomy is not set up yet
            $default_categories = array(
              'live' => 'ライブ',
              'talk' => 'トークイベント',
              'streaming' => '配信',
              'workshop' => 'ワークショップ'
            );
            
            foreach ($default_categories as $slug => $name) {
              echo '<option value="' . esc_attr($slug) . '">' . esc_html($name) . '</option>';
            }
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

        <form class="search-form" id="event-search-form">
          <input type="text" class="search-input" placeholder="<?php esc_attr_e('イベントを検索...', 'logic-nagoya'); ?>">
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
            <?php
            // Get current month and year
            $current_month = date_i18n('Y年n月');
            ?>
            <h3 class="calendar-title" id="calendar-title"><?php echo esc_html($current_month); ?></h3>
            <div class="calendar-nav-button" id="next-month">
              <i class="fas fa-chevron-right"></i>
            </div>
          </div>
        </div>

        <div id="calendar-container">
          <?php
          // Calendar will be populated via JavaScript
          // Initial calendar markup
          ?>
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
              <!-- Calendar rows will be populated by JavaScript -->
            </tbody>
          </table>
        </div>
      </div>

      <!-- Events List -->
      <div class="events-list active" id="list-view">
        <div class="event-grid">
          <?php
          // Query upcoming events
          $today = date('Y-m-d');
          $args = array(
            'post_type' => 'event',
            'posts_per_page' => 6,
            'meta_key' => 'event_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'event_date',
                'value' => $today,
                'compare' => '>=',
                'type' => 'DATE'
              )
            )
          );
          
          $events_query = new WP_Query($args);
          
          if ($events_query->have_posts()) :
            while ($events_query->have_posts()) : $events_query->the_post();
            
              // Get event meta data
              $event_date = get_post_meta(get_the_ID(), 'event_date', true);
              $event_time = get_post_meta(get_the_ID(), 'event_time', true);
              $event_price = get_post_meta(get_the_ID(), 'event_ticket_price', true);
              
              // Format date
              $formatted_date = $event_date ? date_i18n('Y.m.d', strtotime($event_date)) : '';
              
              // Get event categories
              $categories = get_the_terms(get_the_ID(), 'event_category');
              $category_name = !empty($categories) && !is_wp_error($categories) ? esc_html($categories[0]->name) : 'ライブ';
          ?>
          
          <div class="event-card">
            <div class="event-image">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', array('alt' => get_the_title())); ?>
              <?php else : ?>
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/event-placeholder.jpg" alt="<?php the_title_attribute(); ?>">
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
                
                <?php if ($event_price) : ?>
                <div class="event-info">
                  <i class="fas fa-ticket-alt"></i>
                  <span><?php echo esc_html($event_price); ?></span>
                </div>
                <?php endif; ?>
                
                <p class="event-description">
                  <?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?>
                </p>
              </div>
              <div class="event-footer">
                <span class="event-category"><?php echo esc_html($category_name); ?></span>
                <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline event-btn" data-event-id="<?php the_ID(); ?>"><?php esc_html_e('詳細を見る', 'logic-nagoya'); ?></a>
              </div>
            </div>
          </div>
          
          <?php
            endwhile;
            wp_reset_postdata();
          else :
            // Display placeholder events if no events are found
            $placeholder_events = array(
              array(
                'title' => 'アコースティックナイト Vol.5',
                'date' => '2025.03.01',
                'time' => '開場 17:30 / 開演 18:00',
                'price' => '前売 ¥3,500 / 当日 ¥4,000',
                'description' => '名古屋を中心に活動するシンガーソングライターによるアコースティックライブ。心地よい音楽と共に特別な夜をお過ごしください。',
                'category' => 'ライブ',
                'image' => 'https://logicnagoya.com/wp-content/uploads/2023/08/IMG_7590-800x533.jpg'
              ),
              array(
                'title' => 'ROCK EXPLOSION 2025',
                'date' => '2025.03.08',
                'time' => '開場 16:30 / 開演 17:00',
                'price' => '前売 ¥4,000 / 当日 ¥4,500',
                'description' => '名古屋の若手ロックバンド5組によるライブイベント。熱いパフォーマンスをお見逃しなく！',
                'category' => 'ライブ',
                'image' => 'https://logicnagoya.com/wp-content/uploads/2023/04/フライヤー.psd-800x533.png'
              ),
              array(
                'title' => 'Friday Jazz Session',
                'date' => '2025.03.14',
                'time' => '開場 18:30 / 開演 19:00',
                'price' => '前売 ¥3,000 / 当日 ¥3,500',
                'description' => 'プロジャズミュージシャンによる即興セッションナイト。上質な音楽と共に金曜の夜をお楽しみください。',
                'category' => 'ライブ',
                'image' => 'https://logicnagoya.com/wp-content/uploads/2020/12/IMG_3744-scaled.jpg'
              ),
              array(
                'title' => 'クリエイターズトークショー',
                'date' => '2025.03.20',
                'time' => '開場 13:30 / 開演 14:00',
                'price' => '前売 ¥2,500 / 当日 ¥3,000',
                'description' => '人気クリエイターをゲストに迎えたトークイベント。創作の裏側や今後の展望について語ります。',
                'category' => 'トークイベント',
                'image' => 'https://logicnagoya.com/wp-content/uploads/2022/06/S__8249376-800x533.jpg'
              ),
              array(
                'title' => 'WEEKEND DJ NIGHT',
                'date' => '2025.03.22',
                'time' => '開場 21:00 / 開演 21:30',
                'price' => '前売 ¥2,800 / 当日 ¥3,300',
                'description' => '名古屋で活躍するDJ3名によるスペシャルイベント。様々なジャンルの音楽で一晩中踊り明かそう！',
                'category' => 'DJ',
                'image' => 'https://logicnagoya.com/wp-content/uploads/2021/05/v2-1-800x533.jpg'
              ),
              array(
                'title' => 'POP SENSATION',
                'date' => '2025.03.28',
                'time' => '開場 18:00 / 開演 18:30',
                'price' => '前売 ¥3,800 / 当日 ¥4,300',
                'description' => '話題の若手ポップアーティスト4組によるライブイベント。キャッチーなメロディと素晴らしいステージングをお楽しみに。',
                'category' => 'ライブ',
                'image' => 'https://logicnagoya.com/wp-content/uploads/2022/10/HP-TOP-IMAGE-1.jpg'
              )
            );
            
            foreach ($placeholder_events as $index => $event) :
          ?>
          
          <div class="event-card">
            <div class="event-image">
              <img src="<?php echo esc_url($event['image']); ?>" alt="<?php echo esc_attr($event['title']); ?>">
            </div>
            <div class="event-content">
              <span class="event-date-badge"><?php echo esc_html($event['date']); ?></span>
              <h3 class="event-title"><?php echo esc_html($event['title']); ?></h3>
              <div class="event-details">
                <div class="event-info">
                  <i class="far fa-clock"></i>
                  <span><?php echo esc_html($event['time']); ?></span>
                </div>
                <div class="event-info">
                  <i class="fas fa-ticket-alt"></i>
                  <span><?php echo esc_html($event['price']); ?></span>
                </div>
                <p class="event-description">
                  <?php echo esc_html($event['description']); ?>
                </p>
              </div>
              <div class="event-footer">
                <span class="event-category"><?php echo esc_html($event['category']); ?></span>
                <a href="#" class="btn btn-sm btn-outline event-btn" data-event-id="<?php echo $index + 1; ?>"><?php esc_html_e('詳細を見る', 'logic-nagoya'); ?></a>
              </div>
            </div>
          </div>
          
          <?php
            endforeach;
          endif;
          ?>
        </div>

        <?php
        // Pagination section
        if ($events_query->max_num_pages > 1) :
        ?>
        <div class="pagination">
          <?php
          $big = 999999999; // need an unlikely integer
          echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $events_query->max_num_pages,
            'prev_text' => '<i class="fas fa-chevron-left"></i>',
            'next_text' => '<i class="fas fa-chevron-right"></i>',
            'type' => 'list',
            'before_page_number' => '',
            'after_page_number' => '',
          ));
          ?>
        </div>
        <?php
        elseif (!$events_query->have_posts()) :
        // Show placeholder pagination
        ?>
        <div class="pagination">
          <div class="pagination-item active">1</div>
          <div class="pagination-item">2</div>
          <div class="pagination-item">3</div>
          <div class="pagination-item">
            <i class="fas fa-ellipsis-h"></i>
          </div>
          <div class="pagination-item">
            <i class="fas fa-chevron-right"></i>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Event Modal -->
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
          <div class="event-details-content" id="modal-description">
          </div>
        </div>
        
        <div class="event-details-section" id="modal-performers-section">
          <h3 class="event-details-title"><?php esc_html_e('出演者', 'logic-nagoya'); ?></h3>
          <div class="event-details-content" id="modal-performers">
          </div>
        </div>
        
        <div class="event-details-section">
          <h3 class="event-details-title"><?php esc_html_e('チケット情報', 'logic-nagoya'); ?></h3>
          <div class="ticket-options" id="modal-tickets">
          </div>
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
