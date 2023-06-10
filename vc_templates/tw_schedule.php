<?php
/* ================================================================================== */
/*      Schedule Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-schedule'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$tag = !empty($atts['schedule_tag']) ? ($atts['schedule_tag']) : 'h4';

if ($atts['title_animate']) {
    $atts['element_atts']['class'][] = 'tw-text-animate';
}
if ($atts['subtitle_behind'] == true) {
    $atts['element_atts']['class'][] = 'subtitle-behind';
}
$atts['element_atts']['class'][] = $atts['title_align'];
$atts['element_atts']['class'][] = $atts['max_width'];

$atts['google_fonts_field'] = $this->getParamData( 'google_fonts' );
list($output,$font_styles)=lvly_item($atts);

    if ($atts['subtitle_behind'] == true) {
        $output .= '<div class="schedule-container">';
    }
    if (!empty($atts['subtitle'])) {
        $output .= '<h6 class="tw-sub-title">'.($atts['subtitle']).'</h6>';
    }
    if (!empty($atts['title'])) {
        $output .= '<'.esc_attr($tag).(empty($font_styles)?'':(' style="'.esc_attr($font_styles).'"')).' class="schedule-title">'.($atts['title']).'</'.esc_attr($tag).'>';
    }
    if ($atts['subtitle_behind'] == true) {
        $output .= '</div>';
    }
    $output .= wpb_js_remove_wpautop($content, true);
$output .= "</div>";
/* ================================================================================== */
echo ($output);