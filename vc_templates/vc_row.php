<?php
/* ================================================================================== */
/*      Row Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'tag' => 'section',
    'element_atts' =>array(
        'class' => array('tw-row uk-section'),
    ),
    'animation_target' => '.uk-grid>div',
), vc_map_get_attributes($this->getShortcode(),$atts));
foreach ( array ( 'content_width', 'size', 'gutter' ) as $attr_key ) {
    if ( isset( $atts[ $attr_key ] ) ) {
        $atts[ $attr_key ] = str_replace('default','',$atts[ $attr_key ]);
    }
}

global $lvly_parentAtts;
$before = $after = '';
if ( ! empty( $atts['size'] ) ) {
    $atts['element_atts']['class'][] = $atts['size'];
}
if ( ! empty( $atts['bg_toono'] ) ) {
    $atts['element_atts']['class'][] = $atts['bg_toono'];
}
if ( ! empty( $atts['bg_toono_center'] ) ) {
    $atts['element_atts']['class'][] = $atts['bg_toono_center'];
}
if ( ! empty( $atts['use_bg_alhan_hee'] ) ) {
    $atts['element_atts']['class'][] = 'tw-bg-alhan-hee';
}
if ( isset( $atts['content_width'] ) && $atts['content_width'] != 'uk-container-fullwidth' ) {
    $before .= '<div class="uk-container '.esc_attr($atts['content_width']).'">';
    $after  .= '</div>';
}

if (strpos($content,'[tw_block') !== false) {
    $block_content = '';
    $regex = '/\[tw_block(.*?)\](.*?)/';
    $regex_attr = '/(.*?)=\"(.*?)\"/';
    preg_match_all($regex, $content, $matches, PREG_SET_ORDER);
    if (count($matches)) {
        foreach ($matches as $key => $value) {
            if (isset($value[1])) {
                $block_content .= $value[0];
            }
        }
    }
    $output = wpb_js_remove_wpautop( $block_content );
} else {
    if (!empty($lvly_parentAtts['in_section'])) {
        $atts['tag']='div';
    }
    $gridClass='';
    if ( ! empty( $atts['gutter'] ) ) {
        $gridClass .= ' '.$atts['gutter'];
    }
    if ( ! empty( $atts['valign'] ) ) {
        $gridClass .= ' uk-flex uk-flex-middle';
    }
    if ( ! empty( $atts['match_height'] ) ) {
        $gridClass .= ' uk-grid-match';
    }
    list($output)=lvly_item($atts);
        $output .= $before;
            $output .= '<div class="'.esc_attr($gridClass).'" data-uk-grid>'.wpb_js_remove_wpautop( $content ).'</div>';
        $output .= $after;
    $output .= '</'.esc_attr($atts['tag']).'>';
}

/* ================================================================================== */
echo ($output);