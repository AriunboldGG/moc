<?php
if( function_exists('acf_add_local_field_group') ) {
    $fields = array(
        array(
            'key' => 'field_color',
            'label' => 'Color',
            'name' => 'color',
            'type' => 'color_picker',
            'required' => 0,
            'default_value' => '#DF6837',
            'enable_opacity' => 1,
            'return_format' => 'string',
        ),
    );
    
    acf_add_local_field_group(array(
        'key' => 'tw_heritage_cat_metabox',
        'title' => 'Өвийн ангилалын тохиргоо',
        'fields' => $fields,
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'heritage_cat',
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
        'show_in_rest' => 1,
    ));
}