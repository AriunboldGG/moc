<?php
/* ================================================================================== */
/*      Accordion Tab Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);

$output = '<li>';
    $output .= '<h3 class="uk-accordion-title">'.esc_html($atts['title']) . '</h3>';
    $output .= '<div class="uk-accordion-content">';
        $output .= ($content===''||$content===' ')?esc_html__( "Empty section. Edit page to add content here.", 'lvly' ):wpb_js_remove_wpautop($content);
    $output .= '</div>';
$output .= '</li>';
    

/* ================================================================================== */
echo ($output);