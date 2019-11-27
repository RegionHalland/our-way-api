<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5dde724e9b3b9',
    'title' => __('Bilaga', 'ourway'),
    'fields' => array(
        0 => array(
            'key' => 'field_5dde727cba430',
            'label' => __('Fotograf', 'ourway'),
            'name' => 'citation',
            'type' => 'text',
            'instructions' => __('Namn på fotograf eller ägare till bild, t.ex. "Anders Andersson"', 'ourway'),
            'required' => 0,
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
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'attachment',
                'operator' => '==',
                'value' => 'all',
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
    'description' => 'Fält kopplade till en inställningar för bilagor',
));
}