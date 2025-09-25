<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Logic_Nagoya
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404 not-found">
        <div class="container error-container">
            <div class="error-content">
                <h1 class="error-title">404</h1>
                <h2 class="error-subtitle"><?php esc_html_e( 'ページが見つかりません', 'logic-nagoya' ); ?></h2>
                <div class="error-description">
                    <p><?php esc_html_e( 'お探しのページは移動したか削除された可能性があります。', 'logic-nagoya' ); ?></p>
                </div>
                <div class="error-actions">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                        <i class="fas fa-home"></i> <?php esc_html_e( 'ホームに戻る', 'logic-nagoya' ); ?>
                    </a>
                </div>
                
                <div class="error-search">
                    <h3><?php esc_html_e( 'サイト内を検索', 'logic-nagoya' ); ?></h3>
                    <?php get_search_form(); ?>
                </div>
                
                <div class="error-recent">
                    <h3><?php esc_html_e( '最近の投稿', 'logic-nagoya' ); ?></h3>
                    <ul class="recent-posts">
                        <?php
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 5,
                            'post_status' => 'publish'
                        ));
                        
                        foreach ($recent_posts as $recent) {
                            printf(
                                '<li><a href="%1$s">%2$s</a></li>',
                                esc_url(get_permalink($recent['ID'])),
                                esc_html($recent['post_title'])
                            );
                        }
                        wp_reset_postdata();
                        ?>
                    </ul>
                </div>
                
                <div class="error-upcoming-events">
                    <h3><?php esc_html_e( '今後のイベント', 'logic-nagoya' ); ?></h3>
                    <ul class="upcoming-events">
                        <?php
                        $today = current_time('Y-m-d');
                        $upcoming_events = new WP_Query(array(
                            'post_type' => 'event',
                            'posts_per_page' => 3,
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
                        ));
                        
                        if ($upcoming_events->have_posts()) :
                            while ($upcoming_events->have_posts()) : $upcoming_events->the_post();
                                $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                                if ($event_date) {
                                    $formatted_date = date_i18n(get_option('date_format'), strtotime($event_date));
                                } else {
                                    $formatted_date = '';
                                }
                                
                                printf(
                                    '<li><a href="%1$s">%2$s - %3$s</a></li>',
                                    esc_url(get_permalink()),
                                    esc_html($formatted_date),
                                    esc_html(get_the_title())
                                );
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<li>' . esc_html__('現在予定されているイベントはありません。', 'logic-nagoya') . '</li>';
                        endif;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main><!-- #main -->

<style>
.error-container {
    padding: 180px 30px 100px;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    text-align: center;
}

.error-content {
    max-width: 800px;
    margin: 0 auto;
}

.error-title {
    font-size: 12rem;
    font-weight: 700;
    margin: 0;
    line-height: 1;
    background: linear-gradient(to bottom right, var(--primary), var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    animation: fadeInDown 1s;
}

.error-subtitle {
    font-size: 2.5rem;
    margin: 20px 0 30px;
    font-weight: 300;
    animation: fadeInUp 1s 0.2s forwards;
    opacity: 0;
}

.error-description {
    font-size: 1.2rem;
    margin-bottom: 40px;
    color: rgba(255, 255, 255, 0.8);
    animation: fadeInUp 1s 0.4s forwards;
    opacity: 0;
}

.error-actions {
    margin-bottom: 60px;
    animation: fadeInUp 1s 0.6s forwards;
    opacity: 0;
}

.error-actions .btn {
    padding: 15px 30px;
    font-size: 1.1rem;
}

.error-search, .error-recent, .error-upcoming-events {
    margin-top: 50px;
    padding-top: 30px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    animation: fadeInUp 1s 0.8s forwards;
    opacity: 0;
}

.error-search .search-form {
    display: flex;
    max-width: 500px;
    margin: 20px auto;
}

.error-search .search-field {
    flex: 1;
    padding: 12px 15px;
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: var(--light);
    border-radius: 0;
    transition: var(--transition);
}

.error-search .search-field:focus {
    outline: none;
    border-color: var(--primary);
    background-color: rgba(255, 255, 255, 0.15);
}

.error-search .search-submit {
    padding: 12px 20px;
    background-color: var(--primary);
    border: none;
    color: white;
    cursor: pointer;
    transition: var(--transition);
}

.error-search .search-submit:hover {
    background-color: var(--accent);
}

.recent-posts, .upcoming-events {
    list-style: none;
    padding: 0;
    margin: 20px 0;
    text-align: left;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.recent-posts li, .upcoming-events li {
    padding: 10px 15px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    transition: var(--transition);
}

.recent-posts li:hover, .upcoming-events li:hover {
    background-color: rgba(255, 255, 255, 0.05);
}

.recent-posts li a, .upcoming-events li a {
    color: var(--light);
    text-decoration: none;
    transition: var(--transition);
    display: block;
}

.recent-posts li a:hover, .upcoming-events li a:hover {
    color: var(--primary);
}

@media screen and (max-width: 768px) {
    .error-container {
        padding-top: 120px;
        padding-bottom: 60px;
    }
    
    .error-title {
        font-size: 8rem;
    }
    
    .error-subtitle {
        font-size: 1.8rem;
    }
    
    .error-description {
        font-size: 1rem;
    }
    
    .error-search .search-form {
        flex-direction: column;
    }
    
    .error-search .search-submit {
        margin-top: 10px;
    }
}
</style>

<?php
get_footer();
