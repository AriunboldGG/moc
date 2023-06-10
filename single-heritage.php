<?php 
/**
 * The template for Single
 *
 * This is the template that displays all Post Singles.
 *
 * @package ThemeWaves
 */
global $tw_post__not_in, $post;
get_header();
the_post();
if ( empty( $tw_post__not_in ) ) {
    $tw_post__not_in = array();
}

$tw_post__not_in[] = get_the_ID();

$format = get_post_format() == "" ? "standard" : get_post_format();

$metaboxes = get_fields();
// $single_layout = !empty($metaboxes['single_layout']) ? $metaboxes['single_layout'] : lvly_get_option('single_layout');
$single_layout = lvly_get_option('single_layout');?>
<section class="tw-row uk-section uk-section-blog tw-row-bg-toono-left">
    <div class="uk-container uk-container-small">
        <div class="<?php echo esc_attr($single_layout); ?>" data-uk-grid>
            <!-- Single Content -->
            <div class="content-area uk-width-expand">
                <article <?php post_class('single'); ?>>
                    <div class="tw-post-single-title"><?php
                        echo get_the_title(); ?>
                    </div>
                    <div class="tw-post-single-date">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6663 8.00004C14.6663 11.68 11.6797 14.6667 7.99967 14.6667C4.31967 14.6667 1.33301 11.68 1.33301 8.00004C1.33301 4.32004 4.31967 1.33337 7.99967 1.33337C11.6797 1.33337 14.6663 4.32004 14.6663 8.00004Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4729 10.12L8.40626 8.88671C8.04626 8.67338 7.75293 8.16005 7.75293 7.74005V5.00671" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php
                        echo get_the_time('Y-m-d'); ?>
                    </div>
                    <div class="entry-post"><?php
                        if( $lvly_standard_media = lvly_standard_media( $post, array('img_size'=>'full') ) ) {
                            echo '<div class="gt-single-media">';
                                echo $lvly_standard_media;
                            echo '</div>';
                        } ?>
                        <div class="entry-content uk-clearfix"><?php
                            the_content(); ?>
                        </div>
                    </div><?php
                    $cats = '';
                    $heritage_cats = wp_get_post_terms( $post->ID, 'heritage_cat' );

                    foreach( $heritage_cats as $category) {
                        $cats .= '<div class="cat-item"><span>' . $category->name . '</span></div>';
                    }

                    if ( $cats ) {
                        echo '<div class="entry-post-cats"><span># Сэдвүүд</span>'.  $cats .'</div>';
                    } ?>
                </article>
            </div>
        </div>
    </div>
</section><?php
get_footer();