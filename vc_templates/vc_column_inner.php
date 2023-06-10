<?php
/* ================================================================================== */
/*      Column Inner Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-column-inner'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$atts['element_atts']['class'][]='uk-width-1-1';
switch($atts['width']) {
    case '1/2':
        $atts['element_atts']['class'][]='uk-width-1-2@m';
    break;
    case '1/3':
        $atts['element_atts']['class'][]='uk-width-1-3@m';
    break;
    case '2/3':
        $atts['element_atts']['class'][]='uk-width-2-3@m';
    break;
    case '1/4':
        $atts['element_atts']['class'][]='uk-width-1-4@m';
    break;
    case '3/4':
        $atts['element_atts']['class'][]='uk-width-3-4@m';
    break;
    case '1/6':
        $atts['element_atts']['class'][]='uk-width-1-6@m';
    break;
    case '5/6':
        $atts['element_atts']['class'][]='uk-width-5-6@m';
    break;
    case '5/12':
        $atts['element_atts']['class'][]='uk-width-5-12@m';
    break;
    case '7/12':
        $atts['element_atts']['class'][]='uk-width-7-12@m';
    break;
}

list($output)=lvly_item($atts);
    $output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
/* ================================================================================== */
echo ($output);