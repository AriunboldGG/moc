<?php
if( function_exists('acf_add_local_field_group') ) {
    $fields = array(
        // array(
        //     'key'    => 'field_post_location',
        //     'label'  => 'Хаяг',
        //     'name'   => 'post_location',
        //     'type'   => 'textarea',
        //     'parent' => 'tw_buy_tender_metabox',
        // ),
        // array(
        //     'key'    => 'field_post_phone',
        //     'label'  => 'Утас',
        //     'name'   => 'post_phone',
        //     'type'   => 'textarea',
        //     'parent' => 'tw_buy_tender_metabox',
        // ),

        array(
            'key' => 'field_featured_post',
            'label' => 'Онцлох мэдээ',
            'name' => 'featured_post',
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
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),

        array(
            'key' => 'field_thumb_yesno',
            'label' => 'Нүүр зураг харуулах',
            'name' => 'thumb_yesno',
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
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
        array(
            'key' => 'field_show_related_posts',
            'label' => 'Холбоотой мэдээлэл харуулах',
            'name' => 'show_related_posts',
            'type' => 'true_false',
            'default_value' => 1,
            'ui' => 0,
            'ui_on_text'  => 'Тийм',
            'ui_off_text' => 'Үгүй',
        ),
        array(
            'key' => 'field_related_posts_per_page',
            'label' => 'Холбоотой мэдээний тоо',
            'name' => 'related_posts_per_page',
            'type' => 'number',
            'required' => 0,
            'conditional_logic' => array(
                array(
                    array(
                        'field' => 'field_show_related_posts',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'default_value' => '10',
            'min' => -1,
			'max' => '',
        ),

        array(
            'key' => 'field_post_footer_content',
            'label' => 'Мэдээний хөл хэсгийн агуулга',
            'name' => 'post_footer_content',
            'type' => 'post_object',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'lovelyblock',
            ),
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'object',
            'ui' => 1,
        ),
    );
    acf_add_local_field_group(array(
        'key' => 'tw_buy_tender_metabox',
        'title' => 'Post - Тохиргоо',
        'fields' => $fields,
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
                // array(
                //     'param' => 'post_taxonomy',
                //     'operator' => '==',
                //     'value' => 'post_site:basic',
                // ),
            ),
        ),
    ));

    // $video_fields = array(
    //     array(
    //         'key'    => 'field_post_video_type',
    //         'label'  => 'Видео төрөл',
    //         'name'   => 'post_video_type',
    //         'type'   => 'select',
	// 		'choices' => array(
	// 			''      => 'Choose',
	// 			'url'   => 'URL',
	// 			'embed' => 'Embed',
	// 		),
    //         'parent' => 'tw_post_single_video_metabox',
    //     ),
    //     array(
    //         'key'     => 'field_post_video_url',
    //         'label'   => 'Видео - URL',
    //         'name'    => 'post_video_url',
    //         'type'    => 'text',
    //         'default' => '',
    //         'parent'  => 'tw_post_single_video_metabox',
	// 		'conditional_logic' => array(
	// 			array(
	// 				array(
	// 					'field'    => 'field_post_video_type',
	// 					'operator' => '==',
	// 					'value'    => 'url',
	// 				),
	// 			),
	// 		),
    //     ),
    //     array(
    //         'key'     => 'field_post_video_embed',
    //         'label'   => 'Видео - Embed',
    //         'name'    => 'post_video_embed',
    //         'type'    => 'textarea',
    //         'default' => '',
    //         'parent' => 'tw_post_single_video_metabox',
	// 		'conditional_logic' => array(
	// 			array(
	// 				array(
	// 					'field'    => 'field_post_video_type',
	// 					'operator' => '==',
	// 					'value'    => 'embed',
	// 				),
	// 			),
	// 		),
    //     ),
    // );
    // acf_add_local_field_group(array(
    //     'key' => 'tw_post_single_video_metabox',
    //     'title' => 'Post video - URL or Embed',
    //     'fields' => $video_fields,
    //     'location' => array (
    //         array (
    //             array (
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => 'post',
    //             ),
    //             array(
    //                 'param' => 'post_format',
    //                 'operator' => '==',
    //                 'value' => 'video',
    //             ),
    //         ),
    //     ),
    // ));
}