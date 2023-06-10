<?php
/* ================================================================================== */
/*      Accordion Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-accordion-job'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$collapsible = $atts['collapsible'] == 'yes' ? 'false' : 'true';
$multiple = $atts['multiple'] == 'yes' ? 'true' : 'false';
$active = !empty($atts['active_tab']) ? ('active: ' . intval($atts['active_tab'] - 1)) : '';

$lvly_parentAtts['active_tab'] = $atts['active_tab'];

// $atts['element_atts']['class'][] = $atts['style'];

list($output)=lvly_item($atts);
    $output .= '<ul data-uk-accordion="collapsible: '.esc_attr($collapsible).';multiple: '.esc_attr($multiple).';'.esc_attr($active).'" class="uk-accordion">';
        $output .= wpb_js_remove_wpautop( $content );
    $output .= '</ul>';
$output .= "</div>";
/* ================================================================================== */
echo ($output);