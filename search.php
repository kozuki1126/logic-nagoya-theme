<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Logic_Nagoya
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container search-container">
        <header class="page-header">
            <h1 class="search-title">
                <?php
                /* translators: %s: search query. */
                printf( esc_html__( '「%s」の検索結果', 'logic-nagoya' ), '<span>' . get_search_query() . '</span>' );
                ?>
            </h1>
            <div class="search-meta">
                <?php
                global $wp_query;
                $result_count = $wp_query->found_posts;
                
                printf(
                    esc_html( _n( '%s件の結果が見つかりました', '%s件の結果が見つかりました', $result_count, 'logic-nagoya' ) ),
                    number_format_i18n( $result_count )
                );
                ?>
            </div>
            
            <div class="search-form-container">
                <?php get_search_form(); ?>
            </div>
        </header><!-- .page-header -->

        <?php if ( have_posts() ) : ?>
            <div class="search-results-container">
                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overwrite this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
                        <div class="search-result-inner">
                            <?php if ( has_post_thumbnail() ) : ?>
                            <div class="search-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                            <?php endif; ?>
                            
                            <div class="search-content">
                                <header class="search-entry-header">
                                    <?php the_title( sprintf( '<h2 class="search-entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

                                    <?php if ( 'post' === get_post_type() ) : ?>
                                    <div class="search-entry-meta">
                                        <?php
                                        // 投稿日と著者を表示
                                        echo '<span class="search-post-date"><i class="fas fa-calendar-alt"></i> ';
                                        echo get_the_date();
                                        echo '</span>';
                                        
                                        echo '<span class="search-post-author"><i class="fas fa-user"></i> ';
                                        the_author();
                                        echo '</span>';
                                        
                                        // カテゴリーがあれば表示
                                        $categories_list = get_the_category_list( esc_html__( ', ', 'logic-nagoya' ) );
                                        if ( $categories_list ) {
                                            echo '<span class="search-post-categories"><i class="fas fa-folder"></i> ';
                                            echo $categories_list;
                                            echo '</span>';
                                        }
                                        ?>
                                    </div><!-- .search-entry-meta -->
                                    <?php elseif ( 'event' === get_post_type() ) : ?>
                                    <div class="search-entry-meta">
                                        <?php
                                        // イベント日付があれば表示
                                        $event_date = get_post_meta( get_the_ID(), 'event_date', true );
                                        if ( $event_date ) {
                                            echo '<span class="search-event-date"><i class="fas fa-calendar-alt"></i> ';
                                            echo date_i18n( get_option( 'date_format' ), strtotime( $event_date ) );
                                            echo '</span>';
                                        }
                                        
                                        // イベント時間があれば表示
                                        $event_time = get_post_meta( get_the_ID(), 'event_time', true );
                                        if ( $event_time ) {
                                            echo '<span class="search-event-time"><i class="fas fa-clock"></i> ';
                                            echo esc_html( $event_time );
                                            echo '</span>';
                                        }
                                        
                                        // イベントカテゴリーがあれば表示
                                        $event_categories = get_the_term_list( get_the_ID(), 'event_category', '', ', ', '' );
                                        if ( $event_categories ) {
                                            echo '<span class="search-event-categories"><i class="fas fa-tag"></i> ';
                                            echo $event_categories;
                                            echo '</span>';
                                        }
                                        ?>
                                    </div><!-- .search-entry-meta -->
                                    <?php endif; ?>
                                </header><!-- .search-entry-header -->

                                <div class="search-entry-summary">
                                    <?php the_excerpt(); ?>
                                </div><!-- .search-entry-summary -->

                                <footer class="search-entry-footer">
                                    <a href="<?php the_permalink(); ?>" class="read-more-link">
                                        <?php echo esc_html__( '続きを読む', 'logic-nagoya' ); ?> <i class="fas fa-arrow-right"></i>
                                    </a>
                                </footer><!-- .search-entry-footer -->
                            </div><!-- .search-content -->
                        </div><!-- .search-result-inner -->
                    </article><!-- #post-<?php the_ID(); ?> -->
                    <?php
                endwhile;
                ?>
            </div><!-- .search-results-container -->

            <div class="pagination search-pagination">
                <?php 
                the_posts_pagination( array(
                    'mid_size' => 2,
                    'prev_text' => '<i class="fas fa-chevron-left"></i>',
                    'next_text' => '<i class="fas fa-chevron-right"></i>',
                ) ); 
                ?>
            </div>

        <?php else : ?>

            <div class="no-search-results">
                <div class="no-results-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h2 class="no-results-title"><?php esc_html_e( '検索結果が見つかりませんでした', 'logic-nagoya' ); ?></h2>
                <div class="no-results-content">
                    <p><?php esc_html_e( '検索キーワードに一致するコンテンツが見つかりませんでした。別のキーワードで試してみてください。', 'logic-nagoya' ); ?></p>
                </div>
                
                <div class="no-results-suggestions">
                    <h3><?php esc_html_e( '検索のヒント:', 'logic-nagoya' ); ?></h3>
                    <ul>
                        <li><?php esc_html_e( 'スペルを確認してください。', 'logic-nagoya' ); ?></li>
                        <li><?php esc_html_e( '別のキーワードを試してみてください。', 'logic-nagoya' ); ?></li>
                        <li><?php esc_html_e( 'より一般的な単語を使用してください。', 'logic-nagoya' ); ?></li>
                        <li><?php esc_html_e( 'キーワードの数を減らしてみてください。', 'logic-nagoya' ); ?></li>
                    </ul>
                </div>
                
                <div class="no-results-explore">
                    <h3><?php esc_html_e( '以下のコンテンツも探索してみてください:', 'logic-nagoya' ); ?></h3>
                    <div class="no-results-actions">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-outline">
                            <i class="fas fa-home"></i> <?php esc_html_e( 'ホームページ', 'logic-nagoya' ); ?>
                        </a>
                        
                        <?php
                        // イベントページへのリンクがあれば表示
                        $events_page = get_page_by_path( 'events' );
                        if ( $events_page ) :
                        ?>
                        <a href="<?php echo esc_url( get_permalink( $events_page->ID ) ); ?>" class="btn btn-outline">
                            <i class="fas fa-calendar-alt"></i> <?php esc_html_e( 'イベント', 'logic-nagoya' ); ?>
                        </a>
                        <?php endif; ?>
                        
                        <?php
                        // お問い合わせページへのリンクがあれば表示
                        $contact_page = get_page_by_path( 'contact' );
                        if ( $contact_page ) :
                        ?>
                        <a href="<?php echo esc_url( get_permalink( $contact_page->ID ) ); ?>" class="btn btn-outline">
                            <i class="fas fa-envelope"></i> <?php esc_html_e( 'お問い合わせ', 'logic-nagoya' ); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div><!-- .no-search-results -->

        <?php endif; ?>
    </div><!-- .container -->
</main><!-- #main -->

<style>
.search-container {
    padding: 160px 30px 80px;
    min-height: 60vh;
}

.search-title {
    font-size: 2.5rem;
    margin-bottom: 15px;
    font-weight: 500;
    color: var(--light);
    animation: fadeInDown 0.8s;
}

.search-title span {
    color: var(--primary);
}

.search-meta {
    font-size: 1.1rem;
    margin-bottom: 30px;
    color: rgba(255, 255, 255, 0.8);
    animation: fadeInUp 0.8s;
}

.search-form-container {
    margin-bottom: 40px;
    max-width: 600px;
    animation: fadeInUp 0.8s 0.2s forwards;
    opacity: 0;
}

.search-form {
    display: flex;
    width: 100%;
}

.search-field {
    flex: 1;
    padding: 12px 15px;
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: var(--light);
    border-radius: 0;
    transition: var(--transition);
}

.search-field:focus {
    outline: none;
    border-color: var(--primary);
    background-color: rgba(255, 255, 255, 0.15);
}

.search-submit {
    padding: 12px 20px;
    background-color: var(--primary);
    border: none;
    color: white;
    cursor: pointer;
    transition: var(--transition);
}

.search-submit:hover {
    background-color: var(--accent);
}

.search-results-container {
    margin-bottom: 50px;
}

.search-result-item {
    margin-bottom: 30px;
    background-color: rgba(255, 255, 255, 0.05);
    transition: var(--transition);
    animation: fadeInUp 0.8s forwards;
    opacity: 0;
}

.search-result-item:nth-child(2) {
    animation-delay: 0.1s;
}

.search-result-item:nth-child(3) {
    animation-delay: 0.2s;
}

.search-result-item:nth-child(4) {
    animation-delay: 0.3s;
}

.search-result-item:nth-child(5) {
    animation-delay: 0.4s;
}

.search-result-item:hover {
    background-color: rgba(255, 255, 255, 0.08);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.search-result-inner {
    display: flex;
    flex-wrap: wrap;
}

.search-thumbnail {
    width: 250px;
    overflow: hidden;
}

.search-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.search-result-item:hover .search-thumbnail img {
    transform: scale(1.05);
}

.search-content {
    flex: 1;
    padding: 25px;
}

.search-entry-title {
    font-size: 1.5rem;
    margin-bottom: 10px;
}

.search-entry-title a {
    color: var(--light);
    text-decoration: none;
    transition: var(--transition);
}

.search-entry-title a:hover {
    color: var(--primary);
}

.search-entry-meta {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 15px;
}

.search-entry-meta span {
    margin-right: 15px;
}

.search-entry-meta i {
    margin-right: 5px;
    color: var(--primary);
}

.search-entry-summary {
    margin-bottom: 20px;
    color: rgba(255, 255, 255, 0.9);
}

.search-entry-footer {
    text-align: right;
}

.read-more-link {
    display: inline-block;
    padding: 8px 15px;
    color: var(--light);
    background-color: rgba(255, 255, 255, 0.1);
    text-decoration: none;
    transition: var(--transition);
    font-size: 0.9rem;
}

.read-more-link:hover {
    background-color: var(--primary);
    color: white;
}

.read-more-link i {
    margin-left: 5px;
    transition: var(--transition);
}

.read-more-link:hover i {
    transform: translateX(3px);
}

.search-pagination {
    margin-top: 40px;
    text-align: center;
}

.pagination .page-numbers {
    display: inline-block;
    padding: 8px 15px;
    margin: 0 3px;
    background-color: rgba(255, 255, 255, 0.1);
    color: var(--light);
    text-decoration: none;
    transition: var(--transition);
}

.pagination .page-numbers.current {
    background-color: var(--primary);
    color: white;
}

.pagination .page-numbers:hover {
    background-color: var(--primary);
    color: white;
}

/* 検索結果がない場合のスタイル */
.no-search-results {
    text-align: center;
    padding: 50px 20px;
    animation: fadeIn 1s;
}

.no-results-icon {
    font-size: 4rem;
    color: var(--primary);
    margin-bottom: 20px;
    opacity: 0.8;
}

.no-results-title {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: var(--light);
}

.no-results-content {
    font-size: 1.1rem;
    margin-bottom: 30px;
    color: rgba(255, 255, 255, 0.8);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.no-results-suggestions {
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.no-results-suggestions h3 {
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: var(--light);
}

.no-results-suggestions ul {
    text-align: left;
    list-style-type: disc;
    padding-left: 20px;
    color: rgba(255, 255, 255, 0.8);
}

.no-results-suggestions li {
    margin-bottom: 5px;
}

.no-results-explore {
    margin-top: 40px;
}

.no-results-explore h3 {
    font-size: 1.3rem;
    margin-bottom: 20px;
    color: var(--light);
}

.no-results-actions {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
}

.no-results-actions .btn {
    margin: 5px;
}

@media screen and (max-width: 768px) {
    .search-container {
        padding: 120px 20px 60px;
    }
    
    .search-title {
        font-size: 1.8rem;
    }
    
    .search-form {
        flex-direction: column;
    }
    
    .search-submit {
        margin-top: 10px;
    }
    
    .search-result-inner {
        flex-direction: column;
    }
    
    .search-thumbnail {
        width: 100%;
        max-height: 200px;
    }
    
    .search-content {
        padding: 20px;
    }
    
    .search-entry-title {
        font-size: 1.3rem;
    }
}
</style>

<?php
get_footer();
