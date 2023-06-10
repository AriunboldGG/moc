<?php $atts = lvly_get_atts(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-post">
        <div class="entry-cats tw-meta"><?php echo lvly_cats(); ?></div>
        <h2 class="entry-title">
            <?php echo '<a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a>'; ?>
        </h2>
        <div class="entry-content uk-clearfix">
            <?php lvly_blogcontent($atts); ?>
        </div>
        <div class="tw-meta entry-date">
            <?php echo '<a href="'.esc_url(get_permalink()).'">'.esc_attr(get_the_time(get_option('date_format'))).'</a>'; ?>
        </div>
    </div>
</article>