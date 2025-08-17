<?php
/**
 * Template for About page
 *
 * @package Logic_Nagoya
 */

get_header();
?>

<main id="primary" class="site-main about-page">
    
    <?php while ( have_posts() ) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <!-- Hero Section -->
            <section class="about-hero">
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

            <!-- Concept Image Section -->
            <?php 
            $concept_image = get_post_meta( get_the_ID(), '_logic_nagoya_concept_image', true );
            if ( $concept_image ) : 
            ?>
            <section class="concept-section">
                <div class="container">
                    <div class="concept-image">
                        <?php echo wp_get_attachment_image( $concept_image, 'large', false, array( 'alt' => get_the_title() . ' concept' ) ); ?>
                    </div>
                </div>
            </section>
            <?php endif; ?>

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

            <!-- FAQ Section (if needed) -->
            <?php if ( logic_nagoya_needs_faq() ) : ?>
            <section class="faq-section">
                <div class="container">
                    <h2><?php esc_html_e( 'よくある質問', 'logic-nagoya' ); ?></h2>
                    <!-- FAQ content will be added here -->
                    <div class="faq-placeholder">
                        <p><?php esc_html_e( 'FAQ content coming soon...', 'logic-nagoya' ); ?></p>
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
