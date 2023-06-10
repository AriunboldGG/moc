<?php
/* ================================================================================== */
/*      Call To Action Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array( 'tw-element tw-call-action uk-flex uk-flex-column' ),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));

$link = array();
if ( ! empty( $atts['link'] ) ) {
    $link = vc_build_link( $atts['link'] );
}

list($output,$font_styles)=lvly_item($atts);
    $output .= '<div class="call-content">';
        $output .= '<h3'.(empty($font_styles)?'':(' style="'.esc_attr($font_styles).'"')).'>'.$atts['callout_title'].'</h3>';
        $output .= !empty($atts['callout_desc']) ? ('<p>'.esc_html($atts['callout_desc']).'</p>') : '';
    $output .= '</div>';

    if ( ! empty( $link['url'] ) && ! empty( $link['title'] ) ) {
        $output .= '<div class="call-button">';
            $output .= '<a href="'.esc_url($link['url']).'"'.( empty( $link['target'] ) ? '' : ( ' target="' . esc_attr( $link['target'] ) . '"' ) ).' title="'.esc_attr($link['title']).'" class="uk-button uk-button-default no-hover">' . esc_html( $link['title'] ) . '</a>';
        $output .= '</div>';
    }
$output .= '</div>';

echo ($output);