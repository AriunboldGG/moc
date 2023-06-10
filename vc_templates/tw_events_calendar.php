<?php
/* ================================================================================== */
/*      News Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-events-calendar'),
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));


list($output)=lvly_item($atts);
    $output .= '<div class="tw-events-calendar-navigation-container">';
        if ( ! empty( $atts['title'] ) ) {
            $output .= '<h3 class="tw-title">';
                $output .= esc_html( $atts['title'] );
            $output .= '</h3>';
        }
        // $output .= '<div class="tw-events-calendar-navigation">';
            // $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 12L4.95333 7.95333L9 3.90667" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            // $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 3.95312L11.0467 7.99979L7 12.0465" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        // $output .= '</div>';
    $output .= '</div>';

    // long_events=1
    // full=1
    // country="MN"
    // category="1,2,3,4"
    // yr="2012"
    // mo="2"
    
    $output .= '<div data-uk-grid>';
        $output .= '<div class="uk-width-expand">';
            $output .= do_shortcode( '[events_calendar long_events=1 full=1 ]' );
        $output .= '</div>';
        $output .= '<div class="uk-width-auto tw-events-calendar-more uk-hidden">';
            $output .= '<div class="tw-events-calendar-more-inner">';
                $output .= '<div class="tw-events-calendar-more-head">';
                    $output .= '<div class="tw-btn-close">';
                        $output .= '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg>';
                    $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="tw-events-calendar-more-body">';
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</div>';
    $output .= '</div>';

$output .= '</div>';
/* ================================================================================== */
echo ($output);
