<?php
$output='';
$atts = lvly_get_atts();
$image = lvly_image($atts['img_size'], true);
if ($image) {
    global $post;
    $metas=array_merge(array(
        'parallax'  => 'bgy: -200',
        'overlay' => '0.5',
        'bg_color' => '#151515'
    ),lvly_metas());
    $catsList='';
    $portClass='portfolio-item uk-flex uk-flex-middle uk-flex-center';
    $cats = wp_get_post_terms($post->ID, 'portfolio_cat');
    foreach ($cats as $catalog) {
        $portClass .= " category-" . $catalog->slug;
        $catsList .=($catsList?', ':'').'<span>'. $catalog->name.'</span>';
    }
    $link = !empty($metas['custom_link']) ? $metas['custom_link'] : get_permalink();
    $output .= '<div class="'.esc_attr($portClass).'" data-uk-parallax="'.esc_attr($metas['parallax']).'" data-overlay="'.esc_attr($metas['overlay']).'" style="background-color:'.esc_attr($metas['bg_color']).'; background-image: url('.esc_url($image['url']).'); ">';
        $output .= '<div class="tw-element full tw-heading custom-typography" data-uk-parallax="opacity: 0,1; y: 100,0; viewport: 0.5" data-uk-scrollspy="target: > *; cls:uk-animation-slide-bottom-medium; delay: 400;">';
            $output .= '<h6 class="tw-sub-title">'.get_the_time(get_option('date_format'), $post->ID).'</h6>';
            $output .= '<h1 class="tw-big-title">'.esc_html(get_the_title()).'</h1>';
            $output .= '<a href="'.esc_url($link).'" class="uk-button uk-button-default uk-button-small light-hover uk-button-radius tw-hover"><span class="tw-hover-inner"><span>'.esc_html__('View Project','lvly').'</span><i class="ion-ios-arrow-thin-right"></i></span></a>';
        $output .= '</div>';
    $output .= '</div>';
}
echo ($output);