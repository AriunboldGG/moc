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
            'key' => 'field_file_pdf',
            'label' => 'PDF Файл оруулах',
            'name' => 'file_pdf',
            'type' => 'file',
            'instructions' => '',
            // 'required' => 1,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'return_format' => 'array',
            'library' => 'all',
            'min_size' => '',
            'max_size' => '',
            'mime_types' => 'pdf',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_laws_type',
                        'operator' => '==',
                        'value' => 'pdf',
                    ),
                ),
            ),
        ),
        array(
            'key' => 'field_base',
            'label' => 'Эх сурвалж',
            'name' => 'base',
            'type' => 'text',
            'instructions' => '',
            'required' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 'Эх сурвалж - moc.gov.mn',
            'placeholder' => 'Дараах форматаар оруулна уу! ( Эх сурвалж - moc.gov.mn гэх мэт )',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ),
        array(
            'key' => 'field_base_url',
            'label' => 'Эх сурвалж Холбоос оруулах',
            'name' => 'base_url',
            'type' => 'url',
            'instructions' => '',
            'required' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'default_value' => 'https://moc.gov.mn',
            'placeholder' => 'Сайтын хаягыг энд бичиж оруулна уу!',
        ),
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
        'key'    => 'tw_pell_metabox',
        'title'  => 'Сан Хөмрөгийн Тохиргоо',
        'fields' => $fields,
        'location' => array (
            array (
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'pells',
                ),
            ),
        ),
    ));
}