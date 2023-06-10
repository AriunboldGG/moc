<?php

/**
 * The template for Search Result
 *
 * This is the template that displays Your Searched query Result.
 *
 * @package ThemeWaves
 */

get_header();
    lvly_set_options(array(
        'pagination'    => '',
        'img_size'      => 'lvly_thumb',
        'excerpt_count' => 2,
        'footer_layout' => '',
    ));
    $atts = array(
        'img_size'      => 'lvly_thumb',
        'more_text'     => lvly_get_option( 'more_text', esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'More':'Дэлгэрэнгүй' ) ),
        'excerpt_count' => lvly_get_option( 'blog_excerpt' ),
        'pagination'    => lvly_get_option( 'blog_pagination', 'normal' ),
        'sidebar'       => lvly_get_option( 'blog_sidebar', 'right-sidebar' ),
    );
    $blog_layout = ( ! empty( $atts['sidebar'] ) && $atts['sidebar'] != 'none' ) ? $atts['sidebar'] : '';
    lvly_set_atts( $atts );
    echo '<section class="uk-section uk-section-blog tw-search">';
        echo '<div class="uk-container tw-search-inner">';
            echo '<div class="' . esc_attr( $blog_layout ) . '" data-uk-grid>';
                echo '<div class="content-area uk-clearfix uk-width-expand@m">';
                if ( have_posts() ) {
                    echo '<div class="tw-blog uk-grid-column-small uk-grid-row-large uk-child-width-1-3@s uk-text-center" data-uk-grid>';
                        while ( have_posts() ) { the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                                <div class="entry-post-search">

                                    <?php
                                    $format = get_post_format() == "" ? "standard" : get_post_format();?>
                                    
                                    <div class="search-top">
                                            <div class="search-thumb">
                                                <?php echo lvly_standard_media($post, $atts);?>
                                            </div>
                                            <div class="search-title-date">
                                                <h2 class="entry-title-search"><?php echo get_the_title(); ?></h2>
                                                <div class="entry-date-search tw-meta">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6663 8.00004C14.6663 11.68 11.6797 14.6667 7.99967 14.6667C4.31967 14.6667 1.33301 11.68 1.33301 8.00004C1.33301 4.32004 4.31967 1.33337 7.99967 1.33337C11.6797 1.33337 14.6663 4.32004 14.6663 8.00004Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4729 10.12L8.40626 8.88671C8.04626 8.67338 7.75293 8.16005 7.75293 7.74005V5.00671" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><?php
                                                    echo get_the_time('Y-m-d'); ?>
                                                </div>

                                                
                                            </div>
                                    </div>

                                    <div class="entry-content-search uk-clearfix">
                                        <?php
                                        //More button
                                        if ((!(bool) preg_match('/<!--more(.*?)?-->/', $post->post_content) || !empty($atts['excerpt_count'])) && !empty($atts['more_text'])) {
                                            echo '<p class="more-link"><a class="uk-button uk-button-default uk-button-small uk-button-radius tw-hover" href="'.esc_url(get_permalink()).'"><span class="tw-hover-inner"><span>'.esc_html($atts['more_text']).'</span><i class="ion-ios-arrow-thin-right"></i></span></a></p>';
                                        
                                        } 
                                        ?>
                                        
                                        
                                    </div>
                                   
                                    
                                    
                                </div>
                                
                            </article> 
                            
                       <?php }
                    echo '</div>';
                    if ( $atts['pagination'] ) {
                        lvly_pagination( $atts );
                    }
                } else { ?>
                    <h3 class="uk-margin-bottom"><?php esc_html_e("Уучлаарай таны хайсан илэрц олдсонгүй.", 'lvly'); ?></h3>
                    <div class="uk-margin-bottom">
                        <!-- <?php get_search_form(); ?> -->
                    </div>
                    <p><?php esc_html_e("Хайлтыг оновчтой болгохын тулд дараах зүйлсийг нягтлаарай:", 'lvly');?></p>
                    <ul>
                        <li><?php esc_html_e("Үг үсгийн алдаа.", 'lvly');?></li>
                        <li><?php esc_html_e("Цөөн үгээр хайх.", 'lvly');?></li>
                    </ul><?php
                }
                echo '</div>';
                if ( $blog_layout ) {
                    get_sidebar();
                }
            echo '</div>';
        echo '</div>';
    echo '</section>';
get_footer();