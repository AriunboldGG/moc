<?php
/* ================================================================================== */
/*      Section Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'tag' => 'section',
    'element_atts' =>array(
        'class' => array('tw-section'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));
global $lvly_parentAtts;
$lvly_parentAtts['in_section']=true;

list($output)=lvly_item($atts);
        $output .= wpb_js_remove_wpautop( $content );
$output .= '</section>';

/* ================================================================================== */
echo ($output);
unset($lvly_parentAtts['in_section']);