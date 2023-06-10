<?php
if( function_exists('acf_add_local_field_group') ) {
    $fields = array(
        array(
            'key'    => 'field_name_en',
            'label'  => 'Name EN',
            'name'   => 'name_en',
            'type'   => 'text',
			'default_value' => '',
        ),
        array(
            'key'    => 'field_lat_long',
            'label'  => 'Байршил - lat,long',
            'name'   => 'lat_long',
            'type'   => 'text',
			'default_value' => '47.919846100063204,106.91733986062114',
        ),
    );
    
    acf_add_local_field_group(array(
        'key' => 'tw_heritage_region_metabox',
        'title' => 'Аймаг Сумын тохиргоо',
        'fields' => $fields,
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'heritage_region',
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