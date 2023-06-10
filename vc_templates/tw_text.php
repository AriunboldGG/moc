<?php
/* ================================================================================== */
/*      Text Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-text tw-box'),
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

if (!empty($atts['font_size'])) {
    $atts['element_atts']['class'][] = $atts['font_size'];
}
list($output)=lvly_item($atts);
    $output .= wpb_js_remove_wpautop($content, true);
$output .= '</div>';
/* ================================================================================== */
echo ($output);
