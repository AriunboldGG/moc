<?php 
/**
 * The template for Single
 *
 * This is the template that displays all Post Singles.
 *
 * @package ThemeWaves
 */

get_header();
the_post();

$sidebar = get_field('sidebar' ); ?>
<section class="uk-section uk-section-blog tw-row tw-row-bg-toono-left">
    <div class="uk-container">
        <div data-uk-grid>
            <div class="content-area uk-width-expand">
                <article <?php post_class('single'); ?>>
                    <div class="entry-post nt-page-title"><?php 
                        echo '<div class="law-page-header">';
                            echo '<h4 class="law-page-title' . ( $sidebar ? ' uk-text-left' : ' uk-text-center' ) . '">';
                                echo get_the_title();
                            echo '</h4>';
                        echo '</div>';
                        echo '<div class="entry-content uk-clearfix">';
                            echo do_shortcode( get_the_content() );
                        echo '</div>'; ?>
                    </div>
                </article>
            </div><?php
                if ( $sidebar && is_active_sidebar( $sidebar )  ) {
                    echo '<div class="sidebar-area uk-width-1-3@m">';
                        echo '<div class="sidebar-inner">';
                            dynamic_sidebar($sidebar);
                        echo '</div>';
                    echo '</div>';
                } ?>
        </div>
    </div>
</section>
<?php get_footer();