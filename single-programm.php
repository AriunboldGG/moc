<?php 
/**
 * The template for Single
 *
 * This is the template that displays all Post Singles.
 *
 * @package ThemeWaves
 */
global $tw_post__not_in;
get_header();
the_post();

if ( empty( $tw_post__not_in ) ) {
    $tw_post__not_in = array();
}

$tw_post__not_in[] = get_the_ID();

$format = get_post_format() == "" ? "standard" : get_post_format();

$metaboxes = get_fields();
$media_layout = !empty($metaboxes['single_media']) ? $metaboxes['single_media'] : lvly_get_option('single_media', 'small');
$position = get_field('position');
// $atts = lvly_get_atts(); 
// var_dump( $position );
// die();
$single_layout = lvly_get_option('single_layout');?>
<section class="tw-row uk-section uk-section-blog tw-row-bg-toono-left">
    <div class="uk-container">
        <div class="<?php echo esc_attr($single_layout); ?>" data-uk-grid>
            <!-- Single Content -->
            <div class="content-area uk-width-expand">
                <article <?php post_class('single'); ?>>
                    <div class="tw-post-single-title"><?php
                        echo get_the_title(); ?>
                    </div>
                    <?php
                    echo $position ; ?>
                    <!-- <div class="tw-post-single-date">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6663 8.00004C14.6663 11.68 11.6797 14.6667 7.99967 14.6667C4.31967 14.6667 1.33301 11.68 1.33301 8.00004C1.33301 4.32004 4.31967 1.33337 7.99967 1.33337C11.6797 1.33337 14.6663 4.32004 14.6663 8.00004Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4729 10.12L8.40626 8.88671C8.04626 8.67338 7.75293 8.16005 7.75293 7.74005V5.00671" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php
                        echo get_the_time('Y-m-d'); ?>
                    </div> -->
                    <div class="entry-post"><?php
                        if (!empty( $metaboxes['thumb_yesno']) && $metaboxes['thumb_yesno'] == ' true ') { 
                            echo '<div class="gt-single-media">';
                                $atts['img_size'] = 'full';
                                echo lvly_entry_media($format, $atts, true);
                            echo '</div>';
                        } ?>
                        <div class="entry-content uk-clearfix"><?php
                            the_content(); ?>
                        </div><?php 
                        wp_link_pages();
                        if (lvly_get_option('single_tags')) {
                            echo get_the_tag_list(('<div class="entry-tags tw-meta"><h5>'.esc_html__('# ', 'lvly').'Сэдвүүд</h5>'), '', '</div>');
                        } ?>
                    </div>
                </article>
            </div>
            <!-- Single Sidebar --><?php 
            if ( $single_layout != 'fullwidth-content' && $single_layout != 'narrow-content' ) {
                get_sidebar();
            } ?>
        </div>
    </div><?php
    if ( !empty( $metaboxes['show_related_posts'] ) ) {
        $query = array(
            'post_type'      => 'post',
            'posts_per_page' => $metaboxes['related_posts_per_page'],
            'post__not_in'   => $tw_post__not_in,
            'no_found_rows'  => true,
        );

        $cats = wp_get_post_categories( get_the_ID(), array( 'fields' => 'ids' ) );
        if ( ! empty( $cats ) ) {
            $query['tax_query'] = Array(Array(
                    'taxonomy' => 'category',
                    'terms' => $cats,
                    'field' => 'term_id'
                )
            );
        }
        
        $lvly_query = new WP_Query( $query );
        if ( $lvly_query->have_posts() ) { ?>
            <div class="uk-container tw-related-posts">
                <div data-uk-grid data-uk-slider="autoplay: false; finite: true;">
                    <div class="tw-slider-navigation-container">
                        <h3 class="tw-title"><?php esc_html_e( 'Холбоотой Мэдээлэл', 'lvly' ); ?></h3>
                        <div class="tw-slider-navigation">
                            <a href="#" uk-slider-item="previous"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 12L4.95333 7.95333L9 3.90667" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                            <a href="#" uk-slider-item="next"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 3.95312L11.0467 7.99979L7 12.0465" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                        </div>
                    </div>


                    <div class="uk-slider-container">
                        <ul class="uk-slider-items uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s uk-grid"><?php
                            while ( $lvly_query->have_posts() ) { $lvly_query->the_post(); ?>
                                <li>
                                    <div class="tw-related-posts-item"><?php
                                        $image = lvly_image( 'lvly_carousel_3', true );
                                        if ( ! empty($image['url'] ) ) {
                                            echo '<div class="tw-item-image">';
                                                echo '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                            echo '</div>';
                                        }
                                        echo '<div class="tw-bottom">';
                                            echo '<div class="tw-meta">';
                                                echo '<div class="entry-cats tw-meta">';
                                                    echo lvly_cats( '', '# ' );
                                                echo '</div>';
                                                echo '<div class="tw-meta entry-date">';
                                                    echo '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6667 8.00016C14.6667 11.6802 11.68 14.6668 8.00001 14.6668C4.32001 14.6668 1.33334 11.6802 1.33334 8.00016C1.33334 4.32016 4.32001 1.3335 8.00001 1.3335C11.68 1.3335 14.6667 4.32016 14.6667 8.00016Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4733 10.1202L8.40666 8.88684C8.04666 8.6735 7.75333 8.16017 7.75333 7.74017V5.00684" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                                    echo '<a href="' . esc_url( get_permalink() ) .'">' . esc_attr( get_the_time( get_option( 'date_format' ) ) ) . '</a>';
                                                echo '</div>';
                                            echo '</div>';
                                            echo '<h4 class="tw-item-title">';
                                                echo '<a href="' . esc_url( get_permalink() ) .'">';
                                                    echo get_the_title();
                                                echo '</a>';
                                            echo '</h4>';
                                        echo '</div>'; ?>
                                    </div>
                                </li><?php
                            } ?>
                        </ul>
                    </div>
                </div>
            </div><?php
        }
    } ?>
</section><?php 
/* Footer Content */
if ( ! empty( $metaboxes['post_footer_content'] ) && ! empty( $metaboxes['post_footer_content'] -> post_content ) ) {
    echo do_shortcode( $metaboxes['post_footer_content'] -> post_content );
}

get_footer();