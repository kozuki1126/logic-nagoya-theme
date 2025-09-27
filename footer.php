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

?>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="footer-container">
        <div class="footer-logo">
          <img src="<?php echo esc_url( get_theme_mod( 'logic_nagoya_footer_logo', get_template_directory_uri() . '/assets/images/logo.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>">
          <p class="footer-about">
            <?php echo esc_html( get_theme_mod( 'logic_nagoya_footer_text', '名古屋栄のライブハウス「Logic Nagoya」は、ライブやトークショー、配信など様々な用途でご利用いただける多目的スペースです。' ) ); ?>
          </p>
        </div>
        
        <div class="footer-nav">
          <h3 class="footer-heading"><?php esc_html_e( 'メニュー', 'logic-nagoya' ); ?></h3>
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'footer-menu',
              'menu_id'        => 'footer-menu',
              'container'      => false,
              'menu_class'     => 'footer-links',
              'fallback_cb'    => '__return_false',
            )
          );
          ?>
        </div>
        
        <div class="footer-contact">
          <h3 class="footer-heading"><?php esc_html_e( 'お問い合わせ', 'logic-nagoya' ); ?></h3>
          <div class="footer-contact-item">
            <div class="footer-contact-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <p><?php echo esc_html( get_theme_mod( 'logic_nagoya_address', '愛知県名古屋市中区栄3-13-31' ) ); ?></p>
          </div>
          <div class="footer-contact-item">
            <div class="footer-contact-icon">
              <i class="fas fa-phone-alt"></i>
            </div>
            <p><?php echo esc_html( get_theme_mod( 'logic_nagoya_phone', '052-241-7772' ) ); ?></p>
          </div>
          <div class="footer-contact-item">
            <div class="footer-contact-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <p><?php echo esc_html( get_theme_mod( 'logic_nagoya_email', 'kozuki@logicnagoya.com' ) ); ?></p>
          </div>
        </div>
        
        <div class="footer-social">
          <h3 class="footer-heading"><?php esc_html_e( 'FOLLOW US', 'logic-nagoya' ); ?></h3>
          <p class="footer-social-description"><?php esc_html_e( '最新情報はSNSでもチェックできます。フォローして最新のイベント情報をゲット！', 'logic-nagoya' ); ?></p>
          <div class="footer-social-links">
            <?php if ( get_theme_mod( 'logic_nagoya_twitter' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'logic_nagoya_twitter' ) ); ?>" class="footer-social-link" target="_blank" rel="noopener noreferrer">
              <i class="fab fa-twitter"></i>
            </a>
            <?php endif; ?>

            <?php if ( get_theme_mod( 'logic_nagoya_facebook' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'logic_nagoya_facebook' ) ); ?>" class="footer-social-link" target="_blank" rel="noopener noreferrer">
              <i class="fab fa-facebook-f"></i>
            </a>
            <?php endif; ?>

            <?php if ( get_theme_mod( 'logic_nagoya_instagram' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'logic_nagoya_instagram' ) ); ?>" class="footer-social-link" target="_blank" rel="noopener noreferrer">
              <i class="fab fa-instagram"></i>
            </a>
            <?php endif; ?>

            <?php if ( get_theme_mod( 'logic_nagoya_youtube' ) ) : ?>
            <a href="<?php echo esc_url( get_theme_mod( 'logic_nagoya_youtube' ) ); ?>" class="footer-social-link" target="_blank" rel="noopener noreferrer">
              <i class="fab fa-youtube"></i>
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      
      <div class="footer-bottom">
        <p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'logic-nagoya' ); ?></p>
      </div>
    </div>
  </footer>

  <!-- Modal -->
  <div class="modal">
    <div class="modal-content">
      <img src="" alt="" class="modal-image">
    </div>
    <span class="modal-close"><i class="fas fa-times"></i></span>
  </div>

  <!-- Back to top button -->
  <div class="back-to-top">
    <i class="fas fa-chevron-up"></i>
  </div>

<?php wp_footer(); ?>

</body>
</html>
