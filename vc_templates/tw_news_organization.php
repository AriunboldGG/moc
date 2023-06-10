<?php
/* ================================================================================== */
/*      News Shortcode
/* ================================================================================== */
global $tw_post__not_in, $post;
if ( empty( $tw_post__not_in ) ) {
    $tw_post__not_in = array();
}

/**
 * Cache - Posts
 */

$tw_cache_created = 0;

$tw_all_sites_latest_posts = array();

// Current site Posts
$tw_cache_expire_time = 60 * 30;
$tw_cache_name        = 'tw_all_sites_latest_posts_' . 'portal';
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
            'post_type' => 'post',
            'posts_per_page' => -1,
            // 'posts_per_page' => $atts['left_tab_posts_per_page'],
            'post__not_in'   => $tw_post__not_in,
            'no_found_rows'  => true,
        );
        $cats = false;
        if ( ! empty( $atts['left_tab_org_cats'] ) ) {
            if ( is_array( $atts['left_tab_org_cats'] ) ) {
                $cats = $atts['left_tab_org_cats'];
            } else {
                $cats = explode( ",", $atts['left_tab_org_cats'] );
            }
        }
        if ( $cats ) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'category',
                    'terms' => $cats,
                    'field' => 'slug'
                )
            );
        }

        $lvly_query = new WP_Query( $query );
        if ( $lvly_query->have_posts() ) {
            while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                $tw_post__not_in[] = get_the_ID();
                $new_post = array(
                    'images' => array(),
                    'cats'   => array(),
                ); 

                // Images
                $image = lvly_image( 'lvly_news_tab', true );
                if( ! empty( $image ) ) {
                    $new_post['images']['lvly_news_tab'] = $image;
                }

                $image = lvly_image( 'lvly_news_carousel', true );
                if( ! empty( $image ) ) {
                    $new_post['images']['lvly_news_carousel'] = $image;
                }

                // Cats
                $pCats = get_the_category();
                foreach( $pCats as $pCat ) {
                    $new_post['cats'][] = array(
                        'name' => $pCat->name,
                    );
                }

                // Featured 
                $new_post['featured']  = get_field( 'featured_post' );

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
$tw_all_sites_latest_posts = array_merge( $tw_all_sites_latest_posts, $crr_new_posts );

// Sub Sites Posts
$tw_get_subsite_urls = tw_get_subsite_urls();
foreach( $tw_get_subsite_urls as $tw_get_subsite_url ) {
    $tw_cache_expire_time = 60 * 10;
    $tw_cache_name        = 'tw_all_sites_latest_posts_' . esc_sql( esc_url( $tw_get_subsite_url ) );
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
        
            $response = wp_remote_get( trailingslashit( $tw_get_subsite_url ) . 'wp-json/wp/v2/posts', array( 'timeout' => 1 ) );

            if ( ! is_wp_error( $response ) && is_array( $response ) && ! empty( $response['response'] ) && ! empty( $response['response']['code'] ) && intval( $response['response']['code'] ) === 200  ) {
                if ( ! empty( $response['body'] ) ) {
                    $sub_site_posts = json_decode( $response['body'], true );

                    if ( is_array( $sub_site_posts ) ) {
                        foreach( $sub_site_posts as $sub_site_post ) {
                            $new_post = array(
                                'images' => array(),
                            ); 
                            
                            // Images
                            if( ! empty( $sub_site_post['images'] ) && ! empty( $sub_site_post['images']['lvly_news_tab'] ) ) {
                                $new_post['images']['lvly_news_tab'] = $sub_site_post['images']['lvly_news_tab'];
                            }

                            if( ! empty( $sub_site_post['images'] ) && ! empty( $sub_site_post['images']['lvly_news_carousel'] ) ) {
                                $new_post['images']['lvly_news_carousel'] = $sub_site_post['images']['lvly_news_carousel'];
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


$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw_news_organization'),
        'data-uk-grid' => array(),
        'data-uk-slider' => array('autoplay: true; finite: false;')
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));
list($output)=lvly_item($atts);
    $output .= '<div class="uk-width-2-3@m">';
        $output .= '<div class="tw-slider-navigation-container">';
            if ( !empty( $atts['title'] ) ) {
                $output .= '<h3 class="tw-title">';
                    $output .= esc_html( $atts['title'] );
                $output .= '</h3>';
            }
            $output .= '<div class="tw-slider-navigation">';
                $output .= '<a href="#" uk-slider-item="previous">';
                    $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 12L4.95333 7.95333L9 3.90667" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                $output .= '</a>';
                $output .= '<a href="#" uk-slider-item="next">';
                    $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 3.95312L11.0467 7.99979L7 12.0465" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                $output .= '</a>';
            $output .= '</div>';
        $output .= '</div>';

        /* Slider */
        $output .= '<div class="uk-slider-container">';
            $output .= '<ul class="uk-slider-items uk-child-width-1-1 uk-grid">';
                foreach ( $tw_all_sites_latest_posts as $tw_all_sites_latest_post ) {
                    if ( ! empty( $tw_all_sites_latest_post['featured'] ) ) {
                        $dateFormated = '';
                        if ( ! empty( $tw_all_sites_latest_post['date'] ) ) {
                            $dateFormated = date( get_option( 'date_format' ), $tw_all_sites_latest_post['date'] );
                        }
    
                        $output .= '<li>';
                            $output .= '<div class="tw-slider-item">';
                                $image = ( ! empty( $tw_all_sites_latest_post['images'] ) && ! empty( $tw_all_sites_latest_post['images']['lvly_news_carousel'] ) ) ? $tw_all_sites_latest_post['images']['lvly_news_carousel'] : array() ;
                                if ( ! empty($image['url'] ) ) {
                                    $output .= '<div class="tw-item-image">';
                                        $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                    $output .= '</div>';
                                }
                                $output .= '<div class="tw-bottom">';
                                    $output .= '<div class="tw-meta">';
                                        if ( ! empty( $tw_all_sites_latest_post['cats'] ) ) {
                                            $output .= '<div class="entry-cats tw-meta">';
                                                foreach ( $tw_all_sites_latest_post['cats'] as $cat ) {
                                                    if ( ! empty( $cat['name'] ) ) {
                                                        $output .= '<div class="cat-item"><span># ' . esc_html( $cat['name'] ) . '</span></div>';
                                                    }
                                                }
                                            $output .= '</div>';
                                        }
                                        $output .= '<div class="tw-meta entry-date">';
                                            $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6667 8.00016C14.6667 11.6802 11.68 14.6668 8.00001 14.6668C4.32001 14.6668 1.33334 11.6802 1.33334 8.00016C1.33334 4.32016 4.32001 1.3335 8.00001 1.3335C11.68 1.3335 14.6667 4.32016 14.6667 8.00016Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4733 10.1202L8.40666 8.88684C8.04666 8.6735 7.75333 8.16017 7.75333 7.74017V5.00684" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                            $output .= '<a href="' . esc_url( $tw_all_sites_latest_post['permalink'] ) .'">' . esc_html( $dateFormated ) . '</a>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                    $output .= '<h4 class="tw-item-title">';
                                        $output .= '<a href="' . esc_url( $tw_all_sites_latest_post['permalink'] ) .'">';
                                            $output .= esc_html( $tw_all_sites_latest_post['title'] );
                                        $output .= '</a>';
                                    $output .= '</h4>';
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</li>';
                    }
                }
            $output .= '</ul>';
        $output .= '</div>';
        /***/


    $output .= '</div>';
    $output .= '<div class="uk-width-1-3@m">';

        $output .= '<ul data-uk-tab>';
            if ( ! empty( $atts['left_tab_title'] ) ) {
                $output .= '<li><a href="#">';
                    $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6663 8.00016C14.6663 11.6802 11.6797 14.6668 7.99967 14.6668C4.31967 14.6668 1.33301 11.6802 1.33301 8.00016C1.33301 4.32016 4.31967 1.3335 7.99967 1.3335C11.6797 1.3335 14.6663 4.32016 14.6663 8.00016Z" stroke="#95A1BB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path opacity="0.4" d="M10.4731 10.1202L8.40638 8.88684C8.04638 8.6735 7.75305 8.16017 7.75305 7.74017V5.00684" stroke="#95A1BB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                    $output .= esc_html( $atts['left_tab_title'] );
                $output .= '</a></li>';
            }
            if ( ! empty( $atts['right_tab_title'] ) ) {
                $output .= '<li><a href="#">';
                    $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.06665 7.99999V7.01333C6.06665 5.73999 6.96665 5.22666 8.06665 5.85999L8.91998 6.35333L9.77332 6.84666C10.8733 7.47999 10.8733 8.51999 9.77332 9.15333L8.91998 9.64666L8.06665 10.14C6.96665 10.7733 6.06665 10.2533 6.06665 8.98666V7.99999Z" stroke="#95A1BB" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.00004 14.6668C11.6819 14.6668 14.6667 11.6821 14.6667 8.00016C14.6667 4.31826 11.6819 1.3335 8.00004 1.3335C4.31814 1.3335 1.33337 4.31826 1.33337 8.00016C1.33337 11.6821 4.31814 14.6668 8.00004 14.6668Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                    $output .= esc_html( $atts['right_tab_title'] );
                $output .= '</a></li>';
            }
        $output .= '</ul>';
        $output .= '<ul class="uk-switcher tw-org-tab-body">';
            if ( ! empty( $atts['left_tab_title'] ) ) {
                $output .= '<li class="tw-org-latest">';
                    $output .= '<div class="tw-org-items">';

                        foreach ( $tw_all_sites_latest_posts as $tw_all_sites_latest_post ) {
                            if ( empty( $tw_all_sites_latest_post['featured'] ) ) {
                                $dateFormated = '';

                                if ( ! empty( $tw_all_sites_latest_post['date'] ) ) {
                                    $dateFormated = date( get_option( 'date_format' ), $tw_all_sites_latest_post['date'] );
                                }

                                $output .= '<div class="tw-org-item">';
                                
                                    $image = ( ! empty( $tw_all_sites_latest_post['images'] ) && ! empty( $tw_all_sites_latest_post['images']['lvly_news_tab'] ) ) ? $tw_all_sites_latest_post['images']['lvly_news_tab'] : array() ;

                                    if ( ! empty( $image ) && ! empty( $image['url'] ) ) {
                                        $output .= '<div class="tw-item-image">';
                                            $output .= '<img src="' . esc_url( $image['url'] ) . '"' . ( ! empty( $image['alt'] ) ? ( ' alt="' . esc_attr( $image['alt'] ) . '"') : '' ) . ' />';
                                        $output .= '</div>';
                                    }

                                    $output .= '<div class="tw-right-org">';
                                        $output .= '<h6 class="tw-item-title">';
                                            $output .= '<a href="' . esc_url( $tw_all_sites_latest_post['permalink'] ) .'">';
                                                $output .= esc_html( $tw_all_sites_latest_post['title'] );
                                            $output .= '</a>';
                                        $output .= '</h6>';
                                        $output .= '<div class="tw-meta-org">';
                                            $output .= '<div class="tw-meta entry-date">';
                                                $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6667 8.00016C14.6667 11.6802 11.68 14.6668 8.00001 14.6668C4.32001 14.6668 1.33334 11.6802 1.33334 8.00016C1.33334 4.32016 4.32001 1.3335 8.00001 1.3335C11.68 1.3335 14.6667 4.32016 14.6667 8.00016Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4733 10.1202L8.40666 8.88684C8.04666 8.6735 7.75333 8.16017 7.75333 7.74017V5.00684" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                                $output .= '<a href="' . esc_url( $tw_all_sites_latest_post['permalink'] ) .'">' . esc_html( $dateFormated ) . '</a>';
                                            $output .= '</div>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                $output .= '</div>';
                            }
                        }
                        /***/

                    $output .= '</div>';
                $output .= '</li>';
            }
            if ( ! empty( $atts['right_tab_title'] ) ) {
                $output .= '<li class="tw-org-video">';
                    $output .= '<div class="tw-org-items">';
                        
                        /* Right Tab */
                        $query = array(
                            'post_type' => 'organization',
                            'posts_per_page' => $atts['right_tab_posts_per_page'],
                            'no_found_rows'  => true,
                        );
                        $cats = false;
                        if ( ! empty( $atts['right_tab_cats'] ) ) {
                            if ( is_array( $atts['right_tab_cats'] ) ) {
                                $cats = $atts['right_tab_cats'];
                            } else {
                                $cats = explode( ",", $atts['right_tab_cats'] );
                            }
                        }
                        if ($cats) {
                            $query['tax_query'] = Array(Array(
                                    'taxonomy' => 'organization_cat',
                                    'terms' => $cats,
                                    'field' => 'slug'
                                )
                            );
                        }

                        $lvly_query = new WP_Query( $query );
                        if ( $lvly_query->have_posts() ) {
                            while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                                $tw_post__not_in[] = get_the_ID();
                                
                                $site_url = get_field( 'site_url_external' );
                                if( empty( $site_url ) ) {
                                    $site_url = get_field( 'site_url' );
                                }

                                $output .= '<div class="tw-org-item">';
                                    
                                    $image = lvly_image( 'lvly_news_tab', true );

                                    if ( ! empty($image['url'] ) ) {
                                        $output .= '<div class="tw-item-image">';
                                            $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                        $output .= '</div>';
                                    }

                                    $output .= '<div class="tw-right-org">';
                                        $output .= '<h6 class="tw-item-title">';
                                            $output .= '<a href="' . esc_url( empty( $site_url ) ? '' : $site_url ) .'">';
                                                $output .= get_the_title();
                                            $output .= '</a>';
                                        $output .= '</h6>';
                                        $output .= '<div class="tw-meta-org">';
                                            $output .= '<div class="tw-meta entry-date">';
                                                $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6667 8.00016C14.6667 11.6802 11.68 14.6668 8.00001 14.6668C4.32001 14.6668 1.33334 11.6802 1.33334 8.00016C1.33334 4.32016 4.32001 1.3335 8.00001 1.3335C11.68 1.3335 14.6667 4.32016 14.6667 8.00016Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4733 10.1202L8.40666 8.88684C8.04666 8.6735 7.75333 8.16017 7.75333 7.74017V5.00684" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                                $output .= '<a href="' . esc_url( empty( $site_url ) ? '' : $site_url ) .'">' . esc_attr( get_the_time( get_option( 'date_format' ) ) ) . '</a>';
                                            $output .= '</div>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                $output .= '</div>';
                            }
                            wp_reset_postdata();
                        }
                        /***/

                    $output .= '</div>';
                $output .= '</li>';
            }
        $output .= '</ul>';

    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);
