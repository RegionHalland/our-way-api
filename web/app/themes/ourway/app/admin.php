<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

/** Manipulate the admin menu */
add_action('admin_menu', function() {
    // Remove pages not needed
    remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');

    // Add custom taxonomy `Areas`
    add_menu_page(__('Områden', 'ourway'), __('Områden', 'ourway'), 'manage_options', 'edit-tags.php?taxonomy=area', '', 'dashicons-tag', 7);
});


add_action('parent_file', function ($file) {
		// Highlight the Taxonomy Concept menu item
	    global $current_screen;

	    $taxonomy = $current_screen->taxonomy;
	    if ( $taxonomy == 'area' ) {
	        $file = 'edit-tags.php?taxonomy=area';
	    }

	    return $file;
});