<?php
/* ================================================================================== */
/*      Text Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-title'),
    ),
    'animation_target' => '',
), vc_map_get_attributes($this->getShortcode(),$atts));

list($output)=lvly_item($atts);
    $output .= get_the_title();
$output .= '</div>';
/* ================================================================================== */
echo ($output);
