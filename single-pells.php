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

$base_output = '';

$base     = get_field( 'base' );
$base_url = get_field( 'base_url' );
$file_pdf = get_field( 'file_pdf' );

$sidebar = get_field('sidebar' );

if ( ! empty ( $base ) ) {
    $base_output .= '<a href="' . esc_url($base_url) . '" class="uk-button with-icon laws-btn" target="_blank">';
        $base_output .= $base;
    $base_output .= '</a>';
}

?>
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
                            if ( $base_output ) {
                                echo '<div class="uk-text-center">';
                                    echo $base_output;
                                echo '</div>';
                            }
                        echo '</div>';
                        echo '<div class="entry-content uk-clearfix">';
                            echo do_shortcode( get_the_content() );
                        echo '</div>';
                        if ( ! empty( $file_pdf ) && ! empty( $file_pdf['url'] ) ) { ?>
                            <div class="entry-content uk-clearfix"><?php
                                echo '<div class="laws-container uk-text-center">';
                                    echo do_shortcode('[pdf-embedder url="'. $file_pdf['url'] .'"]');
                                echo '</div>';
                           
                                echo '<div class="law-page-footer uk-flex uk-flex-column uk-flex-middle">';
                                    echo '<a href="' . esc_url( $file_pdf['url'] ) . '" class="uk-button with-icon laws-download-btn" download="' . esc_url( $file_pdf['url'] ) . '" target="_blank">';
                                        echo '<span class="icon"></span>';
                                        echo '<span class="content">';
                                            echo '<span class="uk-display-block text">';
                                                esc_html_e('Файлаар татаж авах', 'lvly');
                                            echo '</span>';
                                            // echo '<span class="uk-display-block size">' . size_format ( $file_pdf['filesize'] ) . '</span>';
                                        echo '</span>';
                                    echo '</a>'; 
                                echo '</div>'; ?>
                            </div><?php
                        }

                        if ( $base_output ) {
                            echo '<div class="uk-text-center">';
                                echo $base_output;
                            echo '</div>';
                        } ?>
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