<?php
$class = '';
if (lvly_get_option('sidebar_affix')) {
    $class = ' sticky-sidebar'; 
    wp_enqueue_script('ResizeSensor');
    wp_enqueue_script('theia-sticky-sidebar');
} ?>
<div class="sidebar-area uk-width-1-3@m<?php echo esc_attr($class);?>">
    <div class="sidebar-inner">
        <?php 
        if ( is_active_sidebar( 'default-sidebar' )  ) {
            dynamic_sidebar('default-sidebar');
        } ?>
    </div>
</div>