<?php
/* ================================================================================== */
/*      Slider Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-slider tw-owl-carousel-container'),
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

wp_enqueue_script('owl-carousel');

list($output)=lvly_item($atts);
    $output .= '<div class="owl-carousel owl-theme">';
        $output .= wpb_js_remove_wpautop($content);
    $output .= '</div>';
$output .= '</div>';
/* ================================================================================== */
echo ($output);