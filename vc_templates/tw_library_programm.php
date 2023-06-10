<?php
/* ================================================================================== */
/*      News Filter Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' => array(
        'class' => array('tw-element tw-news-carousel tw-infinite-container'),
        'data-item-selector'=>array('.news-item'),
    ),
    'animation_target' => 'article.post',
), vc_map_get_attributes($this->getShortcode(), $atts));

list($output)=lvly_item($atts);

    

    // Get Posts
    $query = array(
        'post_type' => 'programm',
        'posts_per_page' => $atts['posts_per_page'],
    );

    $cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
    if ($cats) {
        $query['tax_query'] = Array(Array(
                'taxonomy' => 'programm_cat',
                'terms' => $cats,
                'field' => 'slug'
            )
        );
    }
    /* Pagination Fix - NOT Overriding WordPress globals */
    $query['paged'] = intval( get_query_var( 'paged' ) ?  get_query_var( 'paged' ) : get_query_var( 'page', 1 ) );

     
    $lvly_query = new WP_Query( $query );
    if ( $lvly_query->have_posts() ) {
/*Slider options*/ 
            $output .= '<div data-uk-grid data-uk-slider="autoplay: false; finite: true;">';
       
                $output .= '<div class="tw-slider-navigation-container uk-container">';
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

                $output .= '<div class="uk-slider-container">';
                    $output .= '<ul class="uk-slider-items uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s uk-grid">';
                        while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                            $output .= '<li>';
                                $output .= '<article class="news-item">';
                                    $output .= '<div class="news-item-inner-programm">';
                                        $output .= ' <div class="entry-post uk-height-1-1">';
                                            $output .= '<div class="blog-post-container-programm">';
                                                $output .= '<div class="news-program-image">';
                                                    $image = lvly_image( 'lvly_carousel_3', true );
                                                    if ( ! empty( $image['url'] ) ) {
                                                        $output .= '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_title() ) . '" style="background-image:url('. esc_url( $image['url'] ) .')">';
                                                            $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                                        $output .= '</a>';
                                                    }
                                                $output .= '</div>';
                                                $output .= '<div class="news-program-content">';
                                                    $output .= '<h2 class="news-program-title">';
                                                        $output .=  get_the_title();
                                                    $output .= '</h2>';
                                                    $output .= '<a href="' . esc_url( get_permalink() ) . '">';
                                                        $output .= esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'More':'Дэлгэрэнгүй' );
                                                    $output .= '</a>';
                                                    $output .= '</h2>';
                                                $output .= '</div>';
                                            $output .= '</div>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                $output .= '</article>';
                            $output .= '</li>';
                        }
                    $output .= '</ul>';
                $output .= '</div>';
            $output .= '</div>';
        wp_reset_postdata();
    }
        $output .= '</div>';
/* ================================================================================== */
echo ($output);