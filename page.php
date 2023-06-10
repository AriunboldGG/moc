<?php

/**
 * The template for Page
 *
 * This is the template that displays all Pages.
 *
 * @package ThemeWaves
 */

get_header();
the_post();

/* Checking Visual Composer Enabled */
$post = get_post();
if ( $post && preg_match( '/vc_row/', $post->post_content ) ) {
    the_content();
}
/* Default Page content goes here */
else { ?>
    <section class="tw-row uk-section uk-section-normal tw-row-bg-toono-left">
        <div class="uk-container">
            <div class="page-title">
                <h1 class="tw-title"><?php the_title(); ?></h1>
            </div>
        </div>
        <div class="uk-container">
            <div class="page-content"><?php
                the_content(); ?>
            </div>
        </div>
    </section><?php
}
get_footer();