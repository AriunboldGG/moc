<?php
/* ================================================================================== */
/*      Tab Shortcode
/* ================================================================================== */
$atts = vc_map_get_attributes($this->getShortcode(),$atts);

$output = '<li>';
    $output .= ($content===''||$content===' ')?esc_html__( "Empty tab. Edit page to add content here.", 'lvly' ):wpb_js_remove_wpautop($content);
$output .= '</li>';
echo ($output);