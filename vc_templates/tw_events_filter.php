<?php
/* ================================================================================== */
/*      Baiguullaga With Filter Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-events-filter tw-infinite-container'),
        'data-item-selector'=>array('.event-item'),
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

$filter_text     = empty( $_REQUEST['filter_text'] )     ? '' : trim( $_REQUEST['filter_text'] );
$filter_cat      = empty( $_REQUEST['filter_cat'] )      ? '' : intval( $_REQUEST['filter_cat'] );
$filter_tag      = empty( $_REQUEST['filter_tag'] )      ? '' : intval( $_REQUEST['filter_tag'] );
$filter_location = empty( $_REQUEST['filter_location'] ) ? '' : intval( $_REQUEST['filter_location'] );

list($output)=lvly_item($atts);

    $output .= '<form class="tw-filter-form" action="' . get_the_permalink() . '">';
        $output .= '<div class="tw-filter-container" data-uk-grid>';

            $output .= '<div class="uk-width-1-4">';
                // Search
                $output .= '<div class="tw-field-outer uk-flex uk-flex-between">';
                    $output .= '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.0262 13.8475L18.5953 17.4158L17.4162 18.595L13.8478 15.0258C12.5201 16.0902 10.8687 16.6691 9.16699 16.6667C5.02699 16.6667 1.66699 13.3067 1.66699 9.16666C1.66699 5.02666 5.02699 1.66666 9.16699 1.66666C13.307 1.66666 16.667 5.02666 16.667 9.16666C16.6694 10.8683 16.0905 12.5198 15.0262 13.8475ZM13.3545 13.2292C14.4121 12.1416 15.0027 10.6837 15.0003 9.16666C15.0003 5.94332 12.3895 3.33332 9.16699 3.33332C5.94366 3.33332 3.33366 5.94332 3.33366 9.16666C3.33366 12.3892 5.94366 15 9.16699 15C10.684 15.0024 12.1419 14.4118 13.2295 13.3542L13.3545 13.2292ZM10.1487 5.97999C9.90293 6.09099 9.68781 6.25995 9.52174 6.47237C9.35567 6.68479 9.24362 6.93433 9.19519 7.19958C9.14677 7.46483 9.16343 7.73787 9.24374 7.99527C9.32404 8.25266 9.4656 8.48673 9.65626 8.67739C9.84691 8.86805 10.081 9.00961 10.3384 9.08991C10.5958 9.17022 10.8688 9.18688 11.1341 9.13845C11.3993 9.09003 11.6489 8.97798 11.8613 8.81191C12.0737 8.64584 12.2427 8.43072 12.3537 8.18499C12.5727 8.89634 12.5473 9.66053 12.2816 10.3558C12.0158 11.051 11.5251 11.6374 10.8875 12.0213C10.2498 12.4053 9.50206 12.5648 8.76326 12.4745C8.02446 12.3841 7.33716 12.0491 6.81086 11.5228C6.28456 10.9965 5.94954 10.3092 5.8592 9.57039C5.76885 8.83159 5.92836 8.08381 6.31233 7.44619C6.69629 6.80858 7.28261 6.31781 7.97787 6.05209C8.67312 5.78637 9.43731 5.76099 10.1487 5.97999Z" fill="#6571A0"/></svg>';
                    $output .= '<input class="tw-field" type="text" value="' . esc_attr( $filter_text ) . '" name="filter_text" placeholder="' . esc_attr__('Хайлт хийх бол энд бичнэ үү', 'lvly') . '" />';
                $output .= '</div>';
            $output .= '</div>';
        
            $output .= '<div class="uk-width-3-4 uk-flex uk-flex-right">';

                // Tag
                $output .= '<div class="tw-field-outer">';
                        $output .= '<label>';
                            $output .= esc_html__( 'Таг' ,'lvly');
                        $output .= '</label>';
                        $output .= '<select class="tw-field" name="filter_tag">';
                            $output .= '<option value="">' . esc_html__( 'Сонгох' ,'lvly') . '</option>';
                            $term_event_tags = get_terms('event-tags');
                            foreach ( $term_event_tags as $term_event_tag ) {
                                $output .= '<option value="' . esc_attr( $term_event_tag -> term_id ) . '"' . ( $term_event_tag -> term_id === $filter_tag ? ' selected="selected"' : '' ) . '>' . esc_html__( $term_event_tag -> name ) . '</option>';
                            }
                        $output .= '</select>';
                $output .= '</div>';

                // Category
                $output .= '<div class="tw-field-outer">';
                    $output .= '<label>';
                        $output .= esc_html__( 'Ангилал' ,'lvly');
                    $output .= '</label>';
                    $output .= '<select class="tw-field" name="filter_cat">';
                        $output .= '<option value="">' . esc_html__( 'Сонгох' ,'lvly') . '</option>';
                        $term_event_cats = get_terms('event-categories');
                        foreach ( $term_event_cats as $term_event_cat ) {
                            $output .= '<option value="' . esc_attr( $term_event_cat -> term_id ) . '"' . ( $term_event_cat -> term_id === $filter_cat ? ' selected="selected"' : '' ) . '>' . esc_html__( $term_event_cat -> name ) . '</option>';
                        }
                    $output .= '</select>';
                $output .= '</div>';

                // Location
                $output .= '<div class="tw-field-outer uk-flex uk-flex-between">';
                    $output .= '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.3033 14.47L10 19.7733L4.69667 14.47C3.64779 13.4211 2.93349 12.0847 2.64411 10.6299C2.35473 9.17501 2.50326 7.66701 3.07092 6.29657C3.63858 4.92613 4.59987 3.7548 5.83324 2.93069C7.0666 2.10658 8.51665 1.66672 10 1.66672C11.4834 1.66672 12.9334 2.10658 14.1668 2.93069C15.4001 3.7548 16.3614 4.92613 16.9291 6.29657C17.4968 7.66701 17.6453 9.17501 17.3559 10.6299C17.0665 12.0847 16.3522 13.4211 15.3033 14.47ZM10 12.5C10.8841 12.5 11.7319 12.1488 12.357 11.5237C12.9821 10.8986 13.3333 10.0507 13.3333 9.16665C13.3333 8.2826 12.9821 7.43475 12.357 6.80963C11.7319 6.18451 10.8841 5.83332 10 5.83332C9.11595 5.83332 8.2681 6.18451 7.64298 6.80963C7.01786 7.43475 6.66667 8.2826 6.66667 9.16665C6.66667 10.0507 7.01786 10.8986 7.64298 11.5237C8.2681 12.1488 9.11595 12.5 10 12.5ZM10 10.8333C9.55798 10.8333 9.13405 10.6577 8.82149 10.3452C8.50893 10.0326 8.33334 9.60868 8.33334 9.16665C8.33334 8.72462 8.50893 8.3007 8.82149 7.98814C9.13405 7.67558 9.55798 7.49999 10 7.49999C10.442 7.49999 10.866 7.67558 11.1785 7.98814C11.4911 8.3007 11.6667 8.72462 11.6667 9.16665C11.6667 9.60868 11.4911 10.0326 11.1785 10.3452C10.866 10.6577 10.442 10.8333 10 10.8333Z" fill="#1A2B6B"/></svg>';
                    $output .= '<select class="tw-field" name="filter_location">';
                        $output .= '<option value="">' . esc_html__( 'Байршил' ,'lvly') . '</option>';
                        $locations = get_posts(array(
                            'post_type' => 'location',
                            'post_status' => 'publish',
                            'numberposts' => -1
                            // 'order'    => 'ASC'
                        ));
                        foreach ( $locations as $location ) {
                            $output .= '<option value="' . esc_attr( $location -> ID ) . '"' . ( $location -> ID === $filter_location ? ' selected="selected"' : '' ) . '>' . esc_html( $location -> post_title ) . '</option>';
                        }
                    $output .= '</select>';
                $output .= '</div>';

            $output .= '</div>';
        $output .= '</div>';
    $output .= '</form>';

    if ( defined( 'ICT_PORTAL_MAIN' ) ) {
        $events = array();
        
        // Sub Sites Posts
        $tw_get_subsite_urls = tw_get_subsite_urls();
        foreach( $tw_get_subsite_urls as $tw_get_subsite_url ) {
            $response = wp_remote_get( trailingslashit( $tw_get_subsite_url ) . 'wp-json/wp/v2/event', array(
                'timeout'     => 1,
                'body' => array(
                    'posts_per_page' => 10,
                )
            ) );
            if ( is_array( $response ) && ! is_wp_error( $response ) && ! empty( $response['body'] ) ) {
                $response_body = json_decode( $response['body'], true );
                if ( ! empty( $response_body ) && is_array( $response_body ) ) {
                    $events += $response_body;
                }
            }
        }
        array_multisort(array_map(function($element) {
            return empty( $element['event_start'] ) ? '' : $element['event_start'];
        }, $events), SORT_DESC, $events);
        

        if ( ! empty( $events ) ) {
            $output .= '<div class="tw-organization-container tw-filter-items uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s" data-uk-grid>';
                foreach( $events as $event ) {
                    $output .= '<div class="event-item">';
                        $image = lvly_image( 'lvly_carousel_3', true );
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
                                    // $output .= '<a href="#" class="tw-post-like tw-like-button' . ( tw_get_liked( get_the_id() ) ? ' tw-liked': '' ) . '" data-id="' . get_the_id() . '">';
                                    //     $output .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M16.44 3.1001C14.63 3.1001 13.01 3.9801 12 5.3301C10.99 3.9801 9.37 3.1001 7.56 3.1001C4.49 3.1001 2 5.6001 2 8.6901C2 9.8801 2.19 10.9801 2.52 12.0001C4.1 17.0001 8.97 19.9901 11.38 20.8101C11.72 20.9301 12.28 20.9301 12.62 20.8101C15.03 19.9901 19.9 17.0001 21.48 12.0001C21.81 10.9801 22 9.8801 22 8.6901C22 5.6001 19.51 3.1001 16.44 3.1001Z" fill="#171821"/></svg>';
                                    // $output .= '</a>';
                                }
                            $output .= '</div>';

                            $output .= '<div class="tw-bottom-filter-events">';
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
                                                $output .= esc_html__( 'Үнэ', 'lvly' );
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
                    $output .= '</div>';
                }
            $output .= '</div>';
        }
    } else {
        $query = array(
            'post_type' => 'event',
            'posts_per_page' => 3,
        );
    
        if ( !empty( $filter_text ) ) {
            $query['filter_text'] = esc_sql( $filter_text );
        }
    
        // taxanomy
        $tax_query = array();
        if ( !empty( $filter_cat ) ) {
            $tax_query[] = array(
                'taxonomy' => 'event-categories',
                'terms' => $filter_cat,
                'field' => 'term_id'
            );
        }
        if ( !empty( $filter_tag ) ) {
            $tax_query[] = array(
                'taxonomy' => 'event-tags',
                'terms' => $filter_tag,
                'field' => 'term_id'
            );
        }
        if ( ! empty( $tax_query ) ) {
            $query['tax_query'] = $tax_query;
        }
    
        // meta
        if ( ! empty( $filter_location ) ) {
            $query['meta_query'] = array( array(
                'key'   => 'location',
                'value' => $filter_location,
            ) );
        }
    
        /* Pagination Fix - NOT Overriding WordPress globals */
        $query['paged'] = intval( get_query_var( 'paged' ) ?  get_query_var( 'paged' ) : get_query_var( 'page', 1 ) );
    
        $lvly_query = new WP_Query( $query );
        if ( $lvly_query->have_posts() ) {
            $output .= '<div class="tw-organization-container tw-filter-items uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s" data-uk-grid>';
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
    
                    $output .= '<div class="event-item">';
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
    
                            $output .= '<div class="tw-bottom-filter-events">';
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
                                        if ( $evetn_price = get_field( 'event_price' ) ) {
                                            $output .= '<div class="tw-entry-label">';
                                                $output .= esc_html__( 'Үнэ', 'lvly' );
                                            $output .= '</div>';
                                            $output .= '<div class="tw-entry-text">';
                                                $output .= esc_html( $evetn_price );
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
                    $output .= '</div>';
                }
        
            $output .= '</div>';
    
            $output .= lvly_pagination( array(
                'query'                => $lvly_query,
                'pagination'           => 'infinite',
                'infinite_auto'        => true,
                'infinite_auto_offset' => 100,
            ),true);
    
            wp_reset_postdata();
        }
    }




    

$output .= '</div>';
/* ================================================================================== */
echo ($output);
