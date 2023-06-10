<?php
/* ================================================================================== */
/*      Blog Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-reports'),
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
    $reports_types = empty($atts['reports_types']) ? array() : explode(",", $atts['reports_types']);
    if ( empty( $reports_types ) ) {
        $reports_types = get_terms('reports_type');
    }
    foreach ( $reports_types as $reports_type ) {
        $reports_type_details = false;
        if ( is_string( $reports_type ) ) {
            $reports_type_details = get_term_by( 'slug', $reports_type, 'reports_type' );
        } else {
            $reports_type_details = $reports_type;
        }

        if ($reports_type_details) {
            $output .= '<div class="tw-reports-reporttype">';
                
                // $output .= '<h4 class="tw-reports-main-title">' . $reports_type_details->name . '</h4>';
                
                $output .= '<div class="tw-reports-items uk-child-width-1-1 uk-child-width-1-2@l uk-grid-medium" uk-grid>';
                    $query = array(
                        'post_type'      => 'reports',
                        'posts_per_page' => '10',
                        'paged'          => $paged,
                        'tax_query' => Array(Array(
                            'taxonomy' => 'reports_type',
                            'terms' => $reports_type_details->term_id,
                            'field' => 'term_id'
                        ))
                    );

                    $lvly_query = new WP_Query( $query );
                    while ( $lvly_query->have_posts() ) { 
                        $lvly_query->the_post();
                        $output .= '<article class="tw-reports-item">';
                            $output .= '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '">';
                                $output .= '<span class="tw-reports-item-icon"></span>';
                                $output .= '<span class="tw-reports-item-title">'.get_the_title().'</span>';
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
// if ( $atts['pagination'] == "simple" ) {
//     echo '<div class="tw-reports-pagination">';
//         echo report_pagination_simple(array('query'=>$lvly_query));
//     echo '</div>';
// }