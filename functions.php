<?php
if ( ! defined( 'ICT_LANG' ) ) {
    define('ICT_LANG', 'mn');
}

class Lvly_ThemeWaves{
    var $theme_name;
    public function __construct() {
        $this->init_theme();
        $this->constants();
        $this->requires();
    }
    public function init_theme() {
        if (is_child_theme()) {
            $temp_obj = wp_get_theme();
            $theme_obj = wp_get_theme($temp_obj->get('Template'));
        } else {
            $theme_obj = wp_get_theme();
        }
        $this->theme_name = $theme_obj->get('Name');

        add_action('after_setup_theme',  array($this, 'setup_theme'));
        add_action('wp_enqueue_scripts', array($this, 'scripts'), 20);
        add_action('admin_print_scripts', array($this, 'admin_scripts'));
        add_action('admin_print_styles',  array($this, 'admin_styles'));
        add_action('wp_enqueue_scripts', array($this, 'typekit_scripts'), 151);
        add_action('admin_print_scripts', array($this, 'typekit_scripts'));
        add_action('widgets_init', array($this, 'widgets_init'));
        add_filter('widget_title', array($this, 'widget_title' )); //Uses the built in filter function.  The title of the widget is passed to the function.
        add_filter('body_class', array($this,'body_class'));
        add_filter('get_search_form', array($this,'searchform'));
        /* WordPress Edit Gallery */
        add_filter('use_default_gallery_style', '__return_false');
        add_filter('wp_get_attachment_link', array($this,'pretty_photo'), 10, 5);
    }
    public function constants() {
        define( 'LVLY_THEMENAME', str_replace(' ', '-', strtolower( $this->theme_name ) ) );
        define( 'LVLY_META', 'themewaves_' . strtolower( LVLY_THEMENAME ) . '_options' );
        define( 'LVLY_THEME_PATH', trailingslashit( get_template_directory() ) );
        define( 'LVLY_DIR', trailingslashit( get_template_directory_uri() ) );
        define( 'LVLY_FW_PATH',LVLY_THEME_PATH . 'framework/' );
        define( 'LVLY_FW_DIR', LVLY_DIR . 'framework/' );
        define( 'LVLY_OPTIONS_NAME', 'lvly_redux' );
        define( 'LVLY_OPTIONS_PATH', LVLY_FW_PATH . 'options/' );
        define( 'LVLY_STYLESHEET_PATH', trailingslashit( get_stylesheet_directory() ) );
        define( 'LVLY_STYLESHEET_DIR', trailingslashit( get_stylesheet_directory_uri() ) );
    }
    public function requires() {
        require_once (LVLY_FW_PATH . "theme_functions.php");
        require_once (LVLY_FW_PATH . "custom_menu.php");
        require_once (LVLY_FW_PATH . "options/options.php");
        require_once (LVLY_THEME_PATH . "woocommerce/tw_woocommerce.php");
        require_once (LVLY_FW_PATH . "theme_css.php");

        /**
         * REST API
         */
        if ( ! is_admin() ) {
            require_once (LVLY_FW_PATH . "rest-api/rest-api.php");
        }
    }
    public function setup_theme() {
        add_editor_style();
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'quote', 'status', 'link' ) );
        add_theme_support( 'title-tag' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'woocommerce' );

        /* Setting Theme Language - textdomain */
        load_theme_textdomain( 'lvly', LVLY_THEME_PATH . 'languages/' );

        register_nav_menus( array( 'main'   => esc_html__( 'Main Menu', 'lvly' ) ) );
        // register_nav_menus( array( 'menutop'   => esc_html__( 'Top Menu', 'lvly' ) ) );
        register_nav_menus( array( 'mobile' => esc_html__( 'Mobile Menu', 'lvly' ) ) );

        /* Image Size */
        add_image_size( 'lvly_news_carousel', 920, 516, true );
        add_image_size( 'lvly_news_tab', 48, 48, true );
        add_image_size( 'lvly_organization', 320, 450, true );
        add_image_size( 'lvly_carousel_3', 440, 248, true );
        add_image_size( 'lvly_menu_thumb', 260, 120, true );
        add_image_size('gt-team-image', 264, 310, true); 

    }
    public function block_styles() {
        $output = $headerStyle = $footerStyle = $topStyle ='';
        $lvly_get_options = lvly_get_options();
        // Single
        if ( is_singular() || is_404() ) {
            $lvly_metas = get_fields();
            $contentSingleID = get_the_ID();

            // Post Footer Content
            if ( ! empty( $lvly_metas['post_footer_content'] ) && ! empty( $lvly_metas['post_footer_content']->ID ) ) {
                $block_css = get_post_meta( $lvly_metas['post_footer_content']->ID, '_wpb_shortcodes_custom_css', true );
                if ( ! empty( $block_css ) ) {
                    $output .= strip_tags( $block_css );
                }
            }

            // // 404
            // if ( is_404() ) {
            //     if ( ! empty( $lvly_get_options['page_404'] ) ) {
            //         $lvly_metas = lvly_get_att( 'page_404_metas' );
            //         $contentSingleID = lvly_get_ID_by_slug( $lvly_get_options['page_404'], 'page' );
            //         $block_css = get_post_meta( $contentSingleID, '_wpb_shortcodes_custom_css', true );
            //         if ( ! empty( $block_css ) ) {
            //             $output .= strip_tags( $block_css );
            //         }
            //     }
            // }
            
            // // Single - Top Bar
            // if (!empty($lvly_metas['top_bar_content'])) {
            //     $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_metas['top_bar_content'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
            //     if ( !empty($block_css) ) {
            //         $topStyle .= strip_tags( $block_css );
            //     }
            // }
            // // Single - Header
            // if (!empty($lvly_metas['heading_content'])) {
            //     $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_metas['heading_content'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
            //     if ( ! empty( $block_css ) ) {
            //         $headerStyle .= strip_tags( $block_css );
            //     }
            // }
            // // Single - Footer
            // if (!empty($lvly_metas['footer_content'])) {
            //     $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_metas['footer_content'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
            //     if ( ! empty( $block_css ) ) {
            //         $footerStyle .= strip_tags( $block_css );
            //     }
            // }

            // Single - Footer - ACF
            if (!empty($lvly_metas['footer_content'])) {
                $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_metas['footer_content'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
                if ( ! empty( $block_css ) ) {
                    $footerStyle .= strip_tags( $block_css );
                }
            }


            // Single - Content
            $contentSingle = get_post_field( 'post_content', $contentSingleID );
            $regex = '/\[tw_block(.*?)\](.*?)/';
            $regex_attr = '/(.*?)=\"(.*?)\"/';
            preg_match_all($regex, $contentSingle, $matches, PREG_SET_ORDER);
            if (count($matches)) {
                $inside_column = false;
                foreach ($matches as $value) {
                    if (isset($value[1])) {
                        preg_match_all($regex_attr, trim($value[1]), $matches_attr, PREG_SET_ORDER);
                        foreach ($matches_attr as $value_attr) {
                            if (trim($value_attr[1]) === 'slug' && !empty($value_attr[2])) {
                                $block_css = get_post_meta( lvly_get_ID_by_slug($value_attr[2],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
                                if ( ! empty( $block_css ) ) {
                                        $output .= strip_tags( $block_css );
                                }
                                continue;
                            }
                        }
                    }
                }
            }
            
            // if (is_page_template( 'page-splitpage.php' )) {
            //     $metaboxes = lvly_metas();
            //     if (isset($metaboxes['split_page_blocks']['left']['block'])&&is_array($metaboxes['split_page_blocks']['left']['block'])&&isset($metaboxes['split_page_blocks']['right']['block'])&&is_array($metaboxes['split_page_blocks']['right']['block'])) {
            //         foreach($metaboxes['split_page_blocks']['left']['block'] as $i=>$slugL) {
            //             $slugR=isset($metaboxes['split_page_blocks']['right']['block'][$i])?$metaboxes['split_page_blocks']['right']['block'][$i]:'';
            //             if ($slugL) {
            //                 $idL=lvly_get_ID_by_slug($slugL,'lovelyblock');
            //                 if ($idL) {
            //                     $block_css = get_post_meta( $idL, '_wpb_shortcodes_custom_css', true );
            //                     if ( ! empty( $block_css ) ) {
            //                         $output .= strip_tags( $block_css );
            //                     }
            //                 }
            //             }
            //             if ($slugR) {
            //                 $idR=lvly_get_ID_by_slug($slugR,'lovelyblock');
            //                 if ($idR) {
            //                     $block_css = get_post_meta( $idR, '_wpb_shortcodes_custom_css', true );
            //                     if ( ! empty( $block_css ) ) {
            //                         $output .= strip_tags( $block_css );
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // } elseif (is_page_template( 'page-fullpage.php' )) {
            //     $metaboxes = lvly_metas();
            //     if (isset($metaboxes['full_page_blocks']['section']['block'])&&is_array($metaboxes['full_page_blocks']['section']['block'])) {
            //         foreach($metaboxes['full_page_blocks']['section']['block'] as $i=>$slug) {
            //             if ($slug) {
            //                 $id=lvly_get_ID_by_slug($slug,'lovelyblock');
            //                 if ($id) {
            //                     $block_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
            //                     if ( ! empty( $block_css ) ) {
            //                         $output .= strip_tags( $block_css );
            //                     }
            //                 }
            //             }
            //         }
            //     }

            //     // Fullpage - Footer
            //     if ( ! empty( $lvly_metas['full_page_footer_content'] ) ) {
            //         $block_css = get_post_meta( lvly_get_ID_by_slug( $lvly_metas['full_page_footer_content'], 'lovelyblock' ), '_wpb_shortcodes_custom_css', true );
            //         if ( ! empty( $block_css ) ) {
            //             $output .= strip_tags( $block_css );
            //         }
            //     }
            // }
        }

        // Footer
        if (!$footerStyle&&!empty($lvly_get_options['footer_content'])) {
            $block_css = get_post_meta( lvly_get_ID_by_slug($lvly_get_options['footer_content'],'lovelyblock'), '_wpb_shortcodes_custom_css', true );
            if ( ! empty( $block_css ) ) {
                $footerStyle .= strip_tags( $block_css );
            }
        }
        // Merge
        $output .= $topStyle.$headerStyle.$footerStyle;
        return $output;
    }
    public function scripts() {
        wp_localize_script( 'jquery', 'lvly_script_data', array(
            'ajaxurl' => esc_url(admin_url( 'admin-ajax.php' ))
        ));
        wp_enqueue_style('uikit', LVLY_DIR . 'assets/css/uikit.min.css');
        wp_register_style('justifiedGallery', LVLY_DIR . 'assets/css/justifiedGallery.min.css');
        if (is_page_template( 'page-fullpage.php' )) {
            wp_enqueue_style('lvly-animations', LVLY_DIR . 'assets/css/animations.css');
            wp_enqueue_style('jquery-fullpage', LVLY_DIR . 'assets/css/jquery.fullpage.css');
        }
        if (is_page_template( 'page-splitpage.php' )) {
            wp_enqueue_style('jquery-multiscroll', LVLY_DIR . 'assets/css/jquery.multiscroll.min.css');
        }
        if (lvly_woocommerce()) {
           wp_enqueue_style('lvly-tw-woocommerce', LVLY_DIR . 'woocommerce/assets/tw-woocommerce.css');
           wp_enqueue_script('lvly-tw-woocommerce',LVLY_DIR . 'woocommerce/assets/tw-woocommerce.js', array('jquery'), false, true);
        }
        wp_enqueue_style('owl-carousel', LVLY_DIR . 'assets/css/owl.carousel.min.css');
        wp_enqueue_style('lvly-style', LVLY_STYLESHEET_DIR . 'style.css');
        // wp_add_inline_style('lvly-style', lvly_get_option_styles());
        wp_enqueue_style('lvly-helper', LVLY_DIR . 'style-helper.css');
        wp_enqueue_style('lvly-responsive', LVLY_DIR . 'assets/css/responsive.css');
        wp_add_inline_style('lvly-responsive', $this->block_styles());

        if (is_single() && comments_open()) {
            wp_enqueue_script('comment-reply');
        }
        wp_enqueue_script('uikit', LVLY_DIR . 'assets/js/uikit.min.js', array('jquery'), false, true);
        if (is_page_template( 'page-fullpage.php' )) {
            wp_enqueue_script('jquery-fullpage', LVLY_DIR . 'assets/js/jquery.fullpage.js', array('jquery'), false, true);
        }
        if (is_page_template( 'page-splitpage.php' )) {
            wp_enqueue_script('jquery-easings', LVLY_DIR . 'assets/js/jquery.easings.min.js', array('jquery'), false, true);
            wp_enqueue_script('jquery-multiscroll', LVLY_DIR . 'assets/js/jquery.multiscroll.min.js', array('jquery'), false, true);
        }
        wp_register_script('jquery-justifiedGallery',LVLY_DIR . 'assets/js/jquery.justifiedGallery.min.js');
        wp_register_script('ResizeSensor',LVLY_DIR . 'assets/js/ResizeSensor.min.js');
        wp_register_script('theia-sticky-sidebar',LVLY_DIR . 'assets/js/theia-sticky-sidebar.min.js');
        wp_register_script('owl-carousel',LVLY_DIR . 'assets/js/owl.carousel.min.js');
        wp_register_script('codrops-tiltfx',LVLY_DIR . 'assets/js/codrops-tiltfx.js');

        wp_register_script( 'isotope', LVLY_DIR . 'assets/js/isotope.pkgd.min.js' );
        wp_enqueue_script( 'lvly-theme', LVLY_DIR . 'assets/js/theme.js' );

        /* Leaflet */
        wp_enqueue_style  ( 'leaflet', LVLY_DIR . 'assets/css/leaflet.css' );
        wp_register_script( 'leaflet', LVLY_DIR . 'assets/js/leaflet.js' );
    }
    public function admin_scripts() {
        global $post,$pagenow;
        if (current_user_can('edit_posts') && ($pagenow == 'post-new.php' || $pagenow == 'post.php')&&isset($post)) {
            wp_localize_script( 'jquery', 'lvly_script_data', array(
                'home_uri' => esc_url(home_url('/')),
                'post_id' => esc_attr($post->ID),
                'nonce' => esc_attr(wp_create_nonce( 'themewaves-ajax' )),
                'label_create' => esc_html__("Create Featured Gallery", 'lvly'),
                'label_edit' => esc_html__("Edit Featured Gallery", 'lvly'),
                'label_save' => esc_html__("Save Featured Gallery", 'lvly'),
                'label_saving' => esc_html__("Saving...", 'lvly')
            ));
            wp_enqueue_script('lvly-colorpicker',  LVLY_FW_DIR.'assets/js/colorpicker.js');
            wp_enqueue_script('lvly-metabox',  LVLY_FW_DIR.'assets/js/metabox.js');
        }
    }
    function admin_styles() {
        wp_enqueue_style('lvly-metabox',LVLY_FW_DIR . 'assets/css/metabox.css');
    }
    function typekit_scripts() {
        global $pagenow;

        $kit_enqueue = false;
        $kit_id = lvly_get_option( 'typekit_kit_ID' );
    
        if ( $kit_id ) {
            if ( ! is_admin() ) {
                $typography_fields = lvly_get_att( 'typography_fields' );
                $kit_fonts_list  = get_option( 'lvly_custom_fonts', array() );
                if ( is_array( $kit_fonts_list ) ) {
                    $kit_fonts_list_first  = reset( $kit_fonts_list );
                    $kit_fonts_families  = array_keys( $kit_fonts_list_first );
                    foreach ( $typography_fields as $typography_field ) {
                        if ( ! empty( $typography_field['font-family'] ) && in_array( $typography_field['font-family'] , $kit_fonts_families ) ) {
                            $kit_enqueue = true;
                            break;
                        }
                    }
                }
            } elseif ( $pagenow == 'admin.php' ) {
                $kit_enqueue = true;
            }
        }
        if ( $kit_enqueue ) {
            wp_enqueue_script( 'typekit', 'https://use.typekit.com/' . trim( $kit_id ) . '.js' );
            wp_add_inline_script( 'typekit', 'try{Typekit.load();}catch(e){}' );
        }
    }
    public function widgets_init() {
        /* Single Sidebars */
        register_sidebar(array(
            'name' => esc_html__('Default sidebar', 'lvly'),
            'id' => 'default-sidebar',
            'before_widget' => '<div class="widget-item"><aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Law sidebar', 'lvly'),
            'id' => 'law-sidebar',
            'before_widget' => '<div class="widget-item"><aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));
        register_sidebar(array(
            'name' => esc_html__('Entertainment sidebar', 'lvly'),
            'id' => 'entertainment-sidebar',
            'before_widget' => '<div class="widget-item"><aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Transparency sidebar', 'lvly'),
            'id' => 'transparency-sidebar',
            'before_widget' => '<div class="widget-item"><aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Introduction sidebar', 'lvly'),
            'id' => 'introduction-sidebar',
            'before_widget' => '<div class="widget-item"><aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        register_sidebar(array(
            'name' => esc_html__('Handbook sidebar', 'lvly'),
            'id' => 'handbook-sidebar',
            'before_widget' => '<div class="widget-item"><aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside></div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ));

        /* footer sidebar */
        $grid  = lvly_get_option('footer_layout', '3-3-3-3');
        if (!empty($grid) && $grid != 'block') {
            $i = 1;
            foreach (explode('-', $grid) as $g) {
                register_sidebar(array(
                    'name' => esc_html__('Footer sidebar', 'lvly')." $i",
                    'id' => "lvly-footer-sidebar-$i",
                    'description' => esc_html__('The footer sidebar widget area', 'lvly'),
                    'before_widget' => '<aside class="widget %2$s" id="%1$s">',
                    'after_widget' => '</aside>',
                    'before_title' => '<h3 class="widget-title">',
                    'after_title' => '</h3>',
                ));
                $i++;
            }
        }

        require_once (LVLY_FW_PATH . "metabox/metabox.php");
    }
    public function widget_title($html_widget_title) {

        $html_widget_title_tagopen = '['; //Our HTML opening tag replacement
        $html_widget_title_tagclose = ']'; //Our HTML closing tag replacement

        $html_widget_title = str_replace($html_widget_title_tagopen, '<', $html_widget_title);
        $html_widget_title = str_replace($html_widget_title_tagclose, '>', $html_widget_title);

            $html_widget_title = str_replace(array('&quot;','&#8220;','&#8221;'), '"', $html_widget_title );

        return $html_widget_title;
    }
    public function body_class($classes) {
        $classes[] = 'loading';
        return $classes;
    }
    public function searchform() {
        $form = '<form method="get" class="searchform" action="' . esc_url(home_url('/')) . '" >
        <div class="input">
        <input type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_attr__('Keyword ...', 'lvly') . '" />
            <button type="submit" class="button-search"><i class="simple-icon-magnifier"></i></button>
        </div>
        </form>';
        return $form;
    }
    public function pretty_photo($content, $id, $size, $permalink) {
        if (!$permalink)
            $content = preg_replace("/<a/", "<a rel=\"prettyPhoto[gallery]\"", $content, 1);
        $content = preg_replace("/<\/a/", "<span class=\"image-overlay\"></span></a", $content, 1);
        return $content;
    }
}
$lvly_ThemeWaves = new Lvly_ThemeWaves();

if (!isset($content_width)) {
   $content_width = 1170;
}

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'lvly_vcSetAsTheme' );
function lvly_vcSetAsTheme() {
    vc_set_as_theme();
}

/* One Click Dummy for PT One Click Plugin */
function lvly_import_files() {
    return array(
        array(
            'import_file_name'           => esc_html__( 'Main Demo', 'lvly' ),
            'import_file_url'            => LVLY_DIR . 'dummy-data/dummy-data.xml',
            'import_widget_file_url'     => LVLY_DIR . 'dummy-data/widgets.json',
            'import_notice'              => esc_html__( 'Please check the Recommended PHP settings on our Documentation and apply your server.', 'lvly' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'lvly_import_files' );

function lvly_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'main' );
    $mobile = get_term_by( 'name', 'Mobile Menu', 'mobile' );
    // $menu_top = get_term_by( 'name', 'Top Menu', 'menutop' );

    set_theme_mod( 'nav_menu_locations', array(
            'main' => $main_menu->term_id,
            'mobile' => $mobile->term_id,
            // 'menutop' => $menu_top->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );

}
add_action( 'pt-ocdi/after_import', 'lvly_after_import_setup' );

if ( class_exists( 'EM_Events' ) ) {
    class TW_EM_Events extends EM_Events {
        /**
         * Output a set of matched of events. You can pass on an array of EM_Events as well, in this event you can pass args in second param.
         * Note that you can pass a 'pagination' boolean attribute to enable pagination, default is enabled (true). 
         * @param array $args
         * @param array $secondary_args
         * @return string
         */
        public static function output( $args ){
            $curr_day = esc_html( date( 'Y-m-d', $args['date'] ) );
            $args     = $args['events'];
            $output = "";
    
            if ( defined( 'ICT_PORTAL_MAIN' ) ) {
                foreach ( $args as $EM_Event ) {
                    $event_location_name = $event_name = $event_link = '';

                    
                    if ( ! empty( $EM_Event['event_name'] ) ) {
                        $event_name = $EM_Event['event_name'];
                    }
                    if ( ! empty( $EM_Event['custom_event_link'] ) ) {
                        $event_link = $EM_Event['custom_event_link'];
                    }
                    if ( ! empty( $EM_Event['location_name'] ) ) {
                        $event_location_name = $EM_Event['location_name'];
                    }
                    
                    $output .= '<li>';
                        $output .= '<svg width="49" height="48" viewBox="0 0 49 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#filter0_d_550_3579)"><rect x="4" width="40.0016" height="40" rx="20" fill="#F1F4F9" shape-rendering="crispEdges"/><path d="M12.8627 13.7226C14.0778 11.6977 15.698 10.0776 17.7232 8.86266C20.1534 7.64768 22.5836 7.24269 22.5836 10.8876V12.1026V15.7476C22.5836 17.7726 21.7735 18.5825 19.7484 18.5825H16.103H14.8879C11.2426 18.5825 11.6476 15.7476 12.8627 13.7226Z" fill="#DF6837"/><path d="M35.1389 13.7226C33.9238 11.6977 32.3036 10.0776 30.2784 8.86266C28.2532 7.64768 25.418 7.24269 25.418 10.8876V12.1026V15.7476C25.418 17.7726 26.2281 18.5825 28.2533 18.5825H31.8986H33.1137C36.759 18.5825 36.354 15.7476 35.1389 13.7226Z" fill="#B5C450"/><path d="M35.1389 26.2773C33.9238 28.3023 32.3036 29.9223 30.2784 31.1373C28.2532 32.3523 25.418 32.7573 25.418 29.1123V27.8974V24.2524C25.418 22.2274 26.2281 21.4175 28.2533 21.4175H31.8986H33.1137C36.759 21.4175 36.354 24.2524 35.1389 26.2773Z" fill="#FAD547"/><path d="M12.8627 26.2773C14.0778 28.3023 15.698 29.9223 17.7232 31.1373C20.1534 32.3523 22.5836 32.7573 22.5836 29.1123V27.8974V24.2524C22.5836 22.2274 21.7735 21.4175 19.7484 21.4175H16.103H14.8879C11.2426 21.4175 11.6476 24.2524 12.8627 26.2773Z" fill="#C14B93"/></g><defs><filter id="filter0_d_550_3579" x="0" y="0" width="48.002" height="48" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4"/><feGaussianBlur stdDeviation="2"/><feComposite in2="hardAlpha" operator="out"/><feColorMatrix type="matrix" values="0 0 0 0 0.101961 0 0 0 0 0.168627 0 0 0 0 0.419608 0 0 0 0.12 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_550_3579"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_550_3579" result="shape"/></filter></defs></svg>';

                        $output .= '<table class="tw-event-info-table">';

                            $output .= '<tr>';
                                $output .= '<td class="event-left">';
                                    if ( $event_link ) {
                                        $output .= '<a href="' . esc_url( $event_link ) . '" target="_blank">';
                                    }
                                        if ( $event_name ) {
                                            $output .= esc_html( $event_name );
                                        }
                                    if ( $event_link ) {
                                        $output .= '</a>';
                                    }
                                $output .= '</td>';
                                $output .= '<td class="event-right">';
                                    $output .= '<div class="tw-modal-date-label">Он сар өдөр</div>';
                                $output .= '</td>';
                            $output .= '</tr>';
                            
                            $output .= '<tr>';
                                $output .= '<td class="event-left">';
                                    $output .= '<div class="location-name">';
                                        if ( $event_location_name ) {
                                            $output .= esc_html( $event_location_name );
                                        }
                                    $output .= '</div>';
                                $output .= '</td>';
                                $output .= '<td class="event-right">';
                                    $output .= '<div class="tw-modal-date">';
                                        if ( ! empty( $EM_Event['event_start'] ) ) {
                                            $output .= $curr_day . ' ' . date('H:i', strtotime( $EM_Event['event_start'] ) );
                                        }
                                    $output .= '</div>';
                                $output .= '</td>';
                            $output .= '</tr>';

                        $output .= '</table>';

                    $output .= '</li>';
                }
            } else {
                
                global $EM_Event;
                $EM_Event_old = $EM_Event; //When looping, we can replace EM_Event global with the current event in the loop
                //get page number if passed on by request (still needs pagination enabled to have effect)
                $page_queryvar = !empty($args['page_queryvar']) ? $args['page_queryvar'] : 'pno';
                if( !empty($args['pagination']) && !array_key_exists('page',$args) && !empty($_REQUEST[$page_queryvar]) && is_numeric($_REQUEST[$page_queryvar]) ){
                    $args['page'] = $_REQUEST[$page_queryvar];
                }
                //Can be either an array for the get search or an array of EM_Event objects
                if( is_object(current($args)) && get_class((current($args))) == 'EM_Event' ){
                    $func_args = func_get_args();
                    $events = $func_args[0];
                    $args = (!empty($func_args[1]) && is_array($func_args[1])) ? $func_args[1] : array();
                    $args = apply_filters('em_events_output_args', self::get_default_search($args), $events);
                    $limit = ( !empty($args['limit']) && is_numeric($args['limit']) ) ? $args['limit']:false;
                    $events_count = count($events);
                }else{
                    //Firstly, let's check for a limit/offset here, because if there is we need to remove it and manually do this
                    $args = apply_filters('em_events_output_args', self::get_default_search($args));
                    $limit = ( !empty($args['limit']) && is_numeric($args['limit']) ) ? $args['limit']:false;
                    $events = self::get( $args );
                    $events_count = self::$num_rows_found;
                }
                //What format shall we output this to, or use default
                $format = ( empty($args['format']) ) ? get_option( 'dbem_event_list_item_format' ) : $args['format'] ;
                
                
                if ( $events_count > 0 ) {
                    $events = apply_filters('em_events_output_events', $events);
                    foreach ( $events as $EM_Event ) {                    
                        $event_location_name = $event_name = $event_link = '';
                        $event_name = empty( $EM_Event->event_name ) ? '' : $EM_Event->event_name;
                        $event_link = empty( $EM_Event->post_id )    ? '' : get_field( 'event_link', $EM_Event->post_id );
                        if ( ! empty( $EM_Event->location_id ) && is_numeric( $EM_Event->location_id ) && class_exists( 'EM_Location' ) ) {
                            $crr_event_location = new EM_Location( $EM_Event->location_id );
                            if ( ! empty( $crr_event_location->location_name ) ) {
                                $event_location_name = $crr_event_location->location_name;
                            }
                        }

                        $output .= '<li>';
                            $output .= '<svg width="49" height="48" viewBox="0 0 49 48" fill="none" xmlns="http://www.w3.org/2000/svg"><g filter="url(#filter0_d_550_3579)"><rect x="4" width="40.0016" height="40" rx="20" fill="#F1F4F9" shape-rendering="crispEdges"/><path d="M12.8627 13.7226C14.0778 11.6977 15.698 10.0776 17.7232 8.86266C20.1534 7.64768 22.5836 7.24269 22.5836 10.8876V12.1026V15.7476C22.5836 17.7726 21.7735 18.5825 19.7484 18.5825H16.103H14.8879C11.2426 18.5825 11.6476 15.7476 12.8627 13.7226Z" fill="#DF6837"/><path d="M35.1389 13.7226C33.9238 11.6977 32.3036 10.0776 30.2784 8.86266C28.2532 7.64768 25.418 7.24269 25.418 10.8876V12.1026V15.7476C25.418 17.7726 26.2281 18.5825 28.2533 18.5825H31.8986H33.1137C36.759 18.5825 36.354 15.7476 35.1389 13.7226Z" fill="#B5C450"/><path d="M35.1389 26.2773C33.9238 28.3023 32.3036 29.9223 30.2784 31.1373C28.2532 32.3523 25.418 32.7573 25.418 29.1123V27.8974V24.2524C25.418 22.2274 26.2281 21.4175 28.2533 21.4175H31.8986H33.1137C36.759 21.4175 36.354 24.2524 35.1389 26.2773Z" fill="#FAD547"/><path d="M12.8627 26.2773C14.0778 28.3023 15.698 29.9223 17.7232 31.1373C20.1534 32.3523 22.5836 32.7573 22.5836 29.1123V27.8974V24.2524C22.5836 22.2274 21.7735 21.4175 19.7484 21.4175H16.103H14.8879C11.2426 21.4175 11.6476 24.2524 12.8627 26.2773Z" fill="#C14B93"/></g><defs><filter id="filter0_d_550_3579" x="0" y="0" width="48.002" height="48" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="4"/><feGaussianBlur stdDeviation="2"/><feComposite in2="hardAlpha" operator="out"/><feColorMatrix type="matrix" values="0 0 0 0 0.101961 0 0 0 0 0.168627 0 0 0 0 0.419608 0 0 0 0.12 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_550_3579"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_550_3579" result="shape"/></filter></defs></svg>';
                            
                            $output .= '<table class="tw-event-info-table">';

                                $output .= '<tr>';
                                    $output .= '<td class="event-left">';
                                        if ( $event_link ) {
                                            $output .= '<a href="' . esc_url( $event_link ) . '" target="_blank">';
                                        }
                                            if ( $event_name ) {
                                                $output .= esc_html( $event_name );
                                            }
                                        if ( $event_link ) {
                                            $output .= '</a>';
                                        }
                                    $output .= '</td>';
                                    $output .= '<td class="event-right">';
                                        $output .= '<div class="tw-modal-date-label">Он сар өдөр</div>';
                                    $output .= '</td>';
                                $output .= '</tr>';
                                
                                $output .= '<tr>';
                                    $output .= '<td class="event-left">';
                                        $output .= '<div class="location-name">';
                                            if ( $event_location_name ) {
                                                $output .= esc_html( $event_location_name );
                                            }
                                        $output .= '</div>';
                                    $output .= '</td>';
                                    $output .= '<td class="event-right">';
                                        $output .= '<div class="tw-modal-date">';
                                            $output .= $curr_day . ' ' . date('H:i', strtotime( $EM_Event -> start_time ) );
                                        $output .= '</div>';
                                    $output .= '</td>';
                                $output .= '</tr>';

                            $output .= '</table>';

                        $output .= '</li>';
                    } 
                    //Add headers and footers to output
                    // if( $format == get_option( 'dbem_event_list_item_format' ) ){
                    //     //we're using the default format, so if a custom format header or footer is supplied, we can override it, if not use the default
                    //     $format_header = empty($args['format_header']) ? get_option('dbem_event_list_item_format_header') : $args['format_header'];
                    //     $format_footer = empty($args['format_footer']) ? get_option('dbem_event_list_item_format_footer') : $args['format_footer'];
                    // }else{
                    //     //we're using a custom format, so if a header or footer isn't specifically supplied we assume it's blank
                    //     $format_header = !empty($args['format_header']) ? $args['format_header'] : '' ;
                    //     $format_footer = !empty($args['format_footer']) ? $args['format_footer'] : '' ;
                    // }
                    // $output = $format_header .  $output . $format_footer;
                    //Pagination (if needed/requested)
                    if( !empty($args['pagination']) && !empty($limit) && $events_count > $limit ){
                        $output .= self::get_pagination_links($args, $events_count);
                    }
                }elseif( $args['no_results_msg'] !== false ){
                    $output = !empty($args['no_results_msg']) ? $args['no_results_msg'] : get_option('dbem_no_events_message');
                }
                
                //TODO check if reference is ok when restoring object, due to changes in php5 v 4
                $EM_Event = $EM_Event_old;
                $output = apply_filters('em_events_output', $output, $events, $args);
            }
    
            return $output;		
        }
    }
}

/**
 * Disable Comments
 */
add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
    
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }

    // Customize Role
    $role = get_role('editor');
    $role->add_cap( 'edit_theme_options' );

});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});