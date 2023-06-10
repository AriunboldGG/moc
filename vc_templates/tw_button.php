<?php
/* ================================================================================== */
/*      Button Element + Shortcode
/* ================================================================================== */
$atts=shortcode_atts(array(
    'base' => $this->settings['base'],
    'link' => '',
    'style' => '',
    'hover' => '',
    'size' => 'small',
    'color' => '',
    'margin' => '',
    'animate_icon' => 'true',
    // Font Icon
    'icon' => 'none',
    'eticons' => '',
    'ionicons' => '',
    'fontawesome' => 'fa fa-info-circle',
    'openiconic' => '',
    'typicons' => '',
    'entypo' => '',
    'linecons' => '',
    'pixelicons' => '',
    'fi_image' => '',
    //For Shortcode Atts - Don't use "vc_map_get_attributes( $this->getShortcode(), $atts )"
    'target' => '',
    'icon_class' => '',
), $atts);

$icon = $btnclass = $style = $target = '';
if ( $content ) {
    if ( ! empty( $atts['icon_class'] ) ) {
        $atts['icon_class'] = trim( $atts['icon_class'] );
        switch ( true ) {
            case strpos( $atts['icon_class'], 'et-' ) === 0:
                $atts['icon'] = 'eticons';
                break;
            case strpos( $atts['icon_class'], 'ion-' ) === 0:
                $atts['icon'] = 'ionicons';
                break;
            case strpos( $atts['icon_class'], 'fa' ) === 0:
                $atts['icon'] = 'fontawesome';
                break;
            case strpos( $atts['icon_class'], 'vc-oi' ) === 0:
                $atts['icon'] = 'openiconic';
                break;
            case strpos( $atts['icon_class'], 'typcn' ) === 0:
                $atts['icon'] = 'typicons';
                break;
            case strpos( $atts['icon_class'], 'entypo-icon' ) === 0:
                $atts['icon'] = 'entypo';
                break;
            case strpos( $atts['icon_class'], 'vc_li' ) === 0:
                $atts['icon'] = 'linecons';
                break;
        }
        $atts[$atts['icon']]=$atts['icon_class'];
    }
    $link['url']    = empty( $atts['link'] ) ? '' : $atts['link'];
    $link['title']  = $content;
    $link['target'] = empty( $atts['target'] ) ? '' : $atts['target'];
} else {
    $link = vc_build_link( $atts['link'] );
}
if (!empty( $atts['target'] ) && ($atts['target'] == '_blank')){
    $target = 'target="'.$atts['target'].'"';
}
elseif(!empty( $atts['target'] )){
    $target = 'target="'.$atts['target'].'" data-uk-scroll';
}
$icon=lvly_icon($atts);
$btnclass.= !empty($atts['style']) ? (' uk-button-' . $atts['style']) : '';
$btnclass.= !empty($atts['hover']) ? (' ' . $atts['hover']) : '';
$btnclass.= !empty($atts['size']) ? (' uk-button-' . $atts['size']) : '';
if ( ! empty( $atts['margin'] ) ) {
    $margins = explode( ',', $atts['margin'] );
    foreach($margins as $key => $margin) {
        if (!empty($margin)) {
            if (is_numeric($margin)) {
                $margin.='px';
            }
            if ($key == 0)
                $style.='margin-top:'.$margin.';';
            elseif ($key == 1)
                $style.='margin-right:'.$margin.';';
            elseif ($key == 2)
                $style.='margin-bottom:'.$margin.';';
            elseif ($key == 3)
                $style.='margin-left:'.$margin.';';
        }
    }
}
$footerMailText = lvly_get_option( 'footer_mail_text', esc_html__( 'Шуурхай утас, ФАКС', 'lvly' ) );

// var_dump ($footerMailText); die();
if (!empty($atts['color'])) {
    $style .= (($atts['style'] == 'border' || $atts['style'] == 'border uk-button-radius') ? ('color:' . esc_attr($atts['color']).';border-color:' . esc_attr($atts['color']) . '') : ('')) . '';
    $style .= (($atts['style'] == 'flat' || $atts['style'] == 'flat uk-button-radius') ? ('color: #fff ; border-color:' . esc_attr($atts['color']).';background-color:' . esc_attr($atts['color']) . '') : ('')) . '';
    if ($atts['color']==='#fff'||$atts['color']==='#ffffff'||$atts['color']==='white') {$btnclass.= ' white-button';}
}
if ($atts['animate_icon'] && !empty($icon)) {
    if ( !empty ($footerMailText) ){
        $output='<a href="mailto:'. $footerMailText .'" '.($target).' title="'.esc_attr($link['title']).'" class="uk-button uk-button-default tw-hover'.$btnclass.'" style="'.$style.'"><span class="tw-hover-inner"><span>' . esc_html($link['title']).'</span>'.$icon.'</span></a>';
    }

} else {
    $output='<a href="mailto:name@email.com" '.($target).' title="'.esc_attr($link['title']).'" class="uk-button uk-button-default no-hover'.$btnclass.'" style="'.$style.'">' . esc_html($link['title']).$icon.'</a>';
}
echo ($output);