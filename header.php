<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Logic_Nagoya
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

  <!-- Loader -->
  <div class="loader">
    <div class="loader-content">
      <img src="<?php echo esc_url( get_theme_mod( 'logic_nagoya_loader_logo', get_template_directory_uri() . '/assets/images/logo.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="loader-logo">
      <div class="loader-spinner"></div>
    </div>
  </div>

  <!-- Header -->
  <header class="header">
    <div class="container">
      <div class="header-inner">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-link">
          <?php 
          if ( has_custom_logo() ) :
            the_custom_logo();
          else : 
          ?>
            <img src="<?php echo esc_url( get_theme_mod( 'logic_nagoya_site_logo', get_template_directory_uri() . '/assets/images/logo.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="logo">
          <?php endif; ?>
        </a>
        <div class="menu-toggle">
          <i class="fas fa-bars"></i>
        </div>
        <nav class="main-navigation">
          <?php
          wp_nav_menu(
            array(
              'theme_location' => 'menu-1',
              'menu_id'        => 'primary-menu',
              'container'      => false,
              'menu_class'     => 'nav-links',
              'fallback_cb'    => 'logic_nagoya_default_menu',
            )
          );
          ?>
        </nav>
      </div>
    </div>
  </header>