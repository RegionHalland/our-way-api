<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5cd1795ef09a6',
    'title' => __('Evenemang', 'ourway'),
    'fields' => array(
        0 => array(
            'key' => 'field_5cd179688ab0b',
            'label' => __('Plats', 'ourway'),
            'name' => 'location',
            'type' => 'google_map',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'center_lat' => '56.6685327',
            'center_lng' => '12.8542717',
            'zoom' => '',
            'height' => '',
        ),
        1 => array(
            'key' => 'field_5cd1799d8ab0c',
            'label' => __('Startdatum', 'ourway'),
            'name' => 'start_date',
            'type' => 'date_time_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'Y-m-d H:i:s',
            'return_format' => 'Y-m-d H:i:s',
            'first_day' => 1,
        ),
        2 => array(
            'key' => 'field_5cd179c28ab0d',
            'label' => __('Slutdatum', 'ourway'),
            'name' => 'end_date',
            'type' => 'date_time_picker',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'display_format' => 'Y-m-d H:i:s',
            'return_format' => 'Y-m-d H:i:s',
            'first_day' => 1,
        ),
        3 => array(
            'key' => 'field_5cd179cf8ab0e',
            'label' => __('Anmälningslänk', 'ourway'),
            'name' => 'application_link',
            'type' => 'link',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'array',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'event',
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
    'description' => 'Fält kopplade till evenemang',
));
}