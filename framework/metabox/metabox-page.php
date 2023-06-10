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
			'key'     => 'field_page_submenu_type',
			'label'   => 'Page sidebar',
			'name'    => 'page_sidebar',
			'type'    => 'select',
			'choices' => $sidebars,
            'parent'  => 'tw_page_simple_metabox',
		),
        array(
            'key' => 'field_page_title',
            'label' => 'Хуудасны гарчиг',
            'name' => 'page_title',
            'type' => 'radio',
            'instructions' => '',
            'required' => 1,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'true' => 'Идэвхтэй',
                'false' => 'Идэвхгүй',
            ),
            'allow_null' => 0,
            'other_choice' => 0,
            'default_value' => '',
            'layout' => 'vertical',
            'return_format' => 'value',
            'save_other_choice' => 0,
        ),
    );

    acf_add_local_field_group(array(
        'key'    => 'tw_page_simple_metabox',
        'title'  => 'Хуудасны Тохиргоо',
        'fields' => $fields,
        'location' => array (
            array (
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-simple.php',
                ),
            ),
        ),
    ));
}