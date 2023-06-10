<?php

/**
* Hook in on activation
*/
/**
* Define image sizes
*/
function lvly_woo_image_dimensions() {
    global $pagenow;

    if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
        return;
    }
    $catalog = array(
        'width' 	=> '270',	// px
        'height'	=> '320',	// px
        'crop'		=> 1 		// true
    );
    $single = array(
        'width' 	=> '450',	// px
        'height'	=> '590',	// px
        'crop'		=> 1 		// true
    );
    $thumbnail = array(
        'width' 	=> '100',	// px
        'height'	=> '132',	// px
        'crop'		=> 0 		// false
    );
    // Image sizes
    update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
    update_option( 'shop_single_image_size', $single ); 		// Single product image
    update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}
add_action( 'after_switch_theme', 'lvly_woo_image_dimensions', 1 );

function lvly_woocommerce() {
    if (class_exists('woocommerce')) {return true;}
    return false;
}

if (lvly_woocommerce()) {

    /* Disabling all Woo StyleSheets */
    // Remove each style one by one
    add_filter( 'woocommerce_enqueue_styles', 'lvly_woo_dequeue_styles' );
    function lvly_woo_dequeue_styles( $enqueue_styles ) {
        unset( $enqueue_styles['woocommerce-general'] );
        return $enqueue_styles;
    }

    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );

    /* Removed Default Shop Wrapper and Added Our Section Code */
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
    add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20);




    /* Changing the Product Gallery Thumbnail only This option has not included in WooCommerce Settings */
    add_image_size( 'lvly_woo_subcategory_thumbnail_size', 740, 480, false );
    function lvly_woo_subcategory_function() {
        return 'lvly_woo_subcategory_thumbnail_size';
    }
    add_filter( 'subcategory_archive_thumbnail_size', 'lvly_woo_subcategory_function' );
    
    /* ====== Remove Page Title ====== */
    add_filter( 'woocommerce_show_page_title', 'lvly_woo_title_none' );
    function lvly_woo_title_none() {
        return false;
    }

    /* Adding Sidebar for Shop */
    add_action('widgets_init', 'lvly_woo_widgets');
    if ( ! function_exists( 'lvly_woo_widgets' ) ) {
        function lvly_woo_widgets() {
            register_sidebar(array(
                'name' => esc_html__('WooCommerce Shop Sidebar', 'lvly'),
                'id' => 'woocommerce-shop',
                'before_widget' => '<aside class="widget %2$s" id="%1$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
            register_sidebar(array(
                'name' => esc_html__('WooCommerce Single Sidebar', 'lvly'),
                'id' => 'woocommerce-single',
                'before_widget' => '<aside class="widget %2$s" id="%1$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>',
            ));
        }
    }

    add_action('woocommerce_before_main_content', 'lvly_woo_wrapper_start', 10);
    if ( ! function_exists( 'lvly_woo_wrapper_start' ) ) {
        function lvly_woo_wrapper_start() {
            echo '<section class="uk-section uk-section-shop">';
            echo '<div class="uk-container">';
            echo '<div data-uk-grid>';
            echo '<div class="content-area uk-width-expand">';
            echo '<div class="tw-element tw-shop woocommerce columns-'.esc_attr(lvly_woo_shop_columns()).'">';
        }
    }
    add_action('woocommerce_before_subcategory', 'lvly_woo_loop_category_link_open', 10);
    if ( ! function_exists( 'lvly_woo_loop_category_link_open' ) ) {
        function lvly_woo_loop_category_link_open( $category ) {
            echo '<a href="' . esc_url(get_term_link( $category, 'product_cat' )) . '" class="uk-button uk-button-white uk-button-shop uk-no-radius tw-hover">';
        }
    }
    add_action('woocommerce_shop_loop_subcategory_title', 'lvly_woo_template_loop_category_title', 10);
    if ( ! function_exists( 'lvly_woo_template_loop_category_title' ) ) {
        function lvly_woo_template_loop_category_title( $category ) {
            ?>
            <span class="tw-hover-inner">
                <span>
                    <?php
                        echo esc_attr($category->name);
                    ?>
                </span>
                <i class="ion-ios-arrow-thin-right"></i>
            </span>
            <?php
        }
    }

    add_action('woocommerce_after_main_content', 'lvly_woo_wrapper_end', 10);
    if ( ! function_exists( 'lvly_woo_wrapper_end' ) ) {
        function lvly_woo_wrapper_end() {
            echo '</div>';
            echo '</div>';
                // sidebar
                if (!is_product()) {
                    lvly_woo_page_sidebar();
                }
            echo '</div>';
            echo '</div>';
        echo '</section>';
        }
    }
    
    add_action( 'woocommerce_after_shop_loop_item_title', 'lvly_woo_add_product_cat', 1);
    if (!function_exists('lvly_woo_add_product_cat')) {
        function lvly_woo_add_product_cat() {
            global $product;
            echo '<div class="shop-category">';
                echo  wc_get_product_category_list(
                    $product->get_id(), ', ', '', '' );
            echo '</div>';
        }
    }
    /* ====== Change Products Columns ====== */
    add_filter('loop_shop_columns', 'lvly_woo_shop_columns');
    if (!function_exists('lvly_woo_shop_columns')) {
        function lvly_woo_shop_columns() {
            if (!is_product()) {
                return 3;
            }
        }
    }
    if (!function_exists('lvly_woo_page_sidebar')) {
        function lvly_woo_page_sidebar() {
            $class = '';
            if (lvly_get_option('sidebar_affix')) {
                $class = ' sticky-sidebar'; 
                wp_enqueue_script('ResizeSensor');
                wp_enqueue_script('theia-sticky-sidebar');
            }
            echo '<div class="sidebar-area'.esc_attr($class).'"><div class="sidebar-inner">';
            if (!dynamic_sidebar('woocommerce-shop')) {
                dynamic_sidebar('default-sidebar');
            }
            echo '</div></div>';
        }
    }
}