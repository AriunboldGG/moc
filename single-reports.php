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

$huuliin_surwalj_output = '';

$sidebar = get_field('page_sidebar', $post->ID );
$sidebar_widget = get_field('sidebar_widget', $post->ID );
$page_size = get_field('page_size', $post->ID );
$page_content_width = get_field('page_content_width', $post->ID );

$reports_type = get_field('reports_type', $post->ID );
$huuliin_togtool = get_field('huuliin_togtool', $post->ID );
$huuliin_image = get_field('huuliin_image', $post->ID );
$huuliin_date = get_field('huuliin_date', $post->ID );
$huuliin_location = get_field('huuliin_location', $post->ID );
$huuliin_dugaar = get_field('huuliin_dugaar', $post->ID );
$huuliin_darga = get_field('huuliin_darga', $post->ID );
$huuliin_darga_name = get_field('huuliin_darga_name', $post->ID );
$huuliin_surwalj = get_field('huuliin_surwalj', $post->ID );
$huuliin_surwalj_url = get_field('huuliin_surwalj_url', $post->ID );
$huuli_pdf = get_field('huuli_pdf', $post->ID );

if ( !empty ( $huuliin_surwalj ) ) {
    $huuliin_surwalj_output .= '<a href="' . esc_url($huuliin_surwalj_url) . '" class="uk-button with-icon reports-btn" target="_blank">';
        $huuliin_surwalj_output .= $huuliin_surwalj;
    $huuliin_surwalj_output .= '</a>';
}

?>
<section class="uk-section uk-section-blog <?php echo $sidebar === 'enable' ? $page_size : ''; ?>">
    <div class="uk-container <?php echo $sidebar === 'enable' ? $page_content_width : ''; ?>">
        <div data-uk-grid>
            <div class="content-area <?php echo $sidebar === 'enable' ? 'uk-width-expand' : 'uk-width-1-1'?>">
                <article <?php post_class('single'); ?>>
                    <div class="entry-post nt-page-title"><?php 
                        if (function_exists('bcn_display')) {
                            echo '<div class="tw-breadcrumb-outer">';
                                echo '<div class="tw-breadcrumb-container  tw-element" typeof="BreadcrumbList" vocab="https://schema.org/">';
                                    bcn_display();
                                echo '</div>';
                            echo '</div>';
                        }
                        echo '<div class="report-page-header uk-text-center">';
                            echo '<h4 class="report-page-title">';
                                echo get_the_title();
                            echo '</h4>';
                            
                            echo $huuliin_surwalj_output;
                        echo '</div>';

                        if  ( $reports_type == 'default' ) {
                            echo '<div class="reports-container uk-text-center">';
                            if ( !empty ( $huuliin_image ) ) {
                                echo '<img class="reports-image" src="' . $huuliin_image . '" alt="' . get_the_title() . '" />';
                            }
                            if ( !empty ( $huuliin_togtool ) ) {
                                echo '<h3 class="reports-title">';
                                    echo $huuliin_togtool;
                                echo '</h3>';
                            }

                            if ( !empty ( $huuliin_date ) ) {
                                echo '<div class="reports-meta uk-flex uk-flex-between">';
                                $dates = explode( ',', $huuliin_date );
                                    echo '<span class="reports-date">';
                                        echo $dates[0] . ' оны ' . $dates[1] . ' дугаар сарын ' . $dates[2] . '-ны өдөр';
                                    echo '</span>';
                                    echo '<span class="reports-location">' . $huuliin_location . '</span>';
                                echo '</div>';
                            }
                            if ( !empty ( $huuliin_dugaar ) ) {
                                echo '<h6 class="reports-number">';
                                    echo $huuliin_dugaar;
                                echo '</h6>';
                            }
                            echo '</div>';
                        } ?>
                        <div class="entry-content uk-clearfix"><?php
                        if ( $reports_type == 'default' ) {
                            the_content();
                            echo '<div class="reports-container-bottom uk-text-center">';
                                if ( !empty ( $huuliin_darga ) ) {
                                    echo '<h3 class="reports-darga">';
                                        echo $huuliin_darga;
                                    echo '</h3>';
                                }
                                if ( !empty ( $huuliin_darga_name ) ) {
                                    echo '<h3 class="reports-darga-name">';
                                        echo $huuliin_darga_name;
                                    echo '</h3>';
                                }
                                
                                echo '</div>';
                        } elseif ( ! empty ( $huuli_pdf ) ) {
                            echo '<div class="reports-container uk-text-center">';
                                echo do_shortcode('[pdf-embedder url="'. $huuli_pdf['url'] .'"]');
                            echo '</div>';
                        }
                       
                        echo '<div class="report-page-footer uk-flex uk-flex-column uk-flex-middle '. ($reports_type == 'default' ? 'margin-top-small' : '') .'">';
 
                            if ( ! empty ( $huuli_pdf ) ) {
                                echo '<a href="' . esc_url( $huuli_pdf['url'] ) . '" class="uk-button with-icon reports-download-btn" download="' . esc_url( $huuli_pdf['url'] ) . '" target="_blank">';
                                    echo '<span class="icon"></span>';
                                    echo '<span class="content">';
                                        echo '<span class="uk-display-block text">';
                                            esc_html_e('Файлаар татаж авах', 'lvly');
                                        echo '</span>';
                                        echo '<span class="uk-display-block size">' . size_format ( $huuli_pdf['filesize'] ) . '</span>';
                                    echo '</span>';
                                echo '</a>';
                            }
                        echo '</div>';
                        ?>
                        </div>
                    </div>
                </article>
            </div>
            <?php
                if ( $sidebar === 'enable' ) {
                    if ( is_active_sidebar( $sidebar_widget )  ) {
                        echo '<div class="sidebar-area">';
                            echo '<div class="sidebar-inner">';
                                dynamic_sidebar($sidebar_widget);
                            echo '</div>';
                        echo '</div>';
                    }
                }
            ?>
        </div>
    </div>
</section>
<?php get_footer();