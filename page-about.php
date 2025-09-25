<?php
/**
 * Template Name: ABOUTページ
 * 
 * The template for displaying the About page
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
      <p class="page-subtitle"><?php echo esc_html(get_post_meta(get_the_ID(), 'page_subtitle', true) ?: '名古屋栄にあるプレミアムなライブハウス「Logic Nagoya」のコンセプトと特徴をご紹介します。音楽、トーク、配信、すべてが特別な体験に変わる場所。'); ?></p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="main-content">
    <div class="container content-container">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php if (get_the_content()) : ?>
          <div class="about-intro">
            <?php the_content(); ?>
          </div>
        <?php else : ?>
          <p class="about-intro">
            Logic Nagoyaは、単なるライブハウスではなく、創造性を解き放ち、特別な瞬間を生み出すための空間です。
            最新の音響・照明・映像設備と快適な環境で、アーティストとオーディエンスの両方に最高の体験をお届けします。
            名古屋栄の中心、プリンセスガーデンホテル内に位置する当会場は、あらゆるイベントを成功へと導きます。
          </p>
        <?php endif; ?>
      <?php endwhile; endif; ?>

      <!-- Concept Section -->
      <div class="concept-section">
        <div class="concept-container">
          <?php
          $concept_image = get_post_meta(get_the_ID(), 'concept_image', true);
          if ($concept_image) {
            $image_url = wp_get_attachment_image_url($concept_image, 'full');
          } else {
            $image_url = get_template_directory_uri() . '/assets/images/bg-dark.jpg';
          }
          ?>
          <div class="concept-image">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('Logic Nagoya Concept', 'logic-nagoya'); ?>">
          </div>
          
          <div class="concept-content">
            <span class="concept-subtitle"><?php echo esc_html(get_post_meta(get_the_ID(), 'concept_subtitle', true) ?: 'OUR PHILOSOPHY'); ?></span>
            <h2 class="concept-title"><?php echo esc_html(get_post_meta(get_the_ID(), 'concept_title', true) ?: '創造性を解き放つ空間'); ?></h2>
            <p class="concept-text">
              <?php echo esc_html(get_post_meta(get_the_ID(), 'concept_text_1', true) ?: 'Logic Nagoyaは2020年のオープン以来、「音楽と人をつなぐ」をコンセプトに、クオリティとアクセシビリティを両立した空間を提供してきました。プロからアマチュアまで、あらゆるパフォーマーが最高のパフォーマンスを発揮できる環境づくりを追求しています。'); ?>
            </p>
            <p class="concept-text">
              <?php echo esc_html(get_post_meta(get_the_ID(), 'concept_text_2', true) ?: '名古屋の音楽・カルチャーシーンの発展に貢献し、新たなカルチャーの発信地となることを目指しています。アーティストの創造性と観客の感動が交差する場所として、プロフェッショナルな設備と温かみのあるサービスを提供します。'); ?>
            </p>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('equipment-list'))); ?>" class="btn btn-outline"><?php esc_html_e('設備を見る', 'logic-nagoya'); ?></a>
          </div>
        </div>
      </div>

      <!-- Features Section -->
      <div class="features-section">
        <h2 class="section-title"><?php esc_html_e('特徴', 'logic-nagoya'); ?></h2>
        
        <div class="features-grid">
          <?php
          // 特徴セクションの項目（フィールド名：features_items）から取得、なければデフォルト表示
          $features_items = get_post_meta(get_the_ID(), 'features_items', true);
          
          if (!empty($features_items) && is_array($features_items)) {
            foreach ($features_items as $feature) {
              ?>
              <div class="feature-card">
                <div class="feature-icon">
                  <i class="fas fa-<?php echo esc_attr($feature['icon']); ?>"></i>
                </div>
                <h3 class="feature-title"><?php echo esc_html($feature['title']); ?></h3>
                <p class="feature-text">
                  <?php echo esc_html($feature['text']); ?>
                </p>
              </div>
              <?php
            }
          } else {
            // デフォルトの特徴項目
            $default_features = array(
              array(
                'icon' => 'map-marker-alt',
                'title' => '絶好のロケーション',
                'text' => '名古屋栄の中心地、プリンセスガーデンホテル内に位置し、公共交通機関からのアクセスも良好。観客が集まりやすく、遠方からのゲストも安心して参加できます。'
              ),
              array(
                'icon' => 'music',
                'title' => '最高品質の音響設備',
                'text' => 'd&b audiotechnikシステムをはじめとする業界最高クラスの音響設備で、ライブならではの臨場感とクリアなサウンドを実現。どんなジャンルの音楽も最適な状態で届けます。'
              ),
              array(
                'icon' => 'lightbulb',
                'title' => '創造的な照明',
                'text' => '最新のLED照明とムービングライトを駆使した照明演出で、パフォーマンスの雰囲気を最大限に引き立てます。イベントの世界観を視覚的に表現し、観客の感動を増幅させます。'
              ),
              array(
                'icon' => 'video',
                'title' => '配信対応環境',
                'text' => '高品質な配信設備とインターネット環境を完備し、オンラインとリアルを融合したイベント開催をサポート。遠隔地からも参加可能なハイブリッドイベントの実現をお手伝いします。'
              ),
              array(
                'icon' => 'couch',
                'title' => '快適な観覧環境',
                'text' => '着席60名、オールスタンディングで100名超の収容が可能。イベントの性質に合わせて柔軟なレイアウト変更ができ、観客全員が良好な視界でパフォーマンスを楽しめるよう設計されています。'
              ),
              array(
                'icon' => 'hands-helping',
                'title' => '包括的なサポート',
                'text' => 'イベント企画から運営、PRまで、経験豊富なスタッフが全面的にサポート。初めてのイベント開催でも安心して任せられる体制を整えています。'
              )
            );
            
            foreach ($default_features as $feature) {
              ?>
              <div class="feature-card">
                <div class="feature-icon">
                  <i class="fas fa-<?php echo esc_attr($feature['icon']); ?>"></i>
                </div>
                <h3 class="feature-title"><?php echo esc_html($feature['title']); ?></h3>
                <p class="feature-text">
                  <?php echo esc_html($feature['text']); ?>
                </p>
              </div>
              <?php
            }
          }
          ?>
        </div>
      </div>

      <!-- History Section -->
      <div class="history-section">
        <h2 class="section-title"><?php esc_html_e('沿革', 'logic-nagoya'); ?></h2>
        
        <div class="timeline">
          <?php
          // 沿革セクションの項目（フィールド名：history_items）から取得、なければデフォルト表示
          $history_items = get_post_meta(get_the_ID(), 'history_items', true);
          
          if (!empty($history_items) && is_array($history_items)) {
            foreach ($history_items as $index => $history_item) {
              ?>
              <div class="timeline-item">
                <span class="timeline-date"><?php echo esc_html($history_item['date']); ?></span>
                <div class="timeline-content">
                  <h3 class="timeline-title"><?php echo esc_html($history_item['title']); ?></h3>
                  <p class="timeline-text"><?php echo esc_html($history_item['text']); ?></p>
                </div>
              </div>
              <?php
            }
          } else {
            // デフォルトの沿革項目
            $default_history = array(
              array(
                'date' => '2020年1月',
                'title' => 'Logic Nagoya構想開始',
                'text' => '名古屋栄エリアに新しいタイプのライブハウスとしてのコンセプトを策定。音楽と人をつなぐ場を目指して準備を開始。'
              ),
              array(
                'date' => '2020年7月',
                'title' => 'プリンセスガーデンホテルと提携',
                'text' => '立地条件と会場の可能性を見出し、プリンセスガーデンホテル内に会場を設置することが決定。音響・照明設備の設計開始。'
              ),
              array(
                'date' => '2020年11月',
                'title' => 'グランドオープン',
                'text' => '最新の設備を備えたライブハウスとして正式オープン。オープニングイベントには地元アーティストが多数出演し、満員の観客で賑わう。'
              ),
              array(
                'date' => '2021年3月',
                'title' => '配信設備の強化',
                'text' => '高品質な配信を実現するための設備を導入。ライブ配信に対応したハイブリッドイベントを開始。物理的な距離を超えた音楽体験を提供。'
              ),
              array(
                'date' => '2022年8月',
                'title' => '照明システムのアップグレード',
                'text' => '最新のLED照明とムービングライトを導入し、より創造的な照明演出が可能に。視覚と聴覚の両面からの感動体験を追求。'
              ),
              array(
                'date' => '2023年5月',
                'title' => '月間イベント数100件を達成',
                'text' => '名古屋で最も活発なライブハウスの一つとして成長。音楽ライブだけでなく、トークイベントや企業イベントなど多様な用途で利用される会場に。'
              )
            );
            
            foreach ($default_history as $history_item) {
              ?>
              <div class="timeline-item">
                <span class="timeline-date"><?php echo esc_html($history_item['date']); ?></span>
                <div class="timeline-content">
                  <h3 class="timeline-title"><?php echo esc_html($history_item['title']); ?></h3>
                  <p class="timeline-text"><?php echo esc_html($history_item['text']); ?></p>
                </div>
              </div>
              <?php
            }
          }
          ?>
        </div>
      </div>

      <!-- Team Section -->
      <div class="team-section">
        <h2 class="section-title"><?php esc_html_e('チーム', 'logic-nagoya'); ?></h2>
        
        <div class="team-grid">
          <?php
          // チームセクションの項目（フィールド名：team_members）から取得、なければデフォルト表示
          $team_members = get_post_meta(get_the_ID(), 'team_members', true);
          
          if (!empty($team_members) && is_array($team_members)) {
            foreach ($team_members as $member) {
              ?>
              <div class="team-card">
                <div class="team-image">
                  <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                </div>
                <div class="team-content">
                  <h3 class="team-name"><?php echo esc_html($member['name']); ?></h3>
                  <p class="team-role"><?php echo esc_html($member['role']); ?></p>
                  <p class="team-bio">
                    <?php echo esc_html($member['bio']); ?>
                  </p>
                  <div class="team-social">
                    <?php if (!empty($member['twitter'])) : ?>
                      <a href="<?php echo esc_url($member['twitter']); ?>" class="team-social-link" target="_blank">
                        <i class="fab fa-twitter"></i>
                      </a>
                    <?php endif; ?>
                    <?php if (!empty($member['facebook'])) : ?>
                      <a href="<?php echo esc_url($member['facebook']); ?>" class="team-social-link" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                      </a>
                    <?php endif; ?>
                    <?php if (!empty($member['instagram'])) : ?>
                      <a href="<?php echo esc_url($member['instagram']); ?>" class="team-social-link" target="_blank">
                        <i class="fab fa-instagram"></i>
                      </a>
                    <?php endif; ?>
                    <?php if (!empty($member['linkedin'])) : ?>
                      <a href="<?php echo esc_url($member['linkedin']); ?>" class="team-social-link" target="_blank">
                        <i class="fab fa-linkedin-in"></i>
                      </a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            // デフォルトのチームメンバー
            $default_members = array(
              array(
                'name' => '山田 太郎',
                'role' => '代表取締役',
                'bio' => '音楽業界20年のキャリアを持ち、Logic Nagoyaの創設者。様々なアーティストとの関わりからイベント空間の重要性を熟知し、理想の会場を実現。',
                'image' => get_template_directory_uri() . '/assets/images/logo.png'
              ),
              array(
                'name' => '鈴木 花子',
                'role' => '音響ディレクター',
                'bio' => 'レコーディングエンジニアとしての経験を活かし、Logic Nagoyaの音響システムを監修。あらゆるジャンルに対応できる音響環境を構築。',
                'image' => get_template_directory_uri() . '/assets/images/logo.png'
              ),
              array(
                'name' => '佐藤 健',
                'role' => '照明・映像ディレクター',
                'bio' => '劇場やコンサートホールでの経験を持ち、光と映像による空間演出のスペシャリスト。イベントの雰囲気を最大限に引き立てる照明を設計。',
                'image' => get_template_directory_uri() . '/assets/images/logo.png'
              ),
              array(
                'name' => '高橋 真理',
                'role' => 'イベントプロデューサー',
                'bio' => '多彩なイベントの企画・運営経験を持ち、クライアントのビジョンを実現するサポートを担当。初めてのイベント開催でも安心して相談できる存在。',
                'image' => get_template_directory_uri() . '/assets/images/bg-dark.jpg'
              )
            );
            
            foreach ($default_members as $member) {
              ?>
              <div class="team-card">
                <div class="team-image">
                  <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                </div>
                <div class="team-content">
                  <h3 class="team-name"><?php echo esc_html($member['name']); ?></h3>
                  <p class="team-role"><?php echo esc_html($member['role']); ?></p>
                  <p class="team-bio">
                    <?php echo esc_html($member['bio']); ?>
                  </p>
                  <div class="team-social">
                    <a href="#" class="team-social-link">
                      <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="team-social-link">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                  </div>
                </div>
              </div>
              <?php
            }
          }
          ?>
        </div>
      </div>

      <!-- Testimonials Section -->
      <div class="testimonials-section">
        <h2 class="section-title"><?php esc_html_e('お客様の声', 'logic-nagoya'); ?></h2>
        
        <div class="testimonials-container">
          <?php
          // お客様の声セクションの項目（フィールド名：testimonials）から取得、なければデフォルト表示
          $testimonials = get_post_meta(get_the_ID(), 'testimonials', true);
          
          if (!empty($testimonials) && is_array($testimonials)) {
            foreach ($testimonials as $testimonial) {
              ?>
              <div class="testimonial-item">
                <p class="testimonial-quote">
                  <?php echo esc_html($testimonial['quote']); ?>
                </p>
                <div class="testimonial-author">
                  <div class="testimonial-avatar">
                    <img src="<?php echo esc_url($testimonial['avatar']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>">
                  </div>
                  <div class="testimonial-info">
                    <h4><?php echo esc_html($testimonial['name']); ?></h4>
                    <p><?php echo esc_html($testimonial['position']); ?></p>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            // デフォルトのお客様の声
            $default_testimonials = array(
              array(
                'quote' => 'Logic Nagoyaは、名古屋で最高のライブ体験ができる会場です。音響・照明のクオリティが素晴らしく、バンドのサウンドが最高の状態で届きました。スタッフの方々の対応も丁寧で、初めてのライブ開催でしたが安心して臨むことができました。また利用したいと思います。',
                'name' => '田中 誠',
                'position' => 'バンド「ECHOES」ボーカル',
                'avatar' => get_template_directory_uri() . '/assets/images/logo.png'
              ),
              array(
                'quote' => 'トークイベントの会場を探していたところ、Logic Nagoyaを見つけました。音楽ライブだけでなく、トークショーにも適した環境で、参加者からも好評でした。同時配信も可能で、遠方からも多くの方に参加していただけたのが良かったです。',
                'name' => '中村 美咲',
                'position' => 'イベント主催者',
                'avatar' => get_template_directory_uri() . '/assets/images/bg-dark.jpg'
              ),
              array(
                'quote' => '何度もライブを観に行きましたが、Logic Nagoyaは観客として最も快適に音楽を楽しめる会場の一つです。どの場所からも見やすく、音もクリアに聞こえます。バーのドリンクメニューも充実していて、一日中楽しめるのが魅力です。',
                'name' => '佐々木 拓也',
                'position' => '常連客',
                'avatar' => get_template_directory_uri() . '/assets/images/logo.png'
              )
            );
            
            foreach ($default_testimonials as $testimonial) {
              ?>
              <div class="testimonial-item">
                <p class="testimonial-quote">
                  <?php echo esc_html($testimonial['quote']); ?>
                </p>
                <div class="testimonial-author">
                  <div class="testimonial-avatar">
                    <img src="<?php echo esc_url($testimonial['avatar']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>">
                  </div>
                  <div class="testimonial-info">
                    <h4><?php echo esc_html($testimonial['name']); ?></h4>
                    <p><?php echo esc_html($testimonial['position']); ?></p>
                  </div>
                </div>
              </div>
              <?php
            }
          }
          ?>
        </div>
      </div>

      <!-- Contact CTA -->
      <div class="contact-cta">
        <div class="cta-content">
          <h2 class="cta-title"><?php esc_html_e('お問い合わせ', 'logic-nagoya'); ?></h2>
          <p class="cta-text">
            <?php echo wp_kses_post(get_post_meta(get_the_ID(), 'contact_cta_text', true) ?: 'Logic Nagoyaでのイベント開催にご興味をお持ちですか？<br>お客様のイベントに関するご質問や見学のご希望など、お気軽にお問い合わせください。'); ?>
          </p>
          <div class="cta-buttons">
            <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="btn btn-accent"><?php esc_html_e('お問い合わせ', 'logic-nagoya'); ?></a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('equipment-list'))); ?>" class="btn btn-outline"><?php esc_html_e('設備を見る', 'logic-nagoya'); ?></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Back to top button -->
  <div class="back-to-top">
    <i class="fas fa-chevron-up"></i>
  </div>

<?php
get_footer();
