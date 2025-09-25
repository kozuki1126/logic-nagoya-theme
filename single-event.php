<?php
/**
 * The template for displaying single event
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Logic_Nagoya
 */

get_header();

// イベントメタデータの取得
$event_date = get_post_meta(get_the_ID(), 'event_date', true);
$event_time = get_post_meta(get_the_ID(), 'event_time', true);
$event_location = get_post_meta(get_the_ID(), 'event_location', true) ?: 'Logic Nagoya';
$event_ticket_price = get_post_meta(get_the_ID(), 'event_ticket_price', true);
$event_ticket_url = get_post_meta(get_the_ID(), 'event_ticket_url', true);

// 日付のフォーマット
if ($event_date) {
    $formatted_date = date_i18n('Y年n月j日（D）', strtotime($event_date));
    $date_badge = date_i18n('Y.m.d', strtotime($event_date));
} else {
    $formatted_date = esc_html__('Coming Soon', 'logic-nagoya');
    $date_badge = esc_html__('Coming Soon', 'logic-nagoya');
}

// イベントカテゴリーの取得
$event_categories = get_the_terms(get_the_ID(), 'event_category');
$category_name = '';
if (!empty($event_categories) && !is_wp_error($event_categories)) {
    $category_name = $event_categories[0]->name;
}

while (have_posts()) :
    the_post();
?>

  <!-- Page Header with Event Image -->
  <section class="page-header" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full') ?: esc_url(get_template_directory_uri() . '/assets/images/event-placeholder.jpg'); ?>');">
    <div class="page-header-content">
      <h1 class="page-title"><?php the_title(); ?></h1>
      <p class="page-subtitle">
        <?php 
        if ($event_date) {
            echo esc_html($formatted_date); 
            if ($event_time) {
                echo ' | ' . esc_html($event_time);
            }
        }
        ?>
      </p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="main-content">
    <div class="container content-container">
      <div class="event-single">
        <div class="event-modal-meta">
          <div class="event-meta-item">
            <div class="event-meta-icon">
              <i class="far fa-calendar-alt"></i>
            </div>
            <div class="event-meta-info">
              <h4><?php esc_html_e('開催日', 'logic-nagoya'); ?></h4>
              <p><?php echo esc_html($formatted_date); ?></p>
            </div>
          </div>
          
          <?php if ($event_time) : ?>
          <div class="event-meta-item">
            <div class="event-meta-icon">
              <i class="far fa-clock"></i>
            </div>
            <div class="event-meta-info">
              <h4><?php esc_html_e('時間', 'logic-nagoya'); ?></h4>
              <p><?php echo esc_html($event_time); ?></p>
            </div>
          </div>
          <?php endif; ?>
          
          <div class="event-meta-item">
            <div class="event-meta-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="event-meta-info">
              <h4><?php esc_html_e('会場', 'logic-nagoya'); ?></h4>
              <p><?php echo esc_html($event_location); ?></p>
            </div>
          </div>
          
          <?php if ($category_name) : ?>
          <div class="event-meta-item">
            <div class="event-meta-icon">
              <i class="fas fa-tag"></i>
            </div>
            <div class="event-meta-info">
              <h4><?php esc_html_e('カテゴリー', 'logic-nagoya'); ?></h4>
              <p><?php echo esc_html($category_name); ?></p>
            </div>
          </div>
          <?php endif; ?>
        </div>
        
        <div class="event-details-section">
          <h3 class="event-details-title"><?php esc_html_e('イベント詳細', 'logic-nagoya'); ?></h3>
          <div class="event-details-content">
            <?php the_content(); ?>
          </div>
        </div>
        
        <?php
        // 出演者情報があれば表示
        $performers = get_post_meta(get_the_ID(), 'event_performers', true);
        if ($performers) :
        ?>
        <div class="event-details-section">
          <h3 class="event-details-title"><?php esc_html_e('出演者', 'logic-nagoya'); ?></h3>
          <div class="event-details-content">
            <?php echo wp_kses_post($performers); ?>
          </div>
        </div>
        <?php endif; ?>
        
        <?php if ($event_ticket_price || $event_ticket_url) : ?>
        <div class="event-details-section">
          <h3 class="event-details-title"><?php esc_html_e('チケット情報', 'logic-nagoya'); ?></h3>
          <div class="ticket-options">
            <div class="ticket-option">
              <?php if (strpos($event_ticket_price, '/') !== false) : 
                // 前売り/当日などの複数価格がある場合
                $prices = explode('/', $event_ticket_price);
                foreach ($prices as $index => $price) :
                  $price = trim($price);
                  $is_first = ($index === 0);
                  $name = $is_first ? esc_html__('前売りチケット', 'logic-nagoya') : esc_html__('当日券', 'logic-nagoya');
              ?>
                <div class="ticket-option">
                  <h4 class="ticket-name"><?php echo $name; ?></h4>
                  <p class="ticket-price"><?php echo esc_html($price); ?></p>
                  <?php if ($is_first && $event_ticket_url) : ?>
                    <a href="<?php echo esc_url($event_ticket_url); ?>" class="btn btn-sm btn-outline" target="_blank"><?php esc_html_e('予約する', 'logic-nagoya'); ?></a>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            <?php else : ?>
              <h4 class="ticket-name"><?php esc_html_e('チケット', 'logic-nagoya'); ?></h4>
              <p class="ticket-price"><?php echo esc_html($event_ticket_price); ?></p>
              <?php if ($event_ticket_url) : ?>
                <a href="<?php echo esc_url($event_ticket_url); ?>" class="btn btn-sm btn-outline" target="_blank"><?php esc_html_e('予約する', 'logic-nagoya'); ?></a>
              <?php endif; ?>
            <?php endif; ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
        
        <div class="modal-footer">
          <div class="share-links">
            <span style="margin-right: 10px;"><?php esc_html_e('このイベントをシェア：', 'logic-nagoya'); ?></span>
            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" class="share-link" target="_blank">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" class="share-link" target="_blank">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://line.me/R/msg/text/?<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" class="share-link" target="_blank">
              <i class="fab fa-line"></i>
            </a>
          </div>
          
          <?php if ($event_ticket_url) : ?>
          <a href="<?php echo esc_url($event_ticket_url); ?>" class="btn btn-accent" target="_blank"><?php esc_html_e('チケットを予約する', 'logic-nagoya'); ?></a>
          <?php endif; ?>
        </div>
        
        <div class="event-navigation">
          <?php
          $prev_post = get_previous_post(true, '', 'event_category');
          $next_post = get_next_post(true, '', 'event_category');
          
          if ($prev_post) : ?>
            <div class="event-prev">
              <a href="<?php echo get_permalink($prev_post->ID); ?>" class="event-nav-link">
                <i class="fas fa-chevron-left"></i>
                <div class="event-nav-content">
                  <span class="event-nav-label"><?php esc_html_e('前のイベント', 'logic-nagoya'); ?></span>
                  <h4 class="event-nav-title"><?php echo get_the_title($prev_post->ID); ?></h4>
                </div>
              </a>
            </div>
          <?php endif; ?>
          
          <?php if ($next_post) : ?>
            <div class="event-next">
              <a href="<?php echo get_permalink($next_post->ID); ?>" class="event-nav-link">
                <div class="event-nav-content">
                  <span class="event-nav-label"><?php esc_html_e('次のイベント', 'logic-nagoya'); ?></span>
                  <h4 class="event-nav-title"><?php echo get_the_title($next_post->ID); ?></h4>
                </div>
                <i class="fas fa-chevron-right"></i>
              </a>
            </div>
          <?php endif; ?>
        </div>
        
        <div class="event-back">
          <a href="<?php echo esc_url(get_post_type_archive_link('event')); ?>" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> <?php esc_html_e('イベント一覧に戻る', 'logic-nagoya'); ?>
          </a>
        </div>
      </div>
    </div>
  </section>

<?php
endwhile; // End of the loop.

get_footer();
