<?php $atts = lvly_get_atts(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-post">
        <div class="entry-cats tw-meta"><?php echo lvly_cats(); ?></div>
        <h2 class="entry-title"><?php echo '<a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a>'; ?></h2>
        <div class="entry-date tw-meta">
            <span><?php echo '<a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_time(get_option('date_format'))).'</a>'; ?></span>  /
            <span class="entry-author"><?php esc_html_e('By ', 'lvly').' '; the_author_posts_link(); ?></span>
        </div><?php
        $format = get_post_format() == "" ? "standard" : get_post_format();
        echo lvly_entry_media($format,$atts); ?>
        <div class="entry-content uk-clearfix"><?php
            ob_start();
                lvly_blogcontent($atts);
            $blogcontent = ob_get_clean();
            if (!empty($blogcontent)) {
                echo ($blogcontent);
                if ((!(bool) preg_match('/<!--more(.*?)?-->/', $post->post_content) || !empty($atts['excerpt_count'])) && !empty($atts['more_text'])) {
                    echo '<p class="more-link"><a class="uk-button uk-button-default uk-button-small uk-button-radius tw-hover" href="'.esc_url(get_permalink()).'"><span class="tw-hover-inner"><span>'.esc_html($atts['more_text']).'</span><i class="ion-ios-arrow-thin-right"></i></span></a></p>';
                }
            } ?>
        </div><?php
        do_action( 'waves_entry_share' ); ?>
    </div>
</article>