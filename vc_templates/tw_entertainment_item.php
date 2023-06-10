<?php
/* ================================================================================== */
/*      Entertaiment Item Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);

global $ict_parentAtts;
$output = '';
$ict_parentAtts['cnt']++;
$img = wp_get_attachment_image_src( $atts['image'], 'lvly_carousel_3' );

$image=$class=$data=$attachment_title = '';
$img_src=isset($img[0])?$img[0]:'';
$title = $atts['title'];
list($output)=lvly_item($atts);
    $output .= '<h4 class="tw-entertainment-title">';
        $output .= $title ;
    $output .= "</h4>";
    if ($img_src)  {
        $output .= '<div class="tw-entertainment-container">';
            $attachment_title = ' alt="'. get_the_title($atts['image']).'"';
                $output .= '<div class="items">';
                    $output .= '<img '.$attachment_title.' src="' . esc_url($img_src) . '"  />';
                    $output .= '<div>'.wpb_js_remove_wpautop($content, true). '</div>';
                $output .= "</div>";
        $output .= "</div>";
    }
$output .= "</div>";
/* ================================================================================== */
echo ($output);