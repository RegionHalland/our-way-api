<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;
use HelsingborgsStad\AcfExportManager;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

/** Add custom taxonomy areas */
add_action('init', function() {
	$labels = array(
		'name'                       => _x( 'Områden', 'Taxonomy General Name', 'ourway' ),
		'singular_name'              => _x( 'Områden', 'Taxonomy Singular Name', 'ourway' ),
		'menu_name'                  => __( 'Områden', 'ourway' ),
		'parent_item'                => __( 'Överordnat område', 'ourway' ),
		'parent_item_colon'          => __( 'Överordnat område:', 'ourway' ),
		'new_item_name'              => __( 'New Item Name', 'ourway' ),
		'add_new_item'               => __( 'Lägg till ett nytt område', 'ourway' ),
		'edit_item'                  => __( 'Edit Item', 'ourway' ),
		'update_item'                => __( 'Update Item', 'ourway' ),
		'view_item'                  => __( 'View Item', 'ourway' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'ourway' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'ourway' ),
		'choose_from_most_used'      => __( 'Välj från de mest använda områdena', 'ourway' ),
		'popular_items'              => __( 'Populära områden', 'ourway' ),
		'search_items'               => __( 'Sök efter område', 'ourway' ),
		'not_found'                  => __( 'Inga områden funna.', 'ourway' ),
		'no_terms'                   => __( 'No items', 'ourway' ),
		'items_list'                 => __( 'Items list', 'ourway' ),
		'items_list_navigation'      => __( 'Items list navigation', 'ourway' ),
    );
    
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_in_rest'               => true
    );
    
	register_taxonomy( 'area', array( 'news', 'event' ), $args );
}, 0);

/** Add custom post type News */
add_action('init', function() {
	$labels = array(
		'name'                  => _x( 'Nyheter', 'Post Type General Name', 'ourway' ),
		'singular_name'         => _x( 'Nyheter', 'Post Type Singular Name', 'ourway' ),
		'menu_name'             => __( 'Nyheter', 'ourway' ),
        'name_admin_bar'        => __( 'Nyheter', 'ourway' ),
		'parent_item_colon'     => __( 'Parent Item:', 'ourway' ),
		'search_items'          => __( 'Search Item', 'ourway' ),
		'items_list'            => __( 'Items list', 'ourway' ),
		'items_list_navigation' => __( 'Items list navigation', 'ourway' ),
		'filter_items_list'     => __( 'Filter items list', 'ourway' ),
    );
    
	$args = array(
		'label'                 => __( 'News', 'ourway' ),
		'description'           => __( 'News', 'ourway' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'area' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-rss',
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'show_in_nav_rest'      => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'               => true
    );
    
	register_post_type( 'news', $args );
}, 0);

/** Add custom post type Events */
add_action('init', function() {
    $labels = array(
		'name'                  => _x( 'Evenemang', 'Post Type General Name', 'ourway' ),
		'singular_name'         => _x( 'Evenemang', 'Post Type Singular Name', 'ourway' ),
		'menu_name'             => __( 'Evenemang', 'ourway' ),
        'name_admin_bar'        => __( 'Evenemang', 'ourway' ),
		'parent_item_colon'     => __( 'Parent Item:', 'ourway' ),
		'search_items'          => __( 'Search Item', 'ourway' ),
		'items_list'            => __( 'Items list', 'ourway' ),
		'items_list_navigation' => __( 'Items list navigation', 'ourway' ),
		'filter_items_list'     => __( 'Filter items list', 'ourway' ),
    );
    
	$args = array(
		'label'                 => __( 'Event', 'ourway' ),
		'description'           => __( 'Events', 'ourway' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'area' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-calendar',
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
        'show_in_rest'          => true,
        'show_in_rest'          => true
    );
    
    register_post_type( 'event', $args );
    
}, 0);

add_filter('acf/update_value/type=date_time_picker', function( $value, $post_id, $field ) {
	return strtotime($value);	
}, 10, 3);

/* Add options page */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Temainställningar',
		'menu_title'	=> 'Temainställningar',
        'menu_slug' 	=> 'theme-general-settings',
        'position'      => 20,
		'capability'	=> 'edit_posts',
		'redirect'		=> true
    ));
    
    acf_add_options_sub_page(array(
		'page_title' 	=> 'Inställningar för startsidan',
		'menu_title'	=> 'Startsidan',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Inställningar för sidfoten',
		'menu_title'	=> 'Sidfot',
		'parent_slug'	=> 'theme-general-settings',
    ));   
}

/**
 * ACF auto import and export fields
 */
add_action('init', function() {
    if (class_exists('AcfExportManager\AcfExportManager')) {
        $acfExportManager = new \AcfExportManager\AcfExportManager();
        $acfExportManager->setTextdomain('ourway');
        $acfExportManager->setExportFolder(__DIR__ . '/acf');
        $acfExportManager->autoExport(array(
            'evenemang' => 'group_5cd1795ef09a6',
            'område' => 'group_5cd27c0c373e2',
            'sidfot' => 'group_5cd27a0022129',
            'startsidan' => 'group_5cd278e2007e1'
        ));
        $acfExportManager->import();
    }
});