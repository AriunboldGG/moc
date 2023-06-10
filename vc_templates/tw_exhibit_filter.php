<?php
global $post;

/* ================================================================================== */
/*      Exhibit Filter Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' => array(
        'class' => array('tw-element tw-news-filter tw-exhibits-filter tw-infinite-container'),
        'data-item-selector'=>array('.news-item'),
    ),
    'animation_target' => 'article.post',
), vc_map_get_attributes($this->getShortcode(), $atts));

// 
list($output)=lvly_item($atts);

    if ( ! empty( $atts['title'] ) ) {
        $output .= '<div class="uk-container">';
            $output .= '<h3 class="tw-title">';
                $output .= esc_html( $atts['title'] );
            $output .= '</h3>';
        $output .= '</div>';
    }

    if ( defined( 'ICT_PORTAL_MAIN' ) ) {

        /**
         * Cache - Posts
         */

        $tw_cache_created = 0;

        $tw_all_sites_latest_posts = array();

        // Current site Posts
        $tw_cache_expire_time = 60 * 60 * 3;
        $tw_cache_name        = 'tw_all_sites_latest_exhibits_' . 'portal';
        $tw_cache_data        = get_transient( $tw_cache_name );
        $tw_cache_data        = $tw_cache_data && is_array( $tw_cache_data ) ? $tw_cache_data : array();
        $tw_cache_not_expired = get_transient( $tw_cache_name . '_not_expired' );

        $crr_new_posts = array();

        if ( $tw_cache_not_expired ) {
            $crr_new_posts = $tw_cache_data;
        } else {
            if ( $tw_cache_created > 4 ) {
                $crr_new_posts = $tw_cache_data;
            } else {
                $tw_cache_created++;

                $query = array(
                    'post_type' => 'exhibits',
                    'posts_per_page' => -1,
                    // 'posts_per_page' => $atts['left_tab_posts_per_page'],
                    'no_found_rows'  => true,
                );

                $lvly_query = new WP_Query( $query );
                if ( $lvly_query->have_posts() ) {
                    while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                        $new_post = array(
                            'images' => array(),
                            'cats'   => array(),
                        ); 

                        // Images
                        $image = lvly_image( 'lvly_carousel_3', true );
                        if( ! empty( $image ) ) {
                            $new_post['images']['lvly_carousel_3'] = $image;
                        }

                        // Cats
                        $taxs = wp_get_post_terms( get_the_id(), 'exhibits_cat' );
                        foreach( $taxs as $tax ) {
                            $new_post['cats'][] = array(
                                'id'   => $tax->term_id,
                                'name' => $tax->name,
                            );
                        }
                        $new_post['title']     = get_the_title();
                        $new_post['permalink'] = get_permalink();
                        $new_post['date']      = strtotime( $post->post_date );
                        ///

                        $crr_new_posts[] = $new_post;
                    }
                    wp_reset_postdata();
                }

                set_transient( $tw_cache_name                 , $crr_new_posts, $tw_cache_expire_time * 100 );
                set_transient( $tw_cache_name . '_not_expired', true          , $tw_cache_expire_time );
            }
        }

        // Merge Datas
        $tw_all_sites_latest_posts = array_merge( $tw_all_sites_latest_posts, $crr_new_posts );

        // Sub Sites Posts
        $tw_get_subsite_urls = tw_get_subsite_urls();
        
        foreach( $tw_get_subsite_urls as $tw_get_subsite_url ) {
            $tw_cache_expire_time = 60 * 60 * 3;
            $tw_cache_name        = 'tw_all_sites_latest_exhibits_' . esc_sql( esc_url( $tw_get_subsite_url ) );
            $tw_cache_data        = get_transient( $tw_cache_name );
            $tw_cache_data        = $tw_cache_data && is_array( $tw_cache_data ) ? $tw_cache_data : array();
            $tw_cache_not_expired = get_transient( $tw_cache_name . '_not_expired' );

            $crr_new_posts = array();

            if ( $tw_cache_not_expired ) {
                $crr_new_posts = $tw_cache_data;
            } else {
                if ( $tw_cache_created > 4 ) {
                    $crr_new_posts = $tw_cache_data;
                } else {
                    $tw_cache_created++;

                    $response = wp_remote_get( trailingslashit( $tw_get_subsite_url ) . 'wp-json/wp/v2/exhibits/?per_page=100', array( 'timeout' => 1 ) );

                    if ( ! is_wp_error( $response ) && is_array( $response ) && ! empty( $response['response'] ) && ! empty( $response['response']['code'] ) && intval( $response['response']['code'] ) === 200  ) {
                        if ( ! empty( $response['body'] ) ) {
                            $response_body = json_decode( $response['body'], true );

                            if ( is_array( $response_body ) ) {
                                foreach( $response_body as $sub_site_post ) {
                                    $new_post = array(
                                        'images' => array(),
                                    ); 
                                    
                                    // Images
                                    if( ! empty( $sub_site_post['images'] ) && ! empty( $sub_site_post['images']['lvly_carousel_3'] ) ) {
                                        $new_post['images']['lvly_carousel_3'] = $sub_site_post['images']['lvly_carousel_3'];
                                    }

                                    // Cats
                                    $new_post['cats']      = !empty( $sub_site_post['cats'] ) ? $sub_site_post['cats'] : array();
                                    
                                    // Featured
                                    $new_post['featured']  = !empty( $sub_site_post['featured'] ) ? $sub_site_post['featured'] : false;


                                    $new_post['title']     = !empty( $sub_site_post['title'] ) && ! empty( $sub_site_post['title']['rendered'] ) ? $sub_site_post['title']['rendered'] : '';
                                    $new_post['permalink'] = !empty( $sub_site_post['link'] ) ? $sub_site_post['link'] : '#';
                                    $new_post['date']      = !empty( $sub_site_post['date'] ) ? strtotime( $sub_site_post['date'] ) : '#';
                                    
                                    ///
                                    $crr_new_posts[] = $new_post;
                                }

                                set_transient( $tw_cache_name                 , $crr_new_posts, $tw_cache_expire_time * 100 );
                                set_transient( $tw_cache_name . '_not_expired', true          , $tw_cache_expire_time );
                            }
                        }
                    } else {
                        // Set old data, Connection Failed
                        $crr_new_posts = $tw_cache_data;
                    }
                }
            }

            // Merge Datas
            $tw_all_sites_latest_posts = array_merge( $tw_all_sites_latest_posts, $crr_new_posts );
        }

        array_multisort(array_map(function($element) {
            return $element['date'];
        }, $tw_all_sites_latest_posts), SORT_DESC, $tw_all_sites_latest_posts);

        $output .= '<div class="tw-filter-items uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s" data-uk-grid>';

            $posts_per_page = empty( $atts['posts_per_page'] ) ? 9 : intval( $atts['posts_per_page'] );
            $paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : ( get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1);
            
            $offset = ( $paged - 1 ) * $posts_per_page; 
            $max_num_pages = ceil( count( $tw_all_sites_latest_posts ) / $posts_per_page );
            $tw_all_sites_latest_posts = array_slice( $tw_all_sites_latest_posts, $offset, $posts_per_page );

            foreach( $tw_all_sites_latest_posts as $crr_post ) {
                $dateFormated = '';
                if ( ! empty( $crr_post['date'] ) ) {
                    $dateFormated = date( get_option( 'date_format' ), $crr_post['date'] );
                }

                $output .= '<article class="news-item">';
                    $output .= '<div class="news-item-inner">';
                        $output .= ' <div class="entry-post uk-height-1-1">';
                            $output .= '<div class="blog-post-container">';
                                $output .= '<div class="news-filterthubnail">';

                                    if ( ! empty( $crr_post['images'] ) && ! empty( $crr_post['images']['lvly_carousel_3'] )  && ! empty( $crr_post['images']['lvly_carousel_3']['url'] ) ) {
                                        $output .= '<a href="' . esc_url( $crr_post['permalink'] ) . '" title="' . esc_attr( $crr_post['title'] ) . '" style="background-image:url(' . esc_url( $crr_post['images']['lvly_carousel_3']['url'] ) . ')">';
                                            $output .= '<img src="' . esc_url( $crr_post['images']['lvly_carousel_3']['url'] ) . '" alt="' . esc_attr( $crr_post['images']['lvly_carousel_3']['alt'] ) . '" />';
                                        $output .= '</a>';
                                    }
                                    
                                $output .= '</div>';
                                $output .= '<div class="news-filtercontent">';
                                    $output .= '<div class="tw-news-filter uk-flex">';
                                        if ( ! empty( $crr_post['cats'] ) ) {
                                            $output .= '<div class="tw-news-filter-cats uk-flex">';
                                                foreach( $crr_post['cats'] as $cat ) {
                                                    if ( ! empty( $cat['name'] ) ) {
                                                        $output .= '<div class="cat-item"><span># '  . esc_html( $cat['name'] ) . '</span>' . '</div>';
                                                    }
                                                }
                                            $output .= '</div>';
                                        }
                                        $output .= '<div class="tw-news-filter-date uk-flex uk-flex-middle">';
                                            $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6663 8.00004C14.6663 11.68 11.6797 14.6667 7.99967 14.6667C4.31967 14.6667 1.33301 11.68 1.33301 8.00004C1.33301 4.32004 4.31967 1.33337 7.99967 1.33337C11.6797 1.33337 14.6663 4.32004 14.6663 8.00004Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4729 10.12L8.40626 8.88671C8.04626 8.67338 7.75293 8.16005 7.75293 7.74005V5.00671" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                            $output .= '<span class="tw-news-filter-time">';
                                                $output .= $dateFormated;
                                            $output .= '</span>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                    $output .= '<h2 class="news-filtertitle">';
                                        $output .= '<a href="' . esc_url( $crr_post['permalink'] ) . '">' . esc_html( $crr_post['title'] ) . '</a>';
                                    $output .= '</h2>';
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</article>';
            }
        $output .= '</div>';

        $output .= lvly_pagination( array(
            'query'                => 'not_query',
            'max_num_pages'        =>  $max_num_pages,
            'pagination'           => 'infinite',
            'infinite_auto'        => true,
            'infinite_auto_offset' => 100,
        ),true);
    } else {
        $filter_text     = empty( $_REQUEST['filter_text'] )     ? '' : trim( $_REQUEST['filter_text'] );
        $filter_cat      = empty( $_REQUEST['filter_cat'] )      ? '' : intval( $_REQUEST['filter_cat'] );

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

                    // Category
                    $output .= '<div class="tw-field-outer">';
                        $output .= '<label>';
                            $output .= esc_html__( 'Ангилал' ,'lvly');
                        $output .= '</label>';
                        $output .= '<select class="tw-field" name="filter_cat">';
                            $output .= '<option value="">' . esc_html__( 'Сонгох' ,'lvly') . '</option>';
                            $term_post_cats = get_terms('exhibits_cat');
                            foreach ( $term_post_cats as $term_post_cat ) {
                                $output .= '<option value="' . esc_attr( $term_post_cat -> term_id ) . '"' . ( $term_post_cat -> term_id === $filter_cat ? ' selected="selected"' : '' ) . '>' . esc_html__( $term_post_cat -> name ) . '</option>';
                            }
                        $output .= '</select>';
                    $output .= '</div>';

                $output .= '</div>';
            $output .= '</div>';
        $output .= '</form>';

        // Get Posts
        $query = array(
            'post_type' => 'exhibits',
            'posts_per_page' => $atts['posts_per_page'],
        );

        // Custom Filter
        if ( !empty( $filter_text ) ) {
            $query['filter_text'] = esc_sql( $filter_text );
        }

        $tax_query = array();
        if ( !empty( $filter_cat ) ) {
            $tax_query[] = array(
                'taxonomy' => 'exhibits_cat',
                'terms' => $filter_cat,
                'field' => 'term_id'
            );
        }
        if ( ! empty( $tax_query ) ) {
            $query['tax_query'] = $tax_query;
        }

        // Element Default selected Category
        if ( empty( $filter_text ) && empty( $filter_cat ) && ! empty( $atts['cats'] ) ) {
            $query['tax_query'] = array(array(
                'taxonomy' => 'exhibits_cat',
                'terms'    => explode( ",", $atts['cats'] ),
                'field'    => 'slug',
            ));
        }

        /* Pagination Fix - NOT Overriding WordPress globals */
        $query['paged'] = intval( get_query_var( 'paged' ) ?  get_query_var( 'paged' ) : get_query_var( 'page', 1 ) );
        
        $lvly_query = new WP_Query( $query );
        if ( $lvly_query->have_posts() ) {
            $output .= '<div class="tw-filter-items uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s" data-uk-grid>';
                while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                    $output .= '<article class="news-item">';
                        $output .= '<div class="news-item-inner">';
                            $output .= ' <div class="entry-post uk-height-1-1">';
                                $output .= '<div class="blog-post-container">';
                                    $output .= '<div class="news-filterthubnail">';
                                        $image = lvly_image( 'lvly_carousel_3', true );
                                        if ( ! empty( $image['url'] ) ) {
                                            $output .= '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_title() ) . '" style="background-image:url('. esc_url( $image['url'] ) .')">';
                                                $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                            $output .= '</a>';
                                        }
                                    $output .= '</div>';
                                    $output .= '<div class="news-filtercontent">';
                                        $output .= '<div class="tw-news-filter uk-flex">';
                                            $output .= '<div class="tw-news-filter-cats uk-flex">';
                                                $taxs = wp_get_post_terms( get_the_id(), 'exhibits_cat' );
                                                foreach( $taxs as $tax) {
                                                    $output .= '<div class="cat-item"><span># '  . $tax->name . '</span>' . '</div>';
                                                }
                                            $output .= '</div>';
                                            $output .= '<div class="tw-news-filter-date uk-flex uk-flex-middle">';
                                                $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6663 8.00004C14.6663 11.68 11.6797 14.6667 7.99967 14.6667C4.31967 14.6667 1.33301 11.68 1.33301 8.00004C1.33301 4.32004 4.31967 1.33337 7.99967 1.33337C11.6797 1.33337 14.6663 4.32004 14.6663 8.00004Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4729 10.12L8.40626 8.88671C8.04626 8.67338 7.75293 8.16005 7.75293 7.74005V5.00671" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                                $output .= '<span class="tw-news-filter-time">';
                                                    $output .= get_the_time('Y-m-d');
                                                $output .= '</span>';
                                            $output .= '</div>';
                                        $output .= '</div>';
                                        $output .= '<h2 class="news-filtertitle">';
                                            $output .= '<a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a>';
                                        $output .= '</h2>';
                                    $output .= '</div>';
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</article>';
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