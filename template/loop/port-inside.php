<?php
$output='';
$portAtts='';
$portClass='portfolio-item';
$atts = lvly_get_atts();
$metas = lvly_metas();
if ($atts['layout']==='metro') {
    $size=(!empty($atts['style_metro'])&&$atts['style_metro']==='small'||empty($metas['size']))? 'small' : $metas['size'];
    $atts['img_size'] = ( ! empty( $atts['disable_crop'] ) || $size == 'full' ) ? 'full' : ( 'lvly_metro_' . $atts['column'] . '_' . $size );
    $portAtts.=' data-size="'.esc_attr($size).'"';
    if ( in_array($size, array('horizontal', 'large'))) {
        $portClass.=' uk-width-1-1';
        if ($atts['column']==='col3') {
           $portClass.=' uk-width-2-3@m';
        }elseif ($atts['column']==='col4') {
           $portClass.=' uk-width-2-3@m uk-width-1-2@l';
        }
    }
}

$image = lvly_image($atts['img_size'], true);
if ($image) {
    global $post;
    $catsList='';
    $cats = wp_get_post_terms($post->ID, 'portfolio_cat');
    foreach ($cats as $catalog) {
        $portClass .= " category-" . $catalog->slug;
        $catsList .=($catsList?', ':'').'<span>'. $catalog->name.'</span>';
    }
    $link = !empty($metas['custom_link']) ? $metas['custom_link'] : get_permalink();
    $output .= '<div class="'.esc_attr($portClass).'"'.$portAtts.'>';
        $output .= '<div class="portfolio-media tw-image-hover '.esc_attr($atts['hover']).'">';
            $output .= '<img src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'" width="'.esc_attr($image['width']).'" height="'.esc_attr($image['height']).'"/>';
            $output .= '<a href="'.esc_url($link).'" class="portfolio-content uk-light">';
                $output .= '<h3 class="portfolio-title"><span>'.esc_html(get_the_title()).'</span></h3>';
                if ($catsList) {$output.='<div class="tw-meta"><span>'.wp_kses_post($catsList).'</span></div>';}
            $output .= '</a>';
        $output .= '</div>';
    $output .= '</div>';
}
echo ($output);