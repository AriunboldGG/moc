<?php
/* ================================================================================== */
/*      FlipBox Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-flipbox'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

global $lvly_parentAtts;

$atts['element_atts']['class'][] = $atts['hover_direction'];
$lvly_parentAtts['flipbox_item']='front';
$lvly_parentAtts['link']= $atts['link'];
$lvly_parentAtts['min_height']=$atts['min_height'];
$atts['google_fonts_field'] = $this->getParamData( 'google_fonts' );
list($output,$lvly_parentAtts['font_styles'])=lvly_item($atts);
    $output .= wpb_js_remove_wpautop($content);
$output .= "</div>";
/* ================================================================================== */
echo ($output);
unset($lvly_parentAtts['flipbox_item']);
unset($lvly_parentAtts['link']);
unset($lvly_parentAtts['font_styles']);
unset($lvly_parentAtts['min_height']);