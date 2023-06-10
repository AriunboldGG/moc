<?php
/* ================================================================================== */
/*      FlipBox Item Shortcode
/* ================================================================================== */

global $lvly_parentAtts;
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-'.$lvly_parentAtts['flipbox_item'].'-box '),
    ),
    'tag' => 'div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$link = vc_build_link( $lvly_parentAtts['link'] );
$class = $atts['size'];

switch($atts['layout']) {
    case 'top_center':
        $class .= ' uk-text-center ';
    break;
    case 'top_right':
        $class .= ' uk-text-right ';
    break;
    case 'left':
        $class .= ' layout-2 ';
    break;
    case 'right':
        $class .= ' layout-2 right ';
    break;
}

if ($lvly_parentAtts['min_height']) {
    $atts['element_atts']['style'][] = 'min-height: '.esc_attr($lvly_parentAtts['min_height']).'px;';
}
if ( ! empty( $link['url'] ) ) {
    $atts['tag'] = 'a';
    $atts['element_atts']['href'][] = $link['url'];
}
if ( ! empty( $atts['title'] ) ) {
    $atts['element_atts']['title'][] = $atts['title'];
}

list($output)=lvly_item($atts);
    $output .= '<div class="inner tw-box '.esc_attr($class).'">';
        $output .= lvly_icon($atts,true);
        $output .= '<h4'.(empty($lvly_parentAtts['font_styles'])?'':(' style="'.esc_attr($lvly_parentAtts['font_styles']).'"')).'>'.esc_attr($atts['title']).'</h4>';
        if (!empty($content)){
            $output .= '<p class="description">' . do_shortcode($content) . '</p>';
        }
    $output .= "</div>";
$output .= '</'.$atts['tag'].'>';
/* ================================================================================== */
echo ($output);
$lvly_parentAtts['flipbox_item']='back';