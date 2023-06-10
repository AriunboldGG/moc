<?php
/* ================================================================================== */
/*      Image Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-schema'),
    ),
    'animation_target' => '> img',
), vc_map_get_attributes($this->getShortcode(),$atts));

$atts['element_atts']['class'][] = $atts['align'];

$img=wp_get_attachment_image_src($atts['image'],'full');

$img_src=isset($img[0])?$img[0]:'';
$img_width=isset($img[1])?$img[1]:'';
$img_height=isset($img[2])?$img[2]:'';

$image=$class=$data=$height=$unit=$attachment_title='';

if ( is_numeric($atts['height']) ){
    $unit = 'px';
}
// var_dump($atts['title']);
// die();
$atts['title'];
if ($img_src) {
    $attachment_title = ' alt="'. get_the_title($atts['image']).'"';
    if ($atts['as_background']==='true') {
        $atts['element_atts']['class'][] = 'uk-background-cover';
        $atts['element_atts']['style'][] = 'background-image: url('.esc_url($img_src).');';
        $atts['element_atts']['style'][] = 'height: '.esc_attr(trim($atts['height']).$unit).';';
    }else{
        // if ($atts['tilt_enable']==='true') {
        //     wp_enqueue_script('codrops-tiltfx');
        //     $data = " data-tilt-options=' ". rawurldecode(lvly_decode(wp_strip_all_tags($atts['tilt_effect']))) ."'";
        //     $class = 'class="tilt-effect"';
        //     $atts['element_atts']['style'][] = 'height: '.esc_attr(trim($atts['height']).$unit).';';
        //     $atts['element_atts']['class'][] = 'tilt-effect';
        // }
        $height = ' style="height: '.( esc_attr(trim($atts['height']).$unit).';' ).'"';
        $image .= '<img '.$attachment_title.$class . $data. $height .' src="' . esc_url($img_src) . '" width="'.esc_attr($img_width).'" height="'.esc_attr($img_height).'" />';
    }
}

list($output)=lvly_item($atts);
    $output .= '<div class="tw-text-box-content">';
        $output .='<h4>' .$atts['title'] .'</h4>';
            $output .= '<div class="schema-container">';
                $output .= $image;
                $output .= '<div class="schema-texts">';
                    $output .= wpb_js_remove_wpautop($content, true);
                $output .= "</div>";
            $output .= "</div>";
    $output .= "</div>";
$output .= "</div>";
/* ================================================================================== */
echo ($output);