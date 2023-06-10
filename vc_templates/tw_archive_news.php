<?php
/* ================================================================================== */
/*      Archive news
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' => array(
        'class' => array('tw-element tw-archive-news tw-infinite-container'),
        'data-item-selector'=>array('.news-item'),
    ),
    'animation_target' => 'article.post',
), vc_map_get_attributes($this->getShortcode(), $atts));

$filter_text     = empty( $_REQUEST['filter_text'] )     ? '' : trim( $_REQUEST['filter_text'] );
$filter_cat      = empty( $_REQUEST['filter_cat'] )      ? '' : intval( $_REQUEST['filter_cat'] );
$filter_tag      = empty( $_REQUEST['filter_tag'] )      ? '' : intval( $_REQUEST['filter_tag'] );

list($output)=lvly_item($atts);

    // Get Posts
    $query = array(
        'post_type' => 'post',
        'posts_per_page' => $atts['posts_per_page'],
    );

    // Custom Filter
    if ( !empty( $filter_text ) ) {
        $query['filter_text'] = esc_sql( $filter_text );
    }

    $tax_query = array();
    if ( !empty( $filter_cat ) ) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'terms' => $filter_cat,
            'field' => 'term_id'
        );
    }
    if ( !empty( $filter_tag ) ) {
        $tax_query[] = array(
            'taxonomy' => 'post_tag',
            'terms' => $filter_tag,
            'field' => 'term_id'
        );
    }
    if ( ! empty( $tax_query ) ) {
        $query['tax_query'] = $tax_query;
    }

    // Element Default selected Category
    if ( empty( $filter_text ) && empty( $filter_cat ) && empty( $filter_tag ) && ! empty( $atts['cats'] ) ) {
        $query['tax_query'] = array(array(
            'taxonomy' => 'category',
            'terms'    => explode( ",", $atts['cats'] ),
            'field'    => 'slug',
        ));
    }


    /* Pagination Fix - NOT Overriding WordPress globals */
    $query['paged'] = intval( get_query_var( 'paged' ) ?  get_query_var( 'paged' ) : get_query_var( 'page', 1 ) );

     
    $lvly_query = new WP_Query( $query );
    if ( $lvly_query->have_posts() ) {


        $output .= '<div class="tw-filter-items uk-child-width-1-3@l uk-child-width-1-2@m uk-child-width-1-1@s" data-uk-grid>';
            while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                $output .= '<article class="news-item">';
                    $output .= '<div class="news-item-inner">';
                        $output .= ' <div class="entry-post uk-height-1-1">';
                            $output .= '<div class="blog-post-container">';
                                $output .= '<div class="archive-news-filterthubnail">';
                                    $image = lvly_image( 'lvly_carousel_3', true );
                                    if ( ! empty( $image['url'] ) ) {
                                        $output .= '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( get_the_title() ) . '" style="background-image:url('. esc_url( $image['url'] ) .')">';
                                            $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                        $output .= '</a>';
                                    }
                                $output .= '</div>';
                                $output .= '<div class="-archive-news-filtercontent">';
                                    $output .= '<div class="archive-news-filter uk-flex">';
                                        $output .= '<div class="archive-news-filter-cats uk-flex">';
                                            $output .= lvly_cats('', '# ');
                                        $output .= '</div>';
                                        $output .= '<div class="archive-news-filter-date uk-flex uk-flex-middle">';
                                            $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6663 8.00004C14.6663 11.68 11.6797 14.6667 7.99967 14.6667C4.31967 14.6667 1.33301 11.68 1.33301 8.00004C1.33301 4.32004 4.31967 1.33337 7.99967 1.33337C11.6797 1.33337 14.6663 4.32004 14.6663 8.00004Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4729 10.12L8.40626 8.88671C8.04626 8.67338 7.75293 8.16005 7.75293 7.74005V5.00671" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                            $output .= '<span class="archive-news-filter-time">';
                                                $output .= get_the_time('Y-m-d');
                                            $output .= '</span>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                    $output .= '<h2 class="archive-news-title">';
                                        $output .= '<a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a>';
                                    $output .= '</h2>';
                                $output .= '</div>';
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</article>';
            }
        $output .= '</div>';

        $output .= lvly_pagination( array(
            'query'                => $lvly_query,
            'pagination'           => 'infinite',
            'infinite_auto'        => true,
            'infinite_auto_offset' => 100,
        ),true);

        wp_reset_postdata();
    }
$output .= '</div>';
/* ================================================================================== */
echo ($output);