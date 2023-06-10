<?php

// function lvly_get_option_styles() {
//     //Body
//     $body_default = array(
//         'font-size'   => '14px',
//         'font-family' => 'Yantramanav',
//         'font-weight' => '400',
//         'line-height'  => '1.72',
//         'letter-spacing'  => '0',
//         'font-backup' => 'Arial, Helvetica, sans-serif',
//     );
//     $blog_single_default = array(
//         'font-size'   => '15px',
//         'font-family' => 'Yantramanav',
//         'font-weight' => '400',
//         'line-height'  => '1.82',
//         'letter-spacing'  => '0',
//         'font-backup' => 'Arial, Helvetica, sans-serif',
//     );
//     $body_bg = lvly_get_option('body_bg', array('background-color' => '#fff'));
//     $body_typography = lvly_get_option('body_font', $body_default);
//     $blog_single_typography = lvly_get_option('blog_single_font', $blog_single_default);

//     //Heading
//     $heading_default = array('font-family' => 'Yantramanav', 'font-weight' => '400', 'text-transform' => 'uppercase', 'letter-spacing' => '0.2em');
//     $heading_typography = lvly_get_option('heading_font', $heading_default);    
    
//     //Meta
//     $meta_default = array('font-family' => 'Yantramanav', 'font-weight' => '400', 'font-size' => '12px', 'text-transform' => 'none', 'letter-spacing' => '0.2em');
//     $meta_typography = lvly_get_option('meta_font', $meta_default);    
    
//     //Menu
//     $menu_default = array('font-family' => 'Yantramanav', 'font-weight' => '400', 'font-size' => '11px', 'text-transform' => 'uppercase', 'letter-spacing' => '0.2em');
//     $menu_typography = lvly_get_option('menu_font', $menu_default);    
//     $submenu_default = array('font-family' => 'Yantramanav', 'font-weight' => '400', 'font-size' => '11px', 'text-transform' => 'uppercase', 'letter-spacing' => '0.2em');
//     $submenu_typography = lvly_get_option('submenu_font', $submenu_default);    

//     $body_color = lvly_get_option('body_color', '#666');
//     $heading_color = lvly_get_option('heading_color', '#151515');
//     $link_color = lvly_get_option('link_color', array('regular' => '#808080', 'hover' => '#999'));
//     $header_bg = lvly_get_option('header_bg', '#fff');
//     $header_color = lvly_get_option('menu_color', '#151515');
//     $menu_hover = lvly_get_option('menu_hover', '#151515');
//     $submenu_bg = lvly_get_option('submenu_bg', '#151515');
//     $submenu_color = lvly_get_option('submenu_color', '#999');
//     $submenu_hover = lvly_get_option('submenu_hover_color', '#fff');
//     $submenu_hoverbg = lvly_get_option('submenu_hover_bg', '#151515');
//     $post_link = lvly_get_option('post_link', array('regular' => '#151515', 'hover' => '#999'));
//     $border_color = lvly_get_option('border_color', '#e6e6e6');
//     $input_bg = lvly_get_option('input_bg', '#f5f5f5');
//     $footer_color = lvly_get_option('footer_text_color', '#999');
//     $footer_link = lvly_get_option('footer_link_color', array('regular' => '#999', 'hover' => '#fff'));
    
//     $header_height = lvly_get_option('header_height', '70');
    
//     $h1_font = lvly_get_option('h1_font', array('font-size' => '36px', 'line-height' => '1.2'));
//     $h2_font = lvly_get_option('h2_font', array('font-size' => '30px', 'line-height' => '1.2'));
//     $h3_font = lvly_get_option('h3_font', array('font-size' => '24px', 'line-height' => '1.3'));
//     $h4_font = lvly_get_option('h4_font', array('font-size' => '20px', 'line-height' => '1.3'));
//     $h5_font = lvly_get_option('h5_font', array('font-size' => '16px', 'line-height' => '1.4'));
//     $h6_font = lvly_get_option('h6_font', array('font-size' => '14px', 'line-height' => '1.4'));
    
//     $output = '';
//     $output .= 'body{';
//         $output .= !empty($body_color) ? ('color: '.esc_attr($body_color).';') : '';
//         $output .= !empty($body_typography['font-family']) ? ('font-family: '.lvly_font_family($body_typography['font-family']).', '.esc_attr($body_typography['font-backup']).';') : '';
//         $output .= !empty($body_typography['font-size']) ? ('font-size: '.esc_attr($body_typography['font-size']).';') : '';
//         $output .= !empty($body_typography['font-weight']) ? ('font-weight: '.esc_attr($body_typography['font-weight']).';') : '';
//         $output .= !empty($body_typography['line-height']) ? ('line-height: '.esc_attr(str_replace('px', '', $body_typography['line-height'])).';') : '';
//         $output .= !empty($body_typography['letter-spacing']) ? ('letter-spacing: '.esc_attr(str_replace('px', 'em', $body_typography['letter-spacing'])).';') : '';
//     $output .= '}';

//     $output .= '.single .entry-content{';
//         $output .= !empty($blog_single_typography['font-family']) ? ('font-family: '.lvly_font_family($blog_single_typography['font-family']).', '.esc_attr($blog_single_typography['font-backup']).';') : '';
//         $output .= !empty($blog_single_typography['font-size']) ? ('font-size: '.esc_attr($blog_single_typography['font-size']).';') : '';
//         $output .= !empty($blog_single_typography['font-weight']) ? ('font-weight: '.esc_attr($blog_single_typography['font-weight']).';') : '';
//         $output .= !empty($blog_single_typography['line-height']) ? ('line-height: '.esc_attr(str_replace('px', '', $blog_single_typography['line-height'])).';') : '';
//         $output .= !empty($blog_single_typography['letter-spacing']) ? ('letter-spacing: '.esc_attr(str_replace('px', 'em', $blog_single_typography['letter-spacing'])).';') : '';
//     $output .= '}';
    
//     $output .= 'h1, h2, h3, h4, h5, h6, input[type="button"], blockquote, .tw-filter-list-outer,.tw-chart-circle .tw-chart span{';
//         $output .= !empty($heading_typography['font-family']) ? ('font-family: '.lvly_font_family($heading_typography['font-family']).';') : '';
//         $output .= !empty($heading_typography['font-weight']) ? ('font-weight: '.esc_attr($heading_typography['font-weight']).';') : '';
//         $output .= !empty($heading_typography['text-transform']) ? ('text-transform: '.esc_attr($heading_typography['text-transform']).';') : '';
//         $output .= !empty($heading_typography['letter-spacing']) ? ('letter-spacing: '.esc_attr(str_replace('px', 'em', $heading_typography['letter-spacing'])).';') : '';
//     $output .= '}';
    
//     $output .= '.tw-page-title-container .tw-page-title, .button, .uk-button, .woocommerce-loop-product__title, .woocommerce-loop-category__title,.tw-coming-soon .counter,.tw-process .tw-process-block .tw-process-circle .tw-process-number,.tw-progress.style-3 span,.cart-btn i span{';
//         $output .= !empty($heading_typography['font-family']) ? ('font-family: '.lvly_font_family($heading_typography['font-family']).';') : '';
//     $output .= '}';
    
//     $output .= '.tw-main-menu{';
//         $output .= !empty($menu_typography['font-family']) ? ('font-family: '.lvly_font_family($menu_typography['font-family']).';') : '';
//         $output .= !empty($menu_typography['font-size']) ? ('font-size: '.esc_attr($menu_typography['font-size']).';') : '';
//         $output .= !empty($menu_typography['font-weight']) ? ('font-weight: '.esc_attr($menu_typography['font-weight']).';') : '';
//         $output .= !empty($menu_typography['text-transform']) ? ('text-transform: '.esc_attr($menu_typography['text-transform']).';') : '';
//         $output .= !empty($menu_typography['letter-spacing']) ? ('letter-spacing: '.esc_attr(str_replace('px', 'em', $menu_typography['letter-spacing'])).';') : '';
//     $output .= '}';
        
//     $output .= '.tw-main-menu ul{';
//         $output .= !empty($submenu_typography['font-family']) ? ('font-family: '.lvly_font_family($submenu_typography['font-family']).';') : '';
//         $output .= !empty($submenu_typography['font-size']) ? ('font-size: '.esc_attr($submenu_typography['font-size']).';') : '';
//         $output .= !empty($submenu_typography['font-weight']) ? ('font-weight: '.esc_attr($submenu_typography['font-weight']).';') : '';
//         $output .= !empty($submenu_typography['text-transform']) ? ('text-transform: '.esc_attr($submenu_typography['text-transform']).';') : '';
//         $output .= !empty($submenu_typography['letter-spacing']) ? ('letter-spacing: '.esc_attr(str_replace('px', 'em', $submenu_typography['letter-spacing'])).';') : '';
//     $output .= '}';

//     $output .= '.tw-meta{';
//         $output .= !empty($meta_typography['font-family']) ? ('font-family: '.lvly_font_family($meta_typography['font-family']).';') : '';
//         $output .= !empty($meta_typography['font-size']) ? ('font-size: '.esc_attr($meta_typography['font-size']).';') : '';
//         $output .= !empty($meta_typography['font-weight']) ? ('font-weight: '.esc_attr($meta_typography['font-weight']).';') : '';
//         $output .= !empty($meta_typography['text-transform']) ? ('text-transform: '.esc_attr($meta_typography['text-transform']).';') : '';
//         $output .= !empty($meta_typography['letter-spacing']) ? ('letter-spacing: '.esc_attr(str_replace('px', 'em', $meta_typography['letter-spacing'])).';') : '';
//     $output .= '}';
        
//     $output .= 'a{';
//         $output .= !empty($link_color['regular']) ? ('color: '.esc_attr($link_color['regular']).';') : '';
//     $output .= '}';
//     $output .= 'a:hover{';
//         $output .= !empty($link_color['hover']) ? ('color: '.esc_attr($link_color['hover']).';') : '';
//     $output .= '}';

//     $output .= 'h1, h2, h3, h4, h5, h6, div.entry-cats{';
//         $output .= 'color: '.esc_attr($heading_color);
//     $output .= '}';

//     for($i = 1; $i <= 6; $i++) {
//         $h_tag = 'h'.$i.'_font';
//         $heading = $$h_tag;
//         $output .= 'h'.$i.'{';
//             $output .= !empty($heading['font-size']) ? ('font-size: '.esc_attr($heading['font-size']).';') : '';
//             $output .= !empty($heading['line-height']) ? ('line-height: '.esc_attr(str_replace('px', '', $heading['line-height'])).';') : '';
//         $output .= '}';
//     }

//     $output .= !empty($header_bg) ? ('.tw-header{background-color:'.esc_attr($header_bg).';}') : '';
//     $output .= !empty($header_color) ? ('.tw-main-menu > li > a, .tw-logo .site-name, .tw-header-meta i{color:'.esc_attr($header_color).';}') : '';
//     $menu_hover_selectors = '.tw-main-menu > li > a:hover, tw-header-meta a:hover i';
//     $output .= !empty($menu_hover) ? ($menu_hover_selectors.'{color:'.esc_attr($menu_hover).';}') : '';
//     $output .= !empty($submenu_bg) ? ('.tw-main-menu .sub-menu, .uk-drop-boundary .uk-container{background-color:'.esc_attr($submenu_bg).';}') : '';
//     $output .= !empty($submenu_color) ? ('.tw-main-menu .sub-menu a, .uk-navbar-dropdown-nav>li>a, .tw-main-menu .sub-menu .menu-item-has-children:after{color:'.esc_attr($submenu_color).';}') : '';
//     $output .= !empty($submenu_hover) ? ("\n". '.tw-main-menu .sub-menu > li:hover > a, .tw-main-menu .sub-menu > li:hover:after, .uk-navbar-dropdown .uk-navbar-dropdown-nav > li.uk-active > a, .uk-navbar-dropdown .uk-navbar-dropdown-nav > li > a:hover{color:'.esc_attr($submenu_hover).';}') : '';
//     $output .= !empty($submenu_hoverbg) ? ("\n". '.tw-main-menu .sub-menu > li:hover > a{background-color:'.esc_attr($submenu_hoverbg).';}') : '';
//     $output .= !empty($footer_color) ? ('footer .uk-light, footer .uk-light{color:'.esc_attr($footer_color).';}') : '';
//     $output .= !empty($footer_link['regular']) ? ('footer .uk-light a, footer .uk-light a{color:'.esc_attr($footer_link['regular']).';}') : '';
//     $output .= !empty($footer_link['hover']) ? ('footer .uk-light a:hover, footer .uk-light a:hover{color:'.esc_attr($footer_link['hover']).';}') : '';

//     if (!empty($header_height)) {
//         $output .= '.tw-header, .tw-header .uk-navbar-toggle, .transparent-menu-bgnone, .tw-main-menu > li > a{height:'.intval($header_height).'px;}';
//         $output .= '.logo-img{max-height:'.intval($header_height - 1).'px;}';
//     }

//     if (!empty($border_color)) {
//         $output .= '.tw-header, .sidebar-area .widget, .sidebar-area .widget ul li, .tw-blog:not(.metro-blog):not(.grid-blog) > article:not(:last-child), .tw-author, .comment-list .comment-text{border-color:'.esc_attr($border_color).';}';
//         $output .= 'input, input[type="tel"], input[type="date"], input[type="text"], input[type="password"], input[type="email"], textarea, select, table, td, th{border-color:'.esc_attr($border_color).';}';
//     }
//     if (!empty($input_bg)) {
//         $output .= 'input, input[type="tel"], input[type="date"], input[type="text"], input[type="password"], input[type="email"], textarea, select{background-color:'.esc_attr($input_bg).';}';
//     }
//     $output .= !empty($post_link['regular']) ? ('.page-content > p a, .entry-content > p a:not(.uk-button) {color:'.esc_attr($post_link['regular']).';}') : '';
//     $output .= !empty($post_link['hover']) ? ('.page-content > p a:hover, .entry-content > p a:not(.uk-button):hover{color:'.esc_attr($post_link['hover']).';}') : '';

//     return $output;
// }