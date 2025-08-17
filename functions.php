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
	
	// Create assets directory structure for local libraries
	logic_nagoya_create_assets_structure();
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
 * Add image upload metaboxes for custom page templates
 */
function logic_nagoya_add_page_image_metaboxes() {
    // Add meta box for floor plan image
    add_meta_box(
        'floor_plan_image_box',
        __('Floor Plan Image', 'logic-nagoya'),
        'logic_nagoya_floor_plan_image_callback',
        'page',
        'normal',
        'high'
    );
    
    // Add meta box for concept image
    add_meta_box(
        'concept_image_box',
        __('Concept Image', 'logic-nagoya'),
        'logic_nagoya_concept_image_callback',
        'page',
        'normal',
        'high'
    );
    
    // Add meta box for equipment PDF
    add_meta_box(
        'equipment_pdf_box',
        __('Equipment PDF', 'logic-nagoya'),
        'logic_nagoya_equipment_pdf_callback',
        'page',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'logic_nagoya_add_page_image_metaboxes');

/**
 * Floor plan image meta box callback
 */
function logic_nagoya_floor_plan_image_callback($post) {
    wp_nonce_field('logic_nagoya_floor_plan_nonce_' . $post->ID, 'floor_plan_image_nonce');
    
    $floor_plan_image = get_post_meta($post->ID, 'floor_plan_image', true);
    ?>
    <p>
        <label for="floor-plan-image"><?php _e('Select an image to use as the floor plan', 'logic-nagoya'); ?></label><br>
        <input type="hidden" name="floor_plan_image" id="floor-plan-image" value="<?php echo esc_attr($floor_plan_image); ?>" />
        <button type="button" class="button" id="floor-plan-image-select"><?php _e('Select Image', 'logic-nagoya'); ?></button>
        <button type="button" class="button" id="floor-plan-image-remove"><?php _e('Remove Image', 'logic-nagoya'); ?></button>
    </p>
    <div id="floor-plan-image-preview" style="margin-top: 10px;">
        <?php if ($floor_plan_image) : ?>
            <img src="<?php echo esc_url(wp_get_attachment_url($floor_plan_image)); ?>" style="max-width: 300px;" alt="<?php esc_attr_e('Floor plan image preview', 'logic-nagoya'); ?>">
        <?php endif; ?>
    </div>
    <script>
    jQuery(document).ready(function($) {
        // Handle the media uploader for floor plan image
        $('#floor-plan-image-select').click(function(e) {
            e.preventDefault();
            
            var image_frame;
            
            if (image_frame) {
                image_frame.open();
                return;
            }
            
            image_frame = wp.media({
                title: '<?php _e('Select or Upload Floor Plan Image', 'logic-nagoya'); ?>',
                button: {
                    text: '<?php _e('Use this image', 'logic-nagoya'); ?>'
                },
                multiple: false
            });
            
            image_frame.on('select', function() {
                var attachment = image_frame.state().get('selection').first().toJSON();
                $('#floor-plan-image').val(attachment.id);
                $('#floor-plan-image-preview').html('<img src="' + attachment.url + '" style="max-width: 300px;" alt="Floor plan image preview">');
            });
            
            image_frame.open();
        });
        
        // Handle removing the floor plan image
        $('#floor-plan-image-remove').click(function(e) {
            e.preventDefault();
            $('#floor-plan-image').val('');
            $('#floor-plan-image-preview').html('');
        });
    });
    </script>
    <?php
}

/**
 * Concept image meta box callback
 */
function logic_nagoya_concept_image_callback($post) {
    wp_nonce_field('logic_nagoya_concept_nonce_' . $post->ID, 'concept_image_nonce');
    
    $concept_image = get_post_meta($post->ID, 'concept_image', true);
    ?>
    <p>
        <label for="concept-image"><?php _e('Select an image to use for the concept section', 'logic-nagoya'); ?></label><br>
        <input type="hidden" name="concept_image" id="concept-image" value="<?php echo esc_attr($concept_image); ?>" />
        <button type="button" class="button" id="concept-image-select"><?php _e('Select Image', 'logic-nagoya'); ?></button>
        <button type="button" class="button" id="concept-image-remove"><?php _e('Remove Image', 'logic-nagoya'); ?></button>
    </p>
    <div id="concept-image-preview" style="margin-top: 10px;">
        <?php if ($concept_image) : ?>
            <img src="<?php echo esc_url(wp_get_attachment_url($concept_image)); ?>" style="max-width: 300px;" alt="<?php esc_attr_e('Concept image preview', 'logic-nagoya'); ?>">
        <?php endif; ?>
    </div>
    <script>
    jQuery(document).ready(function($) {
        // Handle the media uploader for concept image
        $('#concept-image-select').click(function(e) {
            e.preventDefault();
            
            var image_frame;
            
            if (image_frame) {
                image_frame.open();
                return;
            }
            
            image_frame = wp.media({
                title: '<?php _e('Select or Upload Concept Image', 'logic-nagoya'); ?>',
                button: {
                    text: '<?php _e('Use this image', 'logic-nagoya'); ?>'
                },
                multiple: false
            });
            
            image_frame.on('select', function() {
                var attachment = image_frame.state().get('selection').first().toJSON();
                $('#concept-image').val(attachment.id);
                $('#concept-image-preview').html('<img src="' + attachment.url + '" style="max-width: 300px;" alt="Concept image preview">');
            });
            
            image_frame.open();
        });
        
        // Handle removing the concept image
        $('#concept-image-remove').click(function(e) {
            e.preventDefault();
            $('#concept-image').val('');
            $('#concept-image-preview').html('');
        });
    });
    </script>
    <?php
}

/**
 * Equipment PDF meta box callback
 */
function logic_nagoya_equipment_pdf_callback($post) {
    wp_nonce_field('logic_nagoya_equipment_nonce_' . $post->ID, 'equipment_pdf_nonce');
    
    $equipment_pdf = get_post_meta($post->ID, 'equipment_pdf', true);
    ?>
    <p>
        <label for="equipment-pdf"><?php _e('Select a PDF file for equipment details', 'logic-nagoya'); ?></label><br>
        <input type="hidden" name="equipment_pdf" id="equipment-pdf" value="<?php echo esc_attr($equipment_pdf); ?>" />
        <button type="button" class="button" id="equipment-pdf-select"><?php _e('Select PDF', 'logic-nagoya'); ?></button>
        <button type="button" class="button" id="equipment-pdf-remove"><?php _e('Remove PDF', 'logic-nagoya'); ?></button>
    </p>
    <div id="equipment-pdf-preview" style="margin-top: 10px;">
        <?php if ($equipment_pdf) : ?>
            <p><?php echo esc_html(basename(get_attached_file($equipment_pdf))); ?></p>
        <?php endif; ?>
    </div>
    <script>
    jQuery(document).ready(function($) {
        // Handle the media uploader for equipment PDF
        $('#equipment-pdf-select').click(function(e) {
            e.preventDefault();
            
            var pdf_frame;
            
            if (pdf_frame) {
                pdf_frame.open();
                return;
            }
            
            pdf_frame = wp.media({
                title: '<?php _e('Select or Upload Equipment PDF', 'logic-nagoya'); ?>',
                button: {
                    text: '<?php _e('Use this PDF', 'logic-nagoya'); ?>'
                },
                multiple: false,
                library: {
                    type: 'application/pdf'
                }
            });
            
            pdf_frame.on('select', function() {
                var attachment = pdf_frame.state().get('selection').first().toJSON();
                $('#equipment-pdf').val(attachment.id);
                $('#equipment-pdf-preview').html('<p>' + attachment.filename + '</p>');
            });
            
            pdf_frame.open();
        });
        
        // Handle removing the equipment PDF
        $('#equipment-pdf-remove').click(function(e) {
            e.preventDefault();
            $('#equipment-pdf').val('');
            $('#equipment-pdf-preview').html('');
        });
    });
    </script>
    <?php
}

/**
 * Save custom page meta data
 */
function logic_nagoya_save_page_meta($post_id) {
    // Security checks
    
    // 1. Check if this is an autosave or revision
    if (wp_is_post_autosave($post_id) || wp_is_post_revision($post_id)) {
        return;
    }
    
    // 2. Check user permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // 3. Verify the post type is 'page'
    if (get_post_type($post_id) !== 'page') {
        return;
    }
    
    // Save floor plan image
    if (isset($_POST['floor_plan_image_nonce']) && wp_verify_nonce($_POST['floor_plan_image_nonce'], 'logic_nagoya_floor_plan_nonce_' . $post_id)) {
        if (isset($_POST['floor_plan_image']) && !empty($_POST['floor_plan_image'])) {
            $floor_plan_image = absint($_POST['floor_plan_image']);
            if ($floor_plan_image > 0) {
                update_post_meta($post_id, 'floor_plan_image', $floor_plan_image);
            }
        } else {
            // Delete meta if field is empty
            delete_post_meta($post_id, 'floor_plan_image');
        }
    }
    
    // Save concept image
    if (isset($_POST['concept_image_nonce']) && wp_verify_nonce($_POST['concept_image_nonce'], 'logic_nagoya_concept_nonce_' . $post_id)) {
        if (isset($_POST['concept_image']) && !empty($_POST['concept_image'])) {
            $concept_image = absint($_POST['concept_image']);
            if ($concept_image > 0) {
                update_post_meta($post_id, 'concept_image', $concept_image);
            }
        } else {
            // Delete meta if field is empty
            delete_post_meta($post_id, 'concept_image');
        }
    }
    
    // Save equipment PDF
    if (isset($_POST['equipment_pdf_nonce']) && wp_verify_nonce($_POST['equipment_pdf_nonce'], 'logic_nagoya_equipment_nonce_' . $post_id)) {
        if (isset($_POST['equipment_pdf']) && !empty($_POST['equipment_pdf'])) {
            $equipment_pdf = absint($_POST['equipment_pdf']);
            if ($equipment_pdf > 0) {
                update_post_meta($post_id, 'equipment_pdf', $equipment_pdf);
            }
        } else {
            // Delete meta if field is empty
            delete_post_meta($post_id, 'equipment_pdf');
        }
    }
}
add_action('save_post_page', 'logic_nagoya_save_page_meta');

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
