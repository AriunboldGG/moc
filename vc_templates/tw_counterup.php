<?php
/* ================================================================================== */
/*      Counter Up Shortcode
/* ================================================================================== */
$atts = array_merge(array(
    'base' => $this->settings['base'],
    'element_atts' =>array(
        'class' => array('tw-element tw-counterup uk-text-center'),
    ),
    'animation_target' => '> div',
), vc_map_get_attributes($this->getShortcode(),$atts));
$atts['element_atts']['data-slctr'][] = 'h1';
$atts['element_atts']['data-sep'][] = ',';
$atts['element_atts']['data-dur'][] = '1000';

$counter_title = $counter_number = '';

if ( ! empty( $atts['counter_data'] ) ) {
    switch ( $atts['counter_data'] ) {
        case 'count_art' : 
            $counter_title = esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'Art':'Уран бүтээл' );
            break;
        case 'count_event' : 
            $counter_title = esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'Entertainment':'Үзвэр үйлчилгээ' );
            break;
        case 'count_physical_cultural_heritage' : 
            $counter_title = esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'Physical cultural heritage':'Соёлын биет өв' );
            break;
        case 'count_intangible_cultural_heritage' : 
            $counter_title = esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'Intangible cultural heritage':'Соёлын биет бус өв' );
            break;
        case 'count_documentary_heritage' : 
            $counter_title = esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'Documentary heritage':'Баримтат өв' );
            break;
        case 'count_actors' : 
            $counter_title = esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'Actors':'Жүжигчид' );
            
            break;
        case 'count_play_performed' : 
            $counter_title = esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'A play performed':'Тоглосон жүжиг' );
            break;
        case 'count_organization' : 
            $counter_title = esc_html( defined( 'ICT_LANG' ) && ICT_LANG === 'en' ? 'Affiliate organization':'Харъяа байгууллага' );
            break;
    }

    if ( $counter_title ) {
        $counter_data = array();
        if ( defined( 'ICT_PORTAL_MAIN' ) ) {
            $tw_get_subsite_urls = tw_get_subsite_urls();

            // Sub Sites Counter Data
            $tw_all_sites_counter_data = array(
                'count_art' => array(
                    'count' => 0,
                    'symbol' =>''
                ),
                'count_event' => array(
                    'count' => 0,
                    'symbol' =>''
                ),
                'count_physical_cultural_heritage' => array(
                    'count' => 0,
                    'symbol' =>''
                ),
                'count_intangible_cultural_heritage' => array(
                    'count' => 0,
                    'symbol' =>''
                ),
                'count_documentary_heritage' => array(
                    'count' => 0,
                    'symbol' =>''
                ),
                'count_actors' => array(
                    'count' => 0,
                    'symbol' =>''
                ),
                'count_play_performed' => array(
                    'count' => 0,
                    'symbol' =>''
                ),
                'count_organization' => array(
                    'count' => !empty( $tw_get_subsite_urls ) ? count( $tw_get_subsite_urls ) : 0,
                    'symbol' =>''
                ),                    
            );

            $tw_cache_created = 0;
            foreach( $tw_get_subsite_urls as $tw_get_subsite_url ) {
                $tw_cache_expire_time = 60 * 60;
                $tw_cache_name        = 'tw_all_sites_counter_data_' . esc_sql( esc_url( $tw_get_subsite_url ) );
                $tw_cache_data        = get_transient( $tw_cache_name );
                $tw_cache_data        = $tw_cache_data && is_array( $tw_cache_data ) ? $tw_cache_data : array();
                $tw_cache_not_expired = get_transient( $tw_cache_name . '_not_expired' );

                $crr_site_counter_data = array();

                if ( $tw_cache_not_expired ) {
                    $crr_site_counter_data = $tw_cache_data;
                } else {
                    if ( $tw_cache_created > 5 ) {
                        $crr_site_counter_data = $tw_cache_data;
                    } else {
                        $tw_cache_created++;

                        $response = wp_remote_get( trailingslashit( $tw_get_subsite_url ) . 'wp-json/ict/v1/counter', array( 'timeout' => 1 ) );

                        if ( ! is_wp_error( $response ) && is_array( $response ) && ! empty( $response['response'] ) && ! empty( $response['response']['code'] ) && intval( $response['response']['code'] ) === 200  ) {
                            if ( ! empty( $response['body'] ) ) {
                                $response_body = json_decode( $response['body'], true );
                                if ( ! empty( $response_body ) && isset( $response_body['result'] ) ) {
                                    $crr_site_counter_data = $response_body['result'];
                                    set_transient( $tw_cache_name                 , $crr_site_counter_data, $tw_cache_expire_time * 100 );
                                    set_transient( $tw_cache_name . '_not_expired', true                  , $tw_cache_expire_time );
                                }
                            }
                        } else {
                            // Set old data, Connection Failed
                            $crr_site_counter_data = $tw_cache_data;
                        }
                    }
                }
                
                // Merge Datas
                foreach( $crr_site_counter_data as $key => $val ) {
                    $cr_data = explode( '|', $val );
                    if ( isset( $tw_all_sites_counter_data[ $key ] ) && ! empty( $cr_data[0] ) && is_numeric( $cr_data[0] ) ) {
                        $tw_all_sites_counter_data[ $key ]['count'] += intval( $cr_data[0] );
                        if ( ! empty( $cr_data[1] ) ) {
                            $tw_all_sites_counter_data[ $key ]['symbol'] = $cr_data[1];
                        }
                    }
                }
            }

            if ( ! empty( $tw_all_sites_counter_data[$atts['counter_data']] ) ) {
                $counter_number = $tw_all_sites_counter_data[$atts['counter_data']]['count'];
                if ( ! empty( $tw_all_sites_counter_data[$atts['counter_data']]['symbol'] ) ) {
                    $atts['element_atts']['data-txt'][] = $tw_all_sites_counter_data[$atts['counter_data']]['symbol'];
                }
            }
        } else {
            $counter_data = explode( '|', lvly_get_option( $atts['counter_data'], '' ) );
            if ( ! empty( $counter_data[0] ) ) {
                $counter_number = intval( $counter_data[0] );
            }
            if ( ! empty( $counter_data[1] ) ) {
                $atts['element_atts']['data-txt'][] = $counter_data[1];
            }
        }
    }
} else {
    if ( ! empty( $atts['counter_number'] ) ){
        $counter_number = $atts['counter_number'];
    }
    if ( ! empty( $atts['counter_title'] ) ) {
        $counter_title  = $atts['counter_title'];
    }
    if ( ! empty( $atts['counter_data_title'] ) ) {
        $atts['element_atts']['data-txt'][] = $atts['counter_data_title'];
    }
}

list( $output ) = lvly_item( $atts );
    $output .= '<div class="tw-counterup-content">';
        if ( $counter_number ) {
            $output .= '<h1>' . esc_html( $counter_number ) . '</h1>';
        }
        if ( $counter_title ) {
            $output .= '<span class="counter-meta">' . esc_html( $counter_title ) . '</span>';
        }
    $output .= '</div>';
$output .= '</div>';

echo ($output);