<?php
/* ================================================================================== */
/*      Partner Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-entertainment'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

global $ict_parentAtts;
$ict_parentAtts['cnt'] = 0;
list($output)=lvly_item($atts);
    if ( ! empty( $atts['title'] ) ) {
        $output .=  '<div class="tw-title tw-entertainment-top">'.$atts['title'].'</div>';
    }
    $output .=   '<div class="uk-child-width-1-1@m uk-grid-small" data-uk-grid>';
        $output .= wpb_js_remove_wpautop($content);
    $output .= "</div>";
/* ================================================================================== */
echo ($output);
unset($ict_parentAtts['cnt']);