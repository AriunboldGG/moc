<?php
/* ================================================================================== */
/*      News Shortcode
/* ================================================================================== */
global $tw_post__not_in;
if ( empty( $tw_post__not_in ) ) {
    $tw_post__not_in = array();
}
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-news'),
        'data-uk-grid' => array(),
        'data-uk-slider' => array('autoplay: false; finite: true;')
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

        $lvly_query = new WP_Query( $query );
        if ( $lvly_query->have_posts() ) {
            $output .= '<div class="uk-slider-container">';
                $output .= '<ul class="uk-slider-items uk-child-width-1-1 uk-grid">';
                    while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                        $tw_post__not_in[] = get_the_ID();
                        $output .= '<li>';
                            $output .= '<div class="tw-slider-item">';
                                $image = lvly_image( 'lvly_news_carousel', true );
                                if ( ! empty($image['url'] ) ) {
                                    $output .= '<div class="tw-item-image">';
                                        $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                    $output .= '</div>';
                                }
                                $output .= '<div class="tw-bottom">';
                                    $output .= '<div class="tw-meta">';
                                        $output .= '<div class="entry-cats tw-meta">';
                                            $output .= lvly_cats( '', '# ' );
                                        $output .= '</div>';
                                        $output .= '<div class="tw-meta entry-date">';
                                            // $output .= lvly_svg_icon('icon-clock.svg');
                                            $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6667 8.00016C14.6667 11.6802 11.68 14.6668 8.00001 14.6668C4.32001 14.6668 1.33334 11.6802 1.33334 8.00016C1.33334 4.32016 4.32001 1.3335 8.00001 1.3335C11.68 1.3335 14.6667 4.32016 14.6667 8.00016Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4733 10.1202L8.40666 8.88684C8.04666 8.6735 7.75333 8.16017 7.75333 7.74017V5.00684" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                            $output .= '<a href="' . esc_url( get_permalink() ) .'">' . esc_attr( get_the_time( get_option( 'date_format' ) ) ) . '</a>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                    $output .= '<h4 class="tw-item-title">';
                                        $output .= '<a href="' . esc_url( get_permalink() ) .'">';
                                            $output .= get_the_title();
                                        $output .= '</a>';
                                    $output .= '</h4>';
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</li>';
                    }
                $output .= '</ul>';
            $output .= '</div>';
        }
        /***/


    $output .= '</div>';
    $output .= '<div class="uk-width-1-3@m">';
        $output .= lvly_latest_news_tab( $atts );
    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);
