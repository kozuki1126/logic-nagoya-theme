<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Logic_Nagoya
 */

// Direct access protection
defined('ABSPATH') || exit;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function logic_nagoya_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'logic_nagoya_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function logic_nagoya_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'logic_nagoya_pingback_header' );

/**
 * Custom template include function for page slug to template mapping
 * 
 * @param string $template The path to the template file
 * @return string The modified template path
 */
function logic_nagoya_template_include( $template ) {
	// Only apply to pages
	if ( ! is_page() ) {
		return $template;
	}

	global $post;
	
	// Get page slug
	$page_slug = $post->post_name;
	
	// Template mapping based on page slug
	$template_map = array(
		'about'            => 'page-about.php',
		'events'           => 'page-events.php',
		'equipment-list'   => 'page-equipment-list.php',
		'equipment'        => 'page-equipment.php',
		'floor-map'        => 'page-floor-map.php',
		'system-pricing'   => 'page-system-pricing.php',
		'access'           => 'page-access.php',
	);
	
	// Check if we have a custom template for this slug
	if ( isset( $template_map[ $page_slug ] ) ) {
		$custom_template = locate_template( $template_map[ $page_slug ] );
		if ( $custom_template ) {
			return $custom_template;
		}
	}
	
	// Return default template if no custom template found
	return $template;
}
add_filter( 'template_include', 'logic_nagoya_template_include' );

/**
 * Add page-specific body classes based on template
 */
function logic_nagoya_page_body_classes( $classes ) {
	if ( is_page() ) {
		global $post;
		$page_slug = $post->post_name;
		
		// Add page-specific class
		$classes[] = 'page-' . $page_slug;
		
		// Add template-specific classes
		$template_classes = array(
			'about'            => 'has-concept-image',
			'events'           => 'has-events-grid',
			'equipment-list'   => 'has-equipment-list',
			'equipment'        => 'has-equipment-pdf',
			'floor-map'        => 'has-floor-plan',
			'system-pricing'   => 'has-pricing-tables has-faq',
			'access'           => 'has-map',
		);
		
		if ( isset( $template_classes[ $page_slug ] ) ) {
			$additional_classes = explode( ' ', $template_classes[ $page_slug ] );
			$classes = array_merge( $classes, $additional_classes );
		}
	}
	
	return $classes;
}
add_filter( 'body_class', 'logic_nagoya_page_body_classes' );

/**
 * Check if current page needs specific CSS/JS loading
 * 
 * @param string $asset_type Type of asset ('css' or 'js')
 * @param string $asset_name Name of the specific asset
 * @return bool Whether the asset should be loaded
 */
function logic_nagoya_needs_asset( $asset_type, $asset_name ) {
	if ( ! is_page() ) {
		return false;
	}
	
	global $post;
	$page_slug = $post->post_name;
	
	// Asset requirements mapping
	$asset_requirements = array(
		'css' => array(
			'faq' => array( 'about', 'system-pricing' ),
			'equipment' => array( 'equipment', 'equipment-list' ),
			'events' => array( 'events' ),
			'pricing' => array( 'system-pricing' ),
		),
		'js' => array(
			'faq' => array( 'about', 'system-pricing' ),
			'equipment' => array( 'equipment', 'equipment-list' ),
			'map' => array( 'access' ),
		)
	);
	
	if ( isset( $asset_requirements[ $asset_type ][ $asset_name ] ) ) {
		return in_array( $page_slug, $asset_requirements[ $asset_type ][ $asset_name ], true );
	}
	
	return false;
}
