<?php
if( function_exists('acf_add_local_field_group') ) {
    $fields = array(
        array(
            'key' => 'field_event_price',
            'label' => 'Үзвэрийн Үнэ',
            'name' => 'event_price',
            'type' => 'text',
            'required' => 0,
            'default_value' => '',
        ),
        array(
            'key' => 'field_event_link',
            'label' => 'Үзвэрийн Холбоос',
            'name' => 'event_link',
            'type' => 'text',
            'required' => 0,
            'default_value' => '',
        )
    );
    
    acf_add_local_field_group(array(
        'key' => 'tw_event_metabox',
        'title' => 'Үзвэрийн тохиргоо',
        'fields' => $fields,
        'location' => array(
            array(
                array(
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
        'description' => '',
    ));
}