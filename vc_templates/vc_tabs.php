<?php
/* ================================================================================== */
/*      Tabs Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-tab'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$ex='';
if (!isset($_POST['customized'])) {wp_enqueue_script('jquery-ui-tabs');}else{$ex='_';}
$atts['tab_id'] = 'tabs-'.substr(md5(microtime()),0,5);
preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();
if (isset($matches[1])) {$tab_titles=$matches[1];}
$klass = !empty($atts['layout']) ? (' '.$atts['layout']) : '';
$tabs_nav = '<ul class="uk-tab'.esc_attr($klass).'" data-uk-tab="connect: #'.esc_attr($atts['tab_id']).';animation: uk-animation-fade;">';
    foreach($tab_titles as $tab) {
        $tab_atts=shortcode_parse_atts($tab[0]);
        $icon = lvly_icon($tab_atts);
        if (isset($tab_atts['title'])) {$tabs_nav .= '<li><a href="#">'.$icon.$tab_atts['title'].'</a></li>';}
    }
$tabs_nav .= '</ul>';

list($output)=lvly_item($atts);

if ($atts['layout'] == 'uk-tab-left' || $atts['layout'] == 'uk-tab-right') {
    $output .= '<div data-uk-grid>';
        $output .= '<div class="uk-width-auto@m">';
            $output .= $tabs_nav;
        $output .= '</div>';
        $output .= '<div class="uk-width-expand@m">';
            $output .= '<ul id="'.esc_attr($atts['tab_id']).'" class="uk-switcher">';
                $output .= wpb_js_remove_wpautop($content);
            $output .= '</ul> ';
        $output .= '</div>';
    $output .= '</div>';
} else {
    $output .= $tabs_nav;
    $output .= '<ul id="'.esc_attr($atts['tab_id']).'" class="uk-switcher">';
        $output .= wpb_js_remove_wpautop($content);
    $output .= '</ul> ';
}    

$output .= '</div> ';

echo ($output);