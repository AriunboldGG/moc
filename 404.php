<?php

/**
 * The template for 404 Error Page
 *
 * This is the template that displays 404 Error Page.
 *
 * @package ThemeWaves
 */

$error_page = lvly_get_option( 'page_404' );
$content = '';
if ( ! empty( $error_page ) ) {
    $the_query = new WP_Query( array( 'post_type' => 'page' , 'name' => $error_page ) );
    if ( $the_query->have_posts() ) {
        // The Loop
        while ( $the_query->have_posts() ) { $the_query->the_post();
            $content = get_the_content();
            lvly_set_atts( array( 'page_404_metas' => lvly_metas( get_the_id() ) ) );
        }
        wp_reset_postdata();
    }
}
get_header();
if ( $content ) {
    echo ( do_shortcode( $content ) );
} else { ?>
    <section class="uk-section uk-position-relative uk-text-center uk-flex uk-flex-middle uk-flex-center uk-light page-error">
        <div class="tw-section-overlay uk-overlay-default uk-position-cover uk-background-cover uk-background-center-center"></div>
        <div class="tw-element tw-heading">
            <h4 class="tw-sub-title">
                <?php esc_html_e( 'Page not found.', 'lvly' );?>
            </h4>
            <h2>
                <?php esc_html_e( '404 Error', 'lvly' );?>
            </h2>
            <a href="#" class="uk-button uk-button-default uk-button-small uk-button-radius tw-hover" href="<?php echo esc_url( home_url( '/' ) );?>"><span class="tw-hover-inner"><span><?php esc_html_e( 'Back Home', 'lvly' ); ?></span><i class="ion-ios-arrow-thin-right"></i></span></a>
        </div>
    </section><?php
}
get_footer();