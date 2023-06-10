<?php $atts = lvly_get_atts();
$class = $postAtts = '';
if (!empty($atts['inside'])) {
    $class = ' blog-inside-2';
}


if ( ! empty( $atts['excerpt_count'] ) ) {
    $class .= ' blog-inside-hover';
} elseif ( is_page_template( 'page-magazinepage.php' ) ) {
    $class .= ' blog-inside-hover blog-inside-noexcerpt';
}

if ( $atts['layout'] == 'metro' ) {
    $metas = lvly_metas();
    $size  = empty( $metas['size'] ) ? 'small' : $metas['size'];
    $postAtts .= ' data-size="' . esc_attr( $size ) . '"';
    if ( in_array( $size, array('horizontal', 'large') ) ) {
        $class .= ' uk-width-1-1';
        if ( $atts['column'] == 'col3' ) {
           $class .= ' uk-width-2-3@m';
        } elseif ( $atts['column'] == 'col4' ) {
           $class .= ' uk-width-2-3@m uk-width-1-2@l';
        }
    } elseif ( $size == 'full' ) {
        $class .= ' uk-width-1-1';
    }
    $atts['img_size'] = ( ! empty( $atts['disable_crop'] ) || $size == 'full' ) ? 'full' : ( 'lvly_metro_' . $atts['column'] . '_' . $size );
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'uk-light blog-inside-image' . $class ); echo ( $postAtts ); ?>>
    <div class="article-inner"><?php
        $format = get_post_format() == "" ? "standard" : get_post_format();
        if ( in_array( $format, array( 'status', 'quote' ) ) ) {
            echo lvly_entry_media( $format, $atts, true );
        } else { ?>
            <div class="entry-media">
                <div class="tw-thumbnail abs-thumb"><?php 
                    $image = lvly_image($atts['img_size'], true);
                    if (!empty($image['url'])) {
                        if ( $atts['layout'] != 'metro' ) {
                            echo '<img src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'" />';
                        }
                        echo '<div class="tw-bgthumb" style="background-image: url('.esc_url($image['url']).');"></div>';
                        echo '<div class="image-overlay"></div>';
                    } ?>
                </div>
            </div>
            <div class="entry-post">
                <?php if (empty($atts['inside'])) { ?>
                    <div class="entry-cats tw-meta"><?php echo lvly_cats(); ?></div>
                <?php } else { ?>
                    <div class="tw-meta entry-date">
                        <?php echo '<a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_time(get_option('date_format'))).'</a>'; ?>
                    </div>
                <?php } ?>
                <h2 class="entry-title">
                    <?php echo '<a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a>'; ?>
                </h2>
                <div class="entry-content uk-clearfix"><?php
                    if (!empty($atts['inside'])) {
                        if (!empty($atts['excerpt_count'])) {
                            lvly_blogcontent($atts);
                        }
                        if ((!(bool) preg_match('/<!--more(.*?)?-->/', $post->post_content) || !empty($atts['excerpt_count'])) && !empty($atts['more_text'])) {
                            echo '<p class="more-link"><a class="uk-button uk-button-default uk-button-small uk-button-radius light-hover tw-hover" href="'.esc_url(get_permalink()).'"><span class="tw-hover-inner"><span>'.esc_html($atts['more_text']).'</span><i class="ion-ios-arrow-thin-right"></i></span></a></p>';
                        }
                    } elseif (!empty($atts['excerpt_count'])) {
                        $atts['more_text'] = '';
                        lvly_blogcontent($atts);
                    } ?>
                </div><?php
                if (empty($atts['inside'])) {
                    echo '<div class="tw-meta tw-datetime"><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_time(get_option('date_format'))).'</a></div>';
                } ?>
            </div><?php
        } ?>
    </div>
</article>