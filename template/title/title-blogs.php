<?php 
$lvly_atts=lvly_get_atts();
if (!empty($lvly_atts['post_title'])) { ?>
    <section class="uk-section tw-page-title-bg uk-text-center uk-flex uk-flex-middle uk-flex-center uk-light uk-background-cover uk-background-top-center" data-overlay="0.3">
        <div class="tw-page-title-container tw-element">
            <h1 class="tw-page-title uk-text-uppercase"><?php echo do_shortcode($lvly_atts['post_title']); ?></h1>
            <?php 
                if (is_page() && ($subtitle = lvly_meta('tw-page-title'))) {
                    echo '<p class="page-subtitle">'.esc_html($subtitle).'</div>';
                }
            ?>
        </div>

        <!-- Checking the BreadCrumb NavXT plugin is active -->
        <?php if (function_exists('bcn_display')) {
            echo '<div class="tw-breadcrumb-container uk-position-absolute uk-position-bottom-center tw-element" typeof="BreadcrumbList" vocab="https://schema.org/">';
                bcn_display();
            echo '</div>';
        } ?>
    </section><?php
}