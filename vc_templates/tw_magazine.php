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
    $output .= '<div class="uk-width-1-1>';
        $output .= '<div class="tw-slider-navigation-container">';
            if ( !empty( $atts['title'] ) ) {
                $output .= '<h3 class="tw-title">';
                    $output .= esc_html( $atts['title'] );
                $output .= '</h3>';
            }
        $output .= '</div>';

        /* Slider */
        $query = array(
            'post_type' => 'post',
            'posts_per_page' => $atts['posts_per_page'],
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
                $output .= '<div class="uk-column-1-3@m">';
                    while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                        $tw_post__not_in[] = get_the_ID();
                            $output .= '<div class="tw-magazine">';
                                $image = lvly_image( 'lvly_news_carousel', true );
                                if ( ! empty($image['url'] ) ) {
                                    $output .= '<div class="tw-item-image">';
                                        $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                    $output .= '</div>';
                                }
                                $output .= '<div class="tw-bottom">';
                                    $output .= '<h4 class="tw-item-title">';
                                        $output .= '<a href="' . esc_url( get_permalink() ) .'">';
                                            $output .= get_the_title();
                                        $output .= '</a>';
                                    $output .= '</h4>';
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</li>';
                    }
                $output .= '</div>';
        }


    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);
