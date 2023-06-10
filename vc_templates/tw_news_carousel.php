<?php
/* ================================================================================== */
/*      News Filter Shortcode
/* ================================================================================== */
global $tw_post__not_in;
if ( empty( $tw_post__not_in ) ) {
    $tw_post__not_in = array();
}
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
        'post_type' => 'post',
        'posts_per_page' => $atts['posts_per_page'],
        'post__not_in' => $tw_post__not_in,
    );

    $cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
    if ($cats) {
        $query['tax_query'] = Array(Array(
                'taxonomy' => 'category',
                'terms' => $cats,
                'field' => 'slug'
            )
        );
    }
    /* Pagination Fix - NOT Overriding WordPress globals */
    $query['paged'] = intval( get_query_var( 'paged' ) ?  get_query_var( 'paged' ) : get_query_var( 'page', 1 ) );

    $lvly_query = new WP_Query( $query );
    if ( $lvly_query->have_posts() ) {
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
                            $tw_post__not_in[] = get_the_ID();
                            $output .= '<li>';
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
                                                            $output .= lvly_cats('', '# ');
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