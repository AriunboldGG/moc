<?php
if( function_exists('acf_add_local_field_group') ) {
    //Artist
    acf_add_local_field_group(array(
        'key' => 'group_6131d86909402',
        'title' => 'Artist settings',
        'fields' => array(
            array(
                'key' => 'field_6131d87c9c7df',
                'label' => 'Албан тушаал',
                'name' => 'position',
                'type' => 'text',
                'instructions' => '',
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
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'team',
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