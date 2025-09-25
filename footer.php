<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Logic_Nagoya
 */

// Direct access protection
defined('ABSPATH') || exit;

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'logic-nagoya' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'logic-nagoya' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( 
					esc_html__( 'Theme: %1$s by %2$s.', 'logic-nagoya' ), 
					'Logic Nagoya', 
					sprintf(
						'<a href="%s">%s</a>',
						esc_url( '#' ),
						esc_html__( 'Logic Nagoya Team', 'logic-nagoya' )
					)
				);
				?>

		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
