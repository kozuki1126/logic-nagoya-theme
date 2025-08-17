<?php
/**
 * Template for System & Pricing page
 *
 * @package Logic_Nagoya
 */

get_header();
?>

<main id="primary" class="site-main system-pricing-page">
    
    <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <!-- Hero Section -->
            <section class="system-pricing-hero">
                <div class="container">
                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        <?php if ( has_excerpt() ) : ?>
                            <div class="entry-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                    </header>
                </div>
            </section>

            <!-- Main Content -->
            <section class="entry-content">
                <div class="container">
                    <?php
                    the_content();

                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'logic-nagoya' ),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>
            </section>

            <!-- Pricing Tables Section -->
            <section class="pricing-section">
                <div class="container">
                    <h2><?php esc_html_e( '料金体系', 'logic-nagoya' ); ?></h2>
                    
                    <div class="pricing-tables">
                        <!-- This would typically be populated via custom fields or content blocks -->
                        <div class="pricing-table">
                            <h3><?php esc_html_e( '基本プラン', 'logic-nagoya' ); ?></h3>
                            <div class="price">
                                <span class="currency">¥</span>
                                <span class="amount">15,000</span>
                                <span class="period">/月</span>
                            </div>
                            <ul class="features">
                                <li><?php esc_html_e( '基本設備利用', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( '24時間アクセス', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( 'フリードリンク', 'logic-nagoya' ); ?></li>
                            </ul>
                        </div>
                        
                        <div class="pricing-table featured">
                            <h3><?php esc_html_e( 'プレミアムプラン', 'logic-nagoya' ); ?></h3>
                            <div class="price">
                                <span class="currency">¥</span>
                                <span class="amount">25,000</span>
                                <span class="period">/月</span>
                            </div>
                            <ul class="features">
                                <li><?php esc_html_e( '全設備利用', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( '24時間アクセス', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( 'フリードリンク', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( '専用ロッカー', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( '会議室利用権', 'logic-nagoya' ); ?></li>
                            </ul>
                        </div>
                        
                        <div class="pricing-table">
                            <h3><?php esc_html_e( 'ビジネスプラン', 'logic-nagoya' ); ?></h3>
                            <div class="price">
                                <span class="currency">¥</span>
                                <span class="amount">50,000</span>
                                <span class="period">/月</span>
                            </div>
                            <ul class="features">
                                <li><?php esc_html_e( '全設備利用', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( '24時間アクセス', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( 'フリードリンク', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( '専用オフィス', 'logic-nagoya' ); ?></li>
                                <li><?php esc_html_e( '法人登記可能', 'logic-nagoya' ); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- System Information Section -->
            <section class="system-info-section">
                <div class="container">
                    <h2><?php esc_html_e( 'システム・設備', 'logic-nagoya' ); ?></h2>
                    
                    <div class="system-grid">
                        <div class="system-item">
                            <h3><?php esc_html_e( 'セキュリティシステム', 'logic-nagoya' ); ?></h3>
                            <p><?php esc_html_e( '24時間セキュリティシステムで安心してご利用いただけます。', 'logic-nagoya' ); ?></p>
                        </div>
                        
                        <div class="system-item">
                            <h3><?php esc_html_e( 'ネットワーク環境', 'logic-nagoya' ); ?></h3>
                            <p><?php esc_html_e( '高速Wi-Fi、有線LAN環境を完備しています。', 'logic-nagoya' ); ?></p>
                        </div>
                        
                        <div class="system-item">
                            <h3><?php esc_html_e( 'アクセス管理', 'logic-nagoya' ); ?></h3>
                            <p><?php esc_html_e( 'ICカードによる入退室管理システムを導入しています。', 'logic-nagoya' ); ?></p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section (conditional loading) -->
            <?php if ( logic_nagoya_needs_faq() ) : ?>
            <section class="faq-section">
                <div class="container">
                    <h2><?php esc_html_e( 'よくある質問', 'logic-nagoya' ); ?></h2>
                    
                    <div class="faq-items">
                        <div class="faq-item">
                            <h3 class="faq-question"><?php esc_html_e( '料金の支払い方法は？', 'logic-nagoya' ); ?></h3>
                            <div class="faq-answer">
                                <p><?php esc_html_e( '月額料金は銀行振込、クレジットカードでのお支払いが可能です。', 'logic-nagoya' ); ?></p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <h3 class="faq-question"><?php esc_html_e( '契約期間はありますか？', 'logic-nagoya' ); ?></h3>
                            <div class="faq-answer">
                                <p><?php esc_html_e( '最低契約期間は3ヶ月となっています。', 'logic-nagoya' ); ?></p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <h3 class="faq-question"><?php esc_html_e( '見学は可能ですか？', 'logic-nagoya' ); ?></h3>
                            <div class="faq-answer">
                                <p><?php esc_html_e( 'はい、事前にご予約いただければ見学可能です。お気軽にお問い合わせください。', 'logic-nagoya' ); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php endif; ?>

        </article>

    <?php endwhile; // End of the loop. ?>

</main>

<?php
get_sidebar();
get_footer();
