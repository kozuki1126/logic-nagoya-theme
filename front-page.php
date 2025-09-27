<?php
/**
 * The template for displaying the front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Logic_Nagoya
 */

get_header();
?>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-slider">
      <?php
      // Get hero slider images from theme customizer
      $slide1 = get_theme_mod('logic_nagoya_hero_slide1', get_template_directory_uri() . '/assets/images/slide1.jpg');
      $slide2 = get_theme_mod('logic_nagoya_hero_slide2', get_template_directory_uri() . '/assets/images/slide2.jpg');
      $slide3 = get_theme_mod('logic_nagoya_hero_slide3', get_template_directory_uri() . '/assets/images/slide3.jpg');
      
      // Display slider images
      echo '<div class="hero-slide active" style="background-image: url(\'' . esc_url($slide1) . '\');"></div>';
      echo '<div class="hero-slide" style="background-image: url(\'' . esc_url($slide2) . '\');"></div>';
      echo '<div class="hero-slide" style="background-image: url(\'' . esc_url($slide3) . '\');"></div>';
      ?>
    </div>
    <div class="hero-content">
      <img src="<?php echo esc_url(get_theme_mod('logic_nagoya_hero_logo', get_template_directory_uri() . '/assets/images/logo.png')); ?>" alt="<?php bloginfo('name'); ?>" class="hero-logo" width="180">
      <h1 class="hero-title"><?php echo esc_html(get_theme_mod('logic_nagoya_hero_title', 'MUSIC LIVE HOUSE')); ?></h1>
      <p class="hero-subtitle"><?php echo wp_kses_post(get_theme_mod('logic_nagoya_hero_subtitle', '集まりやすい栄三丁目プリンセスガーデンホテル内でライブイベントができる<br>小規模からライブ開催可能、仲間内のイベントでも使いやすいシステム')); ?></p>
      <a href="<?php echo site_url('/about/'); ?>" class="btn hero-btn"><?php echo esc_html(get_theme_mod('logic_nagoya_hero_button_text', 'DISCOVER MORE')); ?></a>
    </div>
    <div class="scroll-down">
      <i class="fas fa-chevron-down"></i>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="about">
    <div class="container">
      <h2 class="section-title"><?php echo esc_html(get_theme_mod('logic_nagoya_about_title', 'ABOUT LOGIC')); ?></h2>
      <p class="text-center about-description">
        <?php echo wp_kses_post(get_theme_mod('logic_nagoya_about_text', '名古屋栄でのイベント開催に最適なライブハウス「Logic Nagoya」。<br>着席60名、オールスタンドで100名超の収容人数を誇る綺麗な会場で、音響、照明を贅沢に使用できる特別な空間をご提供します。')); ?>
      </p>
      
      <div class="features">
        <?php
        // Feature 1
        $feature1_img = get_theme_mod('logic_nagoya_feature1_image', get_template_directory_uri() . '/assets/images/feature1.jpg');
        $feature1_title = get_theme_mod('logic_nagoya_feature1_title', 'システムと料金');
        $feature1_desc = get_theme_mod('logic_nagoya_feature1_desc', 'LogicNagoyaのシステムや料金のご説明。小規模から本格的なライブまで、柔軟な料金体系でご利用いただけます。');
        $feature1_link = site_url('/system-pricing/');
        $feature1_btn = get_theme_mod('logic_nagoya_feature1_button', '詳しく見る');
        ?>
        <div class="feature-card">
          <div class="feature-img-container">
            <img src="<?php echo esc_url($feature1_img); ?>" alt="<?php echo esc_attr($feature1_title); ?>" class="feature-img">
          </div>
          <div class="feature-content">
            <h3 class="feature-title"><?php echo esc_html($feature1_title); ?></h3>
            <p class="feature-desc"><?php echo esc_html($feature1_desc); ?></p>
            <a href="<?php echo esc_url($feature1_link); ?>" class="btn btn-outline"><?php echo esc_html($feature1_btn); ?></a>
          </div>
        </div>
        
        <?php
        // Feature 2
        $feature2_img = get_theme_mod('logic_nagoya_feature2_image', get_template_directory_uri() . '/assets/images/feature2.jpg');
        $feature2_title = get_theme_mod('logic_nagoya_feature2_title', '設備');
        $feature2_desc = get_theme_mod('logic_nagoya_feature2_desc', '音響、照明を贅沢に使用できるショーも可能な充実の設備。プロの機材で最高のパフォーマンスを実現します。');
        $feature2_link = site_url('/equipment-list/');
        $feature2_btn = get_theme_mod('logic_nagoya_feature2_button', '設備リスト');
        ?>
        <div class="feature-card">
          <div class="feature-img-container">
            <img src="<?php echo esc_url($feature2_img); ?>" alt="<?php echo esc_attr($feature2_title); ?>" class="feature-img">
          </div>
          <div class="feature-content">
            <h3 class="feature-title"><?php echo esc_html($feature2_title); ?></h3>
            <p class="feature-desc"><?php echo esc_html($feature2_desc); ?></p>
            <a href="<?php echo esc_url($feature2_link); ?>" class="btn btn-outline"><?php echo esc_html($feature2_btn); ?></a>
          </div>
        </div>
        
        <?php
        // Feature 3
        $feature3_img = get_theme_mod('logic_nagoya_feature3_image', get_template_directory_uri() . '/assets/images/feature3.jpg');
        $feature3_title = get_theme_mod('logic_nagoya_feature3_title', 'アクセス');
        $feature3_desc = get_theme_mod('logic_nagoya_feature3_desc', '栄三丁目プリンセスガーデンホテル2階という好立地。公共交通機関でのアクセスも便利で集まりやすい場所です。');
        $feature3_link = site_url('/floor-map/');
        $feature3_btn = get_theme_mod('logic_nagoya_feature3_button', '地図を見る');
        ?>
        <div class="feature-card">
          <div class="feature-img-container">
            <img src="<?php echo esc_url($feature3_img); ?>" alt="<?php echo esc_attr($feature3_title); ?>" class="feature-img">
          </div>
          <div class="feature-content">
            <h3 class="feature-title"><?php echo esc_html($feature3_title); ?></h3>
            <p class="feature-desc"><?php echo esc_html($feature3_desc); ?></p>
            <a href="<?php echo esc_url($feature3_link); ?>" class="btn btn-outline"><?php echo esc_html($feature3_btn); ?></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Events Section -->
  <section id="events" class="events">
    <div class="container">
      <h2 class="section-title"><?php echo esc_html(get_theme_mod('logic_nagoya_events_title', 'UPCOMING EVENTS')); ?></h2>
      
      <div class="event-grid">
        <?php
        // Get upcoming events
        $events_args = array(
            'post_type' => 'event',
            'posts_per_page' => 3,
            'meta_key' => 'event_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'value' => wp_date('Y-m-d'),
                    'compare' => '>=',
                    'type' => 'DATE'
                )
            )
        );
        
        $events_query = new WP_Query($events_args);
        
        if ($events_query->have_posts()) :
            while ($events_query->have_posts()) : $events_query->the_post();
                
                // Get event date
                $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                if ($event_date) {
                    $formatted_date = wp_date(get_option('date_format'), strtotime($event_date));
                } else {
                    $formatted_date = 'Coming Soon';
                }
        ?>
        
        <div class="event-card">
          <div class="event-img-container">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('large', array('class' => 'event-img')); ?>
            <?php else : ?>
              <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/event-placeholder.jpg'); ?>" alt="<?php the_title_attribute(); ?>" class="event-img">
            <?php endif; ?>
            <span class="event-date"><?php echo esc_html($formatted_date); ?></span>
          </div>
          <div class="event-content">
            <h3 class="event-title"><?php the_title(); ?></h3>
            <p class="event-desc"><?php echo get_the_excerpt(); ?></p>
            <a href="<?php the_permalink(); ?>" class="btn btn-outline"><?php esc_html_e('詳細を見る', 'logic-nagoya'); ?></a>
          </div>
        </div>
        
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            // Display placeholder events if no events are found
            for ($i = 1; $i <= 3; $i++) :
        ?>
        
        <div class="event-card">
          <div class="event-img-container">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/event-placeholder.jpg'); ?>" alt="<?php printf(esc_attr__('Event %d', 'logic-nagoya'), $i); ?>" class="event-img">
            <span class="event-date">Coming Soon</span>
          </div>
          <div class="event-content">
            <h3 class="event-title"><?php 
                switch ($i) {
                    case 1:
                        esc_html_e('LIVE EVENT', 'logic-nagoya');
                        break;
                    case 2:
                        esc_html_e('ACOUSTIC NIGHT', 'logic-nagoya');
                        break;
                    case 3:
                        esc_html_e('TALK LIVE', 'logic-nagoya');
                        break;
                }
            ?></h3>
            <p class="event-desc"><?php 
                switch ($i) {
                    case 1:
                        esc_html_e('名古屋の人気バンドによるスペシャルライブ。チケット発売中！', 'logic-nagoya');
                        break;
                    case 2:
                        esc_html_e('心地よいアコースティックサウンドで特別な夜を。', 'logic-nagoya');
                        break;
                    case 3:
                        esc_html_e('ゲストを招いた特別トークイベント。配信も同時に行います。', 'logic-nagoya');
                        break;
                }
            ?></p>
            <a href="#" class="btn btn-outline"><?php esc_html_e('詳細を見る', 'logic-nagoya'); ?></a>
          </div>
        </div>
        
        <?php
            endfor;
        endif;
        ?>
      </div>
      
      <div class="event-more">
        <a href="<?php echo esc_url(site_url('/events/')); ?>" class="btn btn-accent"><?php esc_html_e('ALL EVENTS', 'logic-nagoya'); ?></a>
      </div>
    </div>
  </section>

  <!-- Gallery Section -->
  <section id="gallery" class="gallery">
    <div class="container gallery-container">
      <h2 class="section-title"><?php echo esc_html(get_theme_mod('logic_nagoya_gallery_title', 'GALLERY')); ?></h2>
      
      <div class="gallery-grid">
        <?php
        // Get gallery items
        $gallery_args = array(
            'post_type' => 'gallery',
            'posts_per_page' => 6,
        );
        
        $gallery_query = new WP_Query($gallery_args);
        
        if ($gallery_query->have_posts()) :
            $count = 0;
            while ($gallery_query->have_posts()) : $gallery_query->the_post();
                $count++;
        ?>
        
        <div class="gallery-item">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('large', array('class' => 'gallery-img')); ?>
          <?php else : ?>
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/gallery-placeholder.jpg'); ?>" alt="<?php the_title_attribute(); ?>" class="gallery-img">
          <?php endif; ?>
          <div class="gallery-overlay">
            <span class="gallery-icon"><i class="fas fa-search-plus"></i></span>
            <span class="gallery-text"><?php the_title(); ?></span>
          </div>
        </div>
        
        <?php
            endwhile;
            wp_reset_postdata();
        else :
            // Display placeholder gallery items if no items are found
            $gallery_placeholders = array(
                'ステージ全景',
                '照明装置',
                '客席エリア',
                'ライブパフォーマンス',
                'ステージ設備',
                '客席からの眺め'
            );
            
            foreach ($gallery_placeholders as $index => $title) :
                $img_num = $index % 3 + 1; // Use 3 different placeholder images
        ?>
        
        <div class="gallery-item">
          <img src="<?php echo esc_url(get_template_directory_uri() . "/assets/images/gallery-placeholder-{$img_num}.jpg"); ?>" alt="<?php echo esc_attr($title); ?>" class="gallery-img">
          <div class="gallery-overlay">
            <span class="gallery-icon"><i class="fas fa-search-plus"></i></span>
            <span class="gallery-text"><?php echo esc_html($title); ?></span>
          </div>
        </div>
        
        <?php
            endforeach;
        endif;
        ?>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="faq">
    <div class="container">
      <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq_title', 'よくある質問' ) ); ?></h2>
      <p class="text-center about-description">
        <?php echo esc_html( get_theme_mod( 'logic_nagoya_faq_description', 'Logic Nagoyaに関するよくある質問をまとめました。ご不明な点がございましたら、お気軽にお問い合わせください。' ) ); ?>
      </p>
      
      <div class="faq-container">
        <div class="faq-list">
          <!-- FAQ Item 1 -->
          <div class="faq-item">
            <div class="faq-question">
              <h3><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq1_question', '会場の収容人数は何名ですか？' ) ); ?></h3>
              <span class="faq-icon"><i class="fas fa-plus"></i></span>
            </div>
            <div class="faq-answer">
              <p><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq1_answer', '着席形式で約60名、立ち見を含めると最大100名超の収容が可能です。イベントの内容に応じてレイアウトのアレンジも可能ですので、ご相談ください。' ) ); ?></p>
            </div>
          </div>
          
          <!-- FAQ Item 2 -->
          <div class="faq-item">
            <div class="faq-question">
              <h3><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq2_question', '機材のレンタルは可能ですか？' ) ); ?></h3>
              <span class="faq-icon"><i class="fas fa-plus"></i></span>
            </div>
            <div class="faq-answer">
              <p><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq2_answer', '基本的な音響・照明機材は会場料金に含まれています。追加の特殊機材が必要な場合は別途レンタル料金が発生する場合があります。詳細は設備リストをご確認ください。' ) ); ?></p>
            </div>
          </div>
          
          <!-- FAQ Item 3 -->
          <div class="faq-item">
            <div class="faq-question">
              <h3><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq3_question', '予約はどのくらい前から可能ですか？' ) ); ?></h3>
              <span class="faq-icon"><i class="fas fa-plus"></i></span>
            </div>
            <div class="faq-answer">
              <p><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq3_answer', '6ヶ月前から予約受付を行っています。人気の日程（金・土・祝前日）は早めにご予約いただくことをお勧めします。空き状況はお電話またはメールでお問い合わせください。' ) ); ?></p>
            </div>
          </div>
          
          <!-- FAQ Item 4 -->
          <div class="faq-item">
            <div class="faq-question">
              <h3><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq4_question', '飲食物の持ち込みは可能ですか？' ) ); ?></h3>
              <span class="faq-icon"><i class="fas fa-plus"></i></span>
            </div>
            <div class="faq-answer">
              <p><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq4_answer', '飲食物の持ち込みは原則として禁止しています。ドリンク販売は会場で行っています。ケータリングや特別な飲食を伴うイベントについては、事前にご相談ください。' ) ); ?></p>
            </div>
          </div>
          
          <!-- FAQ Item 5 -->
          <div class="faq-item">
            <div class="faq-question">
              <h3><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq5_question', '配信設備はありますか？' ) ); ?></h3>
              <span class="faq-icon"><i class="fas fa-plus"></i></span>
            </div>
            <div class="faq-answer">
              <p><?php echo esc_html( get_theme_mod( 'logic_nagoya_faq5_answer', 'はい、ライブ配信用の基本設備を完備しています。YouTube Live、Twitchなどの各種配信プラットフォームに対応可能です。配信をご希望の場合は、予約時にお申し付けください。' ) ); ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact">
    <div class="container">
      <h2 class="section-title"><?php echo esc_html(get_theme_mod('logic_nagoya_contact_title', 'CONTACT US')); ?></h2>
      
      <div class="contact-container">
        <div class="contact-info">
          <h3 class="contact-heading"><?php esc_html_e('お問い合わせ', 'logic-nagoya'); ?></h3>
          <p class="contact-text"><?php echo esc_html(get_theme_mod('logic_nagoya_contact_text', 'イベント開催のお問い合わせやご質問など、お気軽にご連絡ください。2営業日以内にご返信いたします。')); ?></p>
          
          <?php if (get_theme_mod('logic_nagoya_google_map_url')) : ?>
          <div class="contact-map">
            <iframe src="<?php echo esc_url(get_theme_mod('logic_nagoya_google_map_url')); ?>" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
          <?php endif; ?>
          
          <div class="contact-details">
            <div class="contact-item">
              <div class="contact-icon">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div class="contact-info-text">
                <h3><?php esc_html_e('所在地', 'logic-nagoya'); ?></h3>
                <p><?php echo nl2br(esc_html(get_theme_mod('logic_nagoya_address_full', '愛知県名古屋市中区栄3-13-31
プリンセスガーデンホテル2階'))); ?></p>
              </div>
            </div>
            
            <div class="contact-item">
              <div class="contact-icon">
                <i class="fas fa-phone-alt"></i>
              </div>
              <div class="contact-info-text">
                <h3><?php esc_html_e('電話番号', 'logic-nagoya'); ?></h3>
                <p><?php echo esc_html(get_theme_mod('logic_nagoya_phone', '052-241-7772')); ?></p>
              </div>
            </div>
            
            <div class="contact-item">
              <div class="contact-icon">
                <i class="fas fa-envelope"></i>
              </div>
              <div class="contact-info-text">
                <h3><?php esc_html_e('メール', 'logic-nagoya'); ?></h3>
                <p><?php echo esc_html(get_theme_mod('logic_nagoya_email', 'kozuki@logicnagoya.com')); ?></p>
              </div>
            </div>
          </div>
          
          <div class="social-links">
            <?php if (get_theme_mod('logic_nagoya_twitter')) : ?>
            <a href="<?php echo esc_url(get_theme_mod('logic_nagoya_twitter')); ?>" class="social-link" target="_blank">
              <i class="fab fa-twitter"></i>
            </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('logic_nagoya_facebook')) : ?>
            <a href="<?php echo esc_url(get_theme_mod('logic_nagoya_facebook')); ?>" class="social-link" target="_blank">
              <i class="fab fa-facebook-f"></i>
            </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('logic_nagoya_instagram')) : ?>
            <a href="<?php echo esc_url(get_theme_mod('logic_nagoya_instagram')); ?>" class="social-link" target="_blank">
              <i class="fab fa-instagram"></i>
            </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('logic_nagoya_youtube')) : ?>
            <a href="<?php echo esc_url(get_theme_mod('logic_nagoya_youtube')); ?>" class="social-link" target="_blank">
              <i class="fab fa-youtube"></i>
            </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('logic_nagoya_tiktok')) : ?>
            <a href="<?php echo esc_url(get_theme_mod('logic_nagoya_tiktok')); ?>" class="social-link" target="_blank">
              <i class="fab fa-tiktok"></i>
            </a>
            <?php endif; ?>
            
            <?php if (get_theme_mod('logic_nagoya_line')) : ?>
            <a href="<?php echo esc_url(get_theme_mod('logic_nagoya_line')); ?>" class="social-link" target="_blank">
              <i class="fab fa-line"></i>
            </a>
            <?php endif; ?>
          </div>
        </div>
        
        <div class="contact-form">
          <?php
          // Check if Contact Form 7 is active
          if (function_exists('wpcf7_contact_form')) {
              // Get contact form ID from theme customizer
              $contact_form_id = get_theme_mod('logic_nagoya_contact_form_id');
              
              if ($contact_form_id) {
                  echo do_shortcode('[contact-form-7 id="' . esc_attr($contact_form_id) . '"]');
              } else {
                  // Fallback to basic contact form HTML
          ?>
          <form>
            <div class="form-group">
              <label for="name" class="form-label"><?php esc_html_e('お名前', 'logic-nagoya'); ?></label>
              <input type="text" id="name" class="form-control" placeholder="<?php esc_attr_e('お名前を入力してください', 'logic-nagoya'); ?>">
            </div>
            
            <div class="form-group">
              <label for="email" class="form-label"><?php esc_html_e('メールアドレス', 'logic-nagoya'); ?></label>
              <input type="email" id="email" class="form-control" placeholder="<?php esc_attr_e('メールアドレスを入力してください', 'logic-nagoya'); ?>">
            </div>
            
            <div class="form-group">
              <label for="subject" class="form-label"><?php esc_html_e('件名', 'logic-nagoya'); ?></label>
              <input type="text" id="subject" class="form-control" placeholder="<?php esc_attr_e('件名を入力してください', 'logic-nagoya'); ?>">
            </div>
            
            <div class="form-group">
              <label for="message" class="form-label"><?php esc_html_e('メッセージ', 'logic-nagoya'); ?></label>
              <textarea id="message" class="form-control" placeholder="<?php esc_attr_e('メッセージを入力してください', 'logic-nagoya'); ?>"></textarea>
            </div>
            
            <button type="submit" class="btn btn-accent"><?php esc_html_e('送信する', 'logic-nagoya'); ?></button>
          </form>
          <?php
              }
          } else {
              // Contact Form 7 is not active, display basic form
          ?>
          <form>
            <div class="form-group">
              <label for="name" class="form-label"><?php esc_html_e('お名前', 'logic-nagoya'); ?></label>
              <input type="text" id="name" class="form-control" placeholder="<?php esc_attr_e('お名前を入力してください', 'logic-nagoya'); ?>">
            </div>
            
            <div class="form-group">
              <label for="email" class="form-label"><?php esc_html_e('メールアドレス', 'logic-nagoya'); ?></label>
              <input type="email" id="email" class="form-control" placeholder="<?php esc_attr_e('メールアドレスを入力してください', 'logic-nagoya'); ?>">
            </div>
            
            <div class="form-group">
              <label for="subject" class="form-label"><?php esc_html_e('件名', 'logic-nagoya'); ?></label>
              <input type="text" id="subject" class="form-control" placeholder="<?php esc_attr_e('件名を入力してください', 'logic-nagoya'); ?>">
            </div>
            
            <div class="form-group">
              <label for="message" class="form-label"><?php esc_html_e('メッセージ', 'logic-nagoya'); ?></label>
              <textarea id="message" class="form-control" placeholder="<?php esc_attr_e('メッセージを入力してください', 'logic-nagoya'); ?>"></textarea>
            </div>
            
            <button type="submit" class="btn btn-accent"><?php esc_html_e('送信する', 'logic-nagoya'); ?></button>
          </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>

<?php
get_footer();
