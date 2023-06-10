<?php
/* ================================================================================== */
/*      Events Carousel Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-events-carousel'),
        'data-uk-grid' => array(),
        'data-uk-slider' => array('autoplay: false; finite: true;')
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

list($output)=lvly_item($atts);

    $output .= '<div class="tw-slider-navigation-container">';
        if ( !empty( $atts['title'] ) ) {
            $output .= '<h3 class="tw-title">';
                $output .= esc_html( $atts['title'] );
            $output .= '</h3>';
        }

        $output .= '<div class="tw-slider-navigation">';
            $link = vc_build_link( $atts['link'] );
            
            if ( ! empty( $link['url'] ) && !empty( $link['title'] ) ) {
                $output .= '<a class="tw-link" href="' . esc_url( $link['url'] ) . '" title="' . esc_attr( $link['title'] ) . '">' . esc_html( $link['title'] ) . '</a>';
            }

            $output .= '<a href="#" uk-slider-item="previous">';
                $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 12L4.95333 7.95333L9 3.90667" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            $output .= '</a>';
            $output .= '<a href="#" uk-slider-item="next">';
                $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 3.95312L11.0467 7.99979L7 12.0465" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            $output .= '</a>';
        $output .= '</div>';
    $output .= '</div>';


    if ( defined( 'ICT_PORTAL_MAIN' ) ) {
        $events = array();

        $tw_cache_created = 0;
        
        // Sub Sites Posts
        $tw_get_subsite_urls = tw_get_subsite_urls();
        foreach( $tw_get_subsite_urls as $tw_get_subsite_url ) {
            $tw_cache_expire_time = 60 * 15;
            $tw_cache_name        = 'tw_all_sites_latest_events_' . esc_sql( esc_url( $tw_get_subsite_url ) ) . '_' . ( empty( $atts['posts_per_page'] ) ? 10 : $atts['posts_per_page'] );
            $tw_cache_data        = get_transient( $tw_cache_name );
            $tw_cache_data        = $tw_cache_data && is_array( $tw_cache_data ) ? $tw_cache_data : array();
            $tw_cache_not_expired = get_transient( $tw_cache_name . '_not_expired' );

            $crr_new_events = array();

            if ( $tw_cache_not_expired ) {
                $crr_new_events = $tw_cache_data;
            } else {
                if ( $tw_cache_created > 5 ) {
                    $crr_new_events = $tw_cache_data;
                } else {
                    $tw_cache_created++;

                    $response = wp_remote_get( trailingslashit( $tw_get_subsite_url ) . 'wp-json/wp/v2/event', array(
                        'timeout' => 1,
                        'body' => array(
                            'posts_per_page' => empty( $atts['posts_per_page'] ) ? 10 : $atts['posts_per_page'],
                        )
                    ) );

                    if ( ! is_wp_error( $response ) && is_array( $response ) && ! empty( $response['response'] ) && ! empty( $response['response']['code'] ) && intval( $response['response']['code'] ) === 200  ) {
                        if ( ! empty( $response['body'] ) ) {
                            $response_body = json_decode( $response['body'], true );

                            if ( is_array( $response_body ) ) {
                                $crr_new_events = $response_body;
                                set_transient( $tw_cache_name                 , $crr_new_events, $tw_cache_expire_time * 100 );
                                set_transient( $tw_cache_name . '_not_expired', true           , $tw_cache_expire_time );
                            }
                        }
                    } else {
                        // Set old data, Connection Failed
                        $crr_new_events = $tw_cache_data;
                    }
                }
            }
            
            // Merge Datas
            $events = array_merge( $events, $crr_new_events );
        }

        array_multisort(array_map(function($element) {
            return empty( $element['event_start'] ) ? '' : $element['event_start'];
        }, $events), SORT_DESC, $events);

        $output .= '<div class="uk-slider-container">';
            $output .= '<ul class="uk-slider-items uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s uk-grid">';
                foreach ( $events as $event ) {
                    $output .= '<li>';
                        if ( ! empty($event['thumbs'] ) && ! empty( $event['thumbs']['lvly_carousel_3'] ) && ! empty( $event['thumbs']['lvly_carousel_3']['url'] ) ) {
                            $output .= '<div class="tw-item-image">';
                                $output .= '<img src="' . esc_url( $event['thumbs']['lvly_carousel_3']['url'] ) . '"' . ( empty( $event['thumbs']['lvly_carousel_3']['alt'] ) ? '' : ( ' alt="' . esc_attr( $event['thumbs']['lvly_carousel_3']['alt'] ) . '"' ) ) . ' />';
                            $output .= '</div>';
                        }
                        $output .= '<div class="tw-entry">';
                            $output .= '<div class="tw-top">';
                                if ( ! empty( $event['title'] ) && ! empty( $event['title']['rendered'] ) ) {
                                    $output .= '<h4 class="tw-item-title">';
                                        if ( ! empty( $event['custom_event_link'] ) ) {
                                            $output .= '<a href="' . esc_url( $event['custom_event_link'] ) .'">';
                                        }
                                            $output .= esc_html( $event['title']['rendered'] );
                                        if ( ! empty( $event['custom_event_link'] ) ) {
                                            $output .= '</a>';
                                        }
                                    $output .= '</h4>';
                                }

                                // $output .= '<a href="#" class="tw-post-like tw-like-button' . ( tw_get_liked( get_the_id() ) ? ' tw-liked': '' ) . '" data-id="' . get_the_id() . '">';
                                //     $output .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M16.44 3.1001C14.63 3.1001 13.01 3.9801 12 5.3301C10.99 3.9801 9.37 3.1001 7.56 3.1001C4.49 3.1001 2 5.6001 2 8.6901C2 9.8801 2.19 10.9801 2.52 12.0001C4.1 17.0001 8.97 19.9901 11.38 20.8101C11.72 20.9301 12.28 20.9301 12.62 20.8101C15.03 19.9901 19.9 17.0001 21.48 12.0001C21.81 10.9801 22 9.8801 22 8.6901C22 5.6001 19.51 3.1001 16.44 3.1001Z" fill="#171821"/></svg>';
                                // $output .= '</a>';
                            $output .= '</div>';

                            $output .= '<div class="tw-bottom">';
                                $output .= '<div class="tw-entry-info">';
                                    if ( ! empty( $event['location_name'] ) ) {
                                        $output .= '<div class="tw-entry-info-location">';
                                            $output .= '<div class="tw-entry-label">';
                                                $output .= esc_html__( 'Хаана', 'lvly' );
                                            $output .= '</div>';
                                            $output .= '<div class="tw-entry-text">';
                                                $output .= esc_html( $event['location_name'] );
                                            $output .= '</div>';
                                        $output .= '</div>';
                                    }
                                    if ( ! empty( $event['event_start'] ) ) {
                                        $output .= '<div class="tw-entry-info-date">';
                                            $output .= '<div class="tw-entry-label">';
                                                $output .= esc_html__( 'Хэзээ', 'lvly' );
                                            $output .= '</div>';
                                            $output .= '<div class="tw-entry-text">';
                                                $output .= esc_html( $event['event_start'] );
                                            $output .= '</div>';
                                        $output .= '</div>';
                                    }
                                $output .= '</div>';

                                $output .= '<div class="tw-entry-more">';
                                    $output .= '<div class="tw-entry-price">';
                                        if ( ! empty( $event['event_price'] ) ) {
                                            $output .= '<div class="tw-entry-label">';
                                                $output .= esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'Price':'Үнэ' );
                                            $output .= '</div>';
                                            $output .= '<div class="tw-entry-text">';
                                                $output .= esc_html( $event['event_price'] );
                                            $output .= '</div>';
                                        }
                                    $output .= '</div>';
                                    if ( ! empty( $event['custom_event_link'] ) ) {
                                        $output .= '<a class="tw-button tw-button-more" href="' . esc_url( $event['custom_event_link'] ) . '">';
                                            $output .= esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'More':'Дэлгэрэнгүй' );
                                        $output .= '</a>';
                                    }
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</li>';
                }
            $output .= '</ul>';
        $output .= '</div>';
    } else {
        $query = array(
            'post_type' => 'event',
            'posts_per_page' => $atts['posts_per_page'],
        );

        // $cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
        // if ($cats) {
        //     $query['tax_query'] = Array(Array(
        //             'taxonomy' => 'category',
        //             'terms' => $cats,
        //             'field' => 'slug'
        //         )
        //     );
        // }
        // meta

        $lvly_query = new WP_Query( $query );
        if ( $lvly_query->have_posts() ) {
            $output .= '<div class="uk-slider-container">';
                $output .= '<ul class="uk-slider-items uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s uk-grid">';
                    while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                        $event_location_name = $event_start_date = '';
                        $event_link = get_field( 'event_link' );
                        if ( function_exists( 'em_get_event' ) && class_exists( 'EM_Location' ) ) {
                            $crr_event = em_get_event( $lvly_query->post );
                            
                            $event_start_date = $crr_event->event_start_date;
        
                            if ( ! empty( $crr_event->location_id ) && is_numeric( $crr_event->location_id ) ) {
                                $crr_event_location = new EM_Location( $crr_event->location_id );
                                if ( ! empty( $crr_event_location->location_name ) ) {
                                    $event_location_name = $crr_event_location->location_name;
                                }
                            }
                        }

                        $output .= '<li>';
                            $image = lvly_image( 'lvly_carousel_3', true );
                            if ( ! empty($image['url'] ) ) {
                                $output .= '<div class="tw-item-image">';
                                    $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                $output .= '</div>';
                            }
                            $output .= '<div class="tw-entry">';
                                $output .= '<div class="tw-top">';
                                    $output .= '<h4 class="tw-item-title">';
                                        if ( $event_link ) {
                                            $output .= '<a href="' . esc_url( $event_link ) .'">';
                                        }
                                            $output .= get_the_title();
                                        if ( $event_link ) {
                                            $output .= '</a>';
                                        }
                                    $output .= '</h4>';
                                    $output .= '<a href="#" class="tw-post-like tw-like-button' . ( tw_get_liked( get_the_id() ) ? ' tw-liked': '' ) . '" data-id="' . get_the_id() . '">';
                                        $output .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M16.44 3.1001C14.63 3.1001 13.01 3.9801 12 5.3301C10.99 3.9801 9.37 3.1001 7.56 3.1001C4.49 3.1001 2 5.6001 2 8.6901C2 9.8801 2.19 10.9801 2.52 12.0001C4.1 17.0001 8.97 19.9901 11.38 20.8101C11.72 20.9301 12.28 20.9301 12.62 20.8101C15.03 19.9901 19.9 17.0001 21.48 12.0001C21.81 10.9801 22 9.8801 22 8.6901C22 5.6001 19.51 3.1001 16.44 3.1001Z" fill="#171821"/></svg>';
                                    $output .= '</a>';
                                $output .= '</div>';

                                $output .= '<div class="tw-bottom">';
                                    $output .= '<div class="tw-entry-info">';
                                        if ( $event_location_name ) {
                                            $output .= '<div class="tw-entry-info-location">';
                                                $output .= '<div class="tw-entry-label">';
                                                    $output .= esc_html__( 'Хаана', 'lvly' );
                                                $output .= '</div>';
                                                $output .= '<div class="tw-entry-text">';
                                                    $output .= $event_location_name;
                                                $output .= '</div>';
                                            $output .= '</div>';
                                        }
                                        if ( $event_start_date ) {
                                            $output .= '<div class="tw-entry-info-date">';
                                                $output .= '<div class="tw-entry-label">';
                                                    $output .= esc_html__( 'Хэзээ', 'lvly' );
                                                $output .= '</div>';
                                                $output .= '<div class="tw-entry-text">';
                                                    $output .= $event_start_date;
                                                $output .= '</div>';
                                            $output .= '</div>';
                                        }
                                    $output .= '</div>';

                                    $output .= '<div class="tw-entry-more">';
                                        $output .= '<div class="tw-entry-price">';
                                            if ( $event_price = get_field( 'event_price' ) ) {
                                                $output .= '<div class="tw-entry-label">';
                                                    $output .= esc_html__( 'Үнэ', 'lvly' );
                                                $output .= '</div>';
                                                $output .= '<div class="tw-entry-text">';
                                                    $output .= esc_html( $event_price );
                                                $output .= '</div>';
                                            }
                                        $output .= '</div>';
                                        if ( $event_link ) {
                                            $output .= '<a class="tw-button tw-button-more" href="' . esc_url( $event_link ) . '">';
                                                $output .= esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'More':'Дэлгэрэнгүй' );
                                            $output .= '</a>';
                                        }
                                    $output .= '</div>';
                                    
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</li>';
                    }
                $output .= '</ul>';
            $output .= '</div>';
        }
    }
$output .= '</div>';
/* ================================================================================== */
echo ($output);
