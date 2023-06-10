<?php
if ( class_exists( 'ReduxFramework' ) ) {
    // Remove dashboard widget
    function lvly_redux_remove_dashboard_widget() {
            remove_meta_box( 'redux_dashboard_widget', 'dashboard', 'side' );
    }
    add_action( 'wp_dashboard_setup', 'lvly_redux_remove_dashboard_widget', 100 );
    // Config
    require_once ( LVLY_FW_PATH . 'options/theme-options.php' );
} else {
    function lvly_default_fonts() {
        $font_url = add_query_arg('family', ('Yantramanav:400,700|Lora:400,400i|Shadows+Into+Light'), "//fonts.googleapis.com/css");
        wp_enqueue_style('lvly-google-font', $font_url, array(), '1.0.0');
    }
    add_action( 'wp_enqueue_scripts', 'lvly_default_fonts', 20);
}