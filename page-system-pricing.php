<?php
/**
 * Template Name: System and Pricing Page
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
    <h1 class="page-title">システムと料金</h1>
    <p class="page-subtitle">Logic Nagoyaの利用システムと料金プランの詳細をご紹介します。様々な用途に合わせた柔軟なプランをご用意しています。</p>
  </div>
</section>

<!-- Main Content -->
<section class="main-content">
  <div class="container content-container">
    <p class="intro-text">
      Logic Nagoyaでは、一般的な貸切ライブ利用から、配信、トークイベント、ワークショップなど様々な用途に対応できるよう、
      フレキシブルなシステムと料金体系をご用意しています。皆様のイベントに最適なプランをお選びください。
    </p>

    <!-- Pricing Section -->
    <div class="pricing-section">
      <h2 class="section-title">料金プラン</h2>
      
      <div class="pricing-tabs">
        <div class="pricing-tab active" data-tab="standard">スタンダードプラン</div>
        <div class="pricing-tab" data-tab="streaming">配信プラン</div>
        <div class="pricing-tab" data-tab="other">その他のプラン</div>
      </div>
      
      <div class="pricing-content active" id="standard-content">
        <table class="pricing-table">
          <thead>
            <tr>
              <th>時間帯</th>
              <th>基本料金（平日）</th>
              <th>基本料金（土日祝）</th>
              <th>収容人数</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>午前の部 (10:00-15:00)</td>
              <td><span class="price">¥55,000</span></td>
              <td><span class="price price-accent">¥65,000</span></td>
              <td>最大100名</td>
            </tr>
            <tr>
              <td>夕方の部 (16:00-21:00)</td>
              <td><span class="price">¥65,000</span></td>
              <td><span class="price price-accent">¥75,000</span></td>
              <td>最大100名</td>
            </tr>
            <tr>
              <td>終日 (10:00-21:00)</td>
              <td><span class="price">¥100,000</span></td>
              <td><span class="price price-accent">¥120,000</span></td>
              <td>最大100名</td>
            </tr>
            <tr>
              <td>深夜の部 (22:00-翌5:00)</td>
              <td><span class="price">¥80,000</span></td>
              <td><span class="price price-accent">¥90,000</span></td>
              <td>最大100名</td>
            </tr>
          </tbody>
        </table>
        
        <p class="pricing-note">※基本料金には、PA/照明オペレーターの人件費、基本的な音響・照明機材の使用料が含まれています。</p>
        <p class="pricing-note">※延長料金は1時間あたり平日¥15,000、土日祝¥18,000となります。</p>
      </div>
      
      <div class="pricing-content" id="streaming-content">
        <table class="pricing-table">
          <thead>
            <tr>
              <th>配信プラン</th>
              <th>基本料金</th>
              <th>内容</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>ベーシック配信</td>
              <td><span class="price">¥45,000〜</span></td>
              <td>シンプルな1〜2カメラでの配信対応</td>
            </tr>
            <tr>
              <td>スタンダード配信</td>
              <td><span class="price">¥75,000〜</span></td>
              <td>3〜4カメラ切替での本格的な配信</td>
            </tr>
            <tr>
              <td>プレミアム配信</td>
              <td><span class="price price-accent">¥120,000〜</span></td>
              <td>マルチカメラ+特殊効果を使った映像演出付き配信</td>
            </tr>
          </tbody>
        </table>
        
        <p class="pricing-note">※配信プランはスペース利用料に追加する形で提供されます。</p>
        <p class="pricing-note">※配信オペレーター、配信機材の利用料が含まれています。</p>
        <p class="pricing-note">※配信プラットフォーム（YouTube、ニコニコ動画など）への接続設定もサポートいたします。</p>
      </div>
      
      <div class="pricing-content" id="other-content">
        <table class="pricing-table">
          <thead>
            <tr>
              <th>プラン名</th>
              <th>基本料金</th>
              <th>詳細</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>リハーサルプラン</td>
              <td><span class="price">¥3,000/時間〜</span></td>
              <td>機材のセッティングやリハーサルのための時間貸し</td>
            </tr>
            <tr>
              <td>撮影プラン</td>
              <td><span class="price">¥35,000〜</span></td>
              <td>プロモーション映像やMV撮影向けのプラン</td>
            </tr>
            <tr>
              <td>トークイベントプラン</td>
              <td><span class="price">¥45,000〜</span></td>
              <td>セミナーやトークショー向けの設備プラン</td>
            </tr>
            <tr>
              <td>レコーディングプラン</td>
              <td><span class="price price-accent">¥50,000〜</span></td>
              <td>ライブレコーディング対応プラン</td>
            </tr>
          </tbody>
        </table>
        
        <p class="pricing-note">※各プランは利用時間や必要機材によって料金が変動します。詳細はお問い合わせください。</p>
      </div>
    </div>

    <!-- System Section -->
    <div class="system-section">
      <h2 class="section-title">利用システム</h2>
      
      <div class="system-grid">
        <div class="system-card">
          <div class="system-icon">
            <i class="fas fa-music"></i>
          </div>
          <h3 class="system-title">ライブイベント</h3>
          <p class="system-text">
            バンド演奏からアコースティックライブ、DJイベントまで多様なスタイルに対応。
            プロフェッショナルな音響・照明設備と経験豊かなスタッフがイベントをサポートします。
            セッティングから本番、撤収までスムーズに進行できるよう、万全の体制を整えています。
          </p>
        </div>
        
        <div class="system-card">
          <div class="system-icon">
            <i class="fas fa-video"></i>
          </div>
          <h3 class="system-title">配信サポート</h3>
          <p class="system-text">
            高品質な配信環境を提供。専門スタッフによる配信サポートで、オンラインでも臨場感あるパフォーマンスを届けられます。
            複数カメラでの撮影や、ライブ映像のミキシング、各種配信プラットフォームへの接続など、
            ニーズに合わせた配信スタイルを実現します。
          </p>
        </div>
        
        <div class="system-card">
          <div class="system-icon">
            <i class="fas fa-microphone-alt"></i>
          </div>
          <h3 class="system-title">トークイベント</h3>
          <p class="system-text">
            トークショーやセミナー、ワークショップなどに最適な環境を提供。
            クリアな音響と快適な空間で、話者の声を確実に届けます。
            プロジェクターやスクリーンなどの映像設備も充実しており、
            プレゼンテーションやデモンストレーションも効果的に行えます。
          </p>
        </div>
        
        <div class="system-card">
          <div class="system-icon">
            <i class="fas fa-users"></i>
          </div>
          <h3 class="system-title">設備・サポート</h3>
          <p class="system-text">
            最大100名を収容可能な空間で、着席スタイルやオールスタンディング、
            さらにはソーシャルディスタンスを考慮したレイアウトなど、イベントに合わせた設営が可能です。
            搬入からセッティング、本番中のサポート、撤収まで、経験豊富なスタッフがトータルサポートします。
          </p>
        </div>
      </div>
    </div>

    <!-- FAQ Section -->
    <div class="faq-section">
      <h2 class="section-title">よくある質問</h2>
      
      <div class="faq-list">
        <div class="faq-item">
          <div class="faq-question">
            <span>予約はどのように行えばよいですか？</span>
            <span class="faq-icon"><i class="fas fa-plus"></i></span>
          </div>
          <div class="faq-answer">
            <div class="faq-answer-inner">
              予約はお電話（052-241-7772）または公式サイトのお問い合わせフォームから受け付けております。
              希望日時、イベント内容、参加予定人数などをお知らせください。
              空き状況を確認後、担当スタッフよりご連絡いたします。
            </div>
          </div>
        </div>
        
        <div class="faq-item">
          <div class="faq-question">
            <span>キャンセル料はかかりますか？</span>
            <span class="faq-icon"><i class="fas fa-plus"></i></span>
          </div>
          <div class="faq-answer">
            <div class="faq-answer-inner">
              キャンセル料は以下の通りです：<br>
              - 利用日の30日前まで：キャンセル料なし<br>
              - 利用日の29〜15日前：基本料金の30%<br>
              - 利用日の14〜7日前：基本料金の50%<br>
              - 利用日の6日前〜当日：基本料金の100%<br>
              ※感染症や災害による中止の場合は、別途ご相談ください。
            </div>
          </div>
        </div>
        
        <div class="faq-item">
          <div class="faq-question">
            <span>機材の持ち込みは可能ですか？</span>
            <span class="faq-icon"><i class="fas fa-plus"></i></span>
          </div>
          <div class="faq-answer">
            <div class="faq-answer-inner">
              基本的に機材の持ち込みは可能です。ただし、事前に持ち込み機材の詳細をお知らせいただき、
              当会場のシステムとの互換性や安全性を確認させていただきます。
              特に電源容量や接続方法に関しては、事前の確認が必要です。
            </div>
          </div>
        </div>
        
        <div class="faq-item">
          <div class="faq-question">
            <span>飲食物の持ち込みや販売はできますか？</span>
            <span class="faq-icon"><i class="fas fa-plus"></i></span>
          </div>
          <div class="faq-answer">
            <p>
              飲食物の持ち込みは基本的に可能ですが、会場内での調理は安全上の理由からご遠慮いただいております。
              物販に関しては、事前にご相談いただければ対応可能です。
              また、アルコール提供を伴うイベントの場合は、別途許可が必要となりますので、お申し込み時にご相談ください。
            </p>
          </div>
        </div>
        
        <div class="faq-item">
          <div class="faq-question">
            <span>駐車場はありますか？</span>
            <span class="faq-icon"><i class="fas fa-plus"></i></span>
          </div>
          <div class="faq-answer">
            <p>
              会場専用の駐車場はございませんが、近隣に複数のコインパーキングがございます。
              機材搬入などの際は、ホテル敷地内の一時停車スペースをご利用いただける場合がありますので、
              事前にお問い合わせください。
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact CTA -->
    <div class="contact-cta">
      <div class="cta-content">
        <h2 class="cta-title">CONTACT US</h2>
        <p class="cta-text">
          具体的な料金やシステムについてのご質問や、ご予約のお問い合わせはこちらから。
          皆様のイベントにぴったりの提案をさせていただきます。
        </p>
        <div class="cta-buttons">
          <a href="<?php echo esc_url(home_url('/#contact')); ?>" class="btn btn-accent">お問い合わせ</a>
          <a href="<?php echo esc_url(site_url('/equipment/')); ?>" class="btn btn-outline">設備リストを見る</a>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
