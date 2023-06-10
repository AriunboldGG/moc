<?php
global $post;
$media=$content=$output='';
$atts = lvly_get_atts();
$image = lvly_image($atts['img_size'], true);
$metas=lvly_metas();
if ( isset( $metas['media'] ) ) {   
    if ($metas['media']=='video'&&$metas['video_embed']) {
        $metas['video_min_height']=100;
        $metas['video_modal']=false;
        $media .= lvly_portfolio_video($metas);
    }elseif (strpos($metas['media'],'gallery')!==false&&$metas['gallery']) {
        $media .= '<div class="owl-carousel onhover owl-theme" data-uk-scrollspy="target: .shop-item; cls:uk-animation-slide-bottom-medium; delay: 300;">';
            $images = explode(',', $metas['gallery']);
                wp_enqueue_script('owl-carousel');
                foreach ($images as $image) {
                    $img = wp_get_attachment_image_src($image,$atts['img_size']);
                    if ($image&&$img) {
                        $desc = get_post_field('post_excerpt', $image);
                        $media .= '<div class="gallery-item"><div class="shop-content"><img src="' . esc_url($img[0]) . '" height="'.$img[1].'" width="'.$img[2].'" ' . ($desc ? ' alt="' . $desc . '"' : '') . ' /></div></div>';
                    }
                }
        $media .= '</div>';
    }
}

if ( ! $media && $image ) {
    $media .= '<img class="promo-image" src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'"/>';
}
$media = '<div data-uk-scrollspy="cls:uk-animation-slide-bottom-medium; delay: 400;"><div class="promo-media-container uk-box-shadow-small uk-light'.($media?'':' no-media').'">'.$media.'</div></div>';
$catsList='';
$portClass='portfolio-item uk-padding-large';
$link = !empty($metas['custom_link']) ? $metas['custom_link'] : get_permalink();
$cats = wp_get_post_terms($post->ID, 'portfolio_cat');
foreach ($cats as $catalog) {
    $portClass .= " category-" . $catalog->slug;
    $catsList .=($catsList?', ':'').'<span>'. $catalog->name.'</span>';
}
$content .= '<div class="uk-flex uk-flex-middle">';
    $content .= '<div class="tw-element promo-text-container full tw-box big-typography" data-uk-scrollspy="target: > *; cls:uk-animation-slide-bottom-medium; delay: 400;">';
        if ( $atts['subtitle_promo'] && ! empty( $metas['sub_title'] ) ) {
            $content .= '<h6 class="tw-sub-title">'.esc_html($metas['sub_title']).'</h6>';
        }
        $content .= '<h1 class="tw-big-title">'.esc_html(get_the_title()).'</h1>';
        ob_start();
            lvly_blogcontent($atts);
        $content .= '<p>'.ob_get_clean().'</p>';
        $content .= '<a href="'.esc_url($link).'" class="uk-button uk-button-silver uk-button-default uk-button-small dark-hover uk-button-radius tw-hover"><span class="tw-hover-inner"><span>'.esc_html__('Read More','lvly').'</span><i class="ion-ios-arrow-thin-right"></i></span></a>';
    $content .= '</div>';
$content .= '</div>';

$output .= $atts['cntr']?'<hr class="uk-margin-large" />':'';

$output .= '<div class="'.esc_attr($portClass).'">';
    $output .= '<div class="uk-container">';
        $output .= '<div class="uk-grid-collapse uk-child-width-1-1 uk-child-width-1-2@m  uk-child-width-1-1@s" data-uk-grid>';
            $output .= ($atts['cntr']%2)?($content.$media):($media.$content);
        $output .= '</div>';
    $output .= '</div>';
$output .= '</div>';

echo ($output);