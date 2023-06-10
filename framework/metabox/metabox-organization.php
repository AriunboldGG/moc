<?php
$city_options = array();
$cities = tw_get_region();
if ( ! empty( $cities ) && is_array( $cities ) ) {
    foreach( $cities as $city ) {
        if ( ! empty( $city['id'] ) && ! empty( $city['name'] ) ) {
            $city_options[$city['id']] = $city['name'];
        }
    }
}

if( function_exists('acf_add_local_field_group') ) {
    $fields = array(
        array(
			'key'   => 'field_location',
			'label' => 'Байршил',
			'name'  => 'location',
			'type'  => 'post_object',
			'post_type' => array(
				'location',
			),
			'allow_null' => 1,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
        array(
            'key'    => 'field_site_url',
            'label'  => 'Сайтын хаяг',
            'name'   => 'site_url',
            'type'   => 'text',
			'default_value' => '',
        ),
        array(
            'key'    => 'field_site_url_external',
            'label'  => 'Сайтын нэмэлт хаяг ( Портал сайтаас тусдаа сайттай бол энд бичнэ. ) ',
            'name'   => 'site_url_external',
            'type'   => 'text',
			'default_value' => '',
        ),
        array(
			'key'     => 'field_city',
			'label'   => 'Аймаг/Хот',
			'name'    => 'city',
			'type'    => 'select',
            'multiple' => 1,
			'choices' => $city_options,
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
        'key' => 'tw_organization_metabox',
        'title' => 'Байгууллагын тохиргоо',
        'fields' => $fields,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'organization',
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