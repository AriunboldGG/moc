<?php
if ( ! function_exists( 'ict_rest_sanitize_text' ) ) {
    function ict_rest_sanitize_text($value, $request, $param) {
        $value = trim( esc_sql( $value ) );
        return $value;
    }
}
// Other
add_action( 'rest_api_init', 'ict_rest_api_init' );
if ( ! function_exists( 'ict_rest_api_init' ) ) {
    function ict_rest_api_init() {
        if ( defined( 'ICT_PORTAL_MAIN' ) ) {
            register_rest_route( 'ict/v1', '/menu/(?P<name>[a-zA-Z0-9-]+)', array(
                'methods'  => 'GET',
                'callback' => 'ict_rest_ep_menu',
                'args'     => array(
                    'name' => array(
                        'type'              => 'string',
                        'sanitize_callback' => 'ict_rest_sanitize_text',
                    ),
                ),
            ));
            register_rest_route( 'ict/v1', '/menu-name/(?P<name>[a-zA-Z0-9-]+)', array(
                'methods'  => 'GET',
                'callback' => 'ict_rest_ep_menu_name',
                'args'     => array(
                    'name' => array(
                        'type'              => 'string',
                        'sanitize_callback' => 'ict_rest_sanitize_text',
                    ),
                ),
            ));

        } else {
            register_rest_route( 'ict/v1', '/events', array(
                'methods'  => 'GET',
                'callback' => 'ict_rest_ep_events',
                // 'args'     => array(
                //     'name' => array(
                //         'type'              => 'string',
                //         'sanitize_callback' => 'ict_rest_sanitize_text',
                //     ),
                // ),
            ));
            register_rest_route( 'ict/v1', '/counter', array(
                'methods'  => 'GET',
                'callback' => 'ict_rest_ep_counter',
                // 'args'     => array(
                //     'name' => array(
                //         'type'              => 'string',
                //         'sanitize_callback' => 'ict_rest_sanitize_text',
                //     ),
                // ),
            ));
        }
    }

    
}

/** Post */
class ICTRestPost {
    public $target_endpoints = '';
    function __construct() {
        $this->target_endpoints = array( 'post' );
        add_action( 'rest_api_init', array( $this, 'add_post_images' ));
        add_action( 'rest_api_init', array( $this, 'add_post_cats' ));
        add_action( 'rest_api_init', array( $this, 'add_post_tags' ));
        add_action( 'rest_api_init', array( $this, 'add_post_featured' ));
    }

    // Images
    function add_post_images() {
        register_rest_field( $this->target_endpoints, 'images', array(
                'get_callback'    => array( $this, 'get_images'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }
    function get_images( $object ) {
        $images = array();
        
        ///
        $image_sizes = array(
            'lvly_news_tab',
            'lvly_news_carousel',
            'lvly_carousel_3',
        );
        foreach( $image_sizes as $image_size ) {
            $image = lvly_image( $image_size, true );
            if( ! empty( $image ) ) {
                $images[ $image_size ] = $image;
            }
        }
        ///

        return $images; 
    }

    // Categories
    function add_post_cats() {
        register_rest_field( $this->target_endpoints, 'cats', array(
                'get_callback'    => array( $this, 'get_cats'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }
    function get_cats( $object ) {
        $cats = array();
        
        if ( $pCats = get_the_category( $object['id']) ) {
            foreach( $pCats as $pCat ) {
                $cats[] = array(
                    'id'   => $pCat->term_id,
                    'name' => $pCat->name,
                );
            }
        }

        return $cats; 
    }

    // Tags
    function add_post_tags() {
        register_rest_field( $this->target_endpoints, 'tags', array(
                'get_callback'    => array( $this, 'get_tags'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }
    function get_tags( $object ) {
        $tags = array();
        
        if ( $pTags = get_the_tags( $object['id']) ) {
            foreach( $pTags as $pTag ) {
                $tags[] = array(
                    'id'   => $pTag->term_id,
                    'name' => $pTag->name,
                );
            }
        }

        return $tags; 
    }

    // Featured
    function add_post_featured() {
        register_rest_field( $this->target_endpoints, 'featured', array(
                'get_callback'    => array( $this, 'get_featured'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }
    function get_featured( $object ) {
        return get_field( 'featured_post', $object['id'] );
    }
}
new ICTRestPost;



/** Exhibits */
class ICTRestExhibits {
    public $target_endpoints = '';
    function __construct() {
        $this->target_endpoints = array( 'exhibits' );
        add_action( 'rest_api_init', array( $this, 'add_post_images' ));
        add_action( 'rest_api_init', array( $this, 'add_post_cats' ));
    }

    // Images
    function add_post_images() {
        register_rest_field( $this->target_endpoints, 'images', array(
                'get_callback'    => array( $this, 'get_images'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }
    function get_images( $object ) {
        $images = array();
        
        ///
        $image_sizes = array(
            'lvly_carousel_3',
        );
        foreach( $image_sizes as $image_size ) {
            $image = lvly_image( $image_size, true );
            if( ! empty( $image ) ) {
                $images[ $image_size ] = $image;
            }
        }
        ///

        return $images; 
    }

    // Exhibits Categories
    function add_post_cats() {
        register_rest_field( $this->target_endpoints, 'cats', array(
                'get_callback'    => array( $this, 'get_cats'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }
    function get_cats( $object ) {
        $cats = array();
        
        if ( $term_post_cats = get_terms('exhibits_cat') ) {
            foreach ( $term_post_cats as $term_post_cat ) {
                $cats[] = array(
                    'id'   => intval( $term_post_cat -> term_id ),
                    'name' => esc_html( $term_post_cat -> name ) 
                );
            }
        }

        return $cats;
    }
}
new ICTRestExhibits;




/** Current Time */
class ICTRestEvent {
    public $target_endpoints = '';
    function __construct() {
        $this->target_endpoints = array( 'event' );
        add_action( 'rest_api_init', array( $this, 'add_event_fields' ));
    }
    function add_event_fields() {
        register_rest_field( $this->target_endpoints, 'thumbs', array(
                'get_callback'    => array( $this, 'thumbs'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
        register_rest_field( $this->target_endpoints, 'custom_event_link', array(
                'get_callback'    => array( $this, 'custom_event_link'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
        register_rest_field( $this->target_endpoints, 'event_price', array(
                'get_callback'    => array( $this, 'event_price'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
        register_rest_field( $this->target_endpoints, 'location_name', array(
                'get_callback'    => array( $this, 'location_name'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
        register_rest_field( $this->target_endpoints, 'event_start', array(
                'get_callback'    => array( $this, 'event_start'),
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }

    function thumbs( $object ) {
        $thumbs = array();
        $image = lvly_image( 'lvly_carousel_3', true );

        if ( ! empty( $image['url'] ) ) {
            $thumbs['lvly_carousel_3'] = array(
                'url' => empty( $image['url'] ) ? '' : esc_url( $image['url'] ),
                'alt' => empty( $image['alt'] ) ? '' : esc_url( $image['alt'] ),
            );
        }

        return $thumbs;
    }
    
    function custom_event_link( $object ) {
        return get_field('event_link');
    }

    function event_price( $object ) {
        return get_field('event_price');
    }

    function location_name( $object ) {
        global $post;
        $event_location_name = '';

        if ( function_exists( 'em_get_event' ) && class_exists( 'EM_Location' ) ) {
            $crr_event = em_get_event( $post );
            if ( ! empty( $crr_event->location_id ) && is_numeric( $crr_event->location_id ) ) {
                $crr_event_location = new EM_Location( $crr_event->location_id );
                if ( ! empty( $crr_event_location->location_name ) ) {
                    $event_location_name = $crr_event_location->location_name;
                }
            }
        }

        return $event_location_name;
    }

    function event_start( $object ) {
        global $post;
        $event_start_date = '';

        if ( function_exists( 'em_get_event' ) && class_exists( 'EM_Location' ) ) {
            $crr_event = em_get_event( $post );
            $event_start_date = $crr_event->event_start_date;
        }

        return $event_start_date;
    }




    // function get_images( $object ) {
    //     $images = array();
        
    //     ///
    //     $image_sizes = array(
    //         'lvly_news_tab',
    //     );
    //     foreach( $image_sizes as $image_size ) {
    //         $image = lvly_image( $image_size, true );
    //         if( ! empty( $image ) ) {
    //             $images[ $image_size ] = $image;
    //         }
    //     }
    //     ///

    //     return $images; 
    // }
}
new ICTRestEvent;

/** Current Time */
// class WpApiTime {
//     public $target_endpoints = '';
//     function __construct() {
//         $this->target_endpoints = array('post', 'buy_tender');
//         add_action( 'rest_api_init', array( $this, 'add_current_time' ));
//     }
//     function add_current_time() {
//         register_rest_field( $this->target_endpoints, 'current_time',
//             array(
//             'get_callback'    => array( $this, 'get_current_time'),
//             'update_callback' => null,
//             'schema'          => null,
//             )
//         );
//     }
//     function get_current_time($object) {
//         $currenttime = '';
//         if ( ! empty( $object['id'] ) ) {
//             $currenttime = human_time_diff_mon( get_the_time('U'), current_time('timestamp') );
//         }
//         return $currenttime; 
//     }
// }
// new WpApiTime;


/* rest ep menu */
if ( ! function_exists( 'ict_rest_ep_menu_build' ) ) {
    function ict_rest_ep_menu_build( $menu ) {
        $result = array();
        $menu_filtered = array();
        foreach ( $menu as $menu_item ) {
            $crt_key = 'id_' . $menu_item -> ID;
            $prt_key = 'id_' . $menu_item -> menu_item_parent;
            // var_dump($menu_item);
            // die();
            if ( empty( $menu_filtered[ $crt_key ] ) ) {
                $menu_filtered[ $crt_key ] = array();
            }
            if ( empty( $menu_filtered[ $crt_key ]['sub_items'] ) ) {
                $menu_filtered[ $crt_key ]['sub_items'] = array();
            }
            if ( empty( $menu_filtered[ $crt_key ]['sub_items_ids'] ) ) {
                $menu_filtered[ $crt_key ]['sub_items_ids'] = array();
            }

            if ( empty( $menu_filtered[ $prt_key ] ) ) {
                $menu_filtered[ $prt_key ] = array();
            }
            if ( empty( $menu_filtered[ $prt_key ]['sub_items'] ) ) {
                $menu_filtered[ $prt_key ]['sub_items'] = array();
            }
            if ( empty( $menu_filtered[ $prt_key ]['sub_items_ids'] ) ) {
                $menu_filtered[ $prt_key ]['sub_items_ids'] = array();
            }
            
            $link =  $menu_item -> url;
            $info = pathinfo( $link );

            $menu_filtered[ $crt_key ]['download'] = false;

            if( ! empty( $info['extension'] ) && in_array( $info['extension'], array( 'jpg', 'png', 'pdf' ) ) ) {
                $menu_filtered[ $crt_key ]['download'] = true;
            }


            $menu_filtered[ $crt_key ]['id'] = $menu_item -> ID;
            $menu_filtered[ $crt_key ]['slug'] = $menu_item -> post_name;
            $menu_filtered[ $crt_key ]['text']  = empty( $menu_item -> post_title ) ? $menu_item -> title : $menu_item -> post_title ;
            $menu_filtered[ $crt_key ]['class'] = empty( $menu_item -> classes ) ? $menu_item -> classes : $menu_item -> classes ;
            $menu_filtered[ $crt_key ]['link']  = $link;


            if ( defined( 'ICT_PORTAL_MAIN' ) ) {
                $page_organization = lvly_get_option( 'page_organization' );

                $page_organization_link = '';
                if ( $page_organization ) {
                    $my_posts = get_posts( array('name' => $page_organization,'post_type' => 'page', 'posts_per_page' => 1) );
                    if ( !empty($my_posts[0]) && !empty($my_posts[0]->ID)) {
                        $page_organization_link = get_the_permalink( $my_posts[0]->ID );
                    }
                }

                if ( get_field( 'organization_menu', $menu_item -> ID ) ) {
                    $org_style = '';
        
                    $field_organization_menu_bg_image = get_field( 'field_organization_menu_bg_image', $menu_item -> ID );
                    $field_organization_menu_bg_color = get_field( 'field_organization_menu_bg_color', $menu_item -> ID );
        
                    if ( ! empty( $field_organization_menu_bg_image ) && ! empty( $field_organization_menu_bg_image['url'] ) ) {
                        $org_style .= 'background-image: url(' . esc_url( $field_organization_menu_bg_image['url'] ) . ');';
                    }
                    if ( ! empty( $field_organization_menu_bg_color ) ) {
                        $org_style .= 'background-color: ' . esc_url( $field_organization_menu_bg_color ) . ';';
                    }
        
                    // <button class="uk-button uk-button-default uk-float-left" type="button">Justify</button>
                    // <div uk-drop="pos: bottom-justify; boundary: .boundary-align; boundary-align: true">
                    //     <div class="uk-card uk-card-body uk-card-default">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.</div>
                    // </div>
                    $org_menu_cont  = '<div class="organization-menu"' . ( empty( $org_style ) ? '' : ( ' style="' . esc_attr( $org_style ) . '"' ) ) . '>';
                        $organization_cats = get_terms( 'organization_cat', array( 'hide_empty' => true, 'parent' => 0, 'order' => 'DESC' ) );
                        foreach ( $organization_cats as $organization_cat ) {
                            $organization_cat_image = get_field( 'image', $organization_cat );
                            $organization_cat_icon  = get_field( 'icon',  $organization_cat );
                            $page_organization_link_filter =  $page_organization_link . ( strpos( $page_organization_link, '?' ) === false ? '?' : '&'  ) . 'filter_cat=' . $organization_cat->term_id;
                            $org_menu_cont .= '<a class="organization-menu-item" href="' . esc_url( $page_organization_link_filter ) . '">';
                                if ( ! empty( $organization_cat_image['sizes'] ) && ! empty( $organization_cat_image['sizes']['lvly_menu_thumb'] ) ) {
                                    $org_menu_cont .= '<img src="' . esc_url( $organization_cat_image['sizes']['lvly_menu_thumb'] ) . '"' . ( empty( $organization_cat_image['title'] ) ? '' : ( ' alt="' . esc_attr( $organization_cat_image['title'] ) . '"' ) ) . ' />';
                                }
                                $org_menu_cont .= '<div class="tw-menu-item-icon">';
                                    if ( ! empty( $organization_cat_icon['url'] ) ) {
                                        $org_menu_cont .= '<img src="' . esc_url( $organization_cat_icon['url'] ) . '" />';
                                    }
                                    $org_menu_cont .= $organization_cat -> count;
                                $org_menu_cont .= '</div>';
                                $org_menu_cont .= '<h5># ';
                                    $org_menu_cont .= esc_html( $organization_cat -> name );
                                $org_menu_cont .= '</h5>';
                            $org_menu_cont .= '</a>';
                        }
                    $org_menu_cont .= '</div>';

                    $menu_filtered[ $crt_key ]['organization-menu']  = $org_menu_cont;
                }
            }
            // if ( $menu_item -> megamenu === '1' ) {
            //     $menu_filtered[ $crt_key ]['is_mega'] = $menu_item -> megamenu;
            //     $menu_filtered[ $crt_key ]['mega_column'] = $menu_item -> column;
            // }
        

            

            // Sub Items
            $menu_filtered[ $prt_key ]['sub_items_ids'][] = 'id_' . $menu_item -> ID;
        }
        if ( ! empty( $menu_filtered ) ) {
            $menu_filtered = ict_create_level_menu( isset( $menu_filtered['id_0'] ) ? $menu_filtered['id_0'] : $menu_filtered['id_'], $menu_filtered );
            if ( ! empty( $menu_filtered['sub_items'] ) ) {
                $result['menu'] = $menu_filtered['sub_items'];
            }
            $logo_subsite = lvly_get_option( 'logo_subsite' );
            if( ! empty( $logo_subsite ) && ! empty( $logo_subsite['url'] ) ) {
                $result['topbar_logo'] = $logo_subsite['url'];
            }
            
        }

        return $result;
    }
}

/* rest ep menu */
if ( ! function_exists( 'ict_rest_ep_menu' ) ) {
    function ict_rest_ep_menu( $request ) {
        $result = array(
            'result' => array(),
        );
        if ( ! empty( $request['name'] ) ) {
            $menu = ict_get_nav_menu_items_by_location( $request['name'] );
            $result['result'] = ict_rest_ep_menu_build( $menu );
        }
        if ( empty( $request['get_array'] ) ) {
            return rest_ensure_response( $result );
        }
        return $result;
    }
}

if ( ! function_exists( 'ict_rest_ep_menu_name' ) ) {
    function ict_rest_ep_menu_name( $request ) {
        $result = array(
            'result' => array(),
        );
        if ( ! empty( $request['name'] ) ) {
            $menu_obj = wp_get_nav_menu_object( esc_sql( $request['name'] ) );
            if ( ! empty( $menu_obj->term_id ) ) {
                $menu = wp_get_nav_menu_items( $menu_obj->term_id );
                $result['result'] = ict_rest_ep_menu_build( $menu );
            }
        }
        return $result;
    }
}

/* Nav Menu Items by Location */
if ( ! function_exists( 'ict_get_nav_menu_items_by_location' ) ) {
    function ict_get_nav_menu_items_by_location( $location, $args = array() ) {
        $menu_items = array();

        // Get all locations
        $locations = get_nav_menu_locations();
        if ( ! empty( $locations[ $location ] ) ) {
            // Get menu items by menu id
            $menu_items = wp_get_nav_menu_items( $locations[ $location ], $args );
        }

        // Return menu post objects
        return $menu_items;
    }
}

/* create level menu */
if ( ! function_exists( 'ict_create_level_menu' ) ) {
    function ict_create_level_menu( $parents, $menu_filtered ) {
        if ( ! empty( $parents['sub_items_ids'] ) ) {
            foreach ( $parents['sub_items_ids'] as $sub ) {
                $parents['sub_items'][] = ict_create_level_menu( $menu_filtered[ $sub ], $menu_filtered );
            }
        } else {
            unset( $parents['sub_items'] );
        }
        unset( $parents['sub_items_ids'] );
        return $parents;
    }
}

/* Get Events */
if ( ! function_exists( 'ict_rest_ep_events' ) ) {
    function ict_rest_ep_events( $request ) {
        $result = array(
            'result' => array(),
        );

        if ( ! empty( $_REQUEST['args'] ) && is_array( $_REQUEST['args'] ) && class_exists( 'EM_Events' ) ) {
            
            $args = array();
            foreach ( $_REQUEST['args'] as $key => $arg ) {
                if ( ! empty( $arg ) ) {
                    $args[ $key ] = $arg;
                }
            }

            $events = EM_Events::get( $args );
            
            if ( is_array( $events ) ) {
                foreach( $events as $event ) {
                    $event = (array) $event;
                    if ( ! empty( $event['location_id'] ) ) {
                        $crr_event_location = new EM_Location( $event['location_id'] );
                        if ( ! empty( $crr_event_location->location_name ) ) {
                            $event['location_name'] = $crr_event_location->location_name;
                        }
                    } 
                    if ( ! empty( $event['post_id'] ) ) {
                        $event['custom_event_link'] = get_field( 'event_link', $event['post_id'] );
                    }
                    $result['result'][] = $event;
                }
            }

        }

        return $result;
    }
}

/* Get Counter */
if ( ! function_exists( 'ict_rest_ep_counter' ) ) {
    function ict_rest_ep_counter( $request ) {
        $ops = lvly_get_options();
        $result = array(
            'result' => array(
                'count_art'                          => empty( $ops['count_art'] )                          ? '' : esc_attr( $ops['count_art'] ),
                'count_event'                        => empty( $ops['count_event'] )                        ? '' : esc_attr( $ops['count_event'] ),
                'count_physical_cultural_heritage'   => empty( $ops['count_physical_cultural_heritage'] )   ? '' : esc_attr( $ops['count_physical_cultural_heritage'] ),
                'count_intangible_cultural_heritage' => empty( $ops['count_intangible_cultural_heritage'] ) ? '' : esc_attr( $ops['count_intangible_cultural_heritage'] ),
                'count_documentary_heritage'         => empty( $ops['count_documentary_heritage'] )         ? '' : esc_attr( $ops['count_documentary_heritage'] ),
                'count_actors'                       => empty( $ops['count_actors'] )                       ? '' : esc_attr( $ops['count_actors'] ),
                'count_play_performed'               => empty( $ops['count_play_performed'] )               ? '' : esc_attr( $ops['count_play_performed'] ),
            ),
        );
        return $result;
    }
}

/**
 * REST API Query
 */
function ict_pre_get_posts( $query ) {
    if ( isset( $_REQUEST['posts_per_page'] ) && is_numeric( $_REQUEST['posts_per_page'] ) ) {
        $query->query_vars['posts_per_page'] = intval( $_REQUEST['posts_per_page'] );
    }
}
add_action( 'pre_get_posts', 'ict_pre_get_posts' );