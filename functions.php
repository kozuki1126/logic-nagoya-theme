<?php
/**
 * Logic Nagoya functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Logic_Nagoya
 */

// Direct access protection
defined('ABSPATH') || exit;

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
	
	// Create assets directory structure for local libraries
	logic_nagoya_create_assets_structure();
	
	// Initialize image optimization features
	logic_nagoya_init_image_optimization();
}

/**
 * Initialize image optimization features
 * Task 017: Image optimization and lazy loading
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

/**
 * Create assets directory structure for local libraries
 */
function logic_nagoya_create_assets_structure() {
	$upload_dir = wp_upload_dir();
	$assets_dir = get_template_directory() . '/assets';
	
	// Create assets directories if they don't exist
	$directories = array(
		$assets_dir,
		$assets_dir . '/css',
		$assets_dir . '/fonts',
		$assets_dir . '/js'
	);
	
	foreach ( $directories as $dir ) {
		if ( ! file_exists( $dir ) ) {
			wp_mkdir_p( $dir );
		}
	}
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
 * Enqueue scripts and styles with optimization and security improvements.
 */
function logic_nagoya_scripts() {
	// Enqueue main theme stylesheet with file versioning for cache busting
	$style_file = get_stylesheet_directory() . '/style.css';
	$style_version = file_exists( $style_file ) ? filemtime( $style_file ) : LOGIC_NAGOYA_VERSION;
	wp_enqueue_style( 'logic-nagoya-style', get_stylesheet_uri(), array(), $style_version );
	
	// External libraries - try local first, fallback to CDN
	$fontawesome_local = get_template_directory() . '/assets/css/fontawesome.min.css';
	$animate_local = get_template_directory() . '/assets/css/animate.min.css';
	
	// Font Awesome
	if ( file_exists( $fontawesome_local ) ) {
		wp_enqueue_style( 
			'logic-nagoya-fontawesome', 
			get_template_directory_uri() . '/assets/css/fontawesome.min.css', 
			array(), 
			filemtime( $fontawesome_local ) 
		);
	} else {
		// Fallback to CDN (consider downloading local version for better performance)
		wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', array(), '6.0.0-beta3' );
	}
	
	// Animate.css
	if ( file_exists( $animate_local ) ) {
		wp_enqueue_style( 
			'logic-nagoya-animate', 
			get_template_directory_uri() . '/assets/css/animate.min.css', 
			array(), 
			filemtime( $animate_local ) 
		);
	} else {
		// Fallback to CDN (consider downloading local version for better performance)
		wp_enqueue_style( 'animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', array(), '4.1.1' );
	}
	
	// Event-specific styles (conditional loading)
	if ( is_post_type_archive('event') || is_singular('event') || is_page('events') ) {
		$event_style = get_template_directory() . '/event-styles.css';
		if ( file_exists( $event_style ) ) {
			wp_enqueue_style( 
				'logic-nagoya-event-styles', 
				get_template_directory_uri() . '/event-styles.css', 
				array(), 
				filemtime( $event_style ) 
			);
		}
	}
	
	// FAQ styles and scripts - conditional loading based on page content
	if ( logic_nagoya_needs_faq() ) {
		$faq_css = get_template_directory() . '/css/faq.css';
		$faq_js = get_template_directory() . '/js/faq.js';
		
		if ( file_exists( $faq_css ) && filesize( $faq_css ) > 0 ) {
			wp_enqueue_style( 
				'logic-nagoya-faq', 
				get_template_directory_uri() . '/css/faq.css', 
				array(), 
				filemtime( $faq_css ) 
			);
		}
		if ( file_exists( $faq_js ) && filesize( $faq_js ) > 0 ) {
			wp_enqueue_script( 
				'logic-nagoya-faq', 
				get_template_directory_uri() . '/js/faq.js', 
				array('jquery'), 
				filemtime( $faq_js ), 
				array(
					'strategy' => 'defer',
					'in_footer' => true
				)
			);
		}
	}
	
	// Image optimization scripts and styles - Task 017
	if ( logic_nagoya_needs_image_optimization() ) {
		$image_opt_css = get_template_directory() . '/css/image-optimization.css';
		$image_opt_js = get_template_directory() . '/js/image-optimization.js';
		
		if ( file_exists( $image_opt_css ) && filesize( $image_opt_css ) > 0 ) {
			wp_enqueue_style( 
				'logic-nagoya-image-optimization', 
				get_template_directory_uri() . '/css/image-optimization.css', 
				array(), 
				filemtime( $image_opt_css ) 
			);
		}
		if ( file_exists( $image_opt_js ) && filesize( $image_opt_js ) > 0 ) {
			wp_enqueue_script( 
				'logic-nagoya-image-optimization', 
				get_template_directory_uri() . '/js/image-optimization.js', 
				array(), 
				filemtime( $image_opt_js ), 
				array(
					'strategy' => 'defer',
					'in_footer' => true
				)
			);
			
			// Localize script for AJAX and settings with nonce
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
 * Add meta boxes for custom page content
 */
function logic_nagoya_add_meta_boxes() {
	// Floor Plan Image Meta Box (for floor-map page)
	add_meta_box(
		'logic_nagoya_floor_plan',
		__( 'Floor Plan Image', 'logic-nagoya' ),
		'logic_nagoya_floor_plan_callback',
		'page',
		'normal',
		'high'
	);
	
	// Concept Image Meta Box (for about page)
	add_meta_box(
		'logic_nagoya_concept_image',
		__( 'Concept Image', 'logic-nagoya' ),
		'logic_nagoya_concept_image_callback',
		'page',
		'normal',
		'high'
	);
	
	// Equipment PDF Meta Box (for equipment pages)
	add_meta_box(
		'logic_nagoya_equipment_pdf',
		__( 'Equipment PDF', 'logic-nagoya' ),
		'logic_nagoya_equipment_pdf_callback',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'logic_nagoya_add_meta_boxes' );

/**
 * Floor Plan Image Meta Box Callback
 */
function logic_nagoya_floor_plan_callback( $post ) {
	wp_nonce_field( 'logic_nagoya_floor_plan_save', 'logic_nagoya_floor_plan_nonce' );
	$floor_plan_id = get_post_meta( $post->ID, '_logic_nagoya_floor_plan_image', true );
	?>
	<p>
		<label for="logic_nagoya_floor_plan_image"><?php esc_html_e( 'Floor Plan Image:', 'logic-nagoya' ); ?></label>
		<br>
		<input type="hidden" id="logic_nagoya_floor_plan_image" name="logic_nagoya_floor_plan_image" value="<?php echo esc_attr( $floor_plan_id ); ?>" />
		<input type="button" class="button logic-nagoya-upload-button" id="upload_floor_plan_button" value="<?php esc_attr_e( 'Choose Image', 'logic-nagoya' ); ?>" />
		<input type="button" class="button logic-nagoya-remove-button" id="remove_floor_plan_button" value="<?php esc_attr_e( 'Remove Image', 'logic-nagoya' ); ?>" <?php if ( ! $floor_plan_id ) echo 'style="display:none;"'; ?> />
	</p>
	<div id="floor_plan_preview">
		<?php if ( $floor_plan_id ) : ?>
			<?php echo wp_get_attachment_image( $floor_plan_id, array( 300, 200 ) ); ?>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Concept Image Meta Box Callback
 */
function logic_nagoya_concept_image_callback( $post ) {
	wp_nonce_field( 'logic_nagoya_concept_image_save', 'logic_nagoya_concept_image_nonce' );
	$concept_image_id = get_post_meta( $post->ID, '_logic_nagoya_concept_image', true );
	?>
	<p>
		<label for="logic_nagoya_concept_image"><?php esc_html_e( 'Concept Image:', 'logic-nagoya' ); ?></label>
		<br>
		<input type="hidden" id="logic_nagoya_concept_image" name="logic_nagoya_concept_image" value="<?php echo esc_attr( $concept_image_id ); ?>" />
		<input type="button" class="button logic-nagoya-upload-button" id="upload_concept_button" value="<?php esc_attr_e( 'Choose Image', 'logic-nagoya' ); ?>" />
		<input type="button" class="button logic-nagoya-remove-button" id="remove_concept_button" value="<?php esc_attr_e( 'Remove Image', 'logic-nagoya' ); ?>" <?php if ( ! $concept_image_id ) echo 'style="display:none;"'; ?> />
	</p>
	<div id="concept_image_preview">
		<?php if ( $concept_image_id ) : ?>
			<?php echo wp_get_attachment_image( $concept_image_id, array( 300, 200 ) ); ?>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Equipment PDF Meta Box Callback
 */
function logic_nagoya_equipment_pdf_callback( $post ) {
	wp_nonce_field( 'logic_nagoya_equipment_pdf_save', 'logic_nagoya_equipment_pdf_nonce' );
	$equipment_pdf_id = get_post_meta( $post->ID, '_logic_nagoya_equipment_pdf', true );
	$pdf_url = $equipment_pdf_id ? wp_get_attachment_url( $equipment_pdf_id ) : '';
	?>
	<p>
		<label for="logic_nagoya_equipment_pdf"><?php esc_html_e( 'Equipment PDF:', 'logic-nagoya' ); ?></label>
		<br>
		<input type="hidden" id="logic_nagoya_equipment_pdf" name="logic_nagoya_equipment_pdf" value="<?php echo esc_attr( $equipment_pdf_id ); ?>" />
		<input type="button" class="button logic-nagoya-upload-button" id="upload_pdf_button" value="<?php esc_attr_e( 'Choose PDF', 'logic-nagoya' ); ?>" />
		<input type="button" class="button logic-nagoya-remove-button" id="remove_pdf_button" value="<?php esc_attr_e( 'Remove PDF', 'logic-nagoya' ); ?>" <?php if ( ! $equipment_pdf_id ) echo 'style="display:none;"'; ?> />
	</p>
	<div id="equipment_pdf_preview">
		<?php if ( $pdf_url ) : ?>
			<p><strong><?php esc_html_e( 'Current PDF:', 'logic-nagoya' ); ?></strong> <a href="<?php echo esc_url( $pdf_url ); ?>" target="_blank"><?php echo esc_html( basename( $pdf_url ) ); ?></a></p>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Save Meta Box Data with improved security
 */
function logic_nagoya_save_meta_boxes( $post_id ) {
	// Check if this is an autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	// Check the user's permissions
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	// Save Floor Plan Image
	if ( isset( $_POST['logic_nagoya_floor_plan_nonce'] ) && 
		 wp_verify_nonce( $_POST['logic_nagoya_floor_plan_nonce'], 'logic_nagoya_floor_plan_save' ) &&
		 isset( $_POST['logic_nagoya_floor_plan_image'] ) ) {
		$floor_plan_id = sanitize_text_field( $_POST['logic_nagoya_floor_plan_image'] );
		update_post_meta( $post_id, '_logic_nagoya_floor_plan_image', $floor_plan_id );
	}
	
	// Save Concept Image
	if ( isset( $_POST['logic_nagoya_concept_image_nonce'] ) && 
		 wp_verify_nonce( $_POST['logic_nagoya_concept_image_nonce'], 'logic_nagoya_concept_image_save' ) &&
		 isset( $_POST['logic_nagoya_concept_image'] ) ) {
		$concept_image_id = sanitize_text_field( $_POST['logic_nagoya_concept_image'] );
		update_post_meta( $post_id, '_logic_nagoya_concept_image', $concept_image_id );
	}
	
	// Save Equipment PDF
	if ( isset( $_POST['logic_nagoya_equipment_pdf_nonce'] ) && 
		 wp_verify_nonce( $_POST['logic_nagoya_equipment_pdf_nonce'], 'logic_nagoya_equipment_pdf_save' ) &&
		 isset( $_POST['logic_nagoya_equipment_pdf'] ) ) {
		$equipment_pdf_id = sanitize_text_field( $_POST['logic_nagoya_equipment_pdf'] );
		update_post_meta( $post_id, '_logic_nagoya_equipment_pdf', $equipment_pdf_id );
	}
}
add_action( 'save_post', 'logic_nagoya_save_meta_boxes' );

/**
 * Enqueue admin scripts for meta boxes with nonce verification
 */
function logic_nagoya_admin_scripts( $hook ) {
	if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
		wp_enqueue_media();
		
		$admin_js = get_template_directory() . '/js/admin.js';
		wp_enqueue_script(
			'logic-nagoya-admin',
			get_template_directory_uri() . '/js/admin.js',
			array( 'jquery' ),
			file_exists( $admin_js ) ? filemtime( $admin_js ) : LOGIC_NAGOYA_VERSION,
			true
		);
		
		// Localize script with nonce for AJAX security
		wp_localize_script( 'logic-nagoya-admin', 'logic_nagoya_admin', array(
			'nonce' => wp_create_nonce( 'logic_nagoya_admin_nonce' ),
		) );
	}
}
add_action( 'admin_enqueue_scripts', 'logic_nagoya_admin_scripts' );

/**
 * Get optimized events list with caching (Performance optimization)
 */
function logic_nagoya_get_upcoming_events( $limit = 10 ) {
	$cache_key = 'logic_nagoya_upcoming_events_' . $limit;
	$cached_events = get_transient( $cache_key );
	
	if ( $cached_events !== false ) {
		return $cached_events;
	}
	
	$today = current_time('Ymd');
	$events_query = new WP_Query( array(
		'post_type'      => 'event',
		'posts_per_page' => $limit,
		'meta_key'       => 'event_date',
		'meta_query'     => array(
			array(
				'key'     => 'event_date',
				'value'   => $today,
				'compare' => '>=',
				'type'    => 'NUMERIC',
			)
		),
		'orderby'        => 'meta_value_num',
		'order'          => 'ASC',
		'no_found_rows'  => true, // Performance optimization
	) );
	
	$events = $events_query->posts;
	
	// Cache for 1 hour
	set_transient( $cache_key, $events, HOUR_IN_SECONDS );
	
	return $events;
}

/**
 * Clear events cache when event is saved/updated
 */
function logic_nagoya_clear_events_cache( $post_id ) {
	if ( get_post_type( $post_id ) === 'event' ) {
		// Clear all cached event queries
		global $wpdb;
		$wpdb->query( 
			"DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_logic_nagoya_upcoming_events_%'"
		);
	}
}
add_action( 'save_post', 'logic_nagoya_clear_events_cache' );
add_action( 'delete_post', 'logic_nagoya_clear_events_cache' );
