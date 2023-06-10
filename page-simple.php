<?php 
/**
 * Template Name: Simple Page Template
 *
 * This is the template that displays Split Page JS and it has some additional options.
 *
 * @package ThemeWaves
 */

get_header();
the_post();

global $post;
$metaboxes = get_fields();
$metaboxes['page_title'] = ! isset( $metaboxes['page_title'] ) ? 'true' : $metaboxes['page_title']; ?>
<section class="tw-row uk-section uk-section-blog tw-row-bg-toono-left">
    <div class="uk-container tw-intro-page">
        <div data-uk-grid>
            <!-- Single Content -->
            <div class="content-area uk-width-expand <?php echo $metaboxes['page_title'] !== 'false' ? '' : 'is-no-title'?>">
                <article <?php post_class('single'); ?>>
                    <?php
                        if ( $metaboxes['page_title'] !== 'false') {
                            echo '<div class="tw-post-single-title">';
                                echo get_the_title();
                            echo '</div>';
                            echo '<div class="tw-post-single-date">';
                                echo '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6663 8.00004C14.6663 11.68 11.6797 14.6667 7.99967 14.6667C4.31967 14.6667 1.33301 11.68 1.33301 8.00004C1.33301 4.32004 4.31967 1.33337 7.99967 1.33337C11.6797 1.33337 14.6663 4.32004 14.6663 8.00004Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4729 10.12L8.40626 8.88671C8.04626 8.67338 7.75293 8.16005 7.75293 7.74005V5.00671" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                echo get_the_time('Y-m-d');
                            echo '</div>';
                        }
                    ?>
                    <div class="entry-post"><?php
                        echo '<div class="gt-single-media">';
                            echo lvly_standard_media( $post, array( 'img_size' => 'full' ) );
                        echo '</div>'; ?>
                        <div class="entry-content uk-clearfix tw-page-simple-content"><?php
                            the_content(); ?>
                        </div>
                    </div>
                </article>
            </div><?php 
            if ( ! empty( $metaboxes['page_sidebar'] ) && is_active_sidebar( $metaboxes['page_sidebar'] ) ) {
                $class = '';
                if ( lvly_get_option('sidebar_affix') ) {
                    $class = ' sticky-sidebar'; 
                    wp_enqueue_script('ResizeSensor');
                    wp_enqueue_script('theia-sticky-sidebar');
                } ?>
                <div class="sidebar-area uk-width-1-3@m<?php echo esc_attr( $class ); ?>">
                    <div class="sidebar-inner"><?php
                        dynamic_sidebar( $metaboxes['page_sidebar'] ); ?>
                    </div>
                </div><?php
            } ?>
        </div>
    </div>
</section><?php
get_footer();