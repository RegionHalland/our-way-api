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
 * Manipulate the admin menu
 */
add_action('admin_menu', function() {
    // Remove pages not needed
    remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');
});

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

/**
* Custom Post Type - Department 
*/
add_action('init', function() {
    $labels = array(
        'name'                  => _x( 'Avdelning', 'Post Type General Name', 'ourway' ),
        'singular_name'         => _x( 'Avdelning', 'Post Type Singular Name', 'ourway' ),
        'menu_name'             => __( 'Avdelning', 'ourway' ),
        'name_admin_bar'        => __( 'Avdelning', 'ourway' ),
        'parent_item_colon'     => __( 'Parent Item:', 'ourway' ),
        'search_items'          => __( 'Search Item', 'ourway' ),
        'items_list'            => __( 'Items list', 'ourway' ),
        'items_list_navigation' => __( 'Items list navigation', 'ourway' ),
        'filter_items_list'     => __( 'Filter items list', 'ourway' ),
    );

    $rewrite = array(
        'slug'                  => 'avdelningar',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    
    $args = array(
        'label'                 => __( 'Department', 'ourway' ),
        'description'           => __( 'Departments', 'ourway' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'author', 'page-attributes'),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-category',
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'show_in_nav_rest'      => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
        'rewrite'               => $rewrite
    );
    
    register_post_type( 'department', $args );
}, 0);

/**
 * Custom Post Type - News 
 */
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

    $rewrite = array(
		'slug'                  => 'nyheter',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
    
	$args = array(
		'label'                 => __( 'News', 'ourway' ),
		'description'           => __( 'News', 'ourway' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'author', 'page-attributes'),
		'hierarchical'          => true,
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
        'show_in_rest'          => true,
        'rewrite'               => $rewrite
    );
    
	register_post_type( 'news', $args );
}, 0);

/**
 * Custom Post Type - Events 
 */
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

    $rewrite = array(
		'slug'                  => 'evenemang',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
    
	$args = array(
		'label'                 => __( 'Event', 'ourway' ),
		'description'           => __( 'Events', 'ourway' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'author' ),
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
        'rewrite'               => $rewrite
    );
    
    register_post_type( 'event', $args );
    
}, 0);

/**
 * Custom Post Type - Contact 
 */
add_action('init', function() {
    $labels = array(
        'name'                  => _x( 'Kontaktpersoner', 'Post Type General Name', 'ourway' ),
        'singular_name'         => _x( 'Kontaktpersoner', 'Post Type Singular Name', 'ourway' ),
        'menu_name'             => __( 'Kontaktpersoner', 'ourway' ),
        'name_admin_bar'        => __( 'Kontaktpersoner', 'ourway' ),
        'parent_item_colon'     => __( 'Parent Item:', 'ourway' ),
        'search_items'          => __( 'Search Item', 'ourway' ),
        'items_list'            => __( 'Items list', 'ourway' ),
        'items_list_navigation' => __( 'Items list navigation', 'ourway' ),
        'filter_items_list'     => __( 'Filter items list', 'ourway' ),
    );

    $rewrite = array(
        'slug'                  => 'evenemang',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    
    $args = array(
        'label'                 => __( 'Contact', 'ourway' ),
        'description'           => __( 'Contacts', 'ourway' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'author' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-businesswoman',
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
        'rewrite'               => $rewrite
    );
    
    register_post_type( 'contact', $args );
    
}, 0);


add_filter('acf/update_value/type=date_time_picker', function( $value, $post_id, $field ) {
	return strtotime($value);	
}, 10, 3);

/**
 * Add options page 
 */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title'    => 'Innehåll',
        'menu_title'    => 'Innehåll',
        'menu_slug'     => 'theme-general',
        'position'      => 20,
        'capability'    => 'edit_posts',
        'redirect'      => true
    ));
    acf_add_options_sub_page(array(
        'page_title'    => 'Startsida',
        'menu_title'    => 'Startsida',
        'parent_slug'   => 'theme-general',
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
            'department_parent' => 'group_5ddb97bdb9dac',
            'department_children' => 'group_5ddb9cec17d4d',
            'options_homepage' => 'group_5dde6fcc6caed',
            'media_attachments' => 'group_5dde724e9b3b9',
        ));
        $acfExportManager->import();
    }
});

add_filter( 'rest_prepare_user', function( $response, $user, $request ) {
    $response->data[ 'first_name' ] = get_user_meta( $user->ID, 'first_name', true );
    $response->data[ 'last_name' ] = get_user_meta( $user->ID, 'last_name', true );
    $user_info = get_userdata($user->ID);
    $response->data[ 'email' ] = $user_info->user_email;

    return $response;

}, 10, 3 );

/**
 * Add rule to check custom post type parents in ACF
 * https://support.advancedcustomfields.com/forums/topic/add-condition-page-parent-for-custom-post-types/
 */

add_filter('acf/location/rule_types', function($choices) {
    $choices['Custom Post Types']['cpt_parent'] = 'Custom Post Type Parent';
    return $choices;
});


add_filter('acf/location/rule_values/cpt_parent', function ($choices) {
    $args = array(
        'hierarchical' => true,
        '_builtin' => false,
        'public' => true
    );
    $hierarchical_posttypes = get_post_types($args);
    foreach($hierarchical_posttypes as $hierarchical_posttype) {
        if ('acf' !== $hierarchical_posttype) {
            $choices[0] = __('Ingen förälder');
            $args = array(
                'post_type' => $hierarchical_posttype,
                'posts_per_page' => -1,
                'post_status' => 'publish'
            );
            $customposts = get_posts($args);
            foreach ($customposts as $custompost) {
                $choices[$custompost->ID] = $custompost->post_title;
            }
        }
    }
    return $choices;
});

add_filter('acf/location/rule_match/cpt_parent', function ($match, $rule, $options) {
    global $post;
    $selected_post = (int) $rule['value'];

    if ($post) { // post parent
        $post_parent = $post->post_parent;
        if (isset($options['page_parent'])) {
            $post_parent = $options['page_parent'];
        }
        if ('==' == $rule['operator']) {
            $match = ($post_parent == $selected_post);
        } elseif ('!=' == $rule['operator']) {
            $match = ($post_parent != $selected_post);
        }
    }
  return $match;
}, 10, 3);
