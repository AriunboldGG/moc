<?php
/* ================================================================================== */
/*      News Shortcode
/* ================================================================================== */
global $tw_events_calendar_weekly_today_found, $tw_events_calendar_more;
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-events-calendar tw-events-calendar-weekly'),
        'data-uk-slider' => array('autoplay: false; finite: true;')
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));


list($output)=lvly_item($atts);
    $output .= '<div class="tw-slider-navigation-container">';
        if ( ! empty( $atts['title'] ) ) {
            $output .= '<h3 class="tw-title">';
                $output .= esc_html( $atts['title'] );
            $output .= '</h3>';
        }
        $output .= '<div class="tw-slider-navigation">';
            $link = vc_build_link( $atts['link'] );
            
            if ( ! empty( $link['url'] ) && !empty( $link['title'] ) ) {
                $tw_events_calendar_more = $link['url'];
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
        $output .= '<ul class="uk-slider-items uk-child-width-1-1" data-uk-grid>';
            $tw_events_calendar_weekly_today_found = false;
            // long_events=1
            // full=1
            // country="MN"
            // category="1,2,3,4"
            // yr="2012"
            // mo="2"
            $nexstMonth = strtotime( "+1 Months" );
            $output .= EM_Calendar::output( array( 'long_events'=>1 ), false );
            $output .= EM_Calendar::output( array( 'long_events'=>1 , 'yr' => date( "Y", $nexstMonth ), 'mo' => date( "j", $nexstMonth ) ), false );
        $output .= '</ul>';
    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);
$tw_events_calendar_more = '';