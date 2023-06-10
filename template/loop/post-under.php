<?php $atts = lvly_get_atts(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-under-image'); ?>>
    <div class="entry-post">
        <?php
            $format = get_post_format() == "" ? "standard" : get_post_format();
            echo lvly_entry_media($format,$atts);
            
        if ($atts['category']) { ?>
            <div class="entry-cats tw-meta"><?php echo lvly_cats(); ?></div>
        <?php } ?>
        <h2 class="entry-title">
            <?php echo '<a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a>'; ?>
        </h2>
        <div class="entry-content uk-clearfix"><?php
            if ($atts['under'] == 'btn') {
                lvly_blogcontent($atts);
                if ((!(bool) preg_match('/<!--more(.*?)?-->/', $post->post_content) || !empty($atts['excerpt_count'])) && !empty($atts['more_text'])) {
                    echo '<p class="more-link"><a class="uk-button uk-button-default uk-button-small uk-button-radius tw-hover" href="'.esc_url(get_permalink()).'"><span class="tw-hover-inner"><span>'.esc_html($atts['more_text']).'</span><i class="ion-ios-arrow-thin-right"></i></span></a></p>';
                }
            } else {
                $atts['more_text'] = '';
                lvly_blogcontent($atts);
            } ?>
        </div>
        <?php if ($atts['under'] == 'date') {
                echo '<div class="tw-meta tw-datetime"><a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_time(get_option('date_format'))).'</a></div>';
        } ?>
    </div>
</article>