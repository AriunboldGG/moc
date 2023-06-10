<?php
$output='';
$atts = lvly_get_atts();
$image = lvly_image($atts['img_size'], true);
if ($image) {
    global $post;
    $portClass='portfolio-item';        
    $cats = wp_get_post_terms($post->ID, 'portfolio_cat');
    foreach ($cats as $catalog) {
        $portClass .= " category-" . $catalog->slug;
    }
    $metas = lvly_metas();
    $link = !empty($metas['custom_link']) ? $metas['custom_link'] : get_permalink();
    $output = '<div class="'.esc_attr($portClass).'">';
        $output .= '<div class="portfolio-media">';
            $output .= '<a href="'.esc_url($link).'"'.($atts['hover_under']?' class="tw-image-hover"':'').'>';
                $output .= '<img src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'" width="'.esc_attr($image['width']).'" height="'.esc_attr($image['height']).'"/>';
            $output .= '</a>';
        $output .= '</div>';
        $output .= '<div class="portfolio-content">';
            $output .= '<h3 class="portfolio-title"><a href="'.esc_url($link).'" title="'.esc_attr(get_the_title()).'">';
                $output .= esc_html(get_the_title());
                if ($atts['subtitle_under']&&$metas['sub_title']) {
                    $output .= '<span class="uk-label">'.esc_html($metas['sub_title']).'</span>';
                }
            $output .= '</a></h3>';
            if ($atts['category_under']) {
                $catsList = get_the_term_list( $post->ID, 'portfolio_cat', '', '. ', '' );
                if ($catsList) {$output.='<span class="tw-meta"><span>'.wp_kses_post($catsList).'</span></span>';}
            }
        $output .= '</div>';
    $output .= '</div>';
}
echo ($output);