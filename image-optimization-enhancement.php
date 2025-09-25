<?php
/**
 * Logic Nagoya - Image Optimization Enhancement
 * Task 017 Completion: Advanced image optimization functions
 */

/**
 * Enhanced image optimization script loading
 */
function logic_nagoya_load_image_optimization_assets() {
    // Image optimization CSS (replaces inline styles)
    wp_enqueue_style(
        'logic-nagoya-image-optimization',
        get_template_directory_uri() . '/css/image-optimization.css',
        array('logic-nagoya-style'),
        LOGIC_NAGOYA_VERSION
    );
    
    // Advanced image optimization JavaScript
    wp_enqueue_script(
        'logic-nagoya-image-optimization',
        get_template_directory_uri() . '/js/image-optimization.js',
        array(),
        LOGIC_NAGOYA_VERSION,
        true
    );
    
    // Localize script with configuration
    wp_localize_script('logic-nagoya-image-optimization', 'logicNagoyaImageConfig', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('logic_nagoya_image_nonce'),
        'webpSupported' => function_exists('imagewebp'),
        'debugMode' => defined('WP_DEBUG') && WP_DEBUG,
        'lazyLoadOffset' => '50px',
        'enableRetina' => true,
        'imageQuality' => 85
    ));
}

/**
 * Check if current page needs advanced image optimization
 */
function logic_nagoya_needs_advanced_image_optimization() {
    // Always load on pages with featured images
    if (has_post_thumbnail()) {
        return true;
    }
    
    // Load on gallery and event archives
    if (is_post_type_archive(array('gallery', 'event')) || 
        is_singular(array('gallery', 'event'))) {
        return true;
    }
    
    // Load on image-heavy pages
    if (is_front_page() || is_home()) {
        return true;
    }
    
    // Load on pages with custom images
    if (is_page()) {
        global $post;
        if ($post) {
            $has_images = get_post_meta($post->ID, 'floor_plan_image', true) ||
                         get_post_meta($post->ID, 'concept_image', true) ||
                         strpos($post->post_content, '<img') !== false;
            if ($has_images) {
                return true;
            }
        }
    }
    
    return false;
}

/**
 * Preload critical images for performance
 */
function logic_nagoya_preload_critical_images() {
    $critical_images = array();
    
    // Preload hero images on front page
    if (is_front_page()) {
        $hero_image_id = get_theme_mod('hero_image');
        if ($hero_image_id) {
            $hero_image = wp_get_attachment_image_src($hero_image_id, 'hero-desktop');
            if ($hero_image) {
                $critical_images[] = $hero_image[0];
            }
        }
    }
    
    // Preload featured image on single posts
    if (is_singular() && has_post_thumbnail()) {
        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
        if ($featured_image) {
            $critical_images[] = $featured_image[0];
        }
    }
    
    // Output preload links
    foreach ($critical_images as $image_url) {
        // Check for WebP version
        $webp_url = logic_nagoya_get_webp_url($image_url);
        $preload_url = ($webp_url !== $image_url) ? $webp_url : $image_url;
        
        echo '<link rel="preload" as="image" href="' . esc_url($preload_url) . '">' . "\n";
    }
}

/**
 * Generate WebP images on upload
 */
function logic_nagoya_generate_webp_on_upload($metadata) {
    if (!function_exists('imagewebp')) {
        return $metadata;
    }
    
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . '/' . $metadata['file'];
    
    // Generate WebP for main image
    if (file_exists($file_path)) {
        $webp_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $file_path);
        logic_nagoya_convert_image_to_webp($file_path, $webp_path);
    }
    
    // Generate WebP for all thumbnail sizes
    if (isset($metadata['sizes']) && is_array($metadata['sizes'])) {
        foreach ($metadata['sizes'] as $size => $size_data) {
            $size_file_path = $upload_dir['basedir'] . '/' . dirname($metadata['file']) . '/' . $size_data['file'];
            if (file_exists($size_file_path)) {
                $webp_size_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $size_file_path);
                logic_nagoya_convert_image_to_webp($size_file_path, $webp_size_path);
            }
        }
    }
    
    return $metadata;
}

/**
 * Convert image to WebP format
 */
function logic_nagoya_convert_image_to_webp($source_path, $webp_path) {
    if (!function_exists('imagewebp') || file_exists($webp_path)) {
        return false;
    }
    
    $image_info = getimagesize($source_path);
    if (!$image_info) {
        return false;
    }
    
    $image = null;
    switch ($image_info['mime']) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source_path);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source_path);
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
            break;
        default:
            return false;
    }
    
    if ($image) {
        $result = imagewebp($image, $webp_path, 90);
        imagedestroy($image);
        return $result;
    }
    
    return false;
}

/**
 * Enhanced WebP URL helper
 */
function logic_nagoya_get_optimized_webp_url($image_url) {
    if (!$image_url) {
        return $image_url;
    }
    
    // Check if browser supports WebP
    $supports_webp = false;
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        $supports_webp = strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
    }
    
    if (!$supports_webp) {
        return $image_url;
    }
    
    $webp_url = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $image_url);
    
    // Check if WebP file exists
    $upload_dir = wp_upload_dir();
    $webp_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $webp_url);
    
    if (file_exists($webp_path)) {
        return $webp_url;
    }
    
    return $image_url;
}

/**
 * Image performance debug output
 */
function logic_nagoya_image_performance_debug() {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return;
    }
    
    echo '<!-- Logic Nagoya Image Optimization Debug -->' . "\n";
    echo '<script>console.log("Logic Nagoya Image Optimization: Loaded");</script>' . "\n";
}

/**
 * Enhanced image optimization initialization for Task 017
 */
function logic_nagoya_task017_complete_init() {
    // Load advanced image optimization assets when needed
    if (logic_nagoya_needs_advanced_image_optimization()) {
        add_action('wp_enqueue_scripts', 'logic_nagoya_load_image_optimization_assets', 15);
    }
    
    // Initialize WebP generation
    add_filter('wp_generate_attachment_metadata', 'logic_nagoya_generate_webp_on_upload');
    
    // Add critical image preloading
    add_action('wp_head', 'logic_nagoya_preload_critical_images', 1);
    
    // Debug output in development
    if (defined('WP_DEBUG') && WP_DEBUG) {
        add_action('wp_footer', 'logic_nagoya_image_performance_debug');
    }
}
add_action('init', 'logic_nagoya_task017_complete_init');

/**
 * Override the needs image optimization function to use new system
 */
function logic_nagoya_needs_image_optimization() {
    return logic_nagoya_needs_advanced_image_optimization();
}
