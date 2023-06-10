<?php
/* ================================================================================== */
/*      Map Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-imap'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

wp_enqueue_style( 'leaflet' );
wp_enqueue_script( 'leaflet' );
$imap_url   = 'https://cloudgis.mn/';
$imap_mskey = lvly_get_option( 'imap_mskey');


$response = wp_remote_post( $imap_url . 'map/v1/init/pc?mskey=' . $imap_mskey, array( 'timeout' => 1 ) );
if ( ! is_wp_error( $response ) && ! empty( $response['body'] ) ) {
    $response_body = json_decode( $response['body'], true );
    if ( ! empty( $response_body['ssid'] ) ) {
        $atts['element_atts']['data-tile'] = array( $imap_url . 'map/v1/tilemap/std/{z}/{x}/{y}?ssid=' . $response_body['ssid'] );
    }
}


$city_options = array();
$cities = tw_get_region();

if ( ! empty( $cities ) && is_array( $cities ) ) {
    foreach( $cities as $city ) {
        $city_options[] = array(
            'id'       => $city['id'],
            'slug'     => $city['slug'],
            'text'     => ( ICT_LANG==='en'&&!empty( $city['name_en'] ) ) ? $city['name_en'] : $city['name'],
            'lat_long' => $city['lat_long'],
        );
    }
}


// 


// $atts['element_atts']['data-style'][] = $atts['style_name'];
// $atts['element_atts']['data-mouse'][] = $atts['mouse_wheel'];
// $atts['element_atts']['data-lat'][] = $atts['lat'];
// $atts['element_atts']['data-lng'][] = $atts['lng'];
// $atts['element_atts']['data-zoom'][] = $atts['zoom'];
// $atts['element_atts']['data-json'][] = $atts['json'];

list($output)=lvly_item($atts);

    $output .= '<div class="tw-filter-container">';
        $output .= '<div class="tw-filter-button">';
            $output .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22 11.25H19.96C19.6 7.44 16.56 4.39 12.75 4.04V2C12.75 1.59 12.41 1.25 12 1.25C11.59 1.25 11.25 1.59 11.25 2V4.04C7.44 4.4 4.39 7.44 4.04 11.25H2C1.59 11.25 1.25 11.59 1.25 12C1.25 12.41 1.59 12.75 2 12.75H4.04C4.4 16.56 7.44 19.61 11.25 19.96V22C11.25 22.41 11.59 22.75 12 22.75C12.41 22.75 12.75 22.41 12.75 22V19.96C16.56 19.6 19.61 16.56 19.96 12.75H22C22.41 12.75 22.75 12.41 22.75 12C22.75 11.59 22.41 11.25 22 11.25ZM12 15.12C10.28 15.12 8.88 13.72 8.88 12C8.88 10.28 10.28 8.88 12 8.88C13.72 8.88 15.12 10.28 15.12 12C15.12 13.72 13.72 15.12 12 15.12Z" fill="white"/></svg>';
        $output .= '</div>';
        $output .= '<div class="tw-filter-header">';
            $output .= '<form class="tw-imap-filter-form">';
                $output .= '<label for="tw-imap-filter">Байршлаар хайх</label>';
                $output .= '<div class="tw-imap-filter-field">';
                    $output .= '<select id="tw-imap-filter">';
                        $output .= '<option value="">Сонгох</option>';
                        if ( ! empty( $city_options  ) && is_array( $city_options  ) ) {
                            foreach( $city_options as $city_option ) {
                                $output .= '<option value="' . esc_attr( $city_option['id'] ) . '" data-location="' . esc_attr( $city_option['lat_long'] ) . '">' . esc_html( $city_option['text'] ) . '</option>';
                            }
                        }
                    $output .= '</select>';
                $output .= '</div>';
            $output .= '</form>';
            // $output .= '<div class="tw-filter-title">';
            //     $output .= '<svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.575164 3.8151C1.38523 2.46512 2.46535 1.3851 3.81546 0.575109C5.4356 -0.234879 7.05576 -0.504875 7.05576 1.92509V2.73504V5.16508C7.05576 6.51506 6.51568 7.055 5.16557 7.055H2.73531H1.92528C-0.504923 7.055 -0.234902 5.16508 0.575164 3.8151Z" fill="#DF6837"/><path d="M15.4263 3.8151C14.6163 2.46512 13.5361 1.3851 12.186 0.575109C10.8359 -0.234879 8.94572 -0.504875 8.94572 1.92509V2.73504V5.16508C8.94572 6.51506 9.4858 7.055 10.8359 7.055H13.2662H14.0762C16.5064 7.055 16.2364 5.16508 15.4263 3.8151Z" fill="#B5C450"/><path d="M15.4263 12.1852C14.6163 13.5352 13.5361 14.6152 12.186 15.4252C10.8359 16.2352 8.94572 16.5052 8.94572 14.0752V13.2653V10.8352C8.94572 9.48525 9.4858 8.94531 10.8359 8.94531H13.2662H14.0762C16.5064 8.94531 16.2364 10.8352 15.4263 12.1852Z" fill="#FAD547"/><path d="M0.575164 12.1852C1.38523 13.5352 2.46535 14.6152 3.81546 15.4252C5.4356 16.2352 7.05576 16.5052 7.05576 14.0752V13.2653V10.8352C7.05576 9.48525 6.51568 8.94531 5.16557 8.94531H2.73531H1.92528C-0.504923 8.94531 -0.234902 10.8352 0.575164 12.1852Z" fill="#C14B93"/></svg>';
            //     $output .= 'Харьяа байгууллагууд';
            // $output .= '</div>';
        $output .= '</div>';

        $output .= '<div class="tw-filter-body">';
            
            /* Байгууллагууд */
            $query = array(
                'post_type' => 'organization',
                'posts_per_page' => -1,
            );

            $lvly_query = new WP_Query( $query );
            while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                $catsList = '';
                $city = '';
                $lat_long = '';
                $site_url = '#';
                $icon_color = '#DF6837';

                $cats = wp_get_post_terms( get_the_id(), 'organization_cat' );
                foreach ( $cats as $cat ) {
                    if( $cat_color = get_field( 'color', $cat ) ) {
                        $icon_color = $cat_color;
                    }
                    $catsList  .= '<span style="background-color:' . esc_attr( $icon_color ) . ';">'. $cat->name.'</span>';
                }

                if ( $cr_site_url = get_field('site_url') ) {
                    $site_url = $cr_site_url;
                }
                if ( $cr_city = get_field('city') ) {
                    foreach ( $cr_city as $cr_city_item ) {
                        $city .= '-' . $cr_city_item . '-';
                    }
                }
                if ( $cr_lat_long = get_field('lat_long') ) {
                    $lat_long = $cr_lat_long;
                }

                $output .= '<div class="tw-filter-item tw-filter-item-active" data-color="' . esc_attr( $icon_color ) . '" data-city="' . esc_attr( $city ) . '" data-lat-long="' . esc_attr( $lat_long ) . '">';
                    $output .= '<div class="tw-cats">' . $catsList . '</div>';
                    $output .= '<h4 class="tw-item-title">' . get_the_title() . '</h4>';
                    $output .= '<a class="tw-item-link" href="' . esc_url( $site_url ) . '" title="' . get_the_title() . '">';
                        $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.33398C4.32 1.33398 1.33333 4.32065 1.33333 8.00065C1.33333 11.6807 4.32 14.6673 8 14.6673C11.68 14.6673 14.6667 11.6807 14.6667 8.00065C14.6667 4.32065 11.68 1.33398 8 1.33398ZM5.76667 9.84732C5.69333 10.0473 5.5 10.174 5.3 10.174C5.24 10.174 5.18667 10.1673 5.12667 10.1407C4.58667 9.94065 4.13333 9.54732 3.84667 9.03398C3.18 7.83398 3.59333 6.26732 4.76 5.54065L6.32 4.57398C6.89333 4.22065 7.56667 4.11398 8.20667 4.28065C8.84667 4.44732 9.38667 4.86732 9.71333 5.45398C10.38 6.65398 9.96667 8.22065 8.8 8.94732L8.62667 9.07398C8.4 9.23398 8.08667 9.18065 7.92667 8.96065C7.76667 8.73398 7.82 8.42065 8.04 8.26065L8.24667 8.11398C8.99333 7.64732 9.24667 6.68065 8.84 5.94065C8.64667 5.59398 8.33333 5.34732 7.96 5.24732C7.58667 5.14732 7.19333 5.20732 6.85333 5.42065L5.28 6.39398C4.56 6.84065 4.30667 7.80732 4.71333 8.55398C4.88 8.85398 5.14667 9.08732 5.46667 9.20732C5.72667 9.30065 5.86 9.58732 5.76667 9.84732ZM11.28 10.434L9.72 11.4007C9.32667 11.6473 8.88667 11.7673 8.44 11.7673C8.24 11.7673 8.03333 11.7407 7.83333 11.6873C7.19333 11.5207 6.65333 11.1007 6.33333 10.514C5.66667 9.31398 6.08 7.74732 7.24667 7.02065L7.42 6.89398C7.64667 6.73398 7.96 6.78732 8.12 7.00732C8.28 7.23398 8.22667 7.54732 8.00667 7.70732L7.8 7.85398C7.05333 8.32065 6.8 9.28732 7.20667 10.0273C7.4 10.374 7.71333 10.6207 8.08667 10.7207C8.46 10.8207 8.85333 10.7607 9.19333 10.5473L10.7533 9.58065C11.4733 9.13398 11.7267 8.16732 11.32 7.42065C11.1533 7.12065 10.8867 6.88732 10.5667 6.76732C10.3067 6.67398 10.1733 6.38732 10.2733 6.12732C10.3667 5.86732 10.66 5.73398 10.9133 5.83398C11.4533 6.03398 11.9067 6.42732 12.1933 6.94065C12.8533 8.14065 12.4467 9.70732 11.28 10.434Z" fill="' . esc_attr( $icon_color ) . '"/></svg>';
                        $output .= 'Вебсайтаар зочлох';
                    $output .= '</a>';
                $output .= '</div>';
            }

            /* Өвүүд */
            $query = array(
                'post_type' => 'heritage',
                'posts_per_page' => -1,
            );

            $lvly_query = new WP_Query( $query );
            while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                $catsList = '';
                $city = '';
                $lat_long = '';
                $site_url = get_the_permalink();
                $icon_color = '#DF6837';

                $cats = wp_get_post_terms( get_the_id(), 'heritage_cat' );
                foreach ( $cats as $cat ) {
                    if( $cat_color = get_field( 'color', $cat ) ) {
                        $icon_color = $cat_color;
                    }
                    $catsList  .= '<span style="background-color:' . esc_attr( $icon_color ) . ';">'. $cat->name.'</span>';
                }

                $cr_city = wp_get_post_terms( get_the_id(), 'heritage_region' );
                foreach ( $cr_city as $cr_city_item ) {
                    $city .= '-' . ( $cr_city_item->term_id ) . '-';
                }

                if ( $cr_lat_long = get_field('lat_long') ) {
                    $lat_long = $cr_lat_long;
                }

                $output .= '<div class="tw-filter-item tw-filter-item-active" data-color="' . esc_attr( $icon_color ) . '" data-city="' . esc_attr( $city ) . '" data-lat-long="' . esc_attr( $lat_long ) . '">';
                    $output .= '<div class="tw-cats">' . $catsList . '</div>';
                    $output .= '<h4 class="tw-item-title">' . get_the_title() . '</h4>';
                    $output .= '<a class="tw-item-link" href="' . esc_url( $site_url ) . '" title="' . get_the_title() . '">';
                        $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 1.33398C4.32 1.33398 1.33333 4.32065 1.33333 8.00065C1.33333 11.6807 4.32 14.6673 8 14.6673C11.68 14.6673 14.6667 11.6807 14.6667 8.00065C14.6667 4.32065 11.68 1.33398 8 1.33398ZM5.76667 9.84732C5.69333 10.0473 5.5 10.174 5.3 10.174C5.24 10.174 5.18667 10.1673 5.12667 10.1407C4.58667 9.94065 4.13333 9.54732 3.84667 9.03398C3.18 7.83398 3.59333 6.26732 4.76 5.54065L6.32 4.57398C6.89333 4.22065 7.56667 4.11398 8.20667 4.28065C8.84667 4.44732 9.38667 4.86732 9.71333 5.45398C10.38 6.65398 9.96667 8.22065 8.8 8.94732L8.62667 9.07398C8.4 9.23398 8.08667 9.18065 7.92667 8.96065C7.76667 8.73398 7.82 8.42065 8.04 8.26065L8.24667 8.11398C8.99333 7.64732 9.24667 6.68065 8.84 5.94065C8.64667 5.59398 8.33333 5.34732 7.96 5.24732C7.58667 5.14732 7.19333 5.20732 6.85333 5.42065L5.28 6.39398C4.56 6.84065 4.30667 7.80732 4.71333 8.55398C4.88 8.85398 5.14667 9.08732 5.46667 9.20732C5.72667 9.30065 5.86 9.58732 5.76667 9.84732ZM11.28 10.434L9.72 11.4007C9.32667 11.6473 8.88667 11.7673 8.44 11.7673C8.24 11.7673 8.03333 11.7407 7.83333 11.6873C7.19333 11.5207 6.65333 11.1007 6.33333 10.514C5.66667 9.31398 6.08 7.74732 7.24667 7.02065L7.42 6.89398C7.64667 6.73398 7.96 6.78732 8.12 7.00732C8.28 7.23398 8.22667 7.54732 8.00667 7.70732L7.8 7.85398C7.05333 8.32065 6.8 9.28732 7.20667 10.0273C7.4 10.374 7.71333 10.6207 8.08667 10.7207C8.46 10.8207 8.85333 10.7607 9.19333 10.5473L10.7533 9.58065C11.4733 9.13398 11.7267 8.16732 11.32 7.42065C11.1533 7.12065 10.8867 6.88732 10.5667 6.76732C10.3067 6.67398 10.1733 6.38732 10.2733 6.12732C10.3667 5.86732 10.66 5.73398 10.9133 5.83398C11.4533 6.03398 11.9067 6.42732 12.1933 6.94065C12.8533 8.14065 12.4467 9.70732 11.28 10.434Z" fill="' . esc_attr( $icon_color ) . '"/></svg>';
                        $output .= esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'More':'Дэлгэрэнгүй' );
                    $output .= '</a>';
                $output .= '</div>';
            }
            

        $output .= '</div>';
    $output .= '</div>';






    $output .='<div id="map"></div>';
    // $output .='<ul class="map-markers">';
        // $iconDefault = LVLY_DIR."assets/images/leaflet/marker-icon.png";
        // $markers = (array) vc_param_group_parse_atts( $atts['markers'] );
        // foreach($markers as $marker) {
        //     $marker = shortcode_atts( array(
        //         'css' => '',
        //         'title' => '',
        //         'lat' => '',
        //         'lng' => '',
        //         'icon' => '',
        //         'icon_width' => '',
        //         'icon_height' => '',
        //         'content' => '',
        //     ),$marker);
        //     $icon=$marker['icon'];
        //     if ($icon) {
        //         $icon=wp_get_attachment_image_src($icon,'full');
        //         $icon=isset($icon[0])?$icon[0]:$iconDefault;
        //     }else{
        //         $icon=$iconDefault;
        //     }
        //     $data=' data-title="'.esc_attr($marker['title']).'" data-lat="'.esc_attr($marker['lat']).'" data-lng="'.esc_attr($marker['lng']).'" data-iconsrc="'.esc_url($icon).'" data-iconwidth="'.esc_attr($marker['icon_width']).'" data-iconheight="'.esc_attr($marker['icon_height']).'"';
        //     $output.= '<li class="map-marker"'.$data.'>';
        //         if ($marker['title']) {$output .='<h3 class="map-marker-title">'.esc_html($marker['title']).'</h3>';}
        //         $output .='<div class="marker-content">';
        //             $output .= do_shortcode($marker['content']);
        //         $output .='</div>';
        //     $output .='</li>';
        // }
    // $output .='</ul>';
$output .='</div>';
echo ($output);