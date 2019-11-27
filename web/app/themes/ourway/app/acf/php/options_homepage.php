<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5dde6fcc6caed',
    'title' => __('Startsida', 'ourway'),
    'fields' => array(
        0 => array(
            'key' => 'field_5dde6fda3a497',
            'label' => __('Rubrik', 'ourway'),
            'name' => 'homepage_title',
            'type' => 'text',
            'instructions' => __('Rubrik som visas i sidhuvudet på startsidan', 'ourway'),
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        1 => array(
            'key' => 'field_5dde70c5155c3',
            'label' => __('Bild', 'ourway'),
            'name' => 'homepage_image',
            'type' => 'image',
            'instructions' => __('Bild som visas i sidhuvudet på startsidan', 'ourway'),
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'min_width' => '',
            'min_height' => '',
            'min_size' => '',
            'max_width' => '',
            'max_height' => '',
            'max_size' => '',
            'mime_types' => '',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'acf-options-startsida',
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
    'description' => 'Fält kopplade till innehåll på startsidan',
));
}