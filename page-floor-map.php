<?php
/**
 * Template Name: MAPページ
 * 
 * The template for displaying the Floor Map and Access page
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
      <p class="page-subtitle"><?php echo esc_html(get_post_meta(get_the_ID(), 'page_subtitle', true) ?: 'Logic Nagoyaの会場レイアウトとアクセス情報をご紹介します。名古屋栄の中心地、便利なロケーションでイベント開催をサポートします。'); ?></p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="main-content">
    <div class="container content-container">
      <!-- Floor Map Section -->
      <div class="floormap-section">
        <h2 class="section-title"><?php esc_html_e('フロアマップ', 'logic-nagoya'); ?></h2>
        
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <?php if (get_the_content()) : ?>
            <div class="floormap-intro">
              <?php the_content(); ?>
            </div>
          <?php else : ?>
            <p class="floormap-intro">
              Logic Nagoyaは、着席スタイルで60名、オールスタンディングで100名を超える収容が可能な空間です。
              様々なイベントスタイルに対応できるフレキシブルなレイアウトで、お客様のご要望に合わせた会場設営をサポートします。
            </p>
          <?php endif; ?>
        <?php endwhile; endif; ?>
        
        <div class="floormap-container">
          <?php
          $floormap_image = get_post_meta(get_the_ID(), 'floormap_image', true);
          if ($floormap_image) {
            $image_url = wp_get_attachment_image_url($floormap_image, 'full');
          } else {
            $image_url = 'https://logicnagoya.com/wp-content/uploads/2020/12/IMG_3744-scaled.jpg';
          }
          ?>
          <!-- Floor Map Image -->
          <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('Logic Nagoya Floor Map', 'logic-nagoya'); ?>" class="floormap-image" id="floormap-img">
          
          <div class="floormap-details">
            <h3 class="floormap-details-title"><?php esc_html_e('会場詳細', 'logic-nagoya'); ?></h3>
            
            <div class="floormap-details-grid">
              <div class="floormap-detail-item">
                <h4 class="floormap-detail-title"><?php esc_html_e('スペース情報', 'logic-nagoya'); ?></h4>
                <ul class="floormap-detail-list">
                  <?php
                  $space_info = get_post_meta(get_the_ID(), 'space_info', true);
                  if (!empty($space_info) && is_array($space_info)) {
                    foreach ($space_info as $info) {
                      echo '<li>' . esc_html($info) . '</li>';
                    }
                  } else {
                    // デフォルト表示
                    ?>
                    <li>総面積: 約130平方メートル</li>
                    <li>天井高: 約3.5メートル</li>
                    <li>ステージサイズ: W8.0m × D4.0m × H0.6m</li>
                    <li>ドラム用ライザー: W2.0m × D2.0m × H0.3m</li>
                    <?php
                  }
                  ?>
                </ul>
              </div>
              
              <div class="floormap-detail-item">
                <h4 class="floormap-detail-title"><?php esc_html_e('キャパシティ', 'logic-nagoya'); ?></h4>
                <ul class="floormap-detail-list">
                  <?php
                  $capacity_info = get_post_meta(get_the_ID(), 'capacity_info', true);
                  if (!empty($capacity_info) && is_array($capacity_info)) {
                    foreach ($capacity_info as $info) {
                      echo '<li>' . esc_html($info) . '</li>';
                    }
                  } else {
                    // デフォルト表示
                    ?>
                    <li>着席スタイル: 最大60名</li>
                    <li>シアター形式: 最大80名</li>
                    <li>オールスタンディング: 最大100名</li>
                    <li>立食パーティー: 最大80名</li>
                    <?php
                  }
                  ?>
                </ul>
              </div>
              
              <div class="floormap-detail-item">
                <h4 class="floormap-detail-title"><?php esc_html_e('設備', 'logic-nagoya'); ?></h4>
                <ul class="floormap-detail-list">
                  <?php
                  $facility_info = get_post_meta(get_the_ID(), 'facility_info', true);
                  if (!empty($facility_info) && is_array($facility_info)) {
                    foreach ($facility_info as $info) {
                      echo '<li>' . esc_html($info) . '</li>';
                    }
                  } else {
                    // デフォルト表示
                    ?>
                    <li>PA/照明操作卓</li>
                    <li>ミキシングエリア</li>
                    <li>バーカウンター</li>
                    <li>控室（2室）</li>
                    <?php
                  }
                  ?>
                </ul>
              </div>
              
              <div class="floormap-detail-item">
                <h4 class="floormap-detail-title"><?php esc_html_e('搬入情報', 'logic-nagoya'); ?></h4>
                <ul class="floormap-detail-list">
                  <?php
                  $load_info = get_post_meta(get_the_ID(), 'load_info', true);
                  if (!empty($load_info) && is_array($load_info)) {
                    foreach ($load_info as $info) {
                      echo '<li>' . esc_html($info) . '</li>';
                    }
                  } else {
                    // デフォルト表示
                    ?>
                    <li>搬入口: 幅1.8m × 高さ2.1m</li>
                    <li>エレベーター: 幅1.5m × 奥行1.7m × 高さ2.0m</li>
                    <li>一時駐車スペース: 要事前相談</li>
                    <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Access Section -->
      <div class="access-section">
        <h2 class="section-title"><?php esc_html_e('アクセス', 'logic-nagoya'); ?></h2>
        
        <div class="access-container">
          <div class="access-map">
            <?php
            $google_map_url = get_post_meta(get_the_ID(), 'google_map_embed', true);
            if (empty($google_map_url)) {
              $google_map_url = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3261.5833842968394!2d136.9040943!3d35.1670857!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x600370d4a2729f35%3A0xcfc724cb9535c6ba!2z5qCq5byP5Lya56S-44OX44Oq44Oz44K744K544Ks44O844OH44Oz44Ob44OG44Or!5e0!3m2!1sja!2sjp!4v1648040237864!5m2!1sja!2sjp';
            }
            ?>
            <iframe src="<?php echo esc_url($google_map_url); ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
          
          <div class="access-info">
            <span class="access-subtitle"><?php echo esc_html(get_post_meta(get_the_ID(), 'access_subtitle', true) ?: 'LOCATION'); ?></span>
            <h3 class="access-title"><?php echo esc_html(get_post_meta(get_the_ID(), 'access_title', true) ?: 'Logic Nagoya'); ?></h3>
            
            <p class="access-address">
              <?php echo wp_kses_post(get_post_meta(get_the_ID(), 'access_address', true) ?: '〒460-0008<br>愛知県名古屋市中区栄3-13-31<br>プリンセスガーデンホテル2階'); ?>
            </p>
            
            <div class="access-methods">
              <?php
              $access_methods = get_post_meta(get_the_ID(), 'access_methods', true);
              if (!empty($access_methods) && is_array($access_methods)) {
                foreach ($access_methods as $method) {
                  ?>
                  <div class="access-method">
                    <h4 class="access-method-title">
                      <span class="access-method-icon"><i class="fas fa-<?php echo esc_attr($method['icon']); ?>"></i></span>
                      <?php echo esc_html($method['title']); ?>
                    </h4>
                    <p class="access-method-text">
                      <?php echo wp_kses_post($method['text']); ?>
                    </p>
                  </div>
                  <?php
                }
              } else {
                // デフォルト表示
                ?>
                <div class="access-method">
                  <h4 class="access-method-title">
                    <span class="access-method-icon"><i class="fas fa-subway"></i></span>
                    <?php esc_html_e('電車でお越しの場合', 'logic-nagoya'); ?>
                  </h4>
                  <p class="access-method-text">
                    <?php esc_html_e('名古屋市営地下鉄「栄駅」8番出口より徒歩5分', 'logic-nagoya'); ?><br>
                    <?php esc_html_e('名古屋市営地下鉄「矢場町駅」3番出口より徒歩7分', 'logic-nagoya'); ?>
                  </p>
                </div>
                
                <div class="access-method">
                  <h4 class="access-method-title">
                    <span class="access-method-icon"><i class="fas fa-bus"></i></span>
                    <?php esc_html_e('バスでお越しの場合', 'logic-nagoya'); ?>
                  </h4>
                  <p class="access-method-text">
                    <?php esc_html_e('市バス「栄三丁目」バス停より徒歩2分', 'logic-nagoya'); ?><br>
                    <?php esc_html_e('栄バスターミナルより徒歩7分', 'logic-nagoya'); ?>
                  </p>
                </div>
                
                <div class="access-method">
                  <h4 class="access-method-title">
                    <span class="access-method-icon"><i class="fas fa-car"></i></span>
                    <?php esc_html_e('お車でお越しの場合', 'logic-nagoya'); ?>
                  </h4>
                  <p class="access-method-text">
                    <?php esc_html_e('名古屋高速「錦橋」出口より約10分', 'logic-nagoya'); ?><br>
                    <?php esc_html_e('※専用駐車場はありません。近隣のコインパーキングをご利用ください。', 'logic-nagoya'); ?>
                  </p>
                </div>
                <?php
              }
              ?>
            </div>
            
            <?php
            $google_maps_url = get_post_meta(get_the_ID(), 'google_maps_url', true);
            if (empty($google_maps_url)) {
              $google_maps_url = 'https://goo.gl/maps/YourGoogleMapsURL';
            }
            ?>
            <a href="<?php echo esc_url($google_maps_url); ?>" class="btn btn-outline" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Google Mapsで見る', 'logic-nagoya'); ?></a>
          </div>
        </div>
      </div>

      <!-- Nearby Facilities Section -->
      <div class="nearby-section">
        <h2 class="section-title"><?php esc_html_e('周辺施設', 'logic-nagoya'); ?></h2>
        
        <div class="nearby-tabs">
          <div class="nearby-tab active" data-tab="parking"><?php esc_html_e('駐車場', 'logic-nagoya'); ?></div>
          <div class="nearby-tab" data-tab="restaurant"><?php esc_html_e('飲食店', 'logic-nagoya'); ?></div>
          <div class="nearby-tab" data-tab="hotel"><?php esc_html_e('ホテル', 'logic-nagoya'); ?></div>
          <div class="nearby-tab" data-tab="others"><?php esc_html_e('その他施設', 'logic-nagoya'); ?></div>
        </div>
        
        <!-- 駐車場タブコンテンツ -->
        <div class="nearby-content active" id="parking-content">
          <div class="nearby-grid">
            <?php
            $parking_facilities = get_post_meta(get_the_ID(), 'parking_facilities', true);
            if (!empty($parking_facilities) && is_array($parking_facilities)) {
              foreach ($parking_facilities as $facility) {
                ?>
                <div class="nearby-card">
                  <div class="nearby-card-content">
                    <h3 class="nearby-card-title"><?php echo esc_html($facility['title']); ?></h3>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                      <span><?php echo esc_html($facility['distance']); ?></span>
                    </div>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-car"></i></span>
                      <span><?php echo esc_html($facility['capacity']); ?></span>
                    </div>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-yen-sign"></i></span>
                      <span><?php echo esc_html($facility['price']); ?></span>
                    </div>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="far fa-clock"></i></span>
                      <span><?php echo esc_html($facility['hours']); ?></span>
                    </div>
                    <?php if (!empty($facility['description'])) : ?>
                    <p class="nearby-card-desc">
                      <?php echo esc_html($facility['description']); ?>
                    </p>
                    <?php endif; ?>
                  </div>
                </div>
                <?php
              }
            } else {
              // デフォルト表示
              ?>
              <!-- Parking 1 -->
              <div class="nearby-card">
                <div class="nearby-card-content">
                  <h3 class="nearby-card-title">栄三丁目パーキング</h3>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>徒歩2分（約150m）</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-car"></i></span>
                    <span>収容台数: 約50台</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-yen-sign"></i></span>
                    <span>30分 400円〜</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="far fa-clock"></i></span>
                    <span>24時間営業</span>
                  </div>
                  <p class="nearby-card-desc">
                    会場に最も近い大型パーキング。イベント開催時は混雑する場合があります。
                  </p>
                </div>
              </div>
              
              <!-- Parking 2 -->
              <div class="nearby-card">
                <div class="nearby-card-content">
                  <h3 class="nearby-card-title">栄中央パーキング</h3>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>徒歩5分（約350m）</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-car"></i></span>
                    <span>収容台数: 約100台</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-yen-sign"></i></span>
                    <span>30分 300円〜</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="far fa-clock"></i></span>
                    <span>24時間営業</span>
                  </div>
                  <p class="nearby-card-desc">
                    大型の立体駐車場。比較的空きがあることが多いです。
                  </p>
                </div>
              </div>
              
              <!-- Parking 3 -->
              <div class="nearby-card">
                <div class="nearby-card-content">
                  <h3 class="nearby-card-title">矢場町地下駐車場</h3>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>徒歩7分（約500m）</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-car"></i></span>
                    <span>収容台数: 約200台</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-yen-sign"></i></span>
                    <span>30分 250円〜</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="far fa-clock"></i></span>
                    <span>7:00-23:00</span>
                  </div>
                  <p class="nearby-card-desc">
                    大型の地下駐車場。料金がリーズナブルで長時間の駐車におすすめです。
                  </p>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        
        <!-- 飲食店タブコンテンツ -->
        <div class="nearby-content" id="restaurant-content">
          <div class="nearby-grid">
            <?php
            $restaurant_facilities = get_post_meta(get_the_ID(), 'restaurant_facilities', true);
            if (!empty($restaurant_facilities) && is_array($restaurant_facilities)) {
              foreach ($restaurant_facilities as $facility) {
                ?>
                <div class="nearby-card">
                  <?php if (!empty($facility['image'])) : ?>
                  <div class="nearby-card-image">
                    <img src="<?php echo esc_url($facility['image']); ?>" alt="<?php echo esc_attr($facility['title']); ?>">
                  </div>
                  <?php endif; ?>
                  <div class="nearby-card-content">
                    <h3 class="nearby-card-title"><?php echo esc_html($facility['title']); ?></h3>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                      <span><?php echo esc_html($facility['distance']); ?></span>
                    </div>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-utensils"></i></span>
                      <span><?php echo esc_html($facility['cuisine']); ?></span>
                    </div>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-yen-sign"></i></span>
                      <span><?php echo esc_html($facility['price']); ?></span>
                    </div>
                    <?php if (!empty($facility['description'])) : ?>
                    <p class="nearby-card-desc">
                      <?php echo esc_html($facility['description']); ?>
                    </p>
                    <?php endif; ?>
                  </div>
                </div>
                <?php
              }
            } else {
              // デフォルト表示
              ?>
              <!-- Restaurant 1 -->
              <div class="nearby-card">
                <div class="nearby-card-image">
                  <img src="https://logicnagoya.com/wp-content/uploads/2022/10/HP-TOP-IMAGE.jpg" alt="レストラン">
                </div>
                <div class="nearby-card-content">
                  <h3 class="nearby-card-title">イタリアンレストラン Ciao</h3>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>徒歩3分（ホテル1階）</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-utensils"></i></span>
                    <span>イタリアン</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-yen-sign"></i></span>
                    <span>ランチ 1,200円〜 / ディナー 3,500円〜</span>
                  </div>
                  <p class="nearby-card-desc">
                    同ホテル内のイタリアンレストラン。イベント前後の食事に便利です。
                  </p>
                </div>
              </div>
              
              <!-- Restaurant 2 -->
              <div class="nearby-card">
                <div class="nearby-card-image">
                  <img src="https://logicnagoya.com/wp-content/uploads/2022/10/HP-TOP-IMAGE-1.jpg" alt="居酒屋">
                </div>
                <div class="nearby-card-content">
                  <h3 class="nearby-card-title">居酒屋 和楽</h3>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>徒歩2分（約100m）</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-utensils"></i></span>
                    <span>和食・居酒屋</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-yen-sign"></i></span>
                    <span>平均 3,000円〜</span>
                  </div>
                  <p class="nearby-card-desc">
                    会場近くの人気居酒屋。イベント後の打ち上げに最適です。
                  </p>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        
        <!-- ホテルタブコンテンツ -->
        <div class="nearby-content" id="hotel-content">
          <div class="nearby-grid">
            <?php
            $hotel_facilities = get_post_meta(get_the_ID(), 'hotel_facilities', true);
            if (!empty($hotel_facilities) && is_array($hotel_facilities)) {
              foreach ($hotel_facilities as $facility) {
                ?>
                <div class="nearby-card">
                  <?php if (!empty($facility['image'])) : ?>
                  <div class="nearby-card-image">
                    <img src="<?php echo esc_url($facility['image']); ?>" alt="<?php echo esc_attr($facility['title']); ?>">
                  </div>
                  <?php endif; ?>
                  <div class="nearby-card-content">
                    <h3 class="nearby-card-title"><?php echo esc_html($facility['title']); ?></h3>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                      <span><?php echo esc_html($facility['distance']); ?></span>
                    </div>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-bed"></i></span>
                      <span><?php echo esc_html($facility['room_type']); ?></span>
                    </div>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-yen-sign"></i></span>
                      <span><?php echo esc_html($facility['price']); ?></span>
                    </div>
                    <?php if (!empty($facility['description'])) : ?>
                    <p class="nearby-card-desc">
                      <?php echo esc_html($facility['description']); ?>
                    </p>
                    <?php endif; ?>
                  </div>
                </div>
                <?php
              }
            } else {
              // デフォルト表示
              ?>
              <!-- Hotel 1 -->
              <div class="nearby-card">
                <div class="nearby-card-image">
                  <img src="https://logicnagoya.com/wp-content/uploads/2022/10/HP-TOP-IMAGE.jpg" alt="プリンセスガーデンホテル">
                </div>
                <div class="nearby-card-content">
                  <h3 class="nearby-card-title">プリンセスガーデンホテル</h3>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>同じ建物内</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-bed"></i></span>
                    <span>シングル/ツイン/ダブル</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-yen-sign"></i></span>
                    <span>1泊 8,000円〜</span>
                  </div>
                  <p class="nearby-card-desc">
                    Logic Nagoyaが入っているホテル。イベント出演者や遠方からのゲストに便利です。
                  </p>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
        
        <!-- その他施設タブコンテンツ -->
        <div class="nearby-content" id="others-content">
          <div class="nearby-grid">
            <?php
            $other_facilities = get_post_meta(get_the_ID(), 'other_facilities', true);
            if (!empty($other_facilities) && is_array($other_facilities)) {
              foreach ($other_facilities as $facility) {
                ?>
                <div class="nearby-card">
                  <?php if (!empty($facility['image'])) : ?>
                  <div class="nearby-card-image">
                    <img src="<?php echo esc_url($facility['image']); ?>" alt="<?php echo esc_attr($facility['title']); ?>">
                  </div>
                  <?php endif; ?>
                  <div class="nearby-card-content">
                    <h3 class="nearby-card-title"><?php echo esc_html($facility['title']); ?></h3>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                      <span><?php echo esc_html($facility['distance']); ?></span>
                    </div>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="fas fa-<?php echo esc_attr($facility['icon'] ?? 'store'); ?>"></i></span>
                      <span><?php echo esc_html($facility['type'] ?? ''); ?></span>
                    </div>
                    <?php if (!empty($facility['hours'])) : ?>
                    <div class="nearby-card-info">
                      <span class="nearby-card-icon"><i class="far fa-clock"></i></span>
                      <span><?php echo esc_html($facility['hours']); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($facility['description'])) : ?>
                    <p class="nearby-card-desc">
                      <?php echo esc_html($facility['description']); ?>
                    </p>
                    <?php endif; ?>
                  </div>
                </div>
                <?php
              }
            } else {
              // デフォルト表示
              ?>
              <!-- Other 1 -->
              <div class="nearby-card">
                <div class="nearby-card-content">
                  <h3 class="nearby-card-title">栄地下街</h3>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                    <span>徒歩5分（約350m）</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="fas fa-store"></i></span>
                    <span>ショッピング・飲食</span>
                  </div>
                  <div class="nearby-card-info">
                    <span class="nearby-card-icon"><i class="far fa-clock"></i></span>
                    <span>10:00-21:00（店舗により異なる）</span>
                  </div>
                  <p class="nearby-card-desc">
                    多数のショップやレストランが集まる地下街。ちょっとした買い物や食事に便利です。
                  </p>
                </div>
              </div>
              <?php
            }
            ?>
          </div>
        </div>
      </div>

      <!-- Transportation Options -->
      <div class="transport-section">
        <h2 class="section-title"><?php esc_html_e('交通アクセス', 'logic-nagoya'); ?></h2>
        
        <div class="transport-grid">
          <?php
          $transport_options = get_post_meta(get_the_ID(), 'transport_options', true);
          if (!empty($transport_options) && is_array($transport_options)) {
            foreach ($transport_options as $option) {
              ?>
              <div class="transport-card">
                <div class="transport-icon">
                  <i class="fas fa-<?php echo esc_attr($option['icon']); ?>"></i>
                </div>
                <h3 class="transport-title"><?php echo esc_html($option['title']); ?></h3>
                <p class="transport-text">
                  <?php echo wp_kses_post($option['text']); ?>
                </p>
                <?php if (!empty($option['time'])) : ?>
                <p class="transport-text">
                  <?php echo esc_html($option['time']); ?>
                </p>
                <?php endif; ?>
              </div>
              <?php
            }
          } else {
            // デフォルト表示
            ?>
            <!-- Transport 1 -->
            <div class="transport-card">
              <div class="transport-icon">
                <i class="fas fa-plane"></i>
              </div>
              <h3 class="transport-title"><?php esc_html_e('中部国際空港から', 'logic-nagoya'); ?></h3>
              <p class="transport-text">
                <?php esc_html_e('中部国際空港（セントレア）から名鉄特急で「金山駅」まで約30分。金山駅から地下鉄名城線で「栄駅」まで約10分。栄駅8番出口から徒歩5分。', 'logic-nagoya'); ?>
              </p>
              <p class="transport-text">
                <?php esc_html_e('所要時間：約45分〜1時間', 'logic-nagoya'); ?>
              </p>
            </div>
            
            <!-- Transport 2 -->
            <div class="transport-card">
              <div class="transport-icon">
                <i class="fas fa-train"></i>
              </div>
              <h3 class="transport-title"><?php esc_html_e('名古屋駅から', 'logic-nagoya'); ?></h3>
              <p class="transport-text">
                <?php esc_html_e('JR名古屋駅から地下鉄東山線で「栄駅」まで約10分。栄駅8番出口から徒歩5分。タクシーの場合は約15分。', 'logic-nagoya'); ?>
              </p>
              <p class="transport-text">
                <?php esc_html_e('所要時間：約15〜20分', 'logic-nagoya'); ?>
              </p>
            </div>
            
            <!-- Transport 3 -->
            <div class="transport-card">
              <div class="transport-icon">
                <i class="fas fa-subway"></i>
              </div>
              <h3 class="transport-title"><?php esc_html_e('市内の主要駅から', 'logic-nagoya'); ?></h3>
              <p class="transport-text">
                <?php esc_html_e('地下鉄「栄駅」（東山線・名城線）8番出口から徒歩5分。', 'logic-nagoya'); ?><br>
                <?php esc_html_e('地下鉄「矢場町駅」（名城線）3番出口から徒歩7分。', 'logic-nagoya'); ?>
              </p>
              <p class="transport-text">
                <?php esc_html_e('栄は名古屋市の中心部に位置し、市内各所からのアクセスが便利です。', 'logic-nagoya'); ?>
              </p>
            </div>
            
            <!-- Transport 4 -->
            <div class="transport-card">
              <div class="transport-icon">
                <i class="fas fa-car"></i>
              </div>
              <h3 class="transport-title"><?php esc_html_e('高速道路から', 'logic-nagoya'); ?></h3>
              <p class="transport-text">
                <?php esc_html_e('名古屋高速「錦橋」出口から約10分。「丸の内」出口から約15分。カーナビの場合は「プリンセスガーデンホテル」で検索してください。', 'logic-nagoya'); ?>
              </p>
              <p class="transport-text">
                <?php esc_html_e('※駐車場については「周辺施設」の駐車場情報をご確認ください。', 'logic-nagoya'); ?>
              </p>
            </div>
            <?php
          }
          ?>
        </div>
      </div>

      <!-- Contact CTA -->
      <div class="contact-cta">
        <div class="cta-content">
          <h2 class="cta-title"><?php esc_html_e('お問い合わせ', 'logic-nagoya'); ?></h2>
          <p class="cta-text">
            <?php echo wp_kses_post(get_post_meta(get_the_ID(), 'contact_cta_text', true) ?: '会場や設備について詳しい情報が必要な場合は、お気軽にお問い合わせください。<br>イベント開催の際の会場レイアウトや搬入出についてもご相談に応じます。'); ?>
          </p>
          <div class="cta-buttons">
            <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="btn btn-accent"><?php esc_html_e('お問い合わせ', 'logic-nagoya'); ?></a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('equipment-list'))); ?>" class="btn btn-outline"><?php esc_html_e('設備を見る', 'logic-nagoya'); ?></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal for Floor Map -->
  <div class="modal" id="floormap-modal">
    <div class="modal-content">
      <img src="" alt="<?php esc_attr_e('Logic Nagoya Floor Map', 'logic-nagoya'); ?>" class="modal-image" id="modal-floormap">
      <div class="modal-close">
        <i class="fas fa-times"></i>
      </div>
    </div>
  </div>

  <!-- Back to top button -->
  <div class="back-to-top">
    <i class="fas fa-chevron-up"></i>
  </div>

<?php
get_footer();
