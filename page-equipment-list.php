<?php
/**
 * Template Name: 設備一覧
 * 
 * The template for displaying the Equipment List page
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
      <p class="page-subtitle"><?php echo esc_html(get_post_meta(get_the_ID(), 'page_subtitle', true) ?: 'Logic Nagoyaが誇る音響・照明・映像機材の設備リスト。あらゆるタイプのイベントに対応できる充実の設備をご紹介します。'); ?></p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="main-content">
    <div class="container content-container">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php if (get_the_content()) : ?>
          <div class="equipment-intro">
            <?php the_content(); ?>
          </div>
        <?php else : ?>
          <p class="equipment-intro">
            Logic Nagoyaでは、ライブイベント、トークショー、ワークショップ、配信など様々な用途に対応できるよう、
            プロフェッショナルな機材を取り揃えています。お客様のイベントに最適な環境をご提供するため、
            音響・照明・映像など各分野のスペシャリストがサポートいたします。
          </p>
        <?php endif; ?>
      <?php endwhile; endif; ?>

      <!-- Equipment Tabs -->
      <div class="equipment-tabs">
        <div class="equipment-tab active" data-tab="sound"><?php esc_html_e('音響機材', 'logic-nagoya'); ?></div>
        <div class="equipment-tab" data-tab="lighting"><?php esc_html_e('照明機材', 'logic-nagoya'); ?></div>
        <div class="equipment-tab" data-tab="stage"><?php esc_html_e('ステージ設備', 'logic-nagoya'); ?></div>
        <div class="equipment-tab" data-tab="video"><?php esc_html_e('映像・配信機材', 'logic-nagoya'); ?></div>
        <div class="equipment-tab" data-tab="other"><?php esc_html_e('その他設備', 'logic-nagoya'); ?></div>
      </div>

      <!-- Sound Equipment -->
      <div class="equipment-content active" id="sound-content">
        <div class="equipment-grid">
          <!-- Mixer -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-sliders-h"></i>
                </div>
                <?php esc_html_e('ミキサー', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">YAMAHA QL5 デジタルミキサー</li>
                <li class="equipment-item">YAMAHA Rio3224-D2 (32in/16out)</li>
                <li class="equipment-item">YAMAHA Rio1608-D2 (16in/8out)</li>
                <li class="equipment-item">BEHRINGER X32 RACK (バックアップ用)</li>
              </ul>
              <p class="equipment-note">※デジタルミキサーのため、iPadからのリモート操作も可能です。</p>
            </div>
          </div>

          <!-- Speakers -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-volume-up"></i>
                </div>
                <?php esc_html_e('スピーカー', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">d&b audiotechnik Y8 ラインアレイ (メイン×4基)</li>
                <li class="equipment-item">d&b audiotechnik Y-SUB (サブウーファー×2基)</li>
                <li class="equipment-item">d&b audiotechnik E8 (フロントフィル×2基)</li>
                <li class="equipment-item">d&b audiotechnik M4 (ステージモニター×4基)</li>
                <li class="equipment-item">d&b audiotechnik D80 アンプ×2台</li>
              </ul>
              <p class="equipment-note">※会場の規模やイベント内容に合わせて最適なセッティングを提案いたします。</p>
            </div>
          </div>

          <!-- Microphones -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-microphone"></i>
                </div>
                <?php esc_html_e('マイク', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">Shure SM58 (ボーカル用×8本)</li>
                <li class="equipment-item">Shure SM57 (楽器用×8本)</li>
                <li class="equipment-item">Shure BETA 52A (バスドラム用×2本)</li>
                <li class="equipment-item">Shure BETA 91A (バスドラム用×1本)</li>
                <li class="equipment-item">AKG C414 XLS (コンデンサーマイク×2本)</li>
                <li class="equipment-item">Sennheiser e904 (タム用×4本)</li>
                <li class="equipment-item">Sennheiser e906 (ギターアンプ用×2本)</li>
                <li class="equipment-item">Sennheiser EW500 G4 (ワイヤレス×4ch)</li>
              </ul>
            </div>
          </div>

          <!-- DI and Others -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-plug"></i>
                </div>
                <?php esc_html_e('DI・その他', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">RADIAL J48 (アクティブDI×4台)</li>
                <li class="equipment-item">RADIAL PRO D2 (パッシブDI×4台)</li>
                <li class="equipment-item">RADIAL ProAV2 (ステレオDI×2台)</li>
                <li class="equipment-item">dbx 266XL (コンプレッサー/リミッター×2台)</li>
                <li class="equipment-item">TC Electronic M-One XL (マルチエフェクター×1台)</li>
                <li class="equipment-item">LINE6 POD HD500X (ギターエフェクター×1台)</li>
                <li class="equipment-item">YAMAHA SPX2000 (マルチエフェクター×1台)</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Lighting Equipment -->
      <div class="equipment-content" id="lighting-content">
        <div class="equipment-grid">
          <!-- Moving Lights -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-lightbulb"></i>
                </div>
                <?php esc_html_e('ムービングライト', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">Martin MAC Aura XB (LED×8台)</li>
                <li class="equipment-item">Martin MAC Quantum Profile (LED×4台)</li>
                <li class="equipment-item">Robe Robin 600 LED Wash (LED×4台)</li>
                <li class="equipment-item">Elation Platinum Beam 5R Extreme (ビーム×4台)</li>
              </ul>
              <p class="equipment-note">※プログラミング済みのシーンを多数用意しています。</p>
            </div>
          </div>

          <!-- LED Fixtures -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-compact-disc"></i>
                </div>
                <?php esc_html_e('LED照明', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">CHAUVET COLORado 1 Tri Tour (LED PAR×12台)</li>
                <li class="equipment-item">Elation SIXPAR 200 (LED PAR×8台)</li>
                <li class="equipment-item">ADJ COB Cannon Wash (LED ウォッシュ×4台)</li>
                <li class="equipment-item">Astera AX3 LightDrop (バッテリー式LED×12台)</li>
                <li class="equipment-item">Elation SIXBAR 1000 (LED バー×4台)</li>
              </ul>
            </div>
          </div>

          <!-- Conventional Lighting -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-fire"></i>
                </div>
                <?php esc_html_e('従来型照明', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">ETC Source Four Profile 26° (575W×4台)</li>
                <li class="equipment-item">ETC Source Four Profile 36° (575W×4台)</li>
                <li class="equipment-item">ETC Source Four PAR (575W×8台)</li>
                <li class="equipment-item">STRAND LIGHTING SL 15/32 (1kW×4台)</li>
                <li class="equipment-item">PAR64 (1kW×8台)</li>
              </ul>
            </div>
          </div>

          <!-- Controllers & Others -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-desktop"></i>
                </div>
                <?php esc_html_e('コントローラー・他', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">MA Lighting dot2 XL-F (照明コンソール×1台)</li>
                <li class="equipment-item">CHAMSYS MagicQ MQ80 (バックアップ用×1台)</li>
                <li class="equipment-item">Antari Z-1500II (フォグマシン×1台)</li>
                <li class="equipment-item">JEM ZR45 (ヘイズマシン×1台)</li>
                <li class="equipment-item">Dimmer Rack 24ch (12kW)</li>
              </ul>
              <p class="equipment-note">※DMX over Ethernet（ArtNet, sACN）対応</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Stage Equipment -->
      <div class="equipment-content" id="stage-content">
        <div class="equipment-grid">
          <!-- Stage Structure -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-theater-masks"></i>
                </div>
                <?php esc_html_e('ステージ構造', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">メインステージ: W8.0m × D4.0m × H0.6m</li>
                <li class="equipment-item">サブステージ: W2.0m × D2.0m × H0.3m (ドラム用)</li>
                <li class="equipment-item">舞台袖: 左右各2.0m</li>
                <li class="equipment-item">昇降機: 電動バトン×2系統</li>
              </ul>
              <p class="equipment-note">※ステージの拡張・縮小も可能です。事前にご相談ください。</p>
            </div>
          </div>

          <!-- Stage Equipment -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-music"></i>
                </div>
                <?php esc_html_e('ステージ設備', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">ドラム用ライザー (W2.0m × D2.0m × H0.3m)</li>
                <li class="equipment-item">ピアノ: YAMAHA C3（要事前予約）</li>
                <li class="equipment-item">電子ピアノ: Roland RD-2000</li>
                <li class="equipment-item">ギターアンプ: Fender Twin Reverb, Marshall JCM900</li>
                <li class="equipment-item">ベースアンプ: Ampeg SVT-4PRO + 8×10キャビネット</li>
                <li class="equipment-item">ドラムセット: TAMA Starclassic (要事前予約)</li>
              </ul>
            </div>
          </div>

          <!-- Curtains & Backdrop -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-square"></i>
                </div>
                <?php esc_html_e('カーテン・背景', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">ブラックカーテン（ステージ背面）</li>
                <li class="equipment-item">サイドカーテン（左右）</li>
                <li class="equipment-item">ホリゾント幕（ホワイト・グレー）</li>
                <li class="equipment-item">プロジェクション用スクリーン（180インチ）</li>
                <li class="equipment-item">バナーフレーム（背景用）</li>
              </ul>
              <p class="equipment-note">※特殊な背景が必要な場合はご相談ください。</p>
            </div>
          </div>

          <!-- Trussing -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-grip-lines"></i>
                </div>
                <?php esc_html_e('トラス', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">Global Truss F34 (メイントラス: 横6m×2列)</li>
                <li class="equipment-item">Global Truss F31 (サイドトラス: 縦3m×左右)</li>
                <li class="equipment-item">電動ホイスト (1t×4基)</li>
                <li class="equipment-item">チェーンホイスト (500kg×2基)</li>
                <li class="equipment-item">垂直トラス (2m×4本)</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Video Equipment -->
      <div class="equipment-content" id="video-content">
        <div class="equipment-grid">
          <!-- Cameras -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-video"></i>
                </div>
                <?php esc_html_e('カメラ', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">Sony PXW-FS7 (メインカメラ×2台)</li>
                <li class="equipment-item">Sony PXW-Z150 (サブカメラ×2台)</li>
                <li class="equipment-item">Panasonic AG-UX180 (ワイド用×1台)</li>
                <li class="equipment-item">BMPCC 6K Pro (シネマカメラ×1台)</li>
                <li class="equipment-item">各種レンズ (広角〜望遠)</li>
              </ul>
              <p class="equipment-note">※SDI/HDMI出力対応。4K収録オプションあり（要事前相談）</p>
            </div>
          </div>

          <!-- Switchers & Streaming -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-random"></i>
                </div>
                <?php esc_html_e('スイッチャー・配信', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">Blackmagic ATEM Television Studio Pro 4K</li>
                <li class="equipment-item">Blackmagic Web Presenter 4K</li>
                <li class="equipment-item">Roland V-8HD (サブスイッチャー)</li>
                <li class="equipment-item">AJA Helo (H.264エンコーダー/レコーダー)</li>
                <li class="equipment-item">インターネット回線: 光回線 1Gbps</li>
                <li class="equipment-item">OBS Studio / vMix / Wirecast</li>
              </ul>
              <p class="equipment-note">※YouTube Live, Zoom, Vimeo, ニコニコ生放送などの配信実績あり</p>
            </div>
          </div>

          <!-- Projectors & Displays -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-projector"></i>
                </div>
                <?php esc_html_e('プロジェクター・ディスプレイ', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">EPSON EB-L1100U (レーザープロジェクター, 6000lm)</li>
                <li class="equipment-item">EPSON EB-L610U (レーザープロジェクター, 6000lm)</li>
                <li class="equipment-item">170インチ電動スクリーン (16:9)</li>
                <li class="equipment-item">LG 75インチ4Kディスプレイ (サブモニター用)</li>
                <li class="equipment-item">LG 55インチFHDディスプレイ×2台 (サイド表示用)</li>
              </ul>
            </div>
          </div>

          <!-- Video Processing -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-cogs"></i>
                </div>
                <?php esc_html_e('映像処理・その他', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">Blackmagic ATEM Mini Pro ISO (小規模配信用)</li>
                <li class="equipment-item">Roland V-1HD (HDMI小型スイッチャー)</li>
                <li class="equipment-item">AJA FS1-X (フレームシンクロナイザー)</li>
                <li class="equipment-item">Blackmagic SmartScope Duo (波形モニター)</li>
                <li class="equipment-item">HDMI/SDIマトリクススイッチャー</li>
                <li class="equipment-item">HDMI/SDI各種コンバーター</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Other Equipment -->
      <div class="equipment-content" id="other-content">
        <div class="equipment-grid">
          <!-- Power -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-bolt"></i>
                </div>
                <?php esc_html_e('電源設備', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">3相200V (100A): メイン電源</li>
                <li class="equipment-item">単相100V (60A×4回路): 機材用電源</li>
                <li class="equipment-item">単相100V (20A×12回路): 一般電源</li>
                <li class="equipment-item">UPS (無停電電源装置): 重要機器用</li>
                <li class="equipment-item">配電盤・延長コード各種</li>
              </ul>
              <p class="equipment-note">※特殊な電源や大容量電源が必要な場合は事前にご相談ください。</p>
            </div>
          </div>

          <!-- Communication -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-headset"></i>
                </div>
                <?php esc_html_e('通信・インカム', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">Clear-Com HelixNet (デジタルインカム)</li>
                <li class="equipment-item">Clear-Com FreeSpeak II (ワイヤレスインカム×8台)</li>
                <li class="equipment-item">Motorola 簡易無線機 (スタッフ間通信用×10台)</li>
                <li class="equipment-item">有線インターカム (固定ポジション用×4台)</li>
                <li class="equipment-item">cueB (キュー出しシステム)</li>
              </ul>
            </div>
          </div>

          <!-- Furniture & Stands -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-chair"></i>
                </div>
                <?php esc_html_e('家具・スタンド類', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">折りたたみ椅子 (観客用×100脚)</li>
                <li class="equipment-item">テーブル (W1800×D600×H700mm×10台)</li>
                <li class="equipment-item">テーブル (丸型Φ900mm×5台)</li>
                <li class="equipment-item">ハイテーブル (バー用×4台)</li>
                <li class="equipment-item">マイクスタンド各種</li>
                <li class="equipment-item">譜面台 (20台)</li>
                <li class="equipment-item">ギタースタンド (10台)</li>
              </ul>
            </div>
          </div>

          <!-- Bar & Catering -->
          <div class="equipment-card">
            <div class="equipment-header">
              <h3 class="equipment-title">
                <div class="equipment-icon">
                  <i class="fas fa-glass-cheers"></i>
                </div>
                <?php esc_html_e('バー・ケータリング', 'logic-nagoya'); ?>
              </h3>
            </div>
            <div class="equipment-body">
              <ul class="equipment-list">
                <li class="equipment-item">バーカウンター (L字型)</li>
                <li class="equipment-item">冷蔵庫 (大型×1台, 小型×2台)</li>
                <li class="equipment-item">製氷機 (キューブアイス用)</li>
                <li class="equipment-item">ドリンクディスペンサー (2台)</li>
                <li class="equipment-item">電子レンジ (2台)</li>
                <li class="equipment-item">コーヒーメーカー (業務用)</li>
                <li class="equipment-item">ケータリングエリア (スタッフ用)</li>
              </ul>
              <p class="equipment-note">※イベント用ドリンクメニューや軽食の提供も可能です。</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Floor Plan Section -->
      <div class="floor-plan">
        <h2 class="section-title"><?php esc_html_e('フロアプラン', 'logic-nagoya'); ?></h2>
        <div class="floor-plan-container">
          <?php
          $floor_plan_image = get_post_meta(get_the_ID(), 'floor_plan_image', true);
          if ($floor_plan_image) {
            $image_url = wp_get_attachment_image_url($floor_plan_image, 'full');
          } else {
            $image_url = get_template_directory_uri() . '/assets/images/bg-dark.jpg';
          }
          ?>
          <img src="<?php echo esc_url($image_url); ?>" alt="<?php esc_attr_e('Logic Nagoya Floor Plan', 'logic-nagoya'); ?>" class="floor-plan-image">
          
          <div class="floor-plan-content">
            <h3 class="floor-plan-title"><?php esc_html_e('会場レイアウト', 'logic-nagoya'); ?></h3>
            <p class="floor-plan-text">
              <?php echo esc_html(get_post_meta(get_the_ID(), 'floor_plan_text', true) ?: 'Logic Nagoyaは、様々なイベントの用途に合わせてフレキシブルなレイアウト変更が可能です。ライブ、トークショー、ワークショップ、配信など、イベントの性質に応じて最適な空間をご提供します。'); ?>
            </p>
            
            <div class="floor-plan-details">
              <div class="floor-plan-item">
                <div class="floor-plan-icon">
                  <i class="fas fa-users"></i>
                </div>
                <div class="floor-plan-info">
                  <h4><?php esc_html_e('収容人数', 'logic-nagoya'); ?></h4>
                  <p><?php echo esc_html(get_post_meta(get_the_ID(), 'venue_capacity', true) ?: '着席スタイル: 最大60名<br>スタンディング: 最大120名'); ?></p>
                </div>
              </div>
              
              <div class="floor-plan-item">
                <div class="floor-plan-icon">
                  <i class="fas fa-vector-square"></i>
                </div>
                <div class="floor-plan-info">
                  <h4><?php esc_html_e('会場サイズ', 'logic-nagoya'); ?></h4>
                  <p><?php echo esc_html(get_post_meta(get_the_ID(), 'venue_size', true) ?: 'メインエリア: 約130平方メートル<br>天井高: 約3.5メートル'); ?></p>
                </div>
              </div>
              
              <div class="floor-plan-item">
                <div class="floor-plan-icon">
                  <i class="fas fa-door-open"></i>
                </div>
                <div class="floor-plan-info">
                  <h4><?php esc_html_e('アクセス', 'logic-nagoya'); ?></h4>
                  <p><?php echo esc_html(get_post_meta(get_the_ID(), 'venue_access', true) ?: '搬入口: 幅1.8m×高さ2.1m<br>エレベーター: 幅1.5m×奥行1.7m×高さ2.0m'); ?></p>
                </div>
              </div>
            </div>
            
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('floor-map'))); ?>" class="btn btn-outline"><?php esc_html_e('詳細なフロアマップを見る', 'logic-nagoya'); ?></a>
          </div>
        </div>
      </div>

      <!-- Technical Specifications -->
      <div class="tech-specs">
        <h2 class="section-title"><?php esc_html_e('技術仕様', 'logic-nagoya'); ?></h2>
        
        <table class="specs-table">
          <thead>
            <tr>
              <th><?php esc_html_e('項目', 'logic-nagoya'); ?></th>
              <th><?php esc_html_e('仕様', 'logic-nagoya'); ?></th>
              <th><?php esc_html_e('備考', 'logic-nagoya'); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php esc_html_e('電源容量', 'logic-nagoya'); ?></td>
              <td>3相200V 100A / 単相100V 60A×4</td>
              <td>合計約60kVA</td>
            </tr>
            <tr>
              <td><?php esc_html_e('スピーカー出力', 'logic-nagoya'); ?></td>
              <td>メインPA: 10,000W / モニター: 2,000W</td>
              <td>d&b audiotechnik システム</td>
            </tr>
            <tr>
              <td><?php esc_html_e('入力チャンネル数', 'logic-nagoya'); ?></td>
              <td>最大48チャンネル</td>
              <td>アナログ/デジタル混在可</td>
            </tr>
            <tr>
              <td><?php esc_html_e('DMXユニバース', 'logic-nagoya'); ?></td>
              <td>最大8ユニバース</td>
              <td>sACN/ArtNet対応</td>
            </tr>
            <tr>
              <td><?php esc_html_e('インターネット回線', 'logic-nagoya'); ?></td>
              <td>光回線 下り1Gbps / 上り1Gbps</td>
              <td>有線LAN/Wi-Fi利用可</td>
            </tr>
            <tr>
              <td><?php esc_html_e('映像入力', 'logic-nagoya'); ?></td>
              <td>HDMI×8 / SDI×4 / アナログ(VGA)×2</td>
              <td>4K入力対応(一部)</td>
            </tr>
            <tr>
              <td><?php esc_html_e('映像出力', 'logic-nagoya'); ?></td>
              <td>プロジェクター×2 / LCD×3</td>
              <td>マトリクス切替可能</td>
            </tr>
            <tr>
              <td><?php esc_html_e('空調', 'logic-nagoya'); ?></td>
              <td>業務用エアコン 23kW</td>
              <td>室温調整可能</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Download Section -->
      <div class="download-section">
        <h3 class="download-title"><?php esc_html_e('詳細な設備リスト', 'logic-nagoya'); ?></h3>
        <p class="download-text">
          <?php esc_html_e('より詳細な設備リストや技術仕様書をご希望の場合は、以下のPDFファイルをダウンロードしてください。イベント計画の際にお役立てください。', 'logic-nagoya'); ?>
        </p>
        <?php
        $pdf_file = get_post_meta(get_the_ID(), 'equipment_pdf', true);
        if ($pdf_file) {
          $pdf_url = wp_get_attachment_url($pdf_file);
        } else {
          $pdf_url = '#';
        }
        ?>
        <a href="<?php echo esc_url($pdf_url); ?>" class="download-button">
          <div class="download-icon">
            <i class="fas fa-file-pdf"></i>
          </div>
          <span><?php esc_html_e('設備詳細PDFをダウンロード', 'logic-nagoya'); ?></span>
        </a>
      </div>

      <!-- Contact CTA -->
      <div class="contact-cta">
        <div class="cta-content">
          <h2 class="cta-title"><?php esc_html_e('お問い合わせ', 'logic-nagoya'); ?></h2>
          <p class="cta-text">
            <?php esc_html_e('ご不明な点や追加設備のご相談、イベントに関するお問い合わせは、お気軽にご連絡ください。お客様のイベントに最適な機材・設備をご提案いたします。', 'logic-nagoya'); ?>
          </p>
          <div class="cta-buttons">
            <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="btn btn-accent"><?php esc_html_e('お問い合わせ', 'logic-nagoya'); ?></a>
            <a href="<?php echo esc_url(get_permalink(get_page_by_path('floor-map'))); ?>" class="btn btn-outline"><?php esc_html_e('フロアマップを見る', 'logic-nagoya'); ?></a>
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
