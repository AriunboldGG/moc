<?php
/* ================================================================================== */
/*      Partner Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-partners-iconbox'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$col = $atts['column'];

global $ict_parentAtts;
$ict_parentAtts['cnt'] = 0;
list($output)=lvly_item($atts);
    $output .=   '<div class="uk-child-width-1-6@m uk-grid-small '.$col.'" data-uk-grid>';
        $output .= wpb_js_remove_wpautop($content);
    $output .= "</div>";
/* ================================================================================== */
echo ($output);
unset($ict_parentAtts['cnt']);