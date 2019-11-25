<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5ddb9cec17d4d',
    'title' => __('Avdelning - Undersida', 'ourway'),
    'fields' => array(
        0 => array(
            'key' => 'field_5ddb9da340725',
            'label' => __('Attachments', 'ourway'),
            'name' => 'attachments',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'sub_fields' => array(
                0 => array(
                    'key' => 'field_5ddb9db440726',
                    'label' => __('Attachment', 'ourway'),
                    'name' => 'attachment',
                    'type' => 'group',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'block',
                    'sub_fields' => array(
                        0 => array(
                            'key' => 'field_5ddb9dbe40727',
                            'label' => __('Titel', 'ourway'),
                            'name' => 'title',
                            'type' => 'text',
                            'instructions' => __('Fyll i filens titel', 'ourway'),
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
                            'key' => 'field_5ddb9dcf40728',
                            'label' => __('Beskrivning', 'ourway'),
                            'name' => 'description',
                            'type' => 'text',
                            'instructions' => __('Beskriv filens innehåll kortfattat', 'ourway'),
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
                        2 => array(
                            'key' => 'field_5ddb9deb40729',
                            'label' => __('Välj typ av bilaga', 'ourway'),
                            'name' => 'is_file',
                            'type' => 'true_false',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 1,
                            'ui' => 1,
                            'ui_on_text' => __('Bilaga', 'ourway'),
                            'ui_off_text' => __('Länk', 'ourway'),
                        ),
                        3 => array(
                            'key' => 'field_5ddb9e514072a',
                            'label' => __('Bilaga', 'ourway'),
                            'name' => 'attachment',
                            'type' => 'file',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                0 => array(
                                    0 => array(
                                        'field' => 'field_5ddb9deb40729',
                                        'operator' => '==',
                                        'value' => '1',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'library' => 'all',
                            'min_size' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        4 => array(
                            'key' => 'field_5ddb9e7e4072b',
                            'label' => __('Länk', 'ourway'),
                            'name' => 'url',
                            'type' => 'url',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => array(
                                0 => array(
                                    0 => array(
                                        'field' => 'field_5ddb9deb40729',
                                        'operator' => '!=',
                                        'value' => '1',
                                    ),
                                ),
                            ),
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                        ),
                    ),
                ),
            ),
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
                'operator' => '!=',
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
    'description' => 'Fält kopplade till en avdelningssida med förälder',
));
}