<?php
if( function_exists('acf_add_local_field_group') ) {

    global $wp_registered_sidebars;
    $sidebars = array(
        '' => 'Select',
    );
    
    foreach ( $wp_registered_sidebars as $sidebar ) {
        $sidebars[$sidebar['id']] = $sidebar['name'];
    }

    $fields = array(
        array(
			'key'     => 'field_sidebar',
			'label'   => 'Select sidebar',
			'name'    => 'sidebar',
			'type'    => 'select',
			'choices' => $sidebars,
            'parent'  => 'tw_page_simple_metabox',
		),
    );

    acf_add_local_field_group(array(
        'key'    => 'tw_exhibits_metabox',
        'title'  => 'Үзүүлэнгийн тохиргоо',
        'fields' => $fields,
        'location' => array (
            array (
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'exhibits',
                ),
            ),
        ),
    ));
}