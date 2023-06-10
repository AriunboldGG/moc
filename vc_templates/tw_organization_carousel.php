<?php
/* ================================================================================== */
/*      Organizatioin Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-baiguullaga'),
        'data-uk-grid' => array(),
        'data-uk-slider' => array('autoplay: false; finite: true;')
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

list($output)=lvly_item($atts);

    $output .= '<div class="tw-slider-navigation-container">';
        if ( !empty( $atts['title'] ) ) {
            $output .= '<h3 class="tw-title tw-baiguullaga">';
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


    $query = array(
        'post_type' => 'organization',
        'posts_per_page' => $atts['posts_per_page'],
    );

    $lvly_query = new WP_Query( $query );
    if ( $lvly_query->have_posts() ) {
        $output .= '<div class="uk-slider-container">';
            $output .= '<ul class="uk-slider-items uk-child-width-1-4@l uk-child-width-1-2@m uk-child-width-1-1@s uk-grid">';
                while ( $lvly_query->have_posts() ) { $lvly_query->the_post();

                    $site_url = get_field( 'site_url_external' );
                    if( empty( $site_url ) ) {
                        $site_url = get_field( 'site_url' );
                    }
                    
                    $output .= '<li>';
                        $image = lvly_image( 'lvly_organization', true );
                        if ( ! empty($image['url'] ) ) {
                            $output .= '<div class="tw-item-image-baiguullaga">';
                                $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                            $output .= '</div>';
                        }
                        $output .= '<div class="tw-entry-baiguullaga">';
                            $output .= '<div class="tw-top-baiguullaga">';
                                $output .= '<h4 class="tw-item-title-baiguullaga">';
                                    // if ( $site_url ) {
                                        $output .= '<a href="' . esc_url( $site_url ) .'">';
                                    // }
                                        $output .= get_the_title();
                                    // if ( $site_url ) {
                                        $output .= '</a>';
                                    // }
                                $output .= '</h4>';
                            $output .= '</div>';

                            $output .= '<div class="tw-bottom-baiguullaga">';
                                $output .= '<div class="tw-post-like-baiguullaga">';
                                    $output .= '<h4>'.esc_html( defined( 'ICT_LANG' ) && 'ICT_LANG' === 'EN' ? 'Liked':'Таалагдсан' ).'</h4>';
                                    $output .= '<a href="#" class="tw-like-button' . ( tw_get_liked( get_the_id() ) ? ' tw-liked': '' ) . ' uk-flex uk-flex-middle" data-id="' . get_the_id() . '">';
                                        $output .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M16.44 3.1001C14.63 3.1001 13.01 3.9801 12 5.3301C10.99 3.9801 9.37 3.1001 7.56 3.1001C4.49 3.1001 2 5.6001 2 8.6901C2 9.8801 2.19 10.9801 2.52 12.0001C4.1 17.0001 8.97 19.9901 11.38 20.8101C11.72 20.9301 12.28 20.9301 12.62 20.8101C15.03 19.9901 19.9 17.0001 21.48 12.0001C21.81 10.9801 22 9.8801 22 8.6901C22 5.6001 19.51 3.1001 16.44 3.1001Z" fill="#171821"/></svg>';
                                        $output .= '<span class="tw-like-count">'.tw_get_like_count( get_the_id() ).'</span>';
                                    $output .= '</a>';
                                $output .= '</div>';
                                if ( $site_url ) {
                                    $output .= '<div class="tw-entry-more-baiguullaga">';
                                        $output .= '<a class="tw-button-baiguullaga tw-button-more" href="' . esc_url( $site_url ) . '" target="_blank">';
                                            $output .= esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'More':'Дэлгэрэнгүй' );
                                        $output .= '</a>';
                                    $output .= '</div>';
                                }
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</li>';
                }
            $output .= '</ul>';
        $output .= '</div>';
        wp_reset_postdata();
    }
$output .= '</div>';
/* ================================================================================== */
echo ($output);