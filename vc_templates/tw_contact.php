<?php
/* ================================================================================== */
/*      Contact Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);

global $ict_parentAtts;
$output = '';

$img=wp_get_attachment_image_src($atts['image'],'full');
$image=$class=$data=$attachment_title = '';
$img_src=isset($img[0])?$img[0]:'';

list($output)=lvly_item($atts);
    if ($img_src)  {
        $output .= '<div class="tw-contact-container">';
            $attachment_title = ' alt="'. get_the_title($atts['image']).'"';
                $output .= '<div class="image-outside-div">';
                 $output .= '<img '.$attachment_title.' src="' . esc_url($img_src) . '"  />';
                $output .= "</div>";
            $output .= '<p>'.wpb_js_remove_wpautop($content, true). '</p>';
        $output .= "</div>";
    }
$output .= "</div>";
/* ================================================================================== */
echo ($output);