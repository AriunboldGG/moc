<?php
/* ================================================================================== */
/*      Blog Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' => array(
        'class' => array('tw-element tw-team'),
    ),
    'animation_target' => 'article.post',
), vc_map_get_attributes($this->getShortcode(), $atts));

$layout = $conClass = '';

$query = array(
    'post_type' => 'team',
    'posts_per_page' => '100',
);

$atts['element_atts']['class'][] = $atts['layout'];

$cats = empty($atts['cats']) ? false : explode(",", $atts['cats']);
if ($cats) {
    $query['tax_query'] = array(array(
        'taxonomy' => 'team_cat',
        'terms' => $cats,
        'field' => 'slug',
    ),
    );
}
$title=$atts['title'];
// echo '<p class="tw-team-title">'.$title.'</p>';
echo lvly_item($atts)[0];
    $lvly_query = new WP_Query( $query );
    if ( $lvly_query->have_posts() ) {
            lvly_set_atts( $atts );
            $count_number = 0;
            echo '<div class="uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-small" data-uk-grid>';
            
                while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                    if($atts['layout'] == ''){
                        if($count_number === 3){
                            get_template_part( 'template/loop/team' );
                            
                        }else{
                            get_template_part( 'template/loop/team' );
                        }
                    }else {
                        get_template_part( 'template/loop/team' );
                    }
                   

                }
            echo '</div>';
        wp_reset_postdata();
    }   
echo '</div>';