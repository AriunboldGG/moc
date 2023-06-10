<?php
/* ================================================================================== */
/*      Row Inner Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-row-inner'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));
foreach ( array ( 'content_width', 'size', 'gutter' ) as $attr_key ) {
    if ( isset( $atts[ $attr_key ] ) ) {
        $atts[ $attr_key ] = str_replace('default','',$atts[ $attr_key ]);
    }
}
$before = $after = '';
if ( ! empty( $atts['size'] ) ) {
    $atts['element_atts']['class'][] = $atts['size'];
}
if ( isset( $atts['content_width'] ) && $atts['content_width'] != 'uk-container-fullwidth' ) {
    $before .= '<div class="uk-container ' . esc_attr( $atts['content_width'] ) . '">';
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
    $gridClass='';
    if ( ! empty( $atts['gutter'] ) ) {
        $gridClass .= $atts['gutter'];
    }
    if ( ! empty( $atts['match_height'] ) ) {
        $gridClass .= ' uk-grid-match';
    }
    list($output)=lvly_item($atts);
        $output .= $before;
            $output .= '<div class="'.esc_attr($gridClass).'" data-uk-grid>'.wpb_js_remove_wpautop( $content ).'</div>';
        $output .= $after;
    $output .= '</div>';
}

/* ================================================================================== */
echo ($output);