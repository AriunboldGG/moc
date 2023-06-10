<?php 

    $atts = lvly_get_atts(); 
    $position = get_field('position');
?>
<div>
    <article id="tw-team-<?php the_ID(); ?>">
        <div class="entry-post">
            <div class="tw-team-image"><?php echo lvly_image('tw-team-image'); ?></div>
            <div class="tw-team-content">
                    <?php echo '<a class="tw-team-title" href="'.esc_url(get_permalink()).'">'.get_the_title().'</a>'; ?>
                <div class="tw-team-position"><?php echo $position ?></div>
            </div>
        </div>
    </article>
</div>