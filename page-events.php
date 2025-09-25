<?php
/**
 * Template for Events page
 *
 * @package Logic_Nagoya
 */

get_header();
?>

<main id="primary" class="site-main events-page">
    
    <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <!-- Hero Section -->
            <section class="events-hero">
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

            <!-- Events List Section -->
            <section class="events-list">
                <div class="container">
                    <h2><?php esc_html_e( 'イベント一覧', 'logic-nagoya' ); ?></h2>
                    
                    <?php
                    // Query events
                    $events_query = new WP_Query(array(
                        'post_type' => 'event',
                        'posts_per_page' => 12,
                        'post_status' => 'publish',
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ));

                    if ( $events_query->have_posts() ) :
                    ?>
                        <div class="events-grid">
                            <?php while ( $events_query->have_posts() ) : $events_query->the_post(); ?>
                                <div class="event-card">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="event-thumbnail">
                                            <a href="<?php echo esc_url( get_permalink() ); ?>">
                                                <?php the_post_thumbnail( 'medium' ); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="event-content">
                                        <h3 class="event-title">
                                            <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                                        </h3>
                                        
                                        <div class="event-meta">
                                            <time class="event-date"><?php echo esc_html( get_the_date() ); ?></time>
                                            <?php
                                            $event_categories = get_the_terms( get_the_ID(), 'event_category' );
                                            if ( $event_categories && ! is_wp_error( $event_categories ) ) :
                                            ?>
                                                <div class="event-categories">
                                                    <?php foreach ( $event_categories as $category ) : ?>
                                                        <span class="event-category"><?php echo esc_html( $category->name ); ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if ( has_excerpt() ) : ?>
                                            <div class="event-excerpt">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="event-link">
                                            <?php esc_html_e( '詳細を見る', 'logic-nagoya' ); ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        
                        <?php
                        // Pagination
                        $total_pages = $events_query->max_num_pages;
                        if ( $total_pages > 1 ) :
                        ?>
                            <div class="events-pagination">
                                <?php
                                echo paginate_links(array(
                                    'total' => $total_pages,
                                    'current' => max(1, get_query_var('paged')),
                                    'prev_text' => esc_html__( '« 前のページ', 'logic-nagoya' ),
                                    'next_text' => esc_html__( '次のページ »', 'logic-nagoya' ),
                                ));
                                ?>
                            </div>
                        <?php endif; ?>
                        
                    <?php else : ?>
                        <div class="no-events">
                            <p><?php esc_html_e( 'イベントが見つかりませんでした。', 'logic-nagoya' ); ?></p>
                        </div>
                    <?php
                    endif;
                    wp_reset_postdata();
                    ?>
                </div>
            </section>

        </article>

    <?php endwhile; // End of the loop. ?>

</main>

<?php
get_sidebar();
get_footer();
