<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5ddb97bdb9dac',
    'title' => __('Avdelning - Förälder', 'ourway'),
    'fields' => array(
        0 => array(
            'key' => 'field_5ddb981c03683',
            'label' => __('Utvald bild', 'ourway'),
            'name' => 'featured_image',
            'type' => 'image',
            'instructions' => __('Välj en bild som visas högst upp på sidan.', 'ourway'),
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'array',
            'preview_size' => 'full',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
        1 => array(
            'key' => 'field_5ddb9bacca601',
            'label' => __('Utdrag', 'ourway'),
            'name' => 'excerpt',
            'type' => 'textarea',
            'instructions' => __('Beskriv avdelningen kortfattat', 'ourway'),
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'maxlength' => '',
            'rows' => 3,
            'new_lines' => '',
        ),
        2 => array(
            'key' => 'field_5ddb9c2f0038c',
            'label' => __('Kontaktpersoner', 'ourway'),
            'name' => 'contacts',
            'type' => 'relationship',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'contact',
            ),
            'taxonomy' => '',
            'filters' => array(
                0 => 'search',
            ),
            'elements' => '',
            'min' => 1,
            'max' => 3,
            'return_format' => 'object',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'department',
            ),
            1 => array(
                'param' => 'cpt_parent',
                'operator' => '==',
                'value' => '0',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => 'Fält kopplade till en avdelningssida utan förälder',
));
}