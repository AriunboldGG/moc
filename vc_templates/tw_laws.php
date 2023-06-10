<?php
/* ================================================================================== */
/*      Blog Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-laws'),
    ),
    'animation_target' => 'article.post',
    'pagination' => 'simple',
), vc_map_get_attributes($this->getShortcode(),$atts));

/* Pagination */
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} elseif (get_query_var('page')) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}

list( $output )=lvly_item( $atts );
    $laws_types = empty($atts['laws_types']) ? array() : explode(",", $atts['laws_types']);
    if ( empty( $laws_types ) ) {
        $laws_types = get_terms('laws_type');
    }
    foreach ( $laws_types as $laws_type ) {
        $laws_type_details = false;
        if ( is_string( $laws_type ) ) {
            $laws_type_details = get_term_by( 'slug', $laws_type, 'laws_type' );
        } else {
            $laws_type_details = $laws_type;
        }

        if ($laws_type_details) {
            $output .= '<div class="tw-laws-lawtype">';
                
                $output .= '<h4 class="tw-laws-main-title">' . $laws_type_details->name . '</h4>';
                
                $output .= '<div class="tw-laws-items uk-child-width-1-1 uk-child-width-1-2@l uk-grid-medium" uk-grid>';
                    $query = array(
                        'post_type'      => 'laws',
                        'posts_per_page' => '12',
                        'paged'          => $paged,
                        'tax_query' => Array(Array(
                            'taxonomy' => 'laws_type',
                            'terms' => $laws_type_details->term_id,
                            'field' => 'term_id'
                        ))
                    );

                    $lvly_query = new WP_Query( $query );
                    while ( $lvly_query->have_posts() ) { 
                        $lvly_query->the_post();
                        $output .= '<article class="tw-laws-item">';
                            $output .= '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '">';
                                $output .= '<span class="tw-laws-item-icon"></span>';
                                $output .= '<span class="tw-laws-item-title">'.get_the_title().'</span>';
                            $output .= '</a>';
                        $output .= '</article>';
                        
                    }
                    $output .= '</div>';
                    $output .= '</div>';
                    ob_start();
                    law_pagination_simple(array('query'=>$lvly_query));
                $output .= ob_get_clean();
        }
    }
    $output .='</div>';
    
/* ================================================================================== */
echo ( $output );