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

if ( ! function_exists( 'logic_nagoya_get_page_template_map' ) ) {
        /**
         * Provides the canonical mapping of template identifiers to template files.
         *
         * The map is used by logic_nagoya_template_include() to resolve templates based on
         * either a custom field or the legacy slug-based routing. Developers can filter the
         * map via the `logic_nagoya_page_template_map` hook.
         *
         * @since 1.0.0
         *
         * @return array<string, string> Associative array of identifiers to template files.
         */
        function logic_nagoya_get_page_template_map() {
                $template_map = array(
                        'about'            => 'page-about.php',
                        'events'           => 'page-events.php',
                        'equipment-list'   => 'page-equipment-list.php',
                        'equipment'        => 'page-equipment.php',
                        'floor-map'        => 'page-floor-map.php',
                        'system-pricing'   => 'page-system-pricing.php',
                        'access'           => 'page-access.php',
                );

                return apply_filters( 'logic_nagoya_page_template_map', $template_map );
        }
}

if ( ! function_exists( 'logic_nagoya_get_field' ) ) {
        /**
         * Safe wrapper for Advanced Custom Fields' get_field function.
         *
         * @param string     $selector     The field name or key.
         * @param int|string $post_id      Optional. Post ID where the value is saved.
         * @param bool       $format_value Optional. Whether to apply formatting.
         * @param mixed      $default      Optional. Default value when ACF is unavailable.
         *
         * @return mixed|null
         */
        function logic_nagoya_get_field( $selector, $post_id = false, $format_value = true, $default = null ) {
                if ( function_exists( 'get_field' ) ) {
                        $value = get_field( $selector, $post_id, $format_value );

                        return null !== $value ? $value : $default;
                }

                return $default;
        }
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
	
}


// ============================================================
// SEO最適化機能
// ============================================================

/**
 * SEO機能の初期化
 */
function logic_nagoya_seo_init() {
    // テーマサポートの追加
    // カスタムメタタグの追加
    add_action('wp_head', 'logic_nagoya_meta_tags', 1);
    add_action('wp_head', 'logic_nagoya_structured_data', 5);
    add_action('wp_head', 'logic_nagoya_social_meta', 10);
    
    // XMLサイトマップの設定
    add_action('init', 'logic_nagoya_sitemap_init');
    
    // robots.txtの最適化
    add_filter('robots_txt', 'logic_nagoya_robots_txt');
    
    // カノニカルURLの設定
    add_action('wp_head', 'logic_nagoya_canonical_url');
}
add_action('after_setup_theme', 'logic_nagoya_seo_init');

/**
 * 動的メタタグの生成
 */
function logic_nagoya_meta_tags() {
    // メタディスクリプション
    $description = logic_nagoya_get_meta_description();
    if ($description) {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }
    
    // メタキーワード（必要に応じて）
    $keywords = logic_nagoya_get_meta_keywords();
    if ($keywords) {
        echo '<meta name="keywords" content="' . esc_attr($keywords) . '">' . "\n";
    }

    // 検索エンジン向け指示
    if (is_search() || is_404()) {
        echo '<meta name="robots" content="noindex, nofollow">' . "\n";
    } else {
        echo '<meta name="robots" content="index, follow">' . "\n";
    }
}

/**
 * メタディスクリプションの動的生成
 */
function logic_nagoya_get_meta_description() {
    $description = '';
    
    if (is_home() || is_front_page()) {
        $description = 'Logic Nagoyaは名古屋栄のプレミアムライブハウス。最新音響・照明設備でライブ、トークイベント、配信まで対応。';
        
    } elseif (is_singular('event')) {
        $event_date = logic_nagoya_get_field('event_date');
        $description = 'Logic Nagoyaで開催される「' . get_the_title() . '」';
        
        if ($event_date) {
            $description .= '（' . wp_date('Y年m月d日', strtotime($event_date)) . '開催）';
        }
        
        $excerpt = get_the_excerpt();
        if ($excerpt) {
            $description .= 'の詳細情報。' . wp_trim_words($excerpt, 15, '...');
        }
        
    } elseif (is_post_type_archive('event')) {
        $description = 'Logic Nagoyaで開催される今後のイベント一覧。ライブ、トークショー、配信イベントなど多彩なラインナップ。';
        
    } elseif (is_page('about')) {
        $description = '名古屋栄のライブハウス「Logic Nagoya」の会社概要、コンセプト、特徴をご紹介。';
        
    } elseif (is_page('equipment')) {
        $description = 'Logic Nagoyaの音響・照明・映像機材の詳細リスト。プロフェッショナルな設備でイベントをサポート。';
        
    } elseif (is_page('pricing')) {
        $description = 'Logic Nagoyaの利用料金とシステムのご案内。ライブから配信まで様々な用途に対応した料金プラン。';
        
    } elseif (is_singular()) {
        $excerpt = get_the_excerpt();
        if ($excerpt) {
            $description = wp_trim_words($excerpt, 25, '...');
        }
        
    } elseif (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        if ($term && $term->description) {
            $description = wp_trim_words($term->description, 25, '...');
        }
    }
    
    // 文字数制限（160文字以下）
    if (mb_strlen($description) > 160) {
        $description = mb_substr($description, 0, 157) . '...';
    }
    
    return $description;
}

/**
 * メタキーワードの生成
 */
function logic_nagoya_get_meta_keywords() {
    $keywords = ['Logic Nagoya', 'ライブハウス', '名古屋', '栄'];
    
    if (is_singular('event')) {
        $terms = get_the_terms(get_the_ID(), 'event_category');
        if ($terms) {
            foreach ($terms as $term) {
                $keywords[] = $term->name;
            }
        }
        $keywords[] = 'イベント';
        $keywords[] = 'ライブ';
        
    } elseif (is_page('equipment')) {
        $keywords = array_merge($keywords, ['音響機材', '照明', '映像', '設備']);
        
    } elseif (is_page('pricing')) {
        $keywords = array_merge($keywords, ['料金', '貸切', 'レンタル']);
    }
    
    return implode(', ', array_unique($keywords));
}

// ============================================================
// 構造化データ（Schema.org JSON-LD）
// ============================================================

/**
 * 構造化データの出力
 */
function logic_nagoya_structured_data() {
    $schema_data = [];
    
    // 基本的な組織情報
    $schema_data[] = logic_nagoya_organization_schema();
    
    // ローカルビジネス情報
    $schema_data[] = logic_nagoya_local_business_schema();
    
    // ページ固有の構造化データ
    if (is_singular('event')) {
        $schema_data[] = logic_nagoya_event_schema();
    } elseif (is_front_page() || is_home()) {
        $schema_data[] = logic_nagoya_website_schema();
    } elseif (is_page('about')) {
        $schema_data[] = logic_nagoya_about_page_schema();
    }
    
    // パンくずリスト
    if (!is_front_page()) {
        $schema_data[] = logic_nagoya_breadcrumb_schema();
    }
    
    // JSON-LD形式で出力
    foreach ($schema_data as $schema) {
        if (!empty($schema)) {
            echo '<script type="application/ld+json">' . "\n";
            echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
            echo '</script>' . "\n";
        }
    }
}

/**
 * 組織情報のスキーマ
 */
function logic_nagoya_organization_schema() {
    $contact_info = logic_nagoya_get_field('contact_info', 'option') ?: [];
    $social_media = logic_nagoya_get_field('social_media', 'option') ?: [];
    
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'Logic Nagoya',
        'alternateName' => 'ロジックナゴヤ',
        'url' => home_url('/'),
        'logo' => get_template_directory_uri() . '/assets/images/logo.png',
        'description' => '名古屋栄のプレミアムライブハウス。最新設備でライブ、トークイベント、配信をサポート。',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $contact_info['address'] ?? '愛知県名古屋市中区栄3-13-31',
            'addressLocality' => '名古屋市',
            'addressRegion' => '愛知県',
            'postalCode' => '460-0008',
            'addressCountry' => 'JP'
        ],
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => $contact_info['phone'] ?? '052-241-7772',
            'email' => $contact_info['email'] ?? 'info@logicnagoya.com',
            'contactType' => 'customer service',
            'availableLanguage' => 'Japanese'
        ],
        'sameAs' => array_filter([
            $social_media['twitter_url'] ?? '',
            $social_media['facebook_url'] ?? '',
            $social_media['instagram_url'] ?? '',
            $social_media['youtube_url'] ?? ''
        ])
    ];
}

/**
 * ローカルビジネス情報のスキーマ
 */
function logic_nagoya_local_business_schema() {
    $contact_info = logic_nagoya_get_field('contact_info', 'option') ?: [];
    
    return [
        '@context' => 'https://schema.org',
        '@type' => 'MusicVenue',
        'name' => 'Logic Nagoya',
        'image' => get_template_directory_uri() . '/assets/images/venue-photo.jpg',
        'description' => '名古屋栄にあるライブハウス。音響・照明・映像設備を完備し、ライブイベントから配信まで対応。',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $contact_info['address'] ?? '愛知県名古屋市中区栄3-13-31',
            'addressLocality' => '名古屋市',
            'addressRegion' => '愛知県',
            'postalCode' => '460-0008',
            'addressCountry' => 'JP'
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => 35.168251,
            'longitude' => 136.906239
        ],
        'telephone' => $contact_info['phone'] ?? '052-241-7772',
        'email' => $contact_info['email'] ?? 'info@logicnagoya.com',
        'url' => home_url('/'),
        'priceRange' => '¥¥',
        'currenciesAccepted' => 'JPY',
        'paymentAccepted' => 'Cash, Credit Card',
        'openingHours' => 'Mo-Su 10:00-22:00',
        'amenityFeature' => [
            [
                '@type' => 'LocationFeatureSpecification',
                'name' => '音響設備',
                'value' => 'd&b audiotechnik PAシステム'
            ],
            [
                '@type' => 'LocationFeatureSpecification',
                'name' => '照明設備',
                'value' => 'LED照明・ムービングライト完備'
            ],
            [
                '@type' => 'LocationFeatureSpecification',
                'name' => '配信設備',
                'value' => 'マルチカメラ配信対応'
            ]
        ]
    ];
}

/**
 * イベント情報のスキーマ
 */
function logic_nagoya_event_schema() {
    if (!is_singular('event')) {
        return null;
    }
    
    $event_date = logic_nagoya_get_field('event_date');
    $event_time_open = logic_nagoya_get_field('event_time_open');
    $pricing = logic_nagoya_get_field('event_pricing') ?: [];
    $performers = logic_nagoya_get_field('event_performers') ?: [];
    $contact_info = logic_nagoya_get_field('contact_info', 'option') ?: [];

    if ($event_date) {
        $start_date = $event_date;
        if ($event_time_open) {
            $start_date .= 'T' . $event_time_open . ':00';
        }
    } else {
        $start_date = get_post_time('c', true);
    }
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'MusicEvent',
        'name' => get_the_title(),
        'description' => get_the_excerpt() ?: get_the_content(),
        'url' => get_permalink(),
        'startDate' => $start_date,
        'location' => [
            '@type' => 'MusicVenue',
            'name' => 'Logic Nagoya',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $contact_info['address'] ?? '愛知県名古屋市中区栄3-13-31',
                'addressLocality' => '名古屋市',
                'addressRegion' => '愛知県',
                'addressCountry' => 'JP'
            ]
        ],
        'organizer' => [
            '@type' => 'Organization',
            'name' => 'Logic Nagoya',
            'url' => home_url('/')
        ]
    ];
    
    // 出演者情報
    if (!empty($performers) && is_array($performers)) {
        $schema['performer'] = [];
        foreach ($performers as $performer) {
            $schema['performer'][] = [
                '@type' => 'MusicGroup',
                'name' => $performer['performer_name'],
                'description' => $performer['performer_bio'] ?? ''
            ];
        }
    }
    
    // チケット情報
    if (!empty($pricing) && (!empty($pricing['price_advance']) || !empty($pricing['price_door']))) {
        $offers = [];

        if (!empty($pricing['price_advance'])) {
            $offers[] = [
                '@type' => 'Offer',
                'name' => '前売りチケット',
                'price' => $pricing['price_advance'],
                'priceCurrency' => 'JPY',
                'availability' => 'https://schema.org/InStock',
                'validFrom' => wp_date('Y-m-d')
            ];
        }

        if (!empty($pricing['price_door'])) {
            $offers[] = [
                '@type' => 'Offer',
                'name' => '当日券',
                'price' => $pricing['price_door'],
                'priceCurrency' => 'JPY',
                'availability' => 'https://schema.org/InStock'
            ];
        }
        
        $schema['offers'] = $offers;
    }
    
    // イベント画像
    if (has_post_thumbnail()) {
        $schema['image'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
    }
    
    return $schema;
}

/**
 * ウェブサイト情報のスキーマ
 */
function logic_nagoya_website_schema() {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'url' => home_url('/'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => home_url('/?s={search_term_string}'),
            'query-input' => 'required name=search_term_string'
        ]
    ];
}

/**
 * アバウトページのスキーマ
 */
function logic_nagoya_about_page_schema() {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        'name' => get_the_title(),
        'description' => logic_nagoya_get_meta_description(),
        'url' => get_permalink(),
        'mainEntity' => [
            '@type' => 'Organization',
            'name' => 'Logic Nagoya',
            'url' => home_url('/'),
            'description' => '名古屋栄にあるプレミアムライブハウス。最新設備でライブイベントから配信まで対応。'
        ]
    ];
}

/**
 * パンくずリストのスキーマ
 */
function logic_nagoya_breadcrumb_schema() {
    $breadcrumbs = logic_nagoya_get_breadcrumbs();
    
    if (empty($breadcrumbs)) {
        return null;
    }
    
    $list_items = [];
    foreach ($breadcrumbs as $index => $breadcrumb) {
        $list_items[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $breadcrumb['title'],
            'item' => $breadcrumb['url']
        ];
    }
    
    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $list_items
    ];
}

// ============================================================
// SNS最適化（Open Graph、Twitter Cards）
// ============================================================

/**
 * ソーシャルメディア用メタタグ
 */
function logic_nagoya_social_meta() {
    // Open Graph
    logic_nagoya_open_graph_tags();

    // Twitter Cards
    logic_nagoya_twitter_card_tags();
}

/**
 * Resolve the canonical URL used for social meta tags.
 *
 * @return string
 */
function logic_nagoya_get_social_meta_url() {
    $canonical_url = wp_get_canonical_url();

    if (! empty($canonical_url)) {
        return $canonical_url;
    }

    if (is_singular()) {
        $permalink = get_permalink();

        if (! empty($permalink)) {
            return $permalink;
        }
    }

    return trailingslashit(home_url());
}

/**
 * Open Graph タグ
 */
function logic_nagoya_open_graph_tags() {
    $meta_url = logic_nagoya_get_social_meta_url();

    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    echo '<meta property="og:locale" content="ja_JP">' . "\n";

    if (is_singular()) {
        echo '<meta property="og:type" content="article">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(logic_nagoya_get_meta_description()) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($meta_url) . '">' . "\n";

        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
            echo '<meta property="og:image" content="' . esc_url($image[0]) . '">' . "\n";
            echo '<meta property="og:image:width" content="' . esc_attr($image[1]) . '">' . "\n";
            echo '<meta property="og:image:height" content="' . esc_attr($image[2]) . '">' . "\n";
        }

        // 記事固有の情報
        echo '<meta property="article:published_time" content="' . get_the_date('c') . '">' . "\n";
        echo '<meta property="article:modified_time" content="' . get_the_modified_date('c') . '">' . "\n";

    } else {
        echo '<meta property="og:type" content="website">' . "\n";
        echo '<meta property="og:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
        echo '<meta property="og:description" content="' . esc_attr(logic_nagoya_get_meta_description()) . '">' . "\n";
        echo '<meta property="og:url" content="' . esc_url($meta_url) . '">' . "\n";

        // デフォルト画像
        $default_image = get_template_directory_uri() . '/assets/images/og-default.jpg';
        echo '<meta property="og:image" content="' . esc_url($default_image) . '">' . "\n";
    }
}

/**
 * Twitter Card タグ
 */
function logic_nagoya_twitter_card_tags() {
    $meta_url = logic_nagoya_get_social_meta_url();

    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:site" content="@logicnagoya">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr(wp_get_document_title()) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr(logic_nagoya_get_meta_description()) . '">' . "\n";
    echo '<meta name="twitter:url" content="' . esc_url($meta_url) . '">' . "\n";

    if (is_singular() && has_post_thumbnail()) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
        echo '<meta name="twitter:image" content="' . esc_url($image[0]) . '">' . "\n";
    } else {
        $default_image = get_template_directory_uri() . '/assets/images/twitter-default.jpg';
        echo '<meta name="twitter:image" content="' . esc_url($default_image) . '">' . "\n";
    }
}

// ============================================================
// パンくずリスト
// ============================================================

/**
 * パンくずリストの生成
 */
function logic_nagoya_get_breadcrumbs() {
    $breadcrumbs = [];
    
    // ホーム
    $breadcrumbs[] = [
        'title' => 'ホーム',
        'url' => home_url('/')
    ];
    
    if (is_singular('event')) {
        $breadcrumbs[] = [
            'title' => 'イベント',
            'url' => get_post_type_archive_link('event')
        ];
        $breadcrumbs[] = [
            'title' => get_the_title(),
            'url' => get_permalink()
        ];
        
    } elseif (is_post_type_archive('event')) {
        $breadcrumbs[] = [
            'title' => 'イベント',
            'url' => get_post_type_archive_link('event')
        ];
        
    } elseif (is_page()) {
        $breadcrumbs[] = [
            'title' => get_the_title(),
            'url' => get_permalink()
        ];
        
    } elseif (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        $breadcrumbs[] = [
            'title' => $term->name,
            'url' => get_term_link($term)
        ];
    }
    
    return $breadcrumbs;
}

/**
 * カノニカルURLの設定
 */
function logic_nagoya_canonical_url() {
    $canonical_url = '';
    
    if (is_home() || is_front_page()) {
        $canonical_url = home_url('/');
    } elseif (is_singular()) {
        $canonical_url = get_permalink();
    } elseif (is_post_type_archive()) {
        $canonical_url = get_post_type_archive_link(get_query_var('post_type'));
    } elseif (is_category() || is_tag() || is_tax()) {
        $canonical_url = get_term_link(get_queried_object());
    }
    
    if ($canonical_url) {
        echo '<link rel="canonical" href="' . esc_url($canonical_url) . '">' . "\n";
    }
}

/**
 * robots.txtの最適化
 */
function logic_nagoya_robots_txt($output) {
    $robots_content = "User-agent: *\n";
    $robots_content .= "Disallow: /wp-admin/\n";
    $robots_content .= "Disallow: /wp-includes/\n";
    $robots_content .= "Disallow: /wp-content/plugins/\n";
    $robots_content .= "Disallow: /wp-content/themes/\n";
    $robots_content .= "Disallow: /?s=\n";
    $robots_content .= "Disallow: /search/\n";
    $robots_content .= "Disallow: /author/\n";
    $robots_content .= "Disallow: */trackback/\n";
    $robots_content .= "Disallow: */feed/\n";
    $robots_content .= "Disallow: */comments/\n";
    $robots_content .= "Disallow: *?replytocom\n";
    $robots_content .= "Disallow: *?attachment_id\n";
    $robots_content .= "\n";
    $robots_content .= "Allow: /wp-content/uploads/\n";
    $robots_content .= "\n";
    $robots_content .= "Sitemap: " . home_url('/sitemap.xml') . "\n";
    
    return $robots_content;
}

/**
 * XMLサイトマップの初期化
 */
function logic_nagoya_sitemap_init() {
    // カスタムサイトマップの生成
    add_filter('query_vars', 'logic_nagoya_register_sitemap_query_var');
    add_action('init', 'logic_nagoya_sitemap_rewrite_rules');
    add_action('template_redirect', 'logic_nagoya_sitemap_template');
}

/**
 * サイトマップ用のクエリ変数登録
 */
function logic_nagoya_register_sitemap_query_var($vars) {
    $vars[] = 'sitemap';

    return $vars;
}

/**
 * サイトマップ用のリライトルール
 */
function logic_nagoya_sitemap_rewrite_rules() {
    add_rewrite_rule('^sitemap\.xml$', 'index.php?sitemap=main', 'top');
    add_rewrite_rule('^sitemap-([^/]+)\.xml$', 'index.php?sitemap=$matches[1]', 'top');
}

/**
 * テーマ有効化時のリライトルール更新
 */
function logic_nagoya_flush_rewrite_rules_on_switch() {
    logic_nagoya_sitemap_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'logic_nagoya_flush_rewrite_rules_on_switch');

/**
 * サイトマップのテンプレート処理
 */
function logic_nagoya_sitemap_template() {
    $sitemap = get_query_var('sitemap');
    
    if (!$sitemap) {
        return;
    }
    
    header('Content-Type: application/xml; charset=utf-8');
    header('X-Robots-Tag: noindex');
    
    switch ($sitemap) {
        case 'main':
            logic_nagoya_main_sitemap();
            break;
        case 'posts':
            logic_nagoya_posts_sitemap();
            break;
        case 'events':
            logic_nagoya_events_sitemap();
            break;
        case 'pages':
            logic_nagoya_pages_sitemap();
            break;
        default:
            status_header(404);
            exit;
    }
    
    exit;
}

/**
 * メインサイトマップ（サイトマップインデックス）
 */
function logic_nagoya_main_sitemap() {
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    $current_datetime_utc = current_datetime('UTC')->format(DATE_W3C);

    // ページサイトマップ
    echo '<sitemap>' . "\n";
    echo '<loc>' . home_url('/sitemap-pages.xml') . '</loc>' . "\n";
    echo '<lastmod>' . $current_datetime_utc . '</lastmod>' . "\n";
    echo '</sitemap>' . "\n";

    // 投稿サイトマップ
    echo '<sitemap>' . "\n";
    echo '<loc>' . home_url('/sitemap-posts.xml') . '</loc>' . "\n";
    echo '<lastmod>' . $current_datetime_utc . '</lastmod>' . "\n";
    echo '</sitemap>' . "\n";

    // イベントサイトマップ
    echo '<sitemap>' . "\n";
    echo '<loc>' . home_url('/sitemap-events.xml') . '</loc>' . "\n";
    echo '<lastmod>' . $current_datetime_utc . '</lastmod>' . "\n";
    echo '</sitemap>' . "\n";

    echo '</sitemapindex>' . "\n";
}

/**
 * イベントサイトマップ
 */
function logic_nagoya_events_sitemap() {
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    $current_datetime_utc = current_datetime('UTC')->format(DATE_W3C);

    // イベント一覧ページ
    echo '<url>' . "\n";
    echo '<loc>' . get_post_type_archive_link('event') . '</loc>' . "\n";
    echo '<lastmod>' . $current_datetime_utc . '</lastmod>' . "\n";
    echo '<changefreq>daily</changefreq>' . "\n";
    echo '<priority>0.8</priority>' . "\n";
    echo '</url>' . "\n";
    
    // 個別イベントページ
    $events = get_posts([
        'post_type' => 'event',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ]);
    
    foreach ($events as $event) {
        echo '<url>' . "\n";
        echo '<loc>' . get_permalink($event->ID) . '</loc>' . "\n";
        echo '<lastmod>' . get_the_modified_date(DATE_W3C, $event->ID) . '</lastmod>' . "\n";
        echo '<changefreq>weekly</changefreq>' . "\n";
        echo '<priority>0.6</priority>' . "\n";
        echo '</url>' . "\n";
    }
    
    echo '</urlset>' . "\n";
}

/**
 * 投稿サイトマップ
 */
function logic_nagoya_posts_sitemap() {
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    // 投稿一覧ページ（ブログトップ）
    $posts_page_id = (int) get_option('page_for_posts');

    if ($posts_page_id) {
        echo '<url>' . "\n";
        echo '<loc>' . get_permalink($posts_page_id) . '</loc>' . "\n";
        echo '<lastmod>' . get_the_modified_date(DATE_W3C, $posts_page_id) . '</lastmod>' . "\n";
        echo '<changefreq>daily</changefreq>' . "\n";
        echo '<priority>0.8</priority>' . "\n";
        echo '</url>' . "\n";
    }

    // 公開済み投稿
    $posts = get_posts([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    foreach ($posts as $post) {
        echo '<url>' . "\n";
        echo '<loc>' . get_permalink($post->ID) . '</loc>' . "\n";
        echo '<lastmod>' . get_post_modified_time(DATE_W3C, false, $post) . '</lastmod>' . "\n";
        echo '<changefreq>weekly</changefreq>' . "\n";
        echo '<priority>0.6</priority>' . "\n";
        echo '</url>' . "\n";
    }

    echo '</urlset>' . "\n";
}

/**
 * ページサイトマップ
 */
function logic_nagoya_pages_sitemap() {
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

    $current_datetime_utc = current_datetime('UTC')->format(DATE_W3C);

    // トップページ
    echo '<url>' . "\n";
    echo '<loc>' . home_url('/') . '</loc>' . "\n";
    echo '<lastmod>' . $current_datetime_utc . '</lastmod>' . "\n";
    echo '<changefreq>daily</changefreq>' . "\n";
    echo '<priority>1.0</priority>' . "\n";
    echo '</url>' . "\n";
    
    // 固定ページ
    $pages = get_pages([
        'post_status' => 'publish',
        'sort_column' => 'menu_order'
    ]);
    
    foreach ($pages as $page) {
        $priority = '0.8';
        $changefreq = 'monthly';
        
        // 重要ページの優先度調整
        if (in_array($page->post_name, ['about', 'equipment', 'pricing'])) {
            $priority = '0.9';
            $changefreq = 'weekly';
        }
        
        echo '<url>' . "\n";
        echo '<loc>' . get_permalink($page->ID) . '</loc>' . "\n";
        echo '<lastmod>' . get_the_modified_date(DATE_W3C, $page->ID) . '</lastmod>' . "\n";
        echo '<changefreq>' . $changefreq . '</changefreq>' . "\n";
        echo '<priority>' . $priority . '</priority>' . "\n";
        echo '</url>' . "\n";
    }
    
    echo '</urlset>' . "\n";
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
	
	// Removed empty CSS files to reduce HTTP requests:
	// - css/custom-templates.css (empty)
	// - css/main.css (empty)
	// - css/navigation.css (empty)
	// - css/footer.css (empty)
	
	// Event-specific styles (only load when needed)
	if ( is_post_type_archive('event') || is_singular('event') ) {
		wp_enqueue_style( 'logic-nagoya-event-styles', get_template_directory_uri() . '/event-styles.css', array(), LOGIC_NAGOYA_VERSION );
	}
	
        // Global site interactions
        wp_enqueue_script( 'logic-nagoya-site-interactions', get_template_directory_uri() . '/js/site-interactions.js', array(), LOGIC_NAGOYA_VERSION, true );

        // Removed empty JavaScript files to reduce HTTP requests:
        // - js/navigation.js (empty)
        // - js/main.js (empty)
	
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
	
	// Page-specific styles and scripts (only load when content exists)
	
	// System pricing page
	if ( is_page_template( 'page-system-pricing.php' ) ) {
		$pricing_css = get_template_directory() . '/css/system-pricing.css';
		$pricing_js = get_template_directory() . '/js/system-pricing.js';
		
		if ( file_exists( $pricing_css ) && filesize( $pricing_css ) > 0 ) {
			wp_enqueue_style( 'logic-nagoya-system-pricing', get_template_directory_uri() . '/css/system-pricing.css', array(), LOGIC_NAGOYA_VERSION );
		}
		if ( file_exists( $pricing_js ) && filesize( $pricing_js ) > 0 ) {
			wp_enqueue_script( 'logic-nagoya-system-pricing', get_template_directory_uri() . '/js/system-pricing.js', array('jquery'), LOGIC_NAGOYA_VERSION, true );
		}
	}
	
	// Events page
	if ( is_page_template( 'page-events.php' ) ) {
		$events_css = get_template_directory() . '/css/events-page.css';
		$events_js = get_template_directory() . '/js/events-page.js';
		
		if ( file_exists( $events_css ) && filesize( $events_css ) > 0 ) {
			wp_enqueue_style( 'logic-nagoya-events-styles', get_template_directory_uri() . '/css/events-page.css', array(), LOGIC_NAGOYA_VERSION );
		}
		if ( file_exists( $events_js ) && filesize( $events_js ) > 0 ) {
			wp_enqueue_script( 'logic-nagoya-events-page', get_template_directory_uri() . '/js/events-page.js', array('jquery'), LOGIC_NAGOYA_VERSION, true );
		}
	}
	
	// Equipment pages
	if ( is_page_template( 'page-equipment.php' ) || is_page_template( 'page-equipment-list.php' ) ) {
		$equipment_css = get_template_directory() . '/css/equipment-page.css';
		$equipment_js = get_template_directory() . '/js/equipment-page.js';
		
		if ( file_exists( $equipment_css ) && filesize( $equipment_css ) > 0 ) {
			wp_enqueue_style( 'logic-nagoya-equipment-styles', get_template_directory_uri() . '/css/equipment-page.css', array(), LOGIC_NAGOYA_VERSION );
		}
		if ( file_exists( $equipment_js ) && filesize( $equipment_js ) > 0 ) {
			wp_enqueue_script( 'logic-nagoya-equipment-page', get_template_directory_uri() . '/js/equipment-page.js', array('jquery'), LOGIC_NAGOYA_VERSION, true );
		}
	}
	
	// About page
	if ( is_page_template( 'page-about.php' ) ) {
		$about_css = get_template_directory() . '/css/about-page.css';
		$about_js = get_template_directory() . '/js/about-page.js';
		
		if ( file_exists( $about_css ) && filesize( $about_css ) > 0 ) {
			wp_enqueue_style( 'logic-nagoya-about-styles', get_template_directory_uri() . '/css/about-page.css', array(), LOGIC_NAGOYA_VERSION );
		}
		if ( file_exists( $about_js ) && filesize( $about_js ) > 0 ) {
			wp_enqueue_script( 'logic-nagoya-about-page', get_template_directory_uri() . '/js/about-page.js', array('jquery'), LOGIC_NAGOYA_VERSION, true );
		}
	}
	
	// Floor map page
	if ( is_page_template( 'page-floor-map.php' ) ) {
		$floor_map_css = get_template_directory() . '/css/floor-map-page.css';
		$floor_map_js = get_template_directory() . '/js/floor-map-page.js';
		
		if ( file_exists( $floor_map_css ) && filesize( $floor_map_css ) > 0 ) {
			wp_enqueue_style( 'logic-nagoya-floor-map-styles', get_template_directory_uri() . '/css/floor-map-page.css', array(), LOGIC_NAGOYA_VERSION );
		}
		if ( file_exists( $floor_map_js ) && filesize( $floor_map_js ) > 0 ) {
			wp_enqueue_script( 'logic-nagoya-floor-map-page', get_template_directory_uri() . '/js/floor-map-page.js', array('jquery'), LOGIC_NAGOYA_VERSION, true );
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
 * Enqueue media library and admin scripts for page meta boxes.
 */
function logic_nagoya_enqueue_page_media_assets( $hook ) {
    if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
        return;
    }

    $screen = get_current_screen();

    if ( ! $screen || 'page' !== $screen->post_type ) {
        return;
    }

    wp_enqueue_media();

    wp_enqueue_script(
        'logic-nagoya-page-media',
        get_template_directory_uri() . '/js/admin-page-media.js',
        array( 'jquery' ),
        LOGIC_NAGOYA_VERSION,
        true
    );

    wp_localize_script(
        'logic-nagoya-page-media',
        'logicNagoyaPageMedia',
        array(
            'floorPlan' => array(
                'title'      => __( 'Select or Upload Floor Plan Image', 'logic-nagoya' ),
                'buttonText' => __( 'Use this image', 'logic-nagoya' ),
                'previewAlt' => __( 'Floor plan image preview', 'logic-nagoya' ),
            ),
            'concept'   => array(
                'title'      => __( 'Select or Upload Concept Image', 'logic-nagoya' ),
                'buttonText' => __( 'Use this image', 'logic-nagoya' ),
                'previewAlt' => __( 'Concept image preview', 'logic-nagoya' ),
            ),
            'equipment' => array(
                'title'      => __( 'Select or Upload Equipment PDF', 'logic-nagoya' ),
                'buttonText' => __( 'Use this PDF', 'logic-nagoya' ),
            ),
        )
    );
}
add_action( 'admin_enqueue_scripts', 'logic_nagoya_enqueue_page_media_assets' );

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

/**
 * Setup default menu items for primary menu
 */
function logic_nagoya_setup_default_menu() {
    // Check if primary menu already exists
    $locations = get_nav_menu_locations();
    if (isset($locations['menu-1'])) {
        return; // Menu already exists, don't create a new one
    }
    
    // Create a new menu
    $menu_name = 'Primary Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Add home page
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'HOME',
            'menu-item-url' => home_url('/'),
            'menu-item-status' => 'publish',
            'menu-item-position' => 1
        ));
        
        // Add about page
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'ABOUT',
            'menu-item-url' => site_url('/about/'),
            'menu-item-status' => 'publish',
            'menu-item-position' => 2
        ));
        
        // Add events page
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'EVENTS',
            'menu-item-url' => site_url('/events/'),
            'menu-item-status' => 'publish',
            'menu-item-position' => 3
        ));
        
        // Add system pricing page - Corrected order
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'システム・料金',
            'menu-item-url' => site_url('/system-pricing/'),
            'menu-item-status' => 'publish',
            'menu-item-position' => 4
        ));
        
        // Add equipment page - Corrected order
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => '設備',
            'menu-item-url' => site_url('/equipment-list/'),
            'menu-item-status' => 'publish',
            'menu-item-position' => 5
        ));
        
        // Add floor map/access page
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => 'アクセス',
            'menu-item-url' => site_url('/floor-map/'),
            'menu-item-status' => 'publish',
            'menu-item-position' => 6
        ));
        
        // Assign menu to primary location
        $locations = get_nav_menu_locations();
        $locations['menu-1'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}
add_action('after_switch_theme', 'logic_nagoya_setup_default_menu');

/**
 * Create a default menu as a fallback
 */
function logic_nagoya_default_menu() {
    echo '<ul class="nav-links">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">HOME</a></li>';
    echo '<li><a href="' . esc_url(site_url('/about/')) . '">ABOUT</a></li>';
    echo '<li><a href="' . esc_url(site_url('/events/')) . '">EVENTS</a></li>';
    echo '<li><a href="' . esc_url(site_url('/system-pricing/')) . '">システム・料金</a></li>';
    echo '<li><a href="' . esc_url(site_url('/equipment-list/')) . '">設備</a></li>';
    echo '<li><a href="' . esc_url(site_url('/floor-map/')) . '">アクセス</a></li>';
    echo '</ul>';
}

// ============================================================
// 画像最適化・遅延読み込み機能（タスク017完全版）
// ============================================================

/**
 * 高度な画像最適化機能の初期化
 */
function logic_nagoya_advanced_image_optimization_init() {
    static $initialized = false;

    if ( $initialized ) {
        return;
    }

    $initialized = true;

    // WebP対応（改良版）
    add_filter('wp_generate_attachment_metadata', 'logic_nagoya_generate_webp_images_enhanced');

    // 遅延読み込み対応（改良版）
    add_filter('wp_get_attachment_image_attributes', 'logic_nagoya_add_advanced_lazy_loading_attributes', 10, 3);
    add_filter('the_content', 'logic_nagoya_add_lazy_loading_to_content');
    
    // レスポンシブ画像のsrcset最適化
    add_filter('wp_calculate_image_srcset', 'logic_nagoya_optimize_image_srcset', 10, 5);
    
    // 画像品質の最適化
    add_filter('wp_editor_set_quality', 'logic_nagoya_set_image_quality');
    add_filter('jpeg_quality', 'logic_nagoya_set_image_quality');
    
    // クリティカル画像のプリロード
    add_action('wp_head', 'logic_nagoya_preload_critical_images', 1);
    
    // 高度な画像最適化アセットの読み込み
    add_action('wp_enqueue_scripts', 'logic_nagoya_enqueue_advanced_image_assets', 15);
    
    // パフォーマンス監視（開発環境のみ）
    if (defined('WP_DEBUG') && WP_DEBUG) {
        add_action('wp_footer', 'logic_nagoya_image_performance_debug');
    }
}
add_action('init', 'logic_nagoya_advanced_image_optimization_init');

/**
 * 高度な画像最適化が必要かを判定
 */
function logic_nagoya_needs_advanced_image_optimization() {
    if (is_admin()) {
        return false;
    }

    if (has_post_thumbnail()) {
        return true;
    }

    if (is_post_type_archive(array('gallery', 'event')) || is_singular(array('gallery', 'event'))) {
        return true;
    }

    if (is_front_page() || is_home()) {
        return true;
    }

    if (is_page()) {
        global $post;

        if ($post instanceof WP_Post) {
            $custom_images = get_post_meta($post->ID, '_logic_nagoya_floor_plan_image', true) ||
                get_post_meta($post->ID, '_logic_nagoya_concept_image', true) ||
                get_post_meta($post->ID, 'floor_plan_image', true) ||
                get_post_meta($post->ID, 'concept_image', true);

            if ($custom_images || strpos($post->post_content, '<img') !== false) {
                return true;
            }
        }
    }

    return false;
}

/**
 * 旧関数名との互換用ラッパー
 */
function logic_nagoya_needs_image_optimization() {
    return logic_nagoya_needs_advanced_image_optimization();
}

/**
 * WebP画像の高度な自動生成（改良版）
 */
function logic_nagoya_generate_webp_images_enhanced($metadata) {
    if (!function_exists('imagewebp')) {
        return $metadata;
    }
    
    $upload_dir = wp_upload_dir();
    $file_path = $upload_dir['basedir'] . '/' . $metadata['file'];
    
    // 元画像からWebP版を生成（エラーハンドリング強化）
    if (file_exists($file_path)) {
        $webp_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $file_path);
        if (logic_nagoya_convert_to_webp_enhanced($file_path, $webp_path)) {
            // WebP生成成功時のログ（開発環境のみ）
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log('WebP生成成功: ' . basename($webp_path));
            }
        }
    }
    
    // 各サムネイルサイズのWebP版も生成（パフォーマンス最適化）
    if (isset($metadata['sizes']) && is_array($metadata['sizes'])) {
        foreach ($metadata['sizes'] as $size => $size_data) {
            $size_file_path = $upload_dir['basedir'] . '/' . dirname($metadata['file']) . '/' . $size_data['file'];
            if (file_exists($size_file_path)) {
                $webp_size_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $size_file_path);
                logic_nagoya_convert_to_webp_enhanced($size_file_path, $webp_size_path);
            }
        }
    }
    
    return $metadata;
}

/**
 * 高度なWebP変換機能（改良版）
 */
function logic_nagoya_convert_to_webp_enhanced($source_path, $webp_path) {
    if (!function_exists('imagewebp') || file_exists($webp_path)) {
        return false;
    }
    
    $image_info = getimagesize($source_path);
    if (!$image_info) {
        return false;
    }
    
    // ファイルサイズチェック（大きすぎるファイルはスキップ）
    $file_size = filesize($source_path);
    if ($file_size > 10 * 1024 * 1024) { // 10MB以上はスキップ
        return false;
    }
    
    $mime_type = $image_info['mime'];
    $image = null;
    
    try {
        switch ($mime_type) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source_path);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source_path);
                // PNG透明度の高品質保持
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source_path);
                imagepalettetotruecolor($image);
                break;
            default:
                return false;
        }
        
        if (!$image) {
            return false;
        }
        
        // 動的品質設定（ファイルサイズに応じて調整）
        $quality = 85; // デフォルト
        if ($file_size < 500 * 1024) { // 500KB未満は高品質
            $quality = 90;
        } elseif ($file_size > 2 * 1024 * 1024) { // 2MB以上は圧縮優先
            $quality = 80;
        }
        
        $result = imagewebp($image, $webp_path, $quality);
        imagedestroy($image);
        
        // ファイルサイズ減少率をチェック
        if ($result && file_exists($webp_path)) {
            $original_size = filesize($source_path);
            $webp_size = filesize($webp_path);
            
            // WebPが元ファイルより大きい場合は削除
            if ($webp_size >= $original_size) {
                unlink($webp_path);
                return false;
            }
        }
        
        return $result;
        
    } catch (Exception $e) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('WebP変換エラー: ' . $e->getMessage());
        }
        return false;
    }
}

/**
 * 画像品質の最適化
 */
function logic_nagoya_set_image_quality($quality) {
    return 85; // JPEG品質を85%に設定（品質とファイルサイズのバランス）
}

/**
 * 遅延読み込み属性の高度な追加（改良版）
 */
function logic_nagoya_add_advanced_lazy_loading_attributes($attr, $attachment, $size) {
    // 管理画面や特定の条件では遅延読み込みを無効化
    if (is_admin() || is_feed() || (wp_is_mobile() && function_exists('is_amp') && is_amp())) {
        return $attr;
    }

    // Above the foldの画像は遅延読み込みをスキップ
    if (logic_nagoya_is_above_fold_image($attachment, $size)) {
        $attr['class'] = (isset($attr['class']) ? $attr['class'] . ' ' : '') . 'above-fold';
        return $attr;
    }

    // data-src属性に元のsrcを移動し、srcには軽量なプレースホルダーを設定
    if (isset($attr['src'])) {
        // WebP対応 URLを取得
        $optimized_src = logic_nagoya_get_webp_image_url($attr['src']);

        $attr['data-src'] = $optimized_src;
        $attr['src'] = logic_nagoya_get_placeholder_image();
        $attr['class'] = (isset($attr['class']) ? $attr['class'] . ' ' : '') . 'lazy-load';

        // srcsetも遅延読み込み対応（WebP最適化）
        if (isset($attr['srcset'])) {
            $attr['data-srcset'] = logic_nagoya_optimize_srcset_webp($attr['srcset']);
            unset($attr['srcset']);
        }
        
        // sizesも遅延読み込み対応
        if (isset($attr['sizes'])) {
            $attr['data-sizes'] = $attr['sizes'];
            unset($attr['sizes']);
        }
        
        // Retina対応の追加
        $attr['data-retina'] = 'true';
        
        // エラーハンドリング用属性
        $attr['data-retry-count'] = '0';
    }
    
    return $attr;
}

/**
 * コンテンツ内の画像に遅延読み込みを追加
 */
function logic_nagoya_add_lazy_loading_to_content($content) {
    if (is_admin() || is_feed()) {
        return $content;
    }
    
    // img タグに遅延読み込み属性を追加
    $content = preg_replace_callback(
        '/<img([^>]+)>/i',
        function($matches) {
            $img_tag = $matches[0];
            
            // 既に遅延読み込みが設定されている場合はスキップ
            if (strpos($img_tag, 'data-src') !== false || strpos($img_tag, 'lazy-load') !== false) {
                return $img_tag;
            }
            
            // src属性を抽出
            if (preg_match('/src="([^"]+)"/i', $img_tag, $src_matches)) {
                $original_src = $src_matches[1];
                $optimized_src = logic_nagoya_get_webp_image_url($original_src);
                $placeholder = logic_nagoya_get_placeholder_image();

                // src属性をdata-srcに変更し、プレースホルダーを設定
                $img_tag = str_replace(
                    'src="' . $original_src . '"',
                    'src="' . $placeholder . '" data-src="' . $optimized_src . '"',
                    $img_tag
                );

                // srcset属性の処理
                if (preg_match('/srcset="([^"]+)"/i', $img_tag, $srcset_matches)) {
                    $original_srcset = $srcset_matches[1];
                    $optimized_srcset = logic_nagoya_optimize_srcset_webp($original_srcset);
                    $img_tag = str_replace('srcset="' . $original_srcset . '"', 'data-srcset="' . $optimized_srcset . '"', $img_tag);
                }
                
                // sizes属性の処理
                if (preg_match('/sizes="([^"]+)"/i', $img_tag, $sizes_matches)) {
                    $original_sizes = $sizes_matches[1];
                    $img_tag = str_replace('sizes="' . $original_sizes . '"', 'data-sizes="' . $original_sizes . '"', $img_tag);
                }
                
                // クラスに lazy-load を追加
                if (preg_match('/class="([^"]+)"/i', $img_tag)) {
                    $img_tag = preg_replace('/class="([^"]+)"/i', 'class="$1 lazy-load"', $img_tag);
                } else {
                    $img_tag = str_replace('<img', '<img class="lazy-load"', $img_tag);
                }
            }
            
            return $img_tag;
        },
        $content
    );
    
    return $content;
}

/**
 * プレースホルダー画像の取得
 */
function logic_nagoya_get_placeholder_image() {
    // 1x1ピクセルの透明なPNG画像（base64エンコード）
    return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==';
}

/**
 * WebP対応画像URL取得関数
 */
function logic_nagoya_get_webp_image_url($image_url) {
    if (empty($image_url)) {
        return $image_url;
    }
    
    // WebP対応ブラウザチェック
    if (!logic_nagoya_browser_supports_webp()) {
        return $image_url;
    }
    
    $webp_url = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $image_url);
    
    // WebPファイルが存在するかチェック
    $upload_dir = wp_upload_dir();
    $webp_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $webp_url);
    
    if (file_exists($webp_path)) {
        return $webp_url;
    }
    
    return $image_url;
}

/**
 * ブラウザのWebP対応チェック
 */
function logic_nagoya_browser_supports_webp() {
    if (isset($_SERVER['HTTP_ACCEPT'])) {
        return strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
    }
    return false;
}

/**
 * srcsetの最適化
 */
function logic_nagoya_optimize_image_srcset($sources, $size_array, $image_src, $image_meta, $attachment_id) {
    if (!$sources || !logic_nagoya_browser_supports_webp()) {
        return $sources;
    }

    // 各srcsetのURLをWebP版に変換
    foreach ($sources as $width => $source) {
        $webp_url = logic_nagoya_get_webp_image_url($source['url']);
        if ($webp_url !== $source['url']) {
            $sources[$width]['url'] = $webp_url;
        }
    }

    return $sources;
}

/**
 * srcset文字列をWebP対応に変換
 */
function logic_nagoya_optimize_srcset_webp($srcset) {
    if (empty($srcset) || !logic_nagoya_browser_supports_webp()) {
        return $srcset;
    }

    $sources = array_map('trim', explode(',', $srcset));

    foreach ($sources as &$source) {
        $parts = preg_split('/\s+/', $source);

        if (!empty($parts[0])) {
            $parts[0] = logic_nagoya_get_webp_image_url($parts[0]);
        }

        $source = implode(' ', array_filter($parts, 'strlen'));
    }

    return implode(', ', $sources);
}

/**
 * Above the fold画像の判定
 */
function logic_nagoya_is_above_fold_image($attachment, $size) {
    $priority_sizes = array(
        'hero-image',
        'hero-image-2x',
        'hero-desktop',
        'hero-desktop-2x',
        'hero-tablet',
        'hero-tablet-2x',
        'hero-mobile',
        'hero-mobile-2x'
    );

    if (in_array($size, $priority_sizes, true)) {
        return true;
    }

    if (!($attachment instanceof WP_Post)) {
        return false;
    }

    $queried_id = get_queried_object_id();

    if ($queried_id && has_post_thumbnail($queried_id)) {
        $featured_id = get_post_thumbnail_id($queried_id);

        if ($featured_id && (int) $featured_id === (int) $attachment->ID) {
            return is_front_page() || is_singular();
        }
    }

    return false;
}

/**
 * クリティカル画像をプリロード
 */
function logic_nagoya_preload_critical_images() {
    $critical_images = array();

    if (is_front_page()) {
        $hero_image_id = get_theme_mod('hero_image');

        if ($hero_image_id) {
            $hero_image = wp_get_attachment_image_src($hero_image_id, 'hero-desktop');

            if ($hero_image) {
                $critical_images[] = logic_nagoya_get_webp_image_url($hero_image[0]);
            }
        }
    }

    if (is_singular() && has_post_thumbnail()) {
        $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');

        if ($featured_image) {
            $critical_images[] = logic_nagoya_get_webp_image_url($featured_image[0]);
        }
    }

    foreach (array_unique($critical_images) as $image_url) {
        if (empty($image_url)) {
            continue;
        }

        echo '<link rel="preload" as="image" href="' . esc_url($image_url) . '">' . "\n";
    }
}

/**
 * 画像最適化デバッグ情報
 */
function logic_nagoya_image_performance_debug() {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return;
    }

    echo '<!-- Logic Nagoya Image Optimization Debug -->' . "\n";
    echo '<script>console.log("Logic Nagoya Image Optimization: Loaded");</script>' . "\n";
}

/**
 * 高度な画像最適化アセットの読み込み
 */
function logic_nagoya_enqueue_advanced_image_assets() {
    // 高度な画像最適化が必要なページでのみ読み込み
    if (!logic_nagoya_needs_advanced_image_optimization()) {
        return;
    }
    
    // 画像最適化CSS
    wp_enqueue_style(
        'logic-nagoya-image-optimization',
        get_template_directory_uri() . '/css/image-optimization.css',
        array('logic-nagoya-style'),
        LOGIC_NAGOYA_VERSION
    );
    
    // 高度な画像最適化JavaScript
    wp_enqueue_script(
        'logic-nagoya-image-optimization',
        get_template_directory_uri() . '/js/image-optimization.js',
        array(),
        LOGIC_NAGOYA_VERSION,
        true
    );
    
    // Intersection Observer API対応の遅延読み込みスクリプト
    wp_enqueue_script(
        'logic-nagoya-lazy-loading',
        get_template_directory_uri() . '/js/lazy-loading.js',
        array(),
        LOGIC_NAGOYA_VERSION,
        true
    );
    
    // JavaScript設定のローカライズ
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
 * 画像サイズの追加（Retina対応）
 */
function logic_nagoya_add_image_sizes() {
    // 既存のサムネイルサイズのRetina版を追加
    add_image_size('thumbnail-2x', 300, 300, true);
    add_image_size('medium-2x', 600, 600, false);
    add_image_size('large-2x', 2048, 2048, false);
    
    // カスタムサイズのRetina版
    add_image_size('hero-image', 1920, 800, true);
    add_image_size('hero-image-2x', 3840, 1600, true);
    add_image_size('feature-image', 400, 300, true);
    add_image_size('feature-image-2x', 800, 600, true);
    add_image_size('event-thumbnail', 350, 250, true);
    add_image_size('event-thumbnail-2x', 700, 500, true);
    add_image_size('gallery-thumbnail', 300, 200, true);
    add_image_size('gallery-thumbnail-2x', 600, 400, true);
}
add_action('after_setup_theme', 'logic_nagoya_add_image_sizes');

/**
 * レスポンシブ画像タグ生成（WebP対応、Retina対応）
 */
function logic_nagoya_get_responsive_image($attachment_id, $size = 'large', $attr = array()) {
    if (!$attachment_id) {
        return '';
    }
    
    $image_src = wp_get_attachment_image_src($attachment_id, $size);
    if (!$image_src) {
        return '';
    }
    
    $image_srcset = wp_get_attachment_image_srcset($attachment_id, $size);
    $image_sizes = wp_get_attachment_image_sizes($attachment_id, $size);
    $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    
    // WebP対応URL
    $webp_src = logic_nagoya_get_webp_image_url($image_src[0]);
    
    // デフォルト属性
    $default_attr = array(
        'src' => logic_nagoya_get_placeholder_image(),
        'data-src' => $webp_src,
        'alt' => $image_alt,
        'class' => 'lazy-load retina-optimized',
        'width' => $image_src[1],
        'height' => $image_src[2],
    );
    
    // srcsetとsizesの設定
    if ($image_srcset) {
        $default_attr['data-srcset'] = $image_srcset;
    }
    
    if ($image_sizes) {
        $default_attr['data-sizes'] = $image_sizes;
    }
    
    // 属性をマージ
    $attr = array_merge($default_attr, $attr);
    
    // HTMLタグの生成
    $attr_strings = array();
    foreach ( $attr as $key => $value ) {
        if ( empty( $value ) && $value !== '0' ) {
            continue;
        }
        $attr_strings[] = sprintf( '%s="%s"', esc_attr( $key ), esc_attr( $value ) );
    }

    return sprintf( '<img %s>', implode( ' ', $attr_strings ) );
}

/**
 * 画像最適化関連の後方互換ヘルパー
 */
if ( ! function_exists( 'logic_nagoya_load_image_optimization_assets' ) ) {
    function logic_nagoya_load_image_optimization_assets() {
        logic_nagoya_enqueue_advanced_image_assets();
    }
}

if ( ! function_exists( 'logic_nagoya_generate_webp_on_upload' ) ) {
    function logic_nagoya_generate_webp_on_upload( $metadata ) {
        return logic_nagoya_generate_webp_images_enhanced( $metadata );
    }
}

if ( ! function_exists( 'logic_nagoya_convert_image_to_webp' ) ) {
    function logic_nagoya_convert_image_to_webp( $source_path, $webp_path ) {
        return logic_nagoya_convert_to_webp_enhanced( $source_path, $webp_path );
    }
}

if ( ! function_exists( 'logic_nagoya_get_optimized_webp_url' ) ) {
    function logic_nagoya_get_optimized_webp_url( $image_url ) {
        return logic_nagoya_get_webp_image_url( $image_url );
    }
}

if ( ! function_exists( 'logic_nagoya_task017_complete_init' ) ) {
    function logic_nagoya_task017_complete_init() {
        logic_nagoya_advanced_image_optimization_init();
    }
}
