<?php
if( function_exists('acf_add_local_field_group') ) {
    $fields = array(
        array(
            'key' => 'field_icon',
            'label' => 'Icon',
            'name' => 'icon',
            'type' => 'image',
            'required' => 0,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'mime_types' => '',
        ),
        array(
            'key' => 'field_icon_color',
            'label' => 'Icon Color',
            'name' => 'icon_color',
            'type' => 'color_picker',
            'required' => 0,
            'default_value' => '#375BD2',
            'enable_opacity' => 1,
            'return_format' => 'string',
        ),
    );

    if ( defined( 'ICT_PORTAL_MAIN' ) ) {
        $fields[] = array(
            'key' => 'field_organization_menu',
            'label' => 'Байгууллагуудын жагсаалт харуулах',
            'name' => 'organization_menu',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        );
        $fields[] = array(
            'key' => 'field_organization_menu_bg_image',
            'label' => 'Icon',
            'name' => 'organization_menu_bg_image',
            'type' => 'image',
            'required' => 0,
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
            'mime_types' => '',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_organization_menu',
                        'operator' => '==',
                        'value' => 1,
                    ),
                ),
            ),
        );
        $fields[] = array(
            'key' => 'field_organization_menu_bg_color',
            'label' => 'Icon Color',
            'name' => 'organization_menu_bg_color',
            'type' => 'color_picker',
            'required' => 0,
            'default_value' => '#171821',
            'enable_opacity' => 1,
            'return_format' => 'string',
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_organization_menu',
                        'operator' => '==',
                        'value' => 1,
                    ),
                ),
            ),
        );
    }

    
    acf_add_local_field_group(array(
        'key' => 'tw_menu_metabox',
        'title' => 'Цэсний тохиргоо',
        'fields' => $fields,
        'location' => array(
            array(
                array(
                    'param' => 'nav_menu_item',
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
        'description' => '',
        'show_in_rest' => 1,
    ));
}