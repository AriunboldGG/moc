<?php

/**
 * The template for Comments
 *
 * This is the template that displays Comment sections.
 *
 * @package ThemeWaves
 */

get_header();
the_post();
the_content();
wp_link_pages();
get_footer();