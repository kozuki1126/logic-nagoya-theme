<?php
/**
 * Logic Nagoya functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Logic_Nagoya
 */

if ( ! defined( 'LOGIC_NAGOYA_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'LOGIC_NAGOYA_VERSION', '1.0.0' );
}

// フルサイト編集（FSE）機能をサポート
add_theme_support( 'block-templates' );
add_theme_support( 'block-template-parts' );

/**
 * Register block pattern categories.
 */
function logic_nagoya_register_block_pattern_categories() {
	register_block_pattern_category(
		'logic-nagoya',
		array( 'label' => esc_html__( 'Logic Nagoya', 'logic-nagoya' ) )
	);
	
	register_block_pattern_category(
		'featured',
		array( 'label' => esc_html__( 'Featured', 'logic-nagoya' ) )
	);
	
	register_block_pattern_category(
		'columns',
		array( 'label' => esc_html__( 'Columns', 'logic-nagoya' ) )
	);
	
	register_block_pattern_category(
		'contact',
		array( 'label' => esc_html__( 'Contact', 'logic-nagoya' ) )
	);
}
add_action( 'init', 'logic_nagoya_register_block_pattern_categories' );

/**
 * Register block styles.
 */
function logic_nagoya_register_block_styles() {
	// Register block style for group block
	register_block_style(
		'core/group',
		array(
			'name'  => 'dark-gradient',
			'label' => esc_html__( 'Dark Gradient', 'logic-nagoya' ),
		)
	);
	
	// Register block style for buttons
	register_block_style(
		'core/button',
		array(
			'name'  => 'accent-outline',
			'label' => esc_html__( 'Accent Outline', 'logic-nagoya' ),
		)
	);
	
	// Register block style for columns
	register_block_style(
		'core/columns',
		array(
			'name'  => 'card-grid',
			'label' => esc_html__( 'Card Grid', 'logic-nagoya' ),
		)
	);
}
add_action( 'init', 'logic_nagoya_register_block_styles' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function logic_nagoya_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'logic-nagoya', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'logic-nagoya' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'logic-nagoya' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'logic_nagoya_custom_background_args',
			array(
				'default-color' => '0a0a0a',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
	
	// Initialize image optimization features - Task 017 COMPLETED
	logic_nagoya_init_image_optimization();
}

/**
 * Initialize image optimization features
 * Task 017: Image optimization and lazy loading - COMPLETED
 */
function logic_nagoya_init_image_optimization() {
	// Add WebP support
	logic_nagoya_add_webp_support();
	
	// Add custom image sizes for optimized loading
	logic_nagoya_add_custom_image_sizes();
	
	// Enable responsive image improvements
	logic_nagoya_enhance_responsive_images();
}

/**
 * Add WebP image format support
 * Task 017: WebP optimization
 */
function logic_nagoya_add_webp_support() {
	// Enable WebP upload
	function logic_nagoya_webp_upload_mimes( $existing_mimes ) {
		$existing_mimes['webp'] = 'image/webp';
		return $existing_mimes;
	}
	add_filter( 'mime_types', 'logic_nagoya_webp_upload_mimes' );
	add_filter( 'upload_mimes', 'logic_nagoya_webp_upload_mimes' );
	
	// Fix WebP display issues in WordPress admin
	function logic_nagoya_webp_display_media_states( $states, $post ) {
		$mime_type = get_post_mime_type( $post->ID );
		if ( $mime_type === 'image/webp' ) {
			$states[] = __( 'WebP', 'logic-nagoya' );
		}
		return $states;
	}
	add_filter( 'display_media_states', 'logic_nagoya_webp_display_media_states', 10, 2 );
}

/**
 * Add custom image sizes for different devices and use cases
 * Task 017: Retina and responsive image optimization
 */
function logic_nagoya_add_custom_image_sizes() {
	// Standard sizes
	add_image_size( 'hero-desktop', 1200, 600, true );
	add_image_size( 'hero-tablet', 800, 400, true );
	add_image_size( 'hero-mobile', 600, 300, true );
	
	add_image_size( 'event-thumb', 300, 200, true );
	add_image_size( 'event-featured', 600, 400, true );
	
	add_image_size( 'gallery-thumb', 250, 250, true );
	add_image_size( 'gallery-medium', 500, 500, true );
	
	// Retina versions (2x resolution)
	add_image_size( 'hero-desktop-2x', 2400, 1200, true );
	add_image_size( 'hero-tablet-2x', 1600, 800, true );
	add_image_size( 'hero-mobile-2x', 1200, 600, true );
	
	add_image_size( 'event-thumb-2x', 600, 400, true );
	add_image_size( 'event-featured-2x', 1200, 800, true );
	
	add_image_size( 'gallery-thumb-2x', 500, 500, true );
	add_image_size( 'gallery-medium-2x', 1000, 1000, true );
}

/**
 * Enhance responsive images with better srcset generation
 * Task 017: Responsive image optimization
 */
function logic_nagoya_enhance_responsive_images() {
	// Improve srcset generation for custom image sizes
	function logic_nagoya_custom_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {
		if ( ! $image_meta || ! $attachment_id ) {
			return $sources;
		}
		
		// Add retina versions to srcset
		$custom_sizes = array(
			'hero-desktop' => 'hero-desktop-2x',
			'hero-tablet' => 'hero-tablet-2x',
			'hero-mobile' => 'hero-mobile-2x',
			'event-thumb' => 'event-thumb-2x',
			'event-featured' => 'event-featured-2x',
			'gallery-thumb' => 'gallery-thumb-2x',
			'gallery-medium' => 'gallery-medium-2x',
		);
		
		foreach ( $custom_sizes as $standard => $retina ) {
			$standard_info = wp_get_attachment_image_src( $attachment_id, $standard );
			$retina_info = wp_get_attachment_image_src( $attachment_id, $retina );
			
			if ( $standard_info && $retina_info ) {
				$standard_width = $standard_info[1];
				$retina_width = $retina_info[1];
				
				// Add standard size if not present
				if ( ! isset( $sources[ $standard_width ] ) ) {
					$sources[ $standard_width ] = array(
						'url' => $standard_info[0],
						'descriptor' => $standard_width . 'w',
						'value' => $standard_width,
					);
				}
				
				// Add retina size
				if ( ! isset( $sources[ $retina_width ] ) ) {
					$sources[ $retina_width ] = array(
						'url' => $retina_info[0],
						'descriptor' => $retina_width . 'w',
						'value' => $retina_width,
					);
				}
			}
		}
		
		return $sources;
	}
	add_filter( 'wp_calculate_image_srcset', 'logic_nagoya_custom_srcset', 10, 5 );
	
	// Add loading="lazy" to images by default
	function logic_nagoya_add_lazy_loading( $attr, $attachment, $size ) {
		// Don't add lazy loading to hero images (above the fold)
		if ( in_array( $size, array( 'hero-desktop', 'hero-tablet', 'hero-mobile' ) ) ) {
			return $attr;
		}
		
		if ( ! isset( $attr['loading'] ) ) {
			$attr['loading'] = 'lazy';
		}
		
		return $attr;
	}
	add_filter( 'wp_get_attachment_image_attributes', 'logic_nagoya_add_lazy_loading', 10, 3 );
}

/**
 * Get optimized image HTML with WebP fallback
 * Task 017: WebP optimization helper function
 */
function logic_nagoya_get_optimized_image( $attachment_id, $size = 'full', $attr = array() ) {
	if ( ! $attachment_id ) {
		return '';
	}
	
	// Get standard image
	$image_src = wp_get_attachment_image_src( $attachment_id, $size );
	if ( ! $image_src ) {
		return '';
	}
	
	// Check if WebP version exists
	$webp_url = logic_nagoya_get_webp_url( $image_src[0] );
	
	// Prepare attributes
	$default_attr = array(
		'class' => 'optimized-image',
		'alt' => get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ),
		'width' => $image_src[1],
		'height' => $image_src[2],
	);
	
	$attr = wp_parse_args( $attr, $default_attr );
	
	// Generate picture element with WebP support
	$html = '<picture>';
	
	if ( $webp_url && $webp_url !== $image_src[0] ) {
		$html .= '<source srcset="' . esc_url( $webp_url ) . '" type="image/webp">';
	}
	
	$html .= '<img src="' . esc_url( $image_src[0] ) . '"';
	
	foreach ( $attr as $name => $value ) {
		$html .= ' ' . $name . '="' . esc_attr( $value ) . '"';
	}
	
	$html .= '>';
	$html .= '</picture>';
	
	return $html;
}

/**
 * Get WebP URL if available
 * Task 017: WebP URL conversion helper
 */
function logic_nagoya_get_webp_url( $image_url ) {
	if ( ! $image_url ) {
		return $image_url;
	}
	
	// Replace extension with .webp
	$webp_url = preg_replace( '/\.(jpg|jpeg|png)$/i', '.webp', $image_url );
	
	// Check if WebP file exists
	$webp_path = str_replace( home_url(), ABSPATH, $webp_url );
	
	if ( file_exists( $webp_path ) ) {
		return $webp_url;
	}
	
	return $image_url;
}

/**
 * Check if current page needs FAQ functionality
 * 
 * @return bool True if FAQ styles/scripts are needed
 */
function logic_nagoya_needs_faq() {
	// Check if it's front page (homepage typically has FAQ section)
	if ( is_front_page() ) {
		return true;
	}
	
	// Check specific page templates that might have FAQ
	$faq_templates = array(
		'page-about.php',
		'page-system-pricing.php',
	);
	
	foreach ( $faq_templates as $template ) {
		if ( is_page_template( $template ) ) {
			return true;
		}
	}
	
	// Check if current page has FAQ content in post content
	if ( is_page() ) {
		global $post;
		if ( $post && ( strpos( $post->post_content, 'faq' ) !== false || strpos( $post->post_content, 'FAQ' ) !== false ) ) {
			return true;
		}
	}
	
	return false;
}

/**
 * Check if current page needs image optimization scripts/styles
 * Task 017: Conditional loading for image optimization
 */
function logic_nagoya_needs_image_optimization() {
	// Always load on pages with images
	if ( has_post_thumbnail() ) {
		return true;
	}
	
	// Load on gallery and event pages
	if ( is_post_type_archive( array( 'gallery', 'event' ) ) || 
		 is_singular( array( 'gallery', 'event' ) ) ) {
		return true;
	}
	
	// Load on front page (hero images, gallery)
	if ( is_front_page() ) {
		return true;
	}
	
	// Load on pages with custom images (floor plan, concept, etc.)
	if ( is_page() ) {
		global $post;
		if ( $post ) {
			$has_custom_images = get_post_meta( $post->ID, '_logic_nagoya_floor_plan_image', true ) ||
							get_post_meta( $post->ID, '_logic_nagoya_concept_image', true );
			if ( $has_custom_images ) {
				return true;
			}
		}
	}
	
	return false;
}

add_action( 'after_setup_theme', 'logic_nagoya_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function logic_nagoya_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'logic_nagoya_content_width', 1200 );
}
add_action( 'after_setup_theme', 'logic_nagoya_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function logic_nagoya_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'logic-nagoya' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'logic-nagoya' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'logic-nagoya' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'First footer widget area', 'logic-nagoya' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="footer-heading">',
			'after_title'   => '</h3>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'logic-nagoya' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Second footer widget area', 'logic-nagoya' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="footer-heading">',
			'after_title'   => '</h3>',
		)
	);
	
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'logic-nagoya' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Third footer widget area', 'logic-nagoya' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="footer-heading">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'logic_nagoya_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function logic_nagoya_scripts() {
	// Enqueue main theme stylesheet
	wp_enqueue_style( 'logic-nagoya-style', get_stylesheet_uri(), array(), LOGIC_NAGOYA_VERSION );
	
	// External libraries - try local first, fallback to CDN
	$fontawesome_local = get_template_directory() . '/assets/css/fontawesome.min.css';
	$animate_local = get_template_directory() . '/assets/css/animate.min.css';
	
	// Font Awesome
	if ( file_exists( $fontawesome_local ) ) {
		wp_enqueue_style( 'logic-nagoya-fontawesome', get_template_directory_uri() . '/assets/css/fontawesome.min.css', array(), '6.0.0' );
	} else {
		// Fallback to CDN (consider downloading local version for better performance)
		wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), '6.0.0-beta3' );
	}
	
	// Animate.css
	if ( file_exists( $animate_local ) ) {
		wp_enqueue_style( 'logic-nagoya-animate', get_template_directory_uri() . '/assets/css/animate.min.css', array(), '4.1.1' );
	} else {
		// Fallback to CDN (consider downloading local version for better performance)
		wp_enqueue_style( 'animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '4.1.1' );
	}
	
	// Event-specific styles (only load when needed)
	if ( is_post_type_archive('event') || is_singular('event') ) {
		wp_enqueue_style( 'logic-nagoya-event-styles', get_template_directory_uri() . '/event-styles.css', array(), LOGIC_NAGOYA_VERSION );
	}
	
	// FAQ styles and scripts - conditional loading based on page content
	if ( logic_nagoya_needs_faq() ) {
		$faq_css = get_template_directory() . '/css/faq.css';
		$faq_js = get_template_directory() . '/js/faq.js';
		
		if ( file_exists( $faq_css ) && filesize( $faq_css ) > 0 ) {
			wp_enqueue_style( 'logic-nagoya-faq', get_template_directory_uri() . '/css/faq.css', array(), LOGIC_NAGOYA_VERSION );
		}
		if ( file_exists( $faq_js ) && filesize( $faq_js ) > 0 ) {
			wp_enqueue_script( 'logic-nagoya-faq', get_template_directory_uri() . '/js/faq.js', array('jquery'), LOGIC_NAGOYA_VERSION, true );
		}
	}
	
	// Image optimization scripts and styles - Task 017 COMPLETED
	if ( logic_nagoya_needs_image_optimization() ) {
		$image_opt_css = get_template_directory() . '/css/image-optimization.css';
		$image_opt_js = get_template_directory() . '/js/image-optimization.js';
		
		if ( file_exists( $image_opt_css ) && filesize( $image_opt_css ) > 0 ) {
			wp_enqueue_style( 'logic-nagoya-image-optimization', get_template_directory_uri() . '/css/image-optimization.css', array(), LOGIC_NAGOYA_VERSION );
		}
		if ( file_exists( $image_opt_js ) && filesize( $image_opt_js ) > 0 ) {
			wp_enqueue_script( 'logic-nagoya-image-optimization', get_template_directory_uri() . '/js/image-optimization.js', array(), LOGIC_NAGOYA_VERSION, true );
			
			// Localize script for AJAX and settings
			wp_localize_script( 'logic-nagoya-image-optimization', 'logic_nagoya_image_opt', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'logic_nagoya_image_opt_nonce' ),
				'lazy_loading_offset' => '50px',
				'fade_duration' => 300,
			) );
		}
	}

	// Comments functionality
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'logic_nagoya_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Event post type 
 */
function logic_nagoya_register_event_post_type() {
	$labels = array(
		'name'                  => _x( 'Events', 'Post type general name', 'logic-nagoya' ),
		'singular_name'         => _x( 'Event', 'Post type singular name', 'logic-nagoya' ),
		'menu_name'             => _x( 'Events', 'Admin Menu text', 'logic-nagoya' ),
		'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'logic-nagoya' ),
		'add_new'               => __( 'Add New', 'logic-nagoya' ),
		'add_new_item'          => __( 'Add New Event', 'logic-nagoya' ),
		'new_item'              => __( 'New Event', 'logic-nagoya' ),
		'edit_item'             => __( 'Edit Event', 'logic-nagoya' ),
		'view_item'             => __( 'View Event', 'logic-nagoya' ),
		'all_items'             => __( 'All Events', 'logic-nagoya' ),
		'search_items'          => __( 'Search Events', 'logic-nagoya' ),
		'parent_item_colon'     => __( 'Parent Events:', 'logic-nagoya' ),
		'not_found'             => __( 'No events found.', 'logic-nagoya' ),
		'not_found_in_trash'    => __( 'No events found in Trash.', 'logic-nagoya' ),
		'featured_image'        => _x( 'Event Cover Image', 'Overrides the "Featured Image" phrase', 'logic-nagoya' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the "Set featured image" phrase', 'logic-nagoya' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the "Remove featured image" phrase', 'logic-nagoya' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the "Use as featured image" phrase', 'logic-nagoya' ),
		'archives'              => _x( 'Event archives', 'The post type archive label used in nav menus', 'logic-nagoya' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'event' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-calendar-alt',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' ),
	);

	register_post_type( 'event', $args );
	
	// Register Event Category Taxonomy
	$cat_labels = array(
		'name'              => _x( 'Event Categories', 'taxonomy general name', 'logic-nagoya' ),
		'singular_name'     => _x( 'Event Category', 'taxonomy singular name', 'logic-nagoya' ),
		'search_items'      => __( 'Search Event Categories', 'logic-nagoya' ),
		'all_items'         => __( 'All Event Categories', 'logic-nagoya' ),
		'parent_item'       => __( 'Parent Event Category', 'logic-nagoya' ),
		'parent_item_colon' => __( 'Parent Event Category:', 'logic-nagoya' ),
		'edit_item'         => __( 'Edit Event Category', 'logic-nagoya' ),
		'update_item'       => __( 'Update Event Category', 'logic-nagoya' ),
		'add_new_item'      => __( 'Add New Event Category', 'logic-nagoya' ),
		'new_item_name'     => __( 'New Event Category Name', 'logic-nagoya' ),
		'menu_name'         => __( 'Event Categories', 'logic-nagoya' ),
	);

	$cat_args = array(
		'hierarchical'      => true,
		'labels'            => $cat_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'event-category' ),
	);

	register_taxonomy( 'event_category', array( 'event' ), $cat_args );
}
add_action( 'init', 'logic_nagoya_register_event_post_type' );

/**
 * Gallery post type
 */
function logic_nagoya_register_gallery_post_type() {
	$labels = array(
		'name'                  => _x( 'Gallery Items', 'Post type general name', 'logic-nagoya' ),
		'singular_name'         => _x( 'Gallery Item', 'Post type singular name', 'logic-nagoya' ),
		'menu_name'             => _x( 'Gallery', 'Admin Menu text', 'logic-nagoya' ),
		'name_admin_bar'        => _x( 'Gallery Item', 'Add New on Toolbar', 'logic-nagoya' ),
		'add_new'               => __( 'Add New', 'logic-nagoya' ),
		'add_new_item'          => __( 'Add New Gallery Item', 'logic-nagoya' ),
		'new_item'              => __( 'New Gallery Item', 'logic-nagoya' ),
		'edit_item'             => __( 'Edit Gallery Item', 'logic-nagoya' ),
		'view_item'             => __( 'View Gallery Item', 'logic-nagoya' ),
		'all_items'             => __( 'All Gallery Items', 'logic-nagoya' ),
		'search_items'          => __( 'Search Gallery Items', 'logic-nagoya' ),
		'parent_item_colon'     => __( 'Parent Gallery Items:', 'logic-nagoya' ),
		'not_found'             => __( 'No gallery items found.', 'logic-nagoya' ),
		'not_found_in_trash'    => __( 'No gallery items found in Trash.', 'logic-nagoya' ),
		'featured_image'        => _x( 'Gallery Image', 'Overrides the "Featured Image" phrase', 'logic-nagoya' ),
		'set_featured_image'    => _x( 'Set gallery image', 'Overrides the "Set featured image" phrase', 'logic-nagoya' ),
		'remove_featured_image' => _x( 'Remove gallery image', 'Overrides the "Remove featured image" phrase', 'logic-nagoya' ),
		'use_featured_image'    => _x( 'Use as gallery image', 'Overrides the "Use as featured image" phrase', 'logic-nagoya' ),
		'archives'              => _x( 'Gallery archives', 'The post type archive label used in nav menus', 'logic-nagoya' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'gallery' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-format-gallery',
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
	);

	register_post_type( 'gallery', $args );
}
add_action( 'init', 'logic_nagoya_register_gallery_post_type' );

/**
 * Task 017 Image Optimization Enhancement
 */
require get_template_directory() . '/image-optimization-enhancement.php';
