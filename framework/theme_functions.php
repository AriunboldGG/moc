<?php
// print_r_pre - for dev
function print_r_pre( $array ) {
    echo '<pre>';
        print_r( $array );
    echo '</pre>';
}
// =====

if (!function_exists('lvly_get_option')) {
    function lvly_get_option($index, $default = false) {
        global $lvly_redux;
        if ( isset( $lvly_redux[ $index ]) ) {
            return $lvly_redux[$index];
        } else {
            return $default;
        }
    }
}
if (!function_exists('lvly_get_options')) {
    function lvly_get_options() {
        global $lvly_redux;
        return $lvly_redux;
    }
}
if (!function_exists('lvly_set_options')) {
    function lvly_set_options($new_atts) {
        global $lvly_redux;
        if (empty($lvly_redux)||!is_array($lvly_redux)) {$lvly_redux=array();}
        $lvly_redux = array_merge($lvly_redux, $new_atts);
    }
}
if (!function_exists('lvly_get_atts')) {
    function lvly_get_atts() {
        global $lvly_atts;
        return $lvly_atts;
    }
}
if (!function_exists('lvly_get_att')) {
    function lvly_get_att($slug) {
        global $lvly_atts;
        return isset($lvly_atts[$slug])?$lvly_atts[$slug]:NULL;
    }
}
if (!function_exists('lvly_set_atts')) {
    function lvly_set_atts($new_atts) {
        global $lvly_atts;
        if (empty($lvly_atts)||!is_array($lvly_atts)) {$lvly_atts=array();}
        $lvly_atts = array_merge($lvly_atts, $new_atts);
    }
}
if (!function_exists('lvly_set_att')) {
    function lvly_set_att($new_att_slug,$new_att_value) {
        global $lvly_atts;
        $lvly_atts[$new_att_slug] = $new_att_value;
    }
}
if (!function_exists('lvly_favicon')) {
    function lvly_favicon() {
        if (!function_exists('has_site_icon')||!has_site_icon()) {

        /* Our Favicon will Work If Site Icon has no value - We are not overriding the Core */

            $favicon = lvly_get_option('favicon');
            if (!empty($favicon['url'])) {
                echo '<link rel="shortcut icon" href="' . esc_url($favicon['url']).'"/>';
            }else{
                echo '<link rel="shortcut icon" href="' . esc_url(LVLY_DIR . 'assets/images/favicon.png') . '"/>';
            }
        }
    }
}

/* Page, Post custom metaboxes */
if ( ! function_exists( 'lvly_metas' ) ) {
    function lvly_metas($pid=false) {
        global $post;
        $metas = array();
        if ( $pid === false && $post ) {
            $pid = $post->ID;
        }
        if ( $pid ) {
            $metas = get_post_meta( $pid, LVLY_META, true );
            if ( ! is_array( $metas ) ) {
                $metas = array();
            }
        }
        return $metas;
    }
}
if ( ! function_exists( 'lvly_meta' ) ) {
    function lvly_meta( $name, $pid=false, $def='' ) {
        $metas = lvly_metas( $pid );
        if ( isset( $metas[ $name ] ) ) {
            return $metas[ $name ];
        }
        return $def;
    }
}
if ( ! function_exists( 'lvly_metas_format' ) ) {
    function lvly_metas_format($pid=false) {
        if (!($metas = lvly_metas($pid))) {
            $metas = array();
        }
        return array_merge(array(
            'gallery_image_ids'=>'',
            'video_embed'=>'',
            'audio_mp3'=>'',
            'audio_embed'=>'',
        ),$metas);
    }
}
if (!function_exists('lvly_update_metas')) {
    function lvly_update_metas($metas,$pid=false) {
        global $post;
        if ($pid===false&&$post) {$pid=$post->ID;}
        if ($pid) {
            return update_post_meta($pid,LVLY_META,$metas);
        }
        return false;
    }
}
if (!function_exists('lvly_update_meta')) {
    function lvly_update_meta($name,$value,$pid=false) {
        global $post;
        if ($pid===false&&$post) {$pid=$post->ID;}
        if ($pid) {
            $metas=lvly_metas($pid);
            $metas[$name]=$value;
            return lvly_update_metas($metas,$pid);
        }
        return false;
    }
}

/* Menu */
if (!function_exists('lvly_social_link')) {
    function lvly_social_link($link) {
        if (!empty($link)) {
            $social = lvly_social_icon(esc_url($link));
            return '<a title="'.esc_attr($social['name']).'" href="'.esc_url($link).'" class="'.esc_attr($social['name']).'"><i class="'.esc_attr($social['class']).'"></i></a>';
        }
    }
}
if (!function_exists('lvly_social_icon')) {
    function lvly_social_icon($url) {
        if (strpos($url,'twitter.com')) {$social['name']='twitter';$social['class']='fa fa-twitter';return $social;}
        if (strpos($url,'linkedin.com')) {$social['name']='linkedin';$social['class']='fa fa-linkedin';return $social;}
        if (strpos($url,'facebook.com')) {$social['name']='facebook';$social['class']='fa fa-facebook';return $social;}
        if (strpos($url,'delicious.com')) {$social['name']='delicious';$social['class']='fa fa-delicious';return $social;}
        if (strpos($url,'codepen.io')) {$social['name']='codepen';$social['class']='fa fa-codepen';return $social;}
        if (strpos($url,'github.com')) {$social['name']='github';$social['class']='fa fa-github';return $social;}
        if (strpos($url,'wordpress.org')||strpos($url,'wordpress.com')) {$social['name']='wordpress';$social['class']='fa fa-wordpress';return $social;}
        if (strpos($url,'youtube.com')) {$social['name']='youtube';$social['class']='fa fa-youtube';return $social;}
        if (strpos($url,'behance.net')) {$social['name']='behance';$social['class']='fa fa-behance';return $social;}
        if (strpos($url,'pinterest.com')) {$social['name']='pinterest';$social['class']='fa fa-pinterest';return $social;}
        if (strpos($url,'foursquare.com')) {$social['name']='foursquare';$social['class']='fa fa-foursquare';return $social;}
        if (strpos($url,'soundcloud.com')) {$social['name']='soundcloud';$social['class']='fa fa-soundcloud';return $social;}
        if (strpos($url,'dribbble.com')) {$social['name']='dribbble';$social['class']='fa fa-dribbble';return $social;}
        if (strpos($url,'instagram.com')) {$social['name']='instagram';$social['class']='fa fa-instagram';return $social;}
        if (strpos($url,'plus.google')) {$social['name']='google';$social['class']='fa fa-google-plus';return $social;}
        if (strpos($url,'reddit.com')) {$social['name']='reddit';$social['class']='fa fa-reddit';return $social;}
        if (strpos($url,'vimeo.com')) {$social['name']='vimeo';$social['class']='fa fa-vimeo';return $social;}
        if (strpos($url,'twitch.tv')) {$social['name']='twitch';$social['class']='fa fa-twitch';return $social;}
        if (strpos($url,'tumblr.com')) {$social['name']='tumblr';$social['class']='fa fa-tumblr';return $social;}
        if (strpos($url,'trello.com')) {$social['name']='trello';$social['class']='fa fa-trello';return $social;}
        if (strpos($url,'spotify.com')) {$social['name']='spotify';$social['class']='fa fa-spotify';return $social;}
        if (strpos($url,'rss')) {$social['name']='feed';$social['class']='fa fa-rss';return $social;}

        $social['name']='custom';$social['class']='fa fa-link';
        $social['name']='tel';$social['class']='fa fa-phone';
        return $social;
    }
}

if (!function_exists('lvly_menu_social_links')) {
    function lvly_menu_social_links() {
        $social_links = lvly_get_option('social_links');
        if ( ! empty( $social_links ) && is_array( $social_links ) ) {
            echo '<div class="tw-header-social-links">';
                foreach( $social_links as $social_link ) {
                    $icon = $title = '';

                    if       ( strpos($social_link,'twitter.com')   !== false ) {
                        $title = 'twitter';
                        $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.8499 5.6564C14.3931 5.65621 13.9419 5.75746 13.5289 5.95282C13.116 6.14819 12.7515 6.4328 12.4619 6.78612C12.1723 7.13944 11.9648 7.55265 11.8543 7.99593C11.7438 8.43921 11.7331 8.90149 11.8229 9.3494C11.8539 9.5046 11.8475 9.66493 11.8044 9.8172C11.7613 9.96947 11.6827 10.1093 11.575 10.2253C11.4674 10.3413 11.3337 10.43 11.1851 10.4843C11.0364 10.5386 10.877 10.5568 10.7199 10.5374C8.56965 10.2733 6.54264 9.38936 4.88592 7.9934C4.91691 8.5954 5.12591 9.2354 5.57891 9.9054L6.25791 10.9094L5.14292 11.3844L4.92791 11.4764C5.08791 11.6594 5.27991 11.8464 5.49491 12.0314C5.78233 12.2774 6.08639 12.5033 6.40491 12.7074L6.41591 12.7144H6.41691L7.96491 13.6534L6.34491 14.4634C6.26491 14.5034 6.18491 14.5394 6.10491 14.5714C6.45325 14.8609 6.837 15.1048 7.24691 15.2974L8.63691 15.9544L7.47291 16.9584C6.83791 17.5064 6.19891 17.9154 5.36991 18.1314C6.64135 18.8086 8.06036 19.1614 9.50091 19.1584C14.3069 19.1584 18.1769 15.3234 18.1769 10.6244V10.1044L18.6019 9.8054C19.2659 9.3394 19.7349 8.7094 20.0709 7.9884H17.9109L17.6389 7.4184C17.3884 6.89107 16.9935 6.4456 16.5 6.13372C16.0065 5.82183 15.4347 5.65632 14.8509 5.6564H14.8499ZM3.56991 12.9564C3.47555 13.0645 3.40554 13.1916 3.36465 13.3291C3.32376 13.4666 3.31293 13.6113 3.33291 13.7534C3.44591 14.5544 3.92491 15.2444 4.45491 15.7714C4.59891 15.9144 4.75291 16.0514 4.91491 16.1824L4.83992 16.2024C4.35892 16.3224 3.70991 16.3474 2.62891 16.2424C2.42477 16.2224 2.21941 16.2656 2.04067 16.3662C1.86193 16.4669 1.71845 16.62 1.6297 16.8049C1.54095 16.9899 1.51121 17.1976 1.54452 17.4C1.57783 17.6024 1.67258 17.7897 1.81591 17.9364C2.81669 18.9593 4.01221 19.7714 5.33194 20.3248C6.65167 20.8782 8.06886 21.1616 9.49991 21.1584C15.2129 21.1584 19.8989 16.7224 20.1639 11.1244C21.4539 10.0414 22.0989 8.5744 22.4469 7.2414C22.4856 7.09346 22.4898 6.9386 22.4593 6.78876C22.4288 6.63891 22.3643 6.49806 22.2708 6.37705C22.1773 6.25603 22.0573 6.15807 21.92 6.09069C21.7827 6.02332 21.6318 5.98832 21.4789 5.9884H19.1259C18.5504 5.09473 17.7093 4.40384 16.7208 4.01284C15.7324 3.62183 14.6462 3.55035 13.6151 3.80845C12.5839 4.06654 11.6595 4.64124 10.9718 5.45178C10.2841 6.26232 9.86762 7.26797 9.78091 8.3274C7.93757 7.84755 6.28825 6.80821 5.05991 5.3524C4.95113 5.22379 4.81162 5.12473 4.65433 5.06444C4.49704 5.00414 4.32707 4.98455 4.16019 5.00749C3.99331 5.03044 3.83492 5.09516 3.69974 5.19567C3.56456 5.29618 3.45695 5.4292 3.38691 5.5824C2.78091 6.9044 2.66491 8.4284 3.34091 9.9784L3.10691 10.0784C2.88299 10.1738 2.70155 10.3476 2.59662 10.5673C2.49168 10.7869 2.47046 11.0372 2.53691 11.2714C2.72291 11.9234 3.14091 12.4994 3.56891 12.9564H3.56991Z" fill="#929AB9"/></svg>';
                    } elseif ( strpos($social_link,'facebook.com')  !== false ) {
                        $title = 'facebook';
                        $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2 6C2 4.93913 2.42143 3.92172 3.17157 3.17157C3.92172 2.42143 4.93913 2 6 2H18C19.0609 2 20.0783 2.42143 20.8284 3.17157C21.5786 3.92172 22 4.93913 22 6V18C22 19.0609 21.5786 20.0783 20.8284 20.8284C20.0783 21.5786 19.0609 22 18 22H6C4.93913 22 3.92172 21.5786 3.17157 20.8284C2.42143 20.0783 2 19.0609 2 18V6ZM6 4C5.46957 4 4.96086 4.21071 4.58579 4.58579C4.21071 4.96086 4 5.46957 4 6V18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20H12V13H11C10.7348 13 10.4804 12.8946 10.2929 12.7071C10.1054 12.5196 10 12.2652 10 12C10 11.7348 10.1054 11.4804 10.2929 11.2929C10.4804 11.1054 10.7348 11 11 11H12V9.5C12 8.57174 12.3687 7.6815 13.0251 7.02513C13.6815 6.36875 14.5717 6 15.5 6H16.1C16.3652 6 16.6196 6.10536 16.8071 6.29289C16.9946 6.48043 17.1 6.73478 17.1 7C17.1 7.26522 16.9946 7.51957 16.8071 7.70711C16.6196 7.89464 16.3652 8 16.1 8H15.5C15.303 8 15.108 8.0388 14.926 8.11418C14.744 8.18956 14.5786 8.30005 14.4393 8.43934C14.3001 8.57863 14.1896 8.74399 14.1142 8.92597C14.0388 9.10796 14 9.30302 14 9.5V11H16.1C16.3652 11 16.6196 11.1054 16.8071 11.2929C16.9946 11.4804 17.1 11.7348 17.1 12C17.1 12.2652 16.9946 12.5196 16.8071 12.7071C16.6196 12.8946 16.3652 13 16.1 13H14V20H18C18.5304 20 19.0391 19.7893 19.4142 19.4142C19.7893 19.0391 20 18.5304 20 18V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4H6Z" fill="#929AB9"/></svg>';
                    } elseif ( strpos($social_link,'youtube.com')   !== false ) {
                        $title = 'youtube';
                        $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.84475 4.77475C10.4368 4.40775 13.5628 4.40775 16.1548 4.77475C18.5098 5.10875 20.3348 6.76075 20.6828 8.54075C21.1058 10.6958 21.1058 13.3038 20.6828 15.4587C20.3337 17.2387 18.5098 18.8908 16.1548 19.2248C13.5628 19.5918 10.4358 19.5918 7.84475 19.2248C5.48975 18.8908 3.66575 17.2387 3.31675 15.4587C2.89375 13.3038 2.89375 10.6958 3.31675 8.54075C3.66575 6.76075 5.48975 5.10875 7.84475 4.77475ZM16.4347 2.79475C13.6577 2.40175 10.3418 2.40175 7.56475 2.79475C4.54975 3.22175 1.89975 5.37275 1.35475 8.15675C0.88175 10.5658 0.88175 13.4338 1.35475 15.8428C1.89975 18.6268 4.54975 20.7778 7.56475 21.2048C10.3418 21.5977 13.6577 21.5977 16.4347 21.2048C19.4497 20.7778 22.0998 18.6268 22.6448 15.8428C23.1178 13.4338 23.1178 10.5658 22.6448 8.15675C22.0998 5.37275 19.4497 3.22175 16.4347 2.79475ZM10.5548 7.16775C10.4042 7.06727 10.2291 7.00956 10.0483 7.00078C9.86744 6.99199 9.68761 7.03247 9.52798 7.11788C9.36835 7.20329 9.23491 7.33043 9.14188 7.48574C9.04884 7.64105 8.99972 7.81871 8.99975 7.99975V15.9998C8.99972 16.1808 9.04884 16.3584 9.14188 16.5138C9.23491 16.6691 9.36835 16.7962 9.52798 16.8816C9.68761 16.967 9.86744 17.0075 10.0483 16.9987C10.2291 16.9899 10.4042 16.9322 10.5548 16.8318L16.5548 12.8317C16.6917 12.7404 16.804 12.6167 16.8817 12.4716C16.9593 12.3264 17 12.1644 17 11.9998C17 11.8351 16.9593 11.6731 16.8817 11.5279C16.804 11.3828 16.6917 11.2591 16.5548 11.1678L10.5548 7.16775ZM14.1967 11.9998L10.9998 14.1318V9.86875L14.1967 11.9998Z" fill="#929AB9"/></svg>';
                    } elseif ( strpos($social_link,'instagram.com') !== false ) {
                        $title = 'instagram';
                        $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M2 6C2 4.93913 2.42143 3.92172 3.17157 3.17157C3.92172 2.42143 4.93913 2 6 2H18C19.0609 2 20.0783 2.42143 20.8284 3.17157C21.5786 3.92172 22 4.93913 22 6V18C22 19.0609 21.5786 20.0783 20.8284 20.8284C20.0783 21.5786 19.0609 22 18 22H6C4.93913 22 3.92172 21.5786 3.17157 20.8284C2.42143 20.0783 2 19.0609 2 18V6ZM6 4C5.46957 4 4.96086 4.21071 4.58579 4.58579C4.21071 4.96086 4 5.46957 4 6V18C4 18.5304 4.21071 19.0391 4.58579 19.4142C4.96086 19.7893 5.46957 20 6 20H18C18.5304 20 19.0391 19.7893 19.4142 19.4142C19.7893 19.0391 20 18.5304 20 18V6C20 5.46957 19.7893 4.96086 19.4142 4.58579C19.0391 4.21071 18.5304 4 18 4H6ZM12 9C11.2044 9 10.4413 9.31607 9.87868 9.87868C9.31607 10.4413 9 11.2044 9 12C9 12.7956 9.31607 13.5587 9.87868 14.1213C10.4413 14.6839 11.2044 15 12 15C12.7956 15 13.5587 14.6839 14.1213 14.1213C14.6839 13.5587 15 12.7956 15 12C15 11.2044 14.6839 10.4413 14.1213 9.87868C13.5587 9.31607 12.7956 9 12 9ZM7 12C7 10.6739 7.52678 9.40215 8.46447 8.46447C9.40215 7.52678 10.6739 7 12 7C13.3261 7 14.5979 7.52678 15.5355 8.46447C16.4732 9.40215 17 10.6739 17 12C17 13.3261 16.4732 14.5979 15.5355 15.5355C14.5979 16.4732 13.3261 17 12 17C10.6739 17 9.40215 16.4732 8.46447 15.5355C7.52678 14.5979 7 13.3261 7 12ZM17.5 8C17.8978 8 18.2794 7.84196 18.5607 7.56066C18.842 7.27936 19 6.89782 19 6.5C19 6.10218 18.842 5.72064 18.5607 5.43934C18.2794 5.15804 17.8978 5 17.5 5C17.1022 5 16.7206 5.15804 16.4393 5.43934C16.158 5.72064 16 6.10218 16 6.5C16 6.89782 16.158 7.27936 16.4393 7.56066C16.7206 7.84196 17.1022 8 17.5 8Z" fill="#929AB9"/></svg>';
                    }

                    if ( $icon ) {
                        echo '<a href="' . esc_url( $social_link ) . '" title="' . esc_attr( $title ) . '">' . $icon . '</a>';
                    }
                }
            echo '</div>';
        }
    }
}

/* Menu */
if (!function_exists('lvly_menu')) {
    function lvly_menu() {
        $menu_args = array(
            'walker' => new Lvly_Menu(),
            'container' => false,
            'menu_id' => '',
            'menu_class' => 'tw-main-menu moc uk-visible@m',
            'fallback_cb' => 'lvly_nomenu',
            'theme_location' => 'main',
        );
        if ($nav_menu = lvly_meta('page_menu')) {
            $menu_args['menu'] = $nav_menu;
        }
        wp_nav_menu($menu_args);
    }
}
// if (!function_exists('lvly_menu_menutop')) {
//     function lvly_menu_menutop() {
//         $menu_args = array(
//             'walker' => new Lvly_Menu_Top(),
//             'container' => false,
//             'menu_id' => '',
//             'menu_class' => 'tw-main-menu uk-visible@m topbar',
//             'fallback_cb' => 'lvly_nomenu',
//             'theme_location' => 'menutop',
//             'echo' => false
//         );
//         if ($nav_menu = lvly_meta('page_menu')) {
//             $menu_args['menu'] = $nav_menu;
//         }
//         return wp_nav_menu($menu_args);
//     }
// }


// if ( ! function_exists( 'lvly_menu_menutop' ) ) {
//     function lvly_menu_menutop() {
//         return '';
//     }
// }

if (!function_exists('lvly_nomenu')) {
    function lvly_nomenu() {
        echo "<ul class='tw-main-menu tw-list-pages uk-visible@m'>";
        wp_list_pages(array('title_li' => ''));
        echo "</ul>";
    }
}
/* Mobile Menu */
if (!function_exists('lvly_mobilemenu_convert')) {
    function lvly_mobilemenu_convert($output) {
        return str_replace(array(' %uk-nav%"',' menu-item-has-children '), array('" data-uk-nav',' uk-parent '),$output);
    }
}
if (!function_exists('lvly_mobilemenu')) {
    function lvly_mobilemenu() {            
        $menu_args = array(
            'walker' => new Lvly_Menu_Mobile(),
            'container' => false,
            'menu_id' => '',
            'menu_class' => 'uk-nav-default uk-nav-parent-icon %uk-nav%',
            'fallback_cb' => 'lvly_mobilemenu_main',
            'theme_location' => 'mobile'
        );
        if ($nav_menu = lvly_meta('page_menu')) {
            $menu_args['menu'] = $nav_menu;
        }
        ob_start();
        wp_nav_menu($menu_args);
        echo lvly_mobilemenu_convert(ob_get_clean());
    }
}
if (!function_exists('lvly_mobilemenu_main')) {
    function lvly_mobilemenu_main() {
        $menu_args = array(
            'walker' => new Lvly_Menu_Mobile(),
            'container' => false,
            'menu_id' => '',
            'menu_class' => 'uk-nav-default uk-nav-parent-icon %uk-nav%',
            'fallback_cb' => 'lvly_nomobilemenu',
            'theme_location' => 'main'
        );
        if ($nav_menu = lvly_meta('page_menu')) {
            $menu_args['menu'] = $nav_menu;
        }
        ob_start();
        wp_nav_menu($menu_args);
        echo lvly_mobilemenu_convert(ob_get_clean());
    }
}
if (!function_exists('lvly_nomobilemenu')) {
    function lvly_nomobilemenu() {
        echo '<ul class="uk-nav-default uk-nav-parent-icon tw-mobile-list-pages" data-uk-nav>';
            wp_list_pages(array('title_li' => ''));
        echo '</ul>';
    }
}

/* Sidebar Menu */
if (!function_exists('lvly_sidemenu_convert')) {
    function lvly_sidemenu_convert($output) {
        return str_replace(array('uk-navbar-dropdown','uk-navbar-dropdown-grid','data-uk-drop="'), array('sub-menu uk-animation-fade','','data-disable-uk-drop="'),$output);
    }
}
if (!function_exists('lvly_sidemenu')) {
    function lvly_sidemenu() {
        ob_start();
            lvly_menu();
        echo lvly_sidemenu_convert(ob_get_clean());
    }
}

/* Blog */
if (!function_exists('lvly_author')) {
    function lvly_author() {
        $description = get_the_author_meta('description');
        if ( $description ) { ?>
            <div class="tw-author">
                <div class="author-box"><?php
                    $tw_author_email = get_the_author_meta('email');
                    echo get_avatar($tw_author_email, $size = '120'); ?>
                    <h3><?php
                        if ( is_author() ) {
                            the_author();
                        } else {
                            the_author_posts_link();
                        } ?>
                    </h3><?php
                    echo '<span class="tw-meta">'.lvly_get_option('text_writer', esc_html__('writer', 'lvly')) .'</span>';
                    echo '<p>';
                        echo esc_html( $description );
                    echo '</p>';
                    $socials = get_the_author_meta('user_social');
                    if (!empty($socials)) {
                        echo '<div class="tw-socials tw-social-light with-hover">';
                        $social_links=explode("\n",$socials);
                        foreach($social_links as $social_link) {
                            $icon = lvly_social_icon(esc_url($social_link));
                            echo '<a href="'.esc_url($social_link).'"><i class="'.esc_attr($icon['class']).'"></i></a>';
                        }
                        echo '</div>';
                    } ?>
                </div>
            </div><?php
        }
    }
}
if (!function_exists('lvly_comment_count')) {
    function lvly_comment_count() {
        if (comments_open()) {
            $comment_count = get_comments_number('0', '1', '%');
            $comment_trans = $comment_count . ' <span class="comment-label">' . esc_html__('comments', 'lvly').'</span>';
            if ($comment_count == 0) {
                $comment_trans = '<span class="comment-label">'.esc_html__('no comment', 'lvly').'</span>';
            } elseif ($comment_count == 1) {
                $comment_trans = '1 <span class="comment-label">'. esc_html__('comment', 'lvly').'</span>';
            }
            return '<a class="comment-count" href="' . esc_url(get_comments_link()) . '" title="' . esc_attr($comment_trans) . '"><i class="ion-chatbubbles"></i><span>' . ($comment_trans) . '</span></a>';
        } else {
            $comment_trans = esc_html__('disabled', 'lvly');
            return '<a class="comment-count" href="' . esc_url(get_comments_link()) . '" title="' . esc_attr($comment_trans) . '"><i class="ion-chatbubbles"></i><span>' . ($comment_trans) . '</span></a>';
        }
    }
}
/* Share */
if (!function_exists('lvly_share_count')) {
    function lvly_share_count($social='',$pid=false) {
        $count = 0;
        if ($social) {$count = lvly_meta('share_count_' . $social, $pid);}
        return intval($count);
    }
}
add_action( 'wp_ajax_lvly_share_ajax', 'lvly_share_ajax' );
add_action( 'wp_ajax_nopriv_lvly_share_ajax', 'lvly_share_ajax' );

function lvly_share_ajax() {
    if (isset($_REQUEST['social_pid']) && isset($_REQUEST['social_name'])) {
        lvly_update_meta('share_count_' . sanitize_text_field(wp_unslash($_REQUEST['social_name'])),lvly_share_count(sanitize_text_field(wp_unslash($_REQUEST['social_name'],$_REQUEST['social_pid']))) + 1,sanitize_text_field(wp_unslash($_REQUEST['social_pid'])));
    }
    wp_die();
}
if (!function_exists('lvly_image')) {
    function lvly_image($size = 'full', $returnURL = false) {
        global $post;
        $attachment = get_post( get_post_thumbnail_id( $post->ID ) );
        if (!empty($attachment)) {
            if ($returnURL) {
                $img = array();
                $lrg_img = wp_get_attachment_image_src($attachment->ID, $size);
                if ( ! empty( $lrg_img ) ) {
                    $url = $lrg_img[0];
                    $width = $lrg_img[1];
                    $height = $lrg_img[2];
                    $alt0 = lvly_meta('_wp_attachment_image_alt',$attachment->ID);
                    $alt = empty($alt0)?$attachment->post_title:$alt0;
                    $img['url'] = $url;
                    $img['alt'] = $alt;
                    $img['width'] = $width;
                    $img['height'] = $height;
                }
                return $img;
            } else {
                return get_the_post_thumbnail( $post->ID, $size );
            }
        }
    }
}

if (!function_exists('lvly_single_title')) {
    function lvly_single_title() {
        echo '<div class="single-title-container">';
            if (lvly_get_option('single_cats')) {
                echo '<div class="entry-cats tw-meta">'.get_the_category_list(', ').'</div>';
            }
            echo '<h2 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h2>';
            if (lvly_get_option('single_meta')) {
                echo '<div class="entry-date tw-meta">';
                    echo '<span>'.esc_attr(get_the_time(get_option('date_format'))).'</span>&nbsp;&nbsp;/&nbsp;&nbsp;';  
                    echo '<span class="entry-author">'.esc_html_e('By ', 'lvly').' ';
                        the_author_posts_link();
                    echo '</span>';
                echo '</div>';
            }
        echo '</div>';
    }
}

if (!function_exists('lvly_cats')) {
    function lvly_cats( $sep = ', ', $before = '' ) {
        $cats = '';
        foreach((get_the_category()) as $category) {
            $options = get_option( "taxonomy_" . $category->cat_ID );
            if (!isset($options['featured']) || !$options['featured']) {
                $cats .= '<div class="cat-item"><span>'  . $before . $category->name . '</span>' . ( $sep ? ( '<span>' . $sep . '</span>' ) : '' ) . '</div>';
            }
        }
        if (!$cats && is_search()) {
            $cats = '<div class="cat-item"><span href="' . get_permalink() . '">' . esc_html__('Page', 'lvly') . '</span></div>';
        }
        return $cats;
    }
}

if (!function_exists('lvly_blogcontent')) {
    function lvly_blogcontent($atts) {
        global $more,$post;
        $more = 0;
        if ( ! empty( $atts['excerpt_count'] ) ) {
            /* $atts['excerpt_count']!==0 */
            $atts['excerpt_count'] = intval( $atts['excerpt_count'] );
            if (has_excerpt()) {
                the_excerpt();
            } elseif ( $atts['excerpt_count'] > 0 ) {
                $more = 1;
                $str = wp_strip_all_tags( do_shortcode( get_the_content() ) );
                echo '<p>' . lvly_excerpt( $str, $atts['excerpt_count'] ) . '</p>';
            } else {
                the_content( isset( $atts['more_text'] ) ? $atts['more_text'] : '' );
            }
            
        }
    }
}

if (!function_exists('lvly_excerpt')) {
    function lvly_excerpt($str, $length) {
        $str = explode(" ", strip_tags($str));
        return implode(" ", array_slice($str, 0, $length));
    }
}

if (!function_exists('lvly_read_more_link')) {
    add_filter('the_content_more_link', 'lvly_read_more_link', 10, 2);
    function lvly_read_more_link($output, $read_more_text) {
        $output = '<p class="more-link"><a class="uk-button uk-button-default uk-button-small uk-button-radius tw-hover" href="'.esc_url(get_permalink()).'"><span class="tw-hover-inner"><span>'.($read_more_text).'</span><i class="ion-ios-arrow-thin-right"></i></span></a></p>';
        return $output;
    }
}

// if (!function_exists('lvly_seen_add')) {
//     function lvly_seen_add() {
//         $seen = lvly_meta('post_seen');
//         $seen = intval($seen)+1;
//         lvly_update_meta('post_seen',$seen);
//     }
// }
if (!function_exists('lvly_standard_media')) {
    function lvly_standard_media($post, $atts) {
        $output = '';
        if (has_post_thumbnail($post->ID)) {
            $output .= '<div class="tw-thumbnail">';
                if (is_single($post)) {
                    $img = lvly_image('full', true);
                    $output .= lvly_image($atts['img_size']);
                    $output .= '<div class="image-overlay"><a href="' . esc_url($img['url']) . '" title="' . esc_attr(get_the_title()) . '"></a></div>';
                } else {
                    $output .= '<a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '" class="tw-image-hover">'.lvly_image($atts['img_size']).'</a>';
                }
            $output .= '</div>';
        }
        return $output;
    }
}
if ( ! function_exists( 'lvly_entry_media' ) ) {
    function lvly_entry_media( $format, $atts, $force = false ) {
        global $post;
        $output = $data = $class = '';
        if ( ! is_single() && has_post_thumbnail( $post->ID ) && ! $force ) {
            $output .= lvly_standard_media( $post, $atts );
        } else {
            $meta = lvly_metas_format();
            switch ( $format ) {
                case 'gallery':
                    $images = explode(',', $meta['gallery_image_ids']);
                    if ($images) {
                        wp_enqueue_script('owl-carousel');
                        $output .= '<div class="tw-element tw-owl-carousel-container uk-light" data-dots="inside" data-nav="true">';
                            $output .= '<div class="owl-carousel onhover owl-theme" data-uk-scrollspy="target: .shop-item; cls:uk-animation-slide-bottom-medium; delay: 300;">';
                                foreach ($images as $image) {
                                    $img = wp_get_attachment_image_src($image, $atts['img_size']);
                                    if ($image&&$img) {
                                        $desc = get_post_field('post_excerpt', $image);
                                        $output .= '<div class="gallery-item"><div class="shop-content"><img src="' . esc_url($img[0]) . '"' . ($desc ? ' alt="' . $desc . '"' : '') . ' /></div></div>';
                                    }
                                }
                            $output .= '</div>';
                        $output .= '</div>';
                    }
                    break;

                case 'video':
                    $embedWP='';
                    $embed = $meta['video_embed'];
                    if (wp_oembed_get($embed)) {
                        $embedWP .= wp_oembed_get($embed);
                    } elseif (!empty($embed)) {
                        $embedWP .= apply_filters("the_content", wp_specialchars_decode($embed));
                    }
                    if ($embedWP) {
                        $class .=' tw-video uk-background-cover';
                        $data .= ' data-video-target=".tw-video-container" style="min-height:'.intval(empty($meta['video_min_height'])?'450':$meta['video_min_height']).'px; background-image: url('.esc_url(lvly_image($atts['img_size'],true)['url']).');"';
                        $output .= '<div class="tw-thumbnail"><button type="button" class="tw-video-icon"><span class="before"></span><i class="ion-play"></i><span class="after"></span></button></div><div class="tw-video-container tw-invis"><div class="tw-video-frame" data-video-embed="'.esc_attr($embedWP).'"></div></div>';
                    }
                    break;

                case 'audio':

                    $mp3   = $meta['audio_mp3'];
                    $embed = $meta['audio_embed'];
                    if ($mp3) {
                        $output .= apply_filters("the_content", '[audio src="' . esc_url($mp3) . '"]');
                    } elseif (wp_oembed_get($embed)) {
                        $output .= wp_oembed_get($embed);
                    } elseif (!empty($embed)) {
                        $output .= apply_filters("the_content", wp_specialchars_decode($embed));
                    }
                    break;
                
                case 'quote':
                    if (!empty($meta['quote_text'])) {
                        $author = $bgimage = '';
                        if (!empty($meta['quote_bgimage'])) {
                            $bgimage = '<div class="testimonial-bgimage" style="background-image:url('.esc_url($meta['quote_bgimage']).')"></div>';
                        }
                        if (!empty($meta['quote_author'])) {
                            $author = '<div class="testimonial-author">'.esc_attr($meta['quote_author']).'</div>';
                        }
                        $output .= '<div class="testimonial">';
                            $output .= '<div class="testimonial-content">'.($bgimage).'<p>'.esc_html($meta['quote_text']).'</p>'.($author). ( empty( $atts['inside'] ) ? ( '<div class="tw-meta tw-datetime"><a href="' . esc_url( get_permalink() ) . '">' . esc_attr( get_the_time( get_option( 'date_format' ) ) ) . '</a></div>' ) : '' ) .'</div>';
                        $output .= '</div>';
                    }
                    break;
                    
                case 'status':
                    if ( ! empty ( $meta['status_url'] ) ) {
                        $status = apply_filters( "the_content", str_replace( '&quot;', '', $meta['status_url'] ) );
                        if ( strpos( $status, 'class="twitter-tweet"' ) === false ) { // important use === false. Do not remove === false.
                            $output .= $status;
                        } else {
                            libxml_use_internal_errors( true );
                            $dom = new DomDocument();
                            $dom->loadHTML( $status );
                            $xpath = new DOMXPath( $dom );
                            libxml_clear_errors();
                            $nodes = $xpath->query( '//blockquote' );
                            $twt = $nodes->item( 0 );
                            $tweetDateLink      = $xpath->query( '(//a)[last()]', $twt )->item( 0 );
                            $tweetDateLinkURL   = $tweetDateLink->getAttribute( 'href' );
                            $tweetDateLinkTime  = strtotime( $tweetDateLink->nodeValue );
                            $tweetUserName = explode( '/', str_replace( array( 'http://twitter.com/', 'https://twitter.com/', '//twitter.com/', 'twitter.com/' ), '', $tweetDateLinkURL ) )[0];
                            $newHTML_Last  = '<p class="tweet-user"><a href="' . esc_url( 'https://twitter.com/' . $tweetUserName ) . '">@' . esc_attr( $tweetUserName ) . '</a></p>';
                            $newHTML_Last .= '<span class="tweet-posted tw-meta"><a href="' . esc_url( $tweetDateLinkURL ) . '">' . human_time_diff( $tweetDateLinkTime ) . esc_html__( ' ago', 'lvly' ) . '</a></span>';
                            $tweetDateLinkParent = $tweetDateLink->parentNode;
                            if ( $tweetDateLinkParent->tagName != 'blockquote' ) {
                                $tweetDateLinkParent->parentNode->removeChild( $tweetDateLinkParent );
                            }
                            $twtChilds  = $twt->childNodes;
                            $output .= '<blockquote class="blockquote-tweet">';
                                $output .= '<i class="icon-twitter fa fa-twitter"></i>';
                                foreach ( $twtChilds as $twtChild ) { 
                                    $output .= $twtChild->ownerDocument->saveHTML( $twtChild );
                                }
                                $output .= $newHTML_Last;
                            $output .= '</blockquote>';
                        }
                    }
                    break;
                    
                case 'link':
                if (!empty($meta['link_url'])) {
                    $author = $bgimage = '';
                    if (!empty($meta['link_bgimage'])) {
                        $bgimage = '<div class="testimonial-bgimage" style="background-image:url('.esc_url($meta['link_bgimage']).')"></div>';
                    }
                    $output .= '<div class="testimonial">';
                        $output .= '<div class="testimonial-content">'.($bgimage).'<a href="'.esc_url($meta['link_url']).'">'.get_the_title().'</a></div>';
                    $output .= '</div>';
                }
                break;
            }
            /* Standard OR Other Formats are Emtpy */
            if (empty($output)) {
                $output .= lvly_standard_media($post, $atts);
            }
        }
        /* if OUTPUT is not empty then add outer (IMPORTANT: Don't merge two IF checks.) */
        if ($output) {$output= '<div class="entry-media uk-responsive-width'.$class.'"'.($data).'>'.$output.'</div>';}
        return $output;
    }
}
if ( ! function_exists( 'lvly_portfolio_gallery_slider' ) ) {
    function lvly_portfolio_gallery_slider( $atts ) {
        $output = '';
        $class = 'tw-gallery-carousel';

        if ( ! empty( $atts['gallery_light'] ) ) {
            $class .= ' uk-light';
        }

        if ( ! empty( $atts['gallery'] ) ) {
            wp_enqueue_script( 'owl-carousel' );
            $images = explode( ',', $atts['gallery'] );
            $output .= '<div class="' . esc_attr( $class ) . '" data-nav="' . esc_attr( empty( $atts['gallery_nav'] ) ? 'false' : 'true' ) . '" data-dots="' . esc_attr( empty( $atts['gallery_dots'] ) ? 'false' : $atts['gallery_dots'] ) . '" data-center="' . esc_attr( empty( $atts['gallery_center'] ) ? '' : 'true' ) . '">';
                $output .= '<div class="owl-carousel owl-theme">';
                    foreach( $images as $image ) {
                        if ( $image && $img = wp_get_attachment_image_src( $image, 'full' ) ) {
                            $desc = get_post_field( 'post_excerpt', $image );
                            $output .= '<div class="carousel-item">';
                                $output .= '<img src="' . esc_url( $img[0] ) . '"' . ( $desc ? ' alt="' . esc_attr( $desc ) . '"' : '' ) . ' />';
                            $output .= '</div>';
                        }
                    }
                $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_gallery_1')) {
    function lvly_portfolio_gallery_1($atts) {
        $output = '';
        if (!empty($atts['gallery'])) {
            wp_enqueue_script( 'isotope' );
            $images = explode(',', $atts['gallery']);
            $output .= '<div class="tw-element tw-gallery tw-isotope-container" data-isotope-item=".gallery-item">';
                $output .= '<div class="isotope-container uk-grid-xsmall uk-child-width-1-1" data-uk-grid>';
                
                foreach($images as $image) {
                    if ($image && $img=wp_get_attachment_image_src($image, 'full')) {
                        $description = '';
                        $desc = get_post_field('post_excerpt', $image);
                        if ($desc) {
                            $description = ' alt="' . esc_attr($desc) . '"';
                        }
                        $output .= '<div class="gallery-item"><div class="gallery-image">';
                                $output .= '<img src="' . esc_url($img[0]) . '"' . ($description) . ' />';
                        $output .= '</div></div>';
                    }
                }
                $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_gallery_2')) {
    function lvly_portfolio_gallery_2($atts) {
        $output = '';
        if (!empty($atts['gallery'])) {
            wp_enqueue_script( 'isotope' );
            $images = explode(',', $atts['gallery']);
            $output .= '<div class="tw-element tw-gallery tw-isotope-container" data-isotope-item=".gallery-item">';
                $output .= '<div class="isotope-container uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@s" data-uk-grid data-uk-lightbox="toggle: .tw-image-hover;">';
                
                foreach($images as $image) {
                    if ($image && $img=wp_get_attachment_image_src($image, 'full')) {
                        $description = $caption = '';
                        $desc = get_post_field('post_excerpt', $image);
                        if ($desc) {
                            $description = ' alt="' . esc_attr($desc) . '"';
                            $caption = ' data-caption="' . esc_attr($desc) . '"';
                        }
                        $output .= '<div class="gallery-item"><div class="gallery-image">';
                            $output .= '<a href="'.esc_url($img[0]).'" class="tw-image-hover"'. ($caption) .'>';
                                $output .= '<img src="' . esc_url($img[0]) . '"' . ($description) . ' />';
                            $output .= '</a>';
                        $output .= '</div></div>';
                    }
                }
                $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_gallery_3')) {
    function lvly_portfolio_gallery_3($atts) {
        $output = '';
        if (!empty($atts['gallery'])) {
            wp_enqueue_script( 'isotope' );
            $images = explode(',', $atts['gallery']);
            $output .= '<div class="tw-element tw-gallery tw-isotope-container" data-isotope-item=".gallery-item">';
                $output .= '<div class="isotope-container uk-grid-medium uk-child-width-1-1@xxs uk-child-width-1-2@xs uk-child-width-1-2@s uk-child-width-1-3@m" data-uk-grid data-uk-lightbox="toggle: .tw-image-hover;">';
                
                foreach($images as $image) {
                    if ($image && $img=wp_get_attachment_image_src($image, 'full')) {
                        $description = $caption = '';
                        $desc = get_post_field('post_excerpt', $image);
                        if ($desc) {
                            $description = ' alt="' . esc_attr($desc) . '"';
                            $caption = ' data-caption="' . esc_attr($desc) . '"';
                        }
                        $output .= '<div class="gallery-item"><div class="gallery-image">';
                            $output .= '<a href="'.esc_url($img[0]).'" class="tw-image-hover"'. ($caption) .'>';
                                $output .= '<img src="' . esc_url($img[0]) . '"' . ($description) . ' />';
                            $output .= '</a>';
                        $output .= '</div></div>';
                    }
                }
                $output .= '</div>';
            $output .= '</div>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_video')) {
    function lvly_portfolio_video($atts) {
        $output = '';
        if (!empty($atts['video_embed'])) {
            if (wp_oembed_get($atts['video_embed'])) {
                $embed = wp_oembed_get($atts['video_embed']);
            } else {
                $embed = apply_filters("the_content", wp_specialchars_decode($atts['video_embed']));
            }
            $image = lvly_image('full', true);
            if (empty($image['url'])) {
                $output .= ($embed);
            } else {
                $output= '<div class="entry-media uk-responsive-width tw-video uk-background-cover" data-video-target=".tw-video-container" style="background-image: url(' . esc_url( $image['url'] ) . ');"><div class="tw-thumbnail"><button type="button" class="tw-video-icon"><span class="before"></span><i class="ion-play"></i><span class="after"></span></button></div><div class="tw-video-container tw-invis"><div class="tw-video-frame" data-video-embed="' . esc_attr( $embed ) . '"></div></div></div>';
            }
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_date')) {
    function lvly_portfolio_date() {
        $output = '';
        $output .= '<li>';
            $output .= '<h3 class="portfolio-subtitle">'.esc_html__('Date', 'lvly').'</h3>';
            $output .= '<div class="portfolio-meta">'.esc_html(get_the_time(get_option('date_format'))).'</div>';
        $output .= '</li>';
        return $output;
    }
}
if (!function_exists('lvly_portfolio_cats')) {
    function lvly_portfolio_cats($post) {
        $output = '';
        $cats = get_the_term_list( $post->ID, 'portfolio_cat', '', ', ', '' );
        if ($cats) {
            $output .= '<li>';
                $output .= '<h3 class="portfolio-subtitle">'.esc_html__('Categories', 'lvly').'</h3>';
                $output .= '<div class="portfolio-meta">'.($cats).'</div>';
            $output .= '</li>';
        } 
        return $output;
    }
}
if (!function_exists('lvly_portfolio_client')) {
    function lvly_portfolio_client($atts) {
        $output = '';
        if (!empty($atts['client_name'])) {
            if (!empty($atts['client_link'])) {
                $atts['client_name'] = '<a href="'.esc_url($atts['client_link']).'">'.esc_html($atts['client_name']).'</a>';
            }
            $output .= '<li>';
                $output .= '<h3 class="portfolio-subtitle">'.esc_html__('Client', 'lvly').'</h3>';
                $output .= '<div class="portfolio-meta">'.($atts['client_name']).'</div>';
            $output .= '</li>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_share')) {
    function lvly_portfolio_share() {
        ob_start();
            do_action( 'waves_entry_share', 'layout-2' );
        return ob_get_clean();
    }
}
if (!function_exists('lvly_portfolio_morebtn')) {
    function lvly_portfolio_morebtn($atts) {
        $output = '';
        if (!empty($atts['more_link'])) {
            $output .= '<a href="'.esc_url($atts['more_link']).'" class="uk-button uk-button-radius uk-button-default portfolio-btn tw-hover"><span class="tw-hover-inner"><span>'.lvly_get_option('launch_project', esc_html__( 'Launch Project', 'lvly')).'</span><i class="ion-ios-arrow-thin-right"></i></span></a>';
        }
        return $output;
    }
}
if (!function_exists('lvly_portfolio_nextprev')) {
    function lvly_portfolio_nextprev($atts) {
        $output = '';
        
        $prev_text = '<i class="ion-ios-arrow-left"></i><span>'.esc_html__('Prev', 'lvly').'</span>';
        $next_text = '<span>'.esc_html__('Next', 'lvly').'</span><i class="ion-ios-arrow-right"></i>';
        ob_start();
        previous_post_link('%link', $prev_text);
        $prev = ob_get_clean();
        ob_start();
        next_post_link('%link', $next_text);
        $next = ob_get_clean();
        $ppage = lvly_get_option('portfolio_page');
        $link = $ppage ? get_permalink($ppage) : home_url('/');
        
        if (isset($atts['full_navigation'])) {
            $output .= '<section class="uk-section uk-section-small uk-padding-large">';
                $output .= '<div class="uk-padding uk-padding-remove-vertical">';
        } else {
            $output .= '<section class="uk-section uk-section-small">';
                $output .= '<div class="uk-container">';
        }
                $output .= '<div class="tw-portfolio-nav uk-flex uk-flex-between uk-flex-middle">';
                    $output .= '<div class="nav-prev tw-meta">';
                        $output .= $prev ? $prev : ('<div>'.$prev_text.'</div>');
                    $output .= '</div>';
                    $output .= '<div class="nav-link">';
                        $output .= '<a href="'.esc_url($link).'">';
                            $output .= '<i class="ion-grid"></i>';
                        $output .= '</a>';
                    $output .= '</div>';
                    $output .= '<div class="nav-next tw-meta">';
                        $output .= $next ? $next : ('<div>'.$next_text.'</div>');
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';
        $output .= '</section>';
        return $output;
    }
}
if (!function_exists('lvly_comment')) {
    function lvly_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
		// Display trackbacks differently than normal comments.
        ?>
        <div class="post pingback" id="comment-<?php comment_ID(); ?>">
		    <?php esc_html_e( 'Pingback:', 'lvly' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'lvly' ), '<span class="edit-link">', '</span>' ); ?>
        <?php
            break;
            default :
            // Proceed with normal comments.
            global $post;
        ?>
        <div <?php comment_class();?> id="comment-<?php comment_ID(); ?>">
            <div class="comment-author">
                <?php echo get_avatar($comment, $size = '65'); ?>
            </div>
            <div class="comment-text">
                <h3 class="author"><?php echo get_comment_author_link(); ?></h3>
                <span class="tw-meta"><?php echo get_comment_date('F j, Y'); ?></span>
                <h6 class="reply"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></h6>
                <?php comment_text() ?>
            </div>
            <?php
		break;
	    endswitch; // end comment_type check
    }
}
if (!function_exists('lvly_comment_form')) {
    function lvly_comment_form($fields) {
        global $id, $post_id;
        if (null === $post_id)
            $post_id = $id;
        else
            $id = $post_id;

        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields = array(
            'author' => '<p class="comment-form-author">' .
            '<input id="author" name="author" placeholder="' . esc_attr__('Name *', 'lvly') . '" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'email' => '<p class="comment-form-email">' .
            '<input id="email" name="email" placeholder="' . esc_attr__('Email *', 'lvly') . '" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'url' => '<p class="comment-form-url">' .
            '<input id="url" name="url" placeholder="' . esc_attr__('Website', 'lvly') . '" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" />' . '</p><div class="clearfix"></div>',
        );
        return $fields;
    }
    add_filter('comment_form_default_fields', 'lvly_comment_form');
}

/* Modal Search */
if (!function_exists('lvly_modal_search')) {
    function lvly_modal_search($header_search = false) {
        if ($header_search) {
            $offset="";
            if ( is_admin_bar_showing() ) {
                $offset = 'style="top: 32px;"';
            }
            else{
                $offset = 'style="top: 0;"';
            }
            $output = '<div id="search-modal" class="uk-modal-full uk-modal" data-uk-modal>';
                $output .= '<div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" data-uk-height-viewport>';
                    $output .= '<button class="uk-modal-close-full" type="button" data-uk-close '.$offset.'></button>';
                    $output .= '<form class="uk-search uk-search-large" action="' . esc_url(home_url('/')) . '">';
                        $output .= '<span class="input--hoshi">';
                            $output .= '<input class="uk-search-input input__field--hoshi" autofocus type="search" name="s" placeholder="' . lvly_get_option('text_search', esc_attr__('Хайх...', 'lvly')) . '"  value="' . get_search_query() . '">';
                            $output .= '<label class="input__label--hoshi"></label>';
                            $output .= '<button type="submit" class="button-search"><i class="simple-icon-magnifier"></i></button>';
                        $output .= '</span>';
                    $output .= '</form>';
                $output .= '</div>';
            $output .= '</div>';

            echo ($output);
        }
    }
}

/* Modal Search */
if (!function_exists('lvly_modal_accessibility')) {
    function lvly_modal_accessibility() { ?>
        <div id="tw-accessibility-modal" uk-offcanvas="flip: true; overlay: true">
            <div class="uk-offcanvas-bar">
                <button class="uk-offcanvas-close" type="button" uk-close><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="24" fill="#FFFF00"/><path d="M24 34C29.5 34 34 29.5 34 24C34 18.5 29.5 14 24 14C18.5 14 14 18.5 14 24C14 29.5 18.5 34 24 34Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M21.1719 26.8319L26.8319 21.1719" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M26.8319 26.8319L21.1719 21.1719" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                <h3><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 48C37.2548 48 48 37.2548 48 24C48 10.7452 37.2548 0 24 0C10.7452 0 0 10.7452 0 24C0 37.2548 10.7452 48 24 48Z" fill="white"/><path d="M24 42C33.9411 42 42 33.9411 42 24C42 14.0589 33.9411 6 24 6C14.0589 6 6 14.0589 6 24C6 33.9411 14.0589 42 24 42Z" fill="white"/><path d="M32.9999 18.9581C33.0052 19.4549 32.6571 19.8851 32.1713 19.9818C31.1148 20.2145 28.9826 20.7627 27.6842 21.0628C27.0802 21.2001 26.6517 21.7403 26.6543 22.3625C26.6596 23.7596 26.6775 26.0703 26.736 26.6859C26.8078 27.5875 26.9267 28.4838 27.0928 29.3727C27.2535 30.2656 27.4576 31.1539 27.7041 32.0301C27.942 32.8964 28.227 33.7487 28.5579 34.5835L28.5752 34.6269C28.7805 35.1391 28.5327 35.7219 28.0217 35.9273C27.5333 36.124 26.9772 35.9059 26.7512 35.4292C26.3306 34.5342 25.9606 33.6159 25.6436 32.6783C25.3246 31.7547 25.0495 30.8164 24.819 29.8634C24.7432 29.556 24.6755 29.2466 24.6103 28.9358C24.5791 28.7825 24.4435 28.6717 24.2867 28.6717H23.7139C23.5571 28.6717 23.4216 28.7824 23.3897 28.9365C23.3252 29.2472 23.2568 29.5567 23.181 29.8641C22.9511 30.817 22.676 31.7553 22.3564 32.6789C22.0388 33.6159 21.6694 34.5342 21.2488 35.4298C21.0122 35.9286 20.4175 36.14 19.9212 35.9026C19.4461 35.6758 19.2288 35.1171 19.4248 34.6276L19.4421 34.5842C19.773 33.7492 20.058 32.897 20.2959 32.0308C20.5424 31.1545 20.7465 30.2662 20.9072 29.3733C21.0733 28.4844 21.1929 27.5881 21.264 26.6865C21.3225 26.071 21.3398 23.7603 21.3457 22.3631C21.3477 21.7416 20.9198 21.2015 20.3158 21.0634C19.0174 20.7627 16.8852 20.2152 15.8287 19.9824C15.3429 19.8857 14.9948 19.4555 15.0001 18.9587C15.0206 18.4066 15.4838 17.9758 16.0339 17.9971C16.0925 17.9991 16.1502 18.0065 16.2074 18.0191L16.2679 18.0325C18.8015 18.6433 21.3942 18.9688 23.9996 19.0028C26.6049 18.9688 29.1983 18.6427 31.7312 18.0325L31.7917 18.0191C32.33 17.9018 32.8608 18.2446 32.9771 18.7847C32.9906 18.8415 32.998 18.9001 32.9999 18.9581ZM24.0004 17.335C25.4682 17.335 26.6583 16.1406 26.6583 14.6675C26.6583 13.1944 25.4682 12 24.0004 12C22.5326 12 21.3426 13.1944 21.3426 14.6675C21.3426 16.1406 22.5326 17.335 24.0004 17.335Z" fill="black"/></svg>Тусгай хэрэгцээт тохиргоо</h3>
                <p>Та энэхүү тохиргоогоор вебсайтын өнгө, зураг, текстүүдийн хэмжээг өөрчлөн харах боломжтой.</p>
                <form id="tw-accessibility-form">
                    
                    <input type="hidden" name="action" value="set_tw_accessibility_ajax" />

                    <div class="tw-form-acc-field-container">
                        <label>1. Өнгө өөрчлөх</label>
                        <fieldset class="uk-fieldset">
                            <label>
                                <img src="<?php echo LVLY_DIR . 'assets/images/accessibility-normal.png'; ?>" />
                                <div class="tw-form-acc-field-radio">
                                    <input class="uk-radio" type="radio" name="color" value="normal"<?php echo ( empty( $_COOKIE['tw_accessibility_color'] ) || $_COOKIE['tw_accessibility_color'] !== 'high' ? ' checked' : '' ); ?> />Энгийн өнгө
                                </div>
                            </label>
                            <label>
                                <img src="<?php echo LVLY_DIR . 'assets/images/accessibility-high.png'; ?>" />
                                <div class="tw-form-acc-field-radio">
                                    <input class="uk-radio" type="radio" name="color" value="high"<?php  echo ( !empty( $_COOKIE['tw_accessibility_color'] ) && $_COOKIE['tw_accessibility_color'] === 'high' ? ' checked' : '' ); ?>/>Өндөр ялгамжтай
                                </div>
                            </label>
                        </fieldset>
                    </div>

                    <div class="tw-form-acc-field-container">
                        <label>2. Текст хэмжээ өөрчлөх</label>
                        <fieldset class="uk-fieldset">
                            <input type="hidden" name="size" value="<?php echo empty( $_COOKIE['tw_accessibility_size'] ) ? 0 : intval( $_COOKIE['tw_accessibility_size'] ) ?>" />
                            <a class="tw-form-acc-btn-size increase" href="#"><svg width="96" height="72" viewBox="0 0 96 72" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="1" y="1" width="94" height="70" fill="black" stroke="#FFFF01" stroke-width="2"/><path d="M55.45 48.3909L46.229 25.7294C45.8455 24.7879 44.93 24.1719 43.9135 24.1719C42.897 24.1719 41.981 24.7879 41.598 25.7299L32.3765 48.3909C31.856 49.6699 32.471 51.1289 33.75 51.6489C34.0585 51.7749 34.3775 51.8339 34.691 51.8339C35.678 51.8339 36.613 51.2459 37.0075 50.2759L39.2345 44.8034H48.592L50.819 50.2759C51.3385 51.5544 52.797 52.1709 54.077 51.6489C55.3555 51.1284 55.9705 49.6694 55.45 48.3909ZM41.2695 39.8029L43.9135 33.3049L46.5575 39.8029H41.2695Z" fill="#FFFF00"/><path d="M61.3059 24.204H59.7699V22.668C59.7699 21.2875 58.6509 20.168 57.2699 20.168C55.8889 20.168 54.7699 21.2875 54.7699 22.668V24.2035H53.2344C51.8534 24.2035 50.7344 25.323 50.7344 26.7035C50.7344 28.084 51.8534 29.2035 53.2344 29.2035H54.7699V30.739C54.7699 32.1195 55.8889 33.239 57.2699 33.239C58.6509 33.239 59.7699 32.1195 59.7699 30.739V29.2035H61.3059C62.6869 29.2035 63.8059 28.084 63.8059 26.7035C63.8059 25.323 62.6864 24.204 61.3059 24.204Z" fill="#FFFF00"/></svg></a>
                            <a class="tw-form-acc-btn-size decrease" href="#"><svg width="96" height="72" viewBox="0 0 96 72" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="1" y="1" width="94" height="70" fill="black" stroke="#FFFF01" stroke-width="2"/><path d="M55.45 46.387L46.229 23.7255C45.8455 22.784 44.93 22.168 43.9135 22.168C42.897 22.168 41.981 22.784 41.598 23.726L32.3765 46.387C31.856 47.666 32.471 49.125 33.75 49.645C34.0585 49.771 34.3775 49.83 34.691 49.83C35.678 49.83 36.613 49.242 37.0075 48.272L39.235 42.799H48.5925L50.8195 48.2715C51.339 49.55 52.7975 50.1665 54.0775 49.6445C55.3555 49.1245 55.9705 47.6655 55.45 46.387ZM41.2695 37.799L43.9135 31.301L46.5575 37.799H41.2695Z" fill="#FFFF00"/><path d="M61.3064 27.1992H53.2344C51.8534 27.1992 50.7344 26.0797 50.7344 24.6992C50.7344 23.3187 51.8534 22.1992 53.2344 22.1992H61.3064C62.6874 22.1992 63.8064 23.3187 63.8064 24.6992C63.8064 26.0797 62.6869 27.1992 61.3064 27.1992Z" fill="#FFFF00"/></svg></a>
                        </fieldset>
                    </div>

                    <div class="tw-form-acc-field-container">
                        <label>3. Зураг нуух</label>
                        <fieldset class="uk-fieldset">
                            <label><input class="uk-radio" type="radio" name="hide_image" value=""    <?php echo (  empty( $_COOKIE['tw_accessibility_hide_image'] ) || $_COOKIE['tw_accessibility_hide_image'] !== 'hide' ? ' checked' : '' ); ?> />Үгүй</label>
                            <label><input class="uk-radio" type="radio" name="hide_image" value="hide"<?php echo ( !empty( $_COOKIE['tw_accessibility_hide_image'] ) && $_COOKIE['tw_accessibility_hide_image'] === 'hide' ? ' checked' : '' ); ?>/>Тийм</label>
                        </fieldset>
                    </div>

                    <div class="tw-form-acc-field-container">
                        <input type="submit" class="tw-form-acc-submit" value="Тохиргоог хадгалах" />
                        <input type="reset" class="tw-form-acc-reset"  value="Тохиргоог арилгах" />
                    </div>

                </form>
            </div>
        </div><?php
    }
}

/* Sidebar Search */
if (!function_exists('lvly_sidebar_search')) {
    function lvly_sidebar_search($header_search = false) {
        if ($header_search) {

            $output = '<div class="search-form">';
                $output .= '<form method="get" class="searchform" action="' . esc_url(home_url('/')) . '">';
                    $output .= '<div class="input uk-position-relative">';
                        $output .= '<input type="text" value="" name="s" placeholder="' . esc_attr__('Search...', 'lvly') . '">';
                        $output .= '<a class="uk-form-icon uk-form-icon-flip"><i class="ion-search tw-search-icon"></i></a>';
                    $output .= '</div>';
                $output .= '</form>';
            $output .= '</div>';

            echo ($output);
        }
    }
}
/* Search  Organization*/
if (!function_exists('lvly_organization_search')) {
    function lvly_organization_search() {
            $output = '<div class="search-form-org">';
                $output .= '<div class="input">';
                    $output .= '<input type="text" value="" name="filter_text" placeholder="' . esc_attr__('Хайлт хийх бол энд бичнэ үү', 'lvly') . '">';
                $output .= '</div>';
            $output .= '</div>';
            
            return $output;
    }
}
if (!function_exists('lvly_modal_cart')) {
    function lvly_modal_cart($drop=array()) {
        $drop = shortcode_atts( array(
            'mode' => 'click',
            'boundary' => '! .uk-navbar-container',
            'pos' => 'bottom-right',
            'offset' => '0',
            'animation' => 'uk-animation-slide-bottom-small',
            'duration' => '300',
        ),$drop);
        $dropAtt='';
        foreach($drop as $k=>$v) {
            $dropAtt.=$k.':'.$v.'; ';
        }
        $output = '<a class="cart-btn uk-navbar-toggle" href="#"><i class="simple-icon-bag"><span class="hidden">0</span></i></a>';
        $output .= '<div class="cart-btn-widget uk-light" data-uk-drop="'.esc_attr($dropAtt).'">';
            ob_start();
                woocommerce_mini_cart(array());
            $output .= ob_get_clean();
        $output .= '</div>';
        echo ($output);
    }
}
if (!function_exists('lvly_modal_mobile_menu')) {
    function lvly_modal_mobile_menu() { ?>
        <div id="mobile-menu-modal" class="uk-modal-full" data-uk-modal>
            <div class="uk-modal-dialog">
                <div class="mobile-header">
                    <svg width="195" height="37" viewBox="0 0 195 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_2693_14842)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.36355 4.05202C7.24882 4.15054 7.14485 4.25976 7.05322 4.37802C6.97787 4.4715 6.91279 4.57202 6.859 4.67802C6.81105 4.76799 6.77557 4.86344 6.75344 4.96202C6.73541 5.05566 6.73009 5.1511 6.73761 5.24602C6.75937 5.46167 6.83149 5.67003 6.94872 5.85602C7.02464 5.98591 7.11222 6.10937 7.2105 6.22502C7.3479 6.39209 7.49596 6.55106 7.65383 6.70102C7.73828 6.78502 7.828 6.86902 8.0085 7.03702L8.30194 7.30902C8.51305 7.50902 8.61333 7.60302 8.80333 7.78402C9.09361 8.06002 9.07672 8.03702 9.49789 8.43202C9.81455 8.72502 9.76916 8.69102 10.1639 9.06302C10.5862 9.46302 10.5746 9.44302 10.7899 9.65102C10.9018 9.75802 11.0168 9.87002 11.1963 10.036C11.3557 10.183 11.4654 10.279 11.5013 10.311C11.6508 10.4482 11.8076 10.578 11.9711 10.7L12.1494 10.828C12.2928 10.9238 12.4415 11.0123 12.5949 11.093C12.7162 11.1577 12.8409 11.2165 12.9686 11.269C13.3228 11.4035 13.7006 11.4734 14.0822 11.475C14.2871 11.476 14.4916 11.4592 14.6933 11.425C14.8622 11.398 14.9994 11.364 15.1208 11.334C15.2422 11.304 15.3784 11.27 15.5557 11.21C15.6613 11.174 15.6613 11.17 15.9579 11.062C16.169 10.983 16.1489 10.994 16.2197 10.962C16.3569 10.906 16.5226 10.839 16.682 10.762C16.8398 10.6809 16.9906 10.588 17.1327 10.484C17.2047 10.4347 17.2731 10.3809 17.3375 10.323C17.3975 10.268 17.4542 10.2099 17.5074 10.149C17.6101 10.0351 17.7026 9.91338 17.784 9.78502C17.8806 9.63049 17.9602 9.46697 18.0215 9.29702C18.0767 9.14642 18.1176 8.99148 18.1439 8.83402C18.1439 8.80802 18.1577 8.72402 18.1767 8.55602C18.203 8.31902 18.2168 8.20102 18.2189 8.17902C18.2305 8.02802 18.2189 7.97902 18.2189 7.65102C18.2189 7.50802 18.2189 7.36502 18.2189 7.22102C18.2189 7.05002 18.2189 4.94902 18.2189 3.57902C18.2294 3.28602 18.2305 2.97902 18.2189 2.65102C18.2104 2.42769 18.1971 2.21269 18.1788 2.00602C18.1675 1.88802 18.1484 1.77079 18.1218 1.65502C18.1035 1.56726 18.0792 1.48074 18.0489 1.39602C17.9898 1.22431 17.8938 1.06601 17.7671 0.931023C17.7039 0.864765 17.6331 0.805399 17.556 0.754024C17.416 0.662807 17.2592 0.597334 17.0937 0.561022C16.7888 0.495006 16.474 0.480451 16.1637 0.518023C15.874 0.542725 15.586 0.583461 15.3013 0.640023C14.6363 0.764023 14.1402 0.890023 14.0241 0.918023C13.3686 1.08302 12.863 1.24402 12.6149 1.32602C12.2371 1.45202 11.8169 1.60302 11.3662 1.78602L10.6411 2.10002C10.5355 2.14602 10.3951 2.20602 10.2093 2.30002C10.1228 2.34302 10.0531 2.37802 9.93594 2.43902C9.66994 2.57802 9.52111 2.65502 9.34694 2.75102C8.92472 2.98002 8.60805 3.17902 8.4265 3.29202C7.96839 3.57702 7.78261 3.71702 7.72667 3.76002C7.57255 3.87302 7.44905 3.97602 7.36355 4.05202ZM13.9766 1.73701C14.0245 1.81375 14.0414 1.90437 14.0241 1.99201C14.0025 2.13758 13.9237 2.27006 13.8035 2.36301C13.6916 2.47201 13.4488 2.67801 13.3813 2.82301C13.3266 2.90735 13.2943 3.00298 13.2871 3.10172C13.28 3.20046 13.2981 3.29937 13.3401 3.39001C13.3867 3.50625 13.469 3.60654 13.5765 3.67787C13.684 3.7492 13.8116 3.78827 13.9428 3.79001C14.1212 3.78301 14.4062 3.80201 14.6311 3.51901C14.679 3.46513 14.7121 3.40085 14.7274 3.3319C14.7428 3.26295 14.7399 3.19147 14.719 3.12384C14.6981 3.05622 14.6598 2.99454 14.6076 2.94432C14.5555 2.8941 14.491 2.85689 14.4199 2.83601C14.1466 2.75001 14.0072 2.88901 14.0072 2.88901C13.9708 2.91999 13.9435 2.95944 13.9282 3.00347C13.9128 3.0475 13.9099 3.09457 13.9196 3.14001C13.9319 3.16822 13.9518 3.19293 13.9772 3.21174C14.0025 3.23054 14.0326 3.2428 14.0645 3.24733C14.0964 3.25186 14.129 3.24851 14.1591 3.23759C14.1892 3.22666 14.2158 3.20855 14.2363 3.18501C14.2363 3.18501 14.421 3.21201 14.2574 3.36101C14.0938 3.51001 13.7444 3.36801 13.7159 3.14801C13.7053 3.0473 13.7216 2.94569 13.763 2.85243C13.8045 2.75917 13.8699 2.67721 13.9534 2.61401C14.1128 2.47701 14.2236 2.35801 14.2088 2.21401C14.212 2.12287 14.1926 2.03229 14.1523 1.94948C14.112 1.86667 14.0518 1.79392 13.9766 1.73701ZM12.6603 3.76201C12.6603 3.76201 12.729 3.98201 12.7321 3.99401C12.7353 4.00601 12.7617 4.10901 12.7691 4.14401C12.7765 4.17901 12.7912 4.25101 12.7955 4.26801C12.8009 4.30748 12.8104 4.34634 12.824 4.38401C12.8387 4.41901 12.8461 4.43501 12.8609 4.44401C12.8757 4.45301 12.9316 4.48301 12.9411 4.48601C12.9622 4.49402 12.9841 4.49973 13.0066 4.50301C13.046 4.50491 13.0854 4.50491 13.1248 4.50301L13.3359 4.48601C13.3602 4.48601 13.5354 4.47501 13.5681 4.47501H14.5836C14.5836 4.47501 14.7503 4.47501 14.8021 4.57501C14.834 4.62612 14.8541 4.68303 14.8612 4.74201C14.8612 4.74201 14.5445 4.72301 14.5139 4.72601C14.4833 4.72901 14.1972 4.71801 14.1814 4.72601C14.1656 4.73401 13.8975 4.72601 13.8837 4.72601L13.5671 4.73201L13.2156 4.73801H12.9527C13.0391 4.8758 13.0853 5.03279 13.0868 5.19301C13.0868 5.19301 13.2768 5.16601 13.4098 5.15901C13.5428 5.15201 13.6441 5.14801 13.7212 5.14701C13.7982 5.14601 13.9323 5.14701 13.9323 5.14701C13.9323 5.14701 14.0579 5.17601 14.0885 5.38201H13.5544C13.4405 5.37993 13.3266 5.38494 13.2135 5.39701C13.0987 5.41347 12.9879 5.44902 12.8862 5.50201C12.8301 5.53445 12.7822 5.57811 12.7457 5.62992C12.7092 5.68174 12.6852 5.74047 12.6751 5.80201C12.6354 5.94454 12.6516 6.09587 12.7205 6.22801C12.7634 6.30443 12.8296 6.36682 12.9105 6.40701C13.019 6.46244 13.1382 6.49645 13.261 6.50701C13.3544 6.51396 13.4483 6.51396 13.5417 6.50701C13.6325 6.49401 13.8299 6.49501 13.9027 6.49101C13.9671 6.48766 14.0316 6.48766 14.0959 6.49101V6.69101C14.0959 6.69101 13.6188 6.69101 13.5396 6.81601C13.4605 6.94101 13.4847 6.94101 13.4879 7.05201C13.4946 7.10511 13.4877 7.15896 13.4678 7.20901C13.4513 7.25074 13.4249 7.28835 13.3908 7.31901C13.3412 7.35518 13.2789 7.372 13.2166 7.36601C13.1683 7.36373 13.1217 7.34808 13.0826 7.32101C13.0669 7.30979 13.054 7.29549 13.0447 7.27909C13.0354 7.2627 13.0299 7.24459 13.0287 7.22601C13.0287 7.18301 13.0467 7.14701 13.1216 7.12601C13.1323 7.12353 13.1434 7.12316 13.1543 7.12492C13.1652 7.12669 13.1755 7.13055 13.1847 7.13628C13.1939 7.142 13.2018 7.14946 13.2078 7.15819C13.2139 7.16691 13.2179 7.17673 13.2198 7.18701C13.2509 7.18178 13.2795 7.16751 13.3016 7.14619C13.3237 7.12486 13.3383 7.09754 13.3433 7.06801C13.3511 7.01405 13.3378 6.95924 13.306 6.91393C13.2741 6.86861 13.2258 6.83591 13.1702 6.82201C13.1031 6.79936 13.031 6.79317 12.9607 6.80401C12.8904 6.81485 12.8241 6.84237 12.768 6.88401C12.7151 6.92544 12.6729 6.97781 12.6448 7.0371C12.6166 7.09639 12.6031 7.16102 12.6055 7.22601C12.6046 7.31201 12.6259 7.39691 12.6677 7.47327C12.7095 7.54963 12.7704 7.61513 12.8451 7.66401C13.0121 7.76199 13.2097 7.80226 13.4045 7.77801C13.4975 7.76826 13.5864 7.73663 13.6631 7.68601C13.7493 7.62836 13.8157 7.54805 13.8542 7.45501C13.8773 7.39765 13.8912 7.3373 13.8953 7.27601C13.8916 7.21871 13.8998 7.16127 13.9196 7.10701C13.9304 7.09591 13.9437 7.08727 13.9585 7.08173C13.9733 7.07619 13.9892 7.07389 14.0051 7.07501C14.059 7.07501 14.0959 7.07501 14.0959 7.07501V7.87501H13.4161C13.4161 7.87501 13.0129 7.87501 12.8261 8.03801C12.6392 8.20101 12.6382 8.47101 12.6888 8.65201C12.7395 8.83301 12.9886 8.95201 13.1248 8.97501C13.2311 8.99966 13.3406 9.00976 13.4499 9.00501L13.7486 8.99101C13.7486 8.99101 13.9048 8.98101 13.9925 8.98401L14.098 8.98901V9.18401L13.7813 9.19601C13.7813 9.19601 13.6673 9.19601 13.6156 9.20601C13.5265 9.21727 13.4391 9.23807 13.3549 9.26801C13.2542 9.30001 13.1609 9.35028 13.0805 9.41601C13.0154 9.46791 12.9604 9.53018 12.9179 9.60001C12.8698 9.68253 12.8343 9.77107 12.8123 9.86301C12.7953 9.95284 12.7854 10.0438 12.7828 10.135C12.7819 10.2071 12.785 10.2792 12.7923 10.351L13.1681 10.335C13.1681 10.335 13.5766 10.316 13.7011 10.318C13.8257 10.32 14.1445 10.311 14.363 10.318C14.5815 10.325 14.8907 10.337 15.0691 10.351L15.3731 10.377L15.3678 9.98201L15.3605 9.34201C15.3605 9.34201 15.3605 8.71201 15.3689 8.58701C15.3719 8.39243 15.386 8.19815 15.4111 8.00501C15.3218 8.06867 15.2234 8.11986 15.1187 8.15701C14.9688 8.20401 14.8432 8.23801 14.8432 8.23801V9.88201C14.585 9.865 14.326 9.86133 14.0674 9.87101C13.6663 9.88801 13.3465 9.89301 13.3232 9.90101C13.3289 9.86713 13.3416 9.83466 13.3607 9.80548C13.3797 9.77629 13.4046 9.75098 13.4341 9.73101C13.5004 9.69098 13.5748 9.66442 13.6526 9.65301C13.8369 9.62622 14.0235 9.61518 14.2099 9.62001L14.6543 9.63501V5.57001C14.6543 5.57001 14.6765 5.28101 14.5572 5.15801C14.5572 5.15801 15.2697 5.19401 15.3721 5.20601C15.3721 5.20601 15.4428 4.58201 15.161 4.29601C14.8791 4.01001 14.6838 4.05001 14.1413 4.03401C13.5987 4.01801 13.3887 4.04901 13.2177 4.02201C13.1105 4.01907 13.0053 3.99434 12.9091 3.94947C12.813 3.90461 12.7281 3.84068 12.6603 3.76201ZM14.098 5.81902V6.07302L13.8573 6.06602H13.7201C13.7106 6.06602 13.5628 6.06602 13.5481 6.06602C13.5333 6.06602 13.4288 6.06602 13.4119 6.06602C13.3764 6.0654 13.341 6.06138 13.3063 6.05402C13.2686 6.04502 13.2343 6.02633 13.2071 6.00002C13.1936 5.98715 13.1844 5.97087 13.1804 5.95313C13.1765 5.93538 13.1781 5.91694 13.1849 5.90002C13.193 5.88517 13.2042 5.87201 13.2178 5.86136C13.2314 5.8507 13.2472 5.84277 13.2641 5.83802C13.3174 5.82206 13.3729 5.81331 13.4288 5.81202H13.851C13.851 5.81202 14.0663 5.81702 14.098 5.81902ZM14.098 8.31803V8.57203L13.8573 8.56403H13.5481C13.5333 8.56403 13.4288 8.56403 13.4119 8.56403C13.3763 8.56442 13.3408 8.56038 13.3063 8.55203C13.2684 8.54354 13.234 8.52478 13.2071 8.49803C13.1934 8.48531 13.184 8.46901 13.18 8.45122C13.1761 8.43342 13.1778 8.41491 13.185 8.39803C13.1929 8.38307 13.204 8.36983 13.2177 8.35916C13.2313 8.34849 13.2471 8.34061 13.2641 8.33603C13.3173 8.31933 13.3728 8.31023 13.4288 8.30903H13.851C13.851 8.30903 14.0663 8.31503 14.098 8.31803Z" fill="#76B71F"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.8877 1.637C19.8365 1.88387 19.8033 2.1338 19.7885 2.385C19.7822 2.518 19.7811 2.67 19.779 2.973C19.779 3.26 19.779 3.473 19.779 3.473C19.779 4.123 19.7853 5.705 19.779 6.861C19.779 7.144 19.779 7.556 19.7684 8.061C19.7832 8.207 19.798 8.353 19.8117 8.5L19.8434 8.834C19.866 8.98738 19.9013 9.13885 19.9489 9.287C20.0939 9.74557 20.3731 10.1558 20.7543 10.47C20.9944 10.6662 21.2636 10.8279 21.5534 10.95C21.623 10.978 21.8563 11.067 21.9819 11.115C22.1265 11.171 22.1994 11.198 22.2532 11.215C22.4639 11.2934 22.6793 11.3602 22.8982 11.415C23.1168 11.4723 23.3404 11.5108 23.5663 11.53C24.1126 11.5884 24.6653 11.5051 25.1655 11.289C25.399 11.1886 25.6205 11.0649 25.8263 10.92C26.0335 10.7785 26.2303 10.6238 26.4153 10.457C26.5958 10.303 26.7024 10.201 27.0676 9.857C27.2629 9.673 27.4582 9.49 27.6524 9.305C28.3469 8.644 28.9855 8.044 29.1428 7.895C29.4109 7.644 29.6706 7.385 29.9429 7.139C30.2515 6.85982 30.5416 6.56293 30.8117 6.25C30.9024 6.139 30.9795 6.024 30.9795 6.024C31.0143 5.971 31.0576 5.905 31.1051 5.815C31.1636 5.70771 31.2086 5.59426 31.2392 5.477C31.2612 5.38916 31.2729 5.29928 31.274 5.209C31.2719 5.02102 31.2235 4.8361 31.1326 4.669C31.0683 4.54699 30.9882 4.4331 30.894 4.33C30.8316 4.25727 30.7646 4.18815 30.6934 4.123C30.5087 3.95265 30.3111 3.79523 30.1023 3.652C29.4145 3.18763 28.6956 2.76608 27.95 2.39C27.4571 2.151 26.7615 1.844 26.7615 1.844C26.2105 1.616 25.7323 1.444 25.3639 1.323C24.5054 1.04207 23.628 0.815572 22.7377 0.645003C22.6892 0.635003 22.4337 0.583003 22.0917 0.545003C21.3877 0.464003 21.0826 0.525001 20.976 0.550001C20.8076 0.579971 20.6461 0.637858 20.4989 0.721C20.0513 0.985 19.9268 1.465 19.8877 1.637ZM24.6377 4.441C24.6377 4.441 24.6472 4.452 24.5575 4.531C24.4678 4.61 24.4678 4.606 24.4076 4.667C24.3474 4.728 24.2873 4.79 24.2767 4.801C24.2662 4.812 24.1817 4.901 24.1712 4.916C24.1362 4.95284 24.1044 4.99231 24.0762 5.034C24.0472 5.07983 24.0211 5.12725 23.9981 5.176C23.9768 5.21747 23.9595 5.26064 23.9463 5.305C23.9407 5.32505 23.9365 5.34543 23.9337 5.366C23.9296 5.40413 23.9321 5.44262 23.9411 5.48C23.944 5.49432 23.9482 5.50838 23.9537 5.522C23.9535 5.52466 23.9535 5.52734 23.9537 5.53C23.9537 5.54 23.9622 5.548 23.9664 5.556L24.0012 5.611C24.0102 5.62223 24.0173 5.63471 24.0223 5.648C24.0254 5.6554 24.0275 5.66312 24.0287 5.671C24.0268 5.67723 24.0235 5.68302 24.0192 5.688C24.0003 5.70485 23.9775 5.71719 23.9527 5.724C23.9434 5.74622 23.9321 5.76764 23.9189 5.788C23.9017 5.81374 23.8819 5.83785 23.8598 5.86C23.8418 5.8794 23.8265 5.90091 23.8144 5.924C23.7925 5.96767 23.7792 6.01479 23.7753 6.063C23.769 6.142 23.7753 6.124 23.7753 6.124C23.7527 6.16118 23.7266 6.19632 23.6972 6.229C23.6618 6.27131 23.6304 6.31648 23.6033 6.364C23.5749 6.41346 23.5499 6.46456 23.5283 6.517C23.5107 6.56075 23.4972 6.60594 23.4882 6.652C23.4769 6.70877 23.4702 6.76627 23.4682 6.824C23.4682 6.843 23.4682 6.865 23.4682 6.891C23.4701 6.92456 23.4743 6.95796 23.4808 6.991C23.4914 7.054 23.5093 7.115 23.5093 7.115C23.5224 7.13598 23.538 7.15545 23.5558 7.173C23.5732 7.18952 23.5869 7.20926 23.5959 7.231C23.5994 7.28099 23.5951 7.33119 23.5832 7.38C23.5621 7.488 23.5188 7.643 23.5188 7.643L23.4661 7.824L23.4112 8.005L23.3542 8.191L23.2908 8.396C23.2634 8.486 23.2359 8.578 23.2095 8.671C23.1768 8.786 23.1473 8.898 23.1198 9.008C23.1029 9.075 23.0913 9.133 23.0829 9.179C23.0702 9.24717 23.0614 9.31593 23.0565 9.385C23.0532 9.42507 23.0575 9.46536 23.0692 9.504H22.5921L22.2564 9.496L21.8648 9.489C21.7856 9.489 21.5069 9.489 21.4806 9.489C21.383 9.4912 21.2857 9.49921 21.1892 9.513H20.7723C20.7649 9.513 20.6921 9.513 20.6266 9.513C20.5612 9.513 20.5021 9.519 20.4683 9.523C20.4271 9.52584 20.3864 9.53288 20.3469 9.544C20.3057 9.558 20.2603 9.567 20.2529 9.612C20.2537 9.62753 20.26 9.64236 20.2709 9.654C20.2886 9.66103 20.3076 9.66477 20.3268 9.665L20.4915 9.675L20.7301 9.684L20.9739 9.69L21.2156 9.695H21.4711L21.8183 9.7H26.7889L27.0391 9.694L26.9029 9.772L27.3378 9.598L27.5352 9.411L27.5416 9.398H27.5352L27.3526 9.388L27.0634 9.375L26.8523 9.366L26.6591 9.357C26.6988 9.33497 26.7345 9.30693 26.7647 9.274C26.8143 9.221 26.8217 9.212 26.8291 9.203C26.8827 9.12852 26.9297 9.04991 26.9694 8.968C27.0284 8.85123 27.0775 8.73018 27.1162 8.606C27.1388 8.52792 27.1478 8.44683 27.1426 8.366C27.1404 8.33051 27.1269 8.2965 27.1036 8.26859C27.0804 8.24067 27.0487 8.22022 27.0127 8.21C26.8625 8.16406 26.7075 8.13388 26.5504 8.12L26.2939 8.089C26.2939 8.089 26.1366 8.06 26.1166 8.055L25.9931 8.019C25.9931 8.019 25.9741 8.019 25.9044 8.01L25.6373 7.984C25.5262 7.97265 25.4159 7.95528 25.3069 7.932C25.3069 7.932 25.3143 7.932 25.3069 7.921C25.2978 7.88389 25.2858 7.84746 25.2711 7.812C25.2489 7.756 25.2183 7.67 25.2183 7.67C25.2183 7.67 25.1898 7.57 25.1856 7.546C25.1764 7.49772 25.1764 7.44828 25.1856 7.4C25.19 7.37837 25.1998 7.35804 25.2141 7.34066C25.2284 7.32329 25.2468 7.30935 25.2679 7.3C25.3283 7.27874 25.3904 7.26202 25.4537 7.25C25.5117 7.24 25.6648 7.218 25.7313 7.209C25.7891 7.20921 25.8469 7.20621 25.9044 7.2C25.9213 7.191 25.9287 7.189 25.9192 7.181C25.9097 7.173 25.8801 7.161 25.8516 7.144C25.8231 7.127 25.7524 7.082 25.7524 7.082L25.6321 6.996L25.5476 6.929L25.4421 6.842L25.3365 6.742L25.2119 6.618C25.2119 6.618 24.9227 6.318 25.0188 6.2C25.0423 6.17065 25.0766 6.15069 25.1148 6.144C25.1887 6.125 25.2584 6.104 25.2584 6.104C25.2584 6.104 25.3112 6.084 25.3112 6.069C25.3112 6.054 25.3038 6.046 25.3323 6.016C25.3742 5.98379 25.4199 5.95627 25.4684 5.934C25.5226 5.90517 25.5738 5.8717 25.6215 5.834C25.6498 5.8111 25.6722 5.78237 25.6869 5.75C25.697 5.71858 25.7094 5.68784 25.7239 5.658C25.7344 5.649 25.9772 5.971 26.3171 6.102C26.5423 6.18654 26.7874 6.21177 27.0264 6.175C27.2039 6.14777 27.383 6.1314 27.5627 6.126C27.7459 6.14293 27.9292 6.09443 28.0767 5.99C28.1842 5.92517 28.2865 5.85298 28.3828 5.774C28.4811 5.68921 28.5518 5.57957 28.5865 5.458C28.6268 5.2999 28.635 5.13601 28.6108 4.975C28.576 4.808 28.5053 4.758 28.4652 4.748C28.4251 4.738 28.3596 4.74 28.3047 4.838C28.2985 4.86056 28.295 4.8837 28.2942 4.907C28.2906 5.01195 28.2793 5.11654 28.2604 5.22C28.2361 5.328 28.2329 5.372 28.1105 5.387C28.0389 5.38789 27.9676 5.37776 27.8994 5.357C27.8039 5.32837 27.7049 5.31157 27.6049 5.307C27.36 5.282 27.4888 5.307 27.208 5.268C26.9961 5.2398 26.7922 5.17181 26.6084 5.068C26.5076 5.00092 26.4233 4.91392 26.3614 4.813C26.322 4.75332 26.2749 4.69856 26.2211 4.65C26.1296 4.56683 26.0576 4.46631 26.0099 4.355C25.9941 4.30288 25.9893 4.24829 25.9958 4.1944C26.0023 4.14051 26.02 4.08838 26.0479 4.041C26.0957 3.94749 26.1608 3.86283 26.2401 3.791C26.2401 3.791 26.2401 3.834 26.3657 3.881C26.4437 3.91052 26.5279 3.9225 26.6116 3.916L26.6781 3.906C26.6972 3.90036 26.7174 3.89866 26.7372 3.901C26.7467 3.907 26.7488 3.906 26.752 3.93C26.752 3.93 26.752 3.979 26.752 3.993C26.752 4.007 26.752 4.026 26.752 4.033C26.7551 4.05789 26.7611 4.08238 26.7699 4.106C26.7823 4.13854 26.8038 4.16726 26.8322 4.189C26.8705 4.21946 26.9162 4.24042 26.9652 4.25C27.0064 4.2596 27.0485 4.26562 27.0908 4.268C27.1261 4.26922 27.1615 4.26721 27.1964 4.262C27.2338 4.25277 27.2695 4.23792 27.3019 4.218C27.3365 4.19062 27.3609 4.15347 27.3716 4.112C27.3716 4.112 27.266 4.097 27.247 4.092L27.1795 4.078C27.1639 4.0737 27.148 4.07036 27.132 4.068L27.0571 4.061C27.0327 4.05768 27.0089 4.05129 26.9863 4.042C26.9716 4.032 26.9694 4.032 26.9694 4.027C26.9694 4.022 26.9694 3.935 26.9621 3.915C26.9576 3.88105 26.9499 3.84757 26.9388 3.815C26.9306 3.78425 26.9125 3.75666 26.8871 3.736C26.8578 3.71133 26.8207 3.69656 26.7816 3.694C26.7373 3.69131 26.6929 3.69468 26.6496 3.704C26.6149 3.71063 26.5795 3.71364 26.5441 3.713C26.5104 3.70742 26.4779 3.69661 26.448 3.681C26.4301 3.668 26.4206 3.657 26.4258 3.635C26.454 3.60887 26.4788 3.57966 26.4997 3.548C26.5821 3.42805 26.6138 3.28308 26.5884 3.142C26.564 3.06314 26.521 2.99056 26.4627 2.92976C26.4044 2.86895 26.3322 2.8215 26.2517 2.791C26.1438 2.74337 26.0251 2.72208 25.9064 2.72907C25.7877 2.73606 25.6727 2.7711 25.5719 2.831C25.4729 2.88792 25.3853 2.96105 25.3133 3.047C25.2545 3.11251 25.2058 3.18557 25.1687 3.264C25.1512 3.30161 25.1368 3.34038 25.1254 3.38C25.1113 3.41847 25.1068 3.45948 25.1121 3.49987C25.1174 3.54027 25.1324 3.57897 25.156 3.613C25.2101 3.6783 25.2836 3.72671 25.3671 3.752C25.3798 3.75761 25.3907 3.76631 25.3986 3.7772C25.4066 3.78809 25.4114 3.80079 25.4125 3.814C25.4125 3.814 25.4125 3.852 25.3333 3.856C25.2929 3.85397 25.2528 3.84725 25.2141 3.836C25.2141 3.836 25.118 3.811 25.0694 3.793C25.0694 3.793 24.9428 3.748 24.9132 3.741C24.8669 3.72855 24.8196 3.71952 24.7718 3.714C24.7718 3.714 24.7148 3.706 24.6451 3.702C24.5754 3.698 24.434 3.693 24.434 3.693H24.0244C24.0244 3.693 23.8408 3.693 23.7964 3.693C23.7964 3.693 23.6729 3.693 23.6244 3.684C23.5628 3.68154 23.5018 3.6718 23.4428 3.655C23.3721 3.63209 23.3098 3.59044 23.2634 3.535C23.2438 3.51751 23.2287 3.49595 23.2193 3.472C23.21 3.44806 23.2066 3.42238 23.2095 3.397C23.2201 3.35476 23.2432 3.31625 23.276 3.286C23.3246 3.24 23.4481 3.129 23.4481 3.129C23.4853 3.09484 23.5167 3.05536 23.541 3.012C23.5517 2.98956 23.5599 2.9661 23.5653 2.942C23.5658 2.93132 23.5638 2.92065 23.5594 2.91079C23.555 2.90093 23.5484 2.89212 23.5399 2.885C23.5051 2.85378 23.46 2.83473 23.4122 2.831C23.3533 2.82579 23.2943 2.84029 23.2454 2.872C23.1673 2.91988 23.1019 2.98423 23.0544 3.06C22.9893 3.15199 22.9115 3.23539 22.8232 3.308C22.7781 3.34065 22.7436 3.38475 22.7238 3.43519C22.704 3.48562 22.6997 3.54033 22.7113 3.593C22.743 3.747 23.0713 4.171 23.0913 4.193C23.1204 4.24362 23.1599 4.28825 23.2074 4.3243C23.2548 4.36035 23.3094 4.3871 23.3679 4.403C23.5347 4.431 23.6191 4.377 24.0244 4.38C24.4298 4.383 24.6377 4.405 24.6377 4.441Z" fill="#E7030A"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M27.417 11.552C27.3526 11.619 27.2661 11.712 27.1689 11.828C26.9516 12.0737 26.7685 12.3449 26.6243 12.635C26.5062 12.8772 26.4221 13.1331 26.3741 13.396C26.3331 13.6319 26.3232 13.8717 26.3446 14.11C26.3641 14.2916 26.3969 14.4717 26.4427 14.649C26.4776 14.8135 26.5231 14.9758 26.5789 15.135C26.6085 15.22 26.6053 15.202 26.752 15.562C26.8576 15.824 26.8681 15.855 26.9103 15.948C26.9667 16.0729 27.0298 16.1951 27.0993 16.314C27.2466 16.5748 27.4377 16.8112 27.6651 17.014C27.7947 17.1296 27.9361 17.2328 28.0873 17.322C28.3169 17.4554 28.5658 17.5565 28.8262 17.622C28.9726 17.6566 29.1209 17.6833 29.2706 17.702C29.4416 17.726 29.5724 17.736 29.6854 17.744C29.8353 17.756 30.0327 17.766 30.2607 17.768H30.9563C31.3943 17.76 32.8246 17.768 33.5529 17.768C34.3267 17.768 35.1848 17.768 35.1848 17.768C35.2904 17.768 35.4445 17.768 35.6313 17.768C35.7992 17.768 35.8826 17.768 35.9923 17.759C36.2034 17.748 36.3808 17.728 36.5032 17.711C36.6428 17.695 36.7811 17.67 36.917 17.636C37.0749 17.5967 37.226 17.5361 37.3656 17.456C37.4517 17.4059 37.5314 17.3465 37.6031 17.279C37.6554 17.2284 37.7024 17.1731 37.7435 17.114C37.8592 16.9413 37.9338 16.7468 37.962 16.544C37.9816 16.4232 37.9911 16.3012 37.9905 16.179C37.9923 16.0337 37.9849 15.8884 37.9683 15.744C37.9504 15.572 37.9293 15.444 37.9029 15.299C37.8733 15.126 37.8459 14.999 37.8132 14.848C37.7456 14.538 37.6865 14.304 37.6728 14.248C37.6358 14.102 37.5672 13.822 37.4564 13.471C37.3941 13.263 37.3361 13.086 37.2907 12.95C37.2041 12.692 37.1292 12.49 37.0891 12.384C36.9835 12.098 36.8885 11.869 36.8262 11.723C36.7745 11.598 36.709 11.444 36.6151 11.243C36.6151 11.243 36.5539 11.111 36.4336 10.861C36.3692 10.727 36.2858 10.561 36.1866 10.375C36.0989 10.209 35.9533 9.93997 35.758 9.61197C35.6926 9.50097 35.4973 9.17697 35.2397 8.79297C35.1036 8.59297 34.9864 8.42598 34.9378 8.35698C34.8734 8.26798 34.8323 8.21198 34.7784 8.13798C34.6372 7.94355 34.4835 7.75753 34.3182 7.58097C34.214 7.46987 34.1022 7.36532 33.9836 7.26797C33.9012 7.2005 33.8133 7.13931 33.7208 7.08498C33.6533 7.04472 33.5827 7.00929 33.5097 6.97898C33.4704 6.96225 33.4303 6.94756 33.3893 6.93498C33.3344 6.91898 33.2922 6.90998 33.2764 6.90698L33.2268 6.89698C33.2067 6.89698 33.1877 6.89098 33.1624 6.88898H33.0273L32.9724 6.89398L32.9038 6.89998L32.7982 6.90897H32.756L32.6811 6.92797C32.642 6.93797 32.6093 6.94898 32.5934 6.95398C32.5213 6.97851 32.4508 7.00723 32.3823 7.03997C32.3201 7.06897 32.2768 7.09398 32.2451 7.10998C32.1533 7.16198 32.0868 7.20997 32.0393 7.23697C31.9464 7.29797 31.8799 7.34897 31.8282 7.38697C31.749 7.44697 31.6899 7.49597 31.6529 7.52697C31.5917 7.57697 31.5474 7.61897 31.4988 7.65797L31.388 7.75797C31.3194 7.81997 31.2824 7.85798 31.1906 7.94498L31.0354 8.09297C31.0217 8.10497 30.5984 8.50698 29.7498 9.31298L29.051 9.97598C29.0394 9.98598 28.3681 10.624 28.3575 10.634C28.1971 10.782 28.0356 10.934 27.873 11.094C27.7105 11.254 27.5679 11.4 27.417 11.552ZM30.4654 8.63698L30.4855 9.03697C30.4869 9.08339 30.4848 9.12985 30.4792 9.17598C30.4686 9.30598 30.4675 9.58498 30.4675 9.58498V9.83198L30.211 9.84097L29.9831 9.84998C29.9007 9.84998 29.7456 9.86097 29.6801 9.86697C29.6224 9.8686 29.5652 9.87768 29.5102 9.89398C29.5102 9.89398 29.4753 9.89898 29.4679 9.95898C29.4597 9.98247 29.4575 10.0075 29.4616 10.032C29.4745 10.0971 29.5026 10.1586 29.5439 10.212C29.5829 10.2673 29.6323 10.3155 29.6896 10.354C29.7364 10.3861 29.7915 10.4054 29.849 10.41C29.849 10.41 30.116 10.399 30.2712 10.387L30.7905 10.341L31.3331 10.287C31.3331 10.287 31.2919 10.687 31.255 10.851C31.2366 11.0012 31.184 11.1459 31.1009 11.275C31.0069 11.4 30.8307 11.394 30.7737 11.402C30.7167 11.41 30.4222 11.42 30.4179 11.416C30.3654 11.3652 30.3021 11.3257 30.2322 11.3C30.1391 11.2605 30.0349 11.251 29.9356 11.273C29.9356 11.273 29.7783 11.304 29.7835 11.431C29.7835 11.431 29.7835 11.571 29.9947 11.675C30.0713 11.7118 30.1558 11.7316 30.2417 11.733C30.2417 11.733 30.248 11.81 30.248 11.902C30.248 11.994 30.248 12.134 30.2374 12.235C30.2269 12.336 30.2269 12.416 30.2047 12.603C30.1825 12.79 30.1541 13.003 30.1403 13.093C30.1266 13.183 30.0749 13.485 30.0559 13.583C30.0369 13.681 29.9999 13.866 29.9641 14.017C29.9282 14.168 29.8638 14.423 29.8279 14.538C29.7781 14.7131 29.7138 14.8843 29.6358 15.05C29.6358 15.05 29.6231 15.075 29.5482 15.193C29.4552 15.334 29.3804 15.4851 29.3254 15.643C29.2872 15.7488 29.2857 15.8635 29.3213 15.9702C29.3568 16.0769 29.4274 16.17 29.5228 16.236C29.731 16.3603 29.9608 16.4486 30.2016 16.497C30.3071 16.521 31.0682 16.672 31.2223 16.697C31.5438 16.7604 31.8704 16.7972 32.1987 16.807C32.5491 16.807 32.68 16.807 32.8425 16.793C33.1734 16.7697 33.502 16.7226 33.8253 16.652C34.067 16.6004 34.302 16.5239 34.5262 16.424C34.6391 16.365 34.9072 16.241 34.9135 16.047C34.9135 16.047 34.7732 15.671 34.6919 15.493L34.5747 15.236L34.4544 15C34.2802 14.637 34.1937 14.455 34.1377 14.33C34.0649 14.17 34.0142 14.049 33.9762 13.957C33.9762 13.957 33.8517 13.657 33.7524 13.385C33.7387 13.347 33.7218 13.299 33.7018 13.237C33.6881 13.194 33.6638 13.12 33.6395 13.024C33.6152 12.928 33.6004 12.85 33.5804 12.741C33.5635 12.648 33.5551 12.589 33.5508 12.561C33.5466 12.533 33.5413 12.491 33.5361 12.435C33.5156 12.2625 33.5156 12.0884 33.5361 11.916C33.5413 11.878 33.5455 11.847 33.5487 11.828C33.5663 11.814 33.5874 11.8043 33.6099 11.8C33.6279 11.7939 33.6456 11.7869 33.6627 11.779L33.7683 11.74L33.8348 11.713C33.8627 11.7024 33.8899 11.69 33.9161 11.676C33.953 11.655 33.9794 11.64 33.9889 11.611C33.9913 11.5934 33.9913 11.5756 33.9889 11.558C33.9876 11.5264 33.9837 11.495 33.9773 11.464C33.9757 11.4552 33.9736 11.4465 33.9709 11.438C33.9681 11.4257 33.9643 11.4136 33.9593 11.402C33.9552 11.3907 33.9503 11.3796 33.9445 11.369C33.9308 11.3453 33.9117 11.3248 33.8886 11.309C33.8578 11.2877 33.8211 11.2752 33.7831 11.273C33.6567 11.2702 33.5326 11.3052 33.4284 11.373C33.4168 11.379 33.3999 11.388 33.3809 11.4L33.3102 11.441C33.269 11.4679 33.2256 11.4917 33.1803 11.512C33.1397 11.5345 33.0933 11.5459 33.0463 11.545C32.9826 11.5377 32.9198 11.5253 32.8584 11.508C32.7832 11.4846 32.7121 11.4509 32.6473 11.408C32.5599 11.3474 32.4854 11.2718 32.4277 11.185C32.3612 11.0841 32.3123 10.9737 32.2831 10.858C32.2508 10.7298 32.2324 10.5987 32.2282 10.467C32.2248 10.3976 32.227 10.3281 32.2345 10.259C32.3686 10.273 32.5607 10.292 32.7919 10.313L33.08 10.34C33.4664 10.376 33.6332 10.393 33.878 10.402H33.953C33.9893 10.3996 34.025 10.3915 34.0586 10.378C34.082 10.3676 34.1039 10.3545 34.124 10.339C34.2043 10.2818 34.2681 10.2065 34.3098 10.12C34.3247 10.0909 34.335 10.0599 34.3404 10.028C34.3419 10.015 34.3419 10.0019 34.3404 9.98898C34.3404 9.98098 34.3404 9.97098 34.333 9.95098C34.3312 9.94031 34.328 9.9299 34.3235 9.91998C34.3207 9.91281 34.3168 9.90607 34.3119 9.89998C34.3043 9.89209 34.2943 9.88652 34.2834 9.88398C34.266 9.87679 34.2474 9.87239 34.2285 9.87098L34.1631 9.86298H34.1367C34.0628 9.85698 34.0174 9.85298 33.9593 9.85098H33.8211C33.7767 9.85098 33.6099 9.84198 33.4674 9.83798C33.3798 9.83798 33.2405 9.83098 33.0378 9.82798C33.0273 9.59498 33.0241 9.40198 33.0241 9.26398C33.0241 9.08798 33.0241 8.93398 33.0304 8.66998C33.0304 8.54498 33.0304 8.44098 33.0357 8.36998L33.0706 6.87598L32.7792 6.90197C32.7792 6.97697 32.7792 7.88298 32.7792 7.95298C32.7792 8.52298 32.7792 8.72797 32.7792 9.03597C32.7792 9.34397 32.7729 9.62198 32.7708 9.79598H32.528L32.3982 9.80298H32.3338L32.2134 9.81198C32.1659 9.81198 32.0773 9.82097 31.8968 9.82897C31.7321 9.82097 31.5643 9.81497 31.3922 9.80997C31.1283 9.80097 30.8381 9.79398 30.7357 9.80198C30.7265 9.73531 30.7181 9.66864 30.7103 9.60197C30.704 9.54397 30.6998 9.48697 30.6956 9.43297L30.7029 8.40898L30.4654 8.63698ZM33.4579 13.329C33.4739 13.2064 33.4617 13.082 33.4222 12.9643C33.3826 12.8465 33.3167 12.7383 33.2289 12.647C32.9323 12.358 32.6557 12.272 32.3137 12.196C32.0444 12.1433 31.7671 12.1379 31.4957 12.18C31.1956 12.2269 30.9141 12.3484 30.6797 12.532C30.6103 12.5917 30.5483 12.6589 30.495 12.732C30.4632 12.7791 30.4357 12.8286 30.4127 12.88C30.3696 12.9763 30.3384 13.0769 30.3198 13.18C30.3134 13.22 30.3092 13.263 30.3092 13.263C30.3092 13.263 30.3092 13.303 30.3029 13.342C30.2914 13.456 30.3047 13.571 30.3419 13.68C30.3625 13.7359 30.3921 13.7886 30.4296 13.836C30.4509 13.8628 30.4745 13.8879 30.5003 13.911C30.5394 13.9439 30.5826 13.9721 30.6291 13.995C30.7279 14.044 30.8351 14.0762 30.9457 14.09C31.0196 14.0995 31.0945 14.0995 31.1684 14.09C31.2239 14.0848 31.2783 14.072 31.3299 14.052C31.4286 14.0179 31.5093 13.9487 31.5548 13.859C31.5637 13.8303 31.5694 13.8008 31.5717 13.771C31.5753 13.7438 31.5753 13.7162 31.5717 13.689C31.5674 13.6548 31.5589 13.6213 31.5463 13.589C31.5346 13.5468 31.5137 13.5073 31.4851 13.473C31.4622 13.4463 31.4324 13.4256 31.3986 13.413C31.3816 13.4075 31.3637 13.4048 31.3458 13.405C31.3206 13.4015 31.295 13.4015 31.2698 13.405C31.2307 13.411 31.1642 13.422 31.1336 13.473C31.1268 13.488 31.1233 13.5042 31.1233 13.5205C31.1233 13.5368 31.1268 13.553 31.1336 13.568C31.1336 13.568 31.2751 13.53 31.3299 13.634C31.3395 13.6489 31.3466 13.6651 31.3511 13.682C31.3559 13.6972 31.3577 13.7132 31.3563 13.729C31.3544 13.7454 31.3494 13.7613 31.3416 13.776C31.332 13.7938 31.3196 13.81 31.3046 13.824C31.2924 13.8325 31.2793 13.8399 31.2656 13.846C31.2544 13.8506 31.2427 13.854 31.2307 13.856C31.2009 13.8621 31.1703 13.8638 31.1399 13.861C31.0955 13.8563 31.0522 13.8441 31.0122 13.825C30.9566 13.7991 30.9095 13.7594 30.8761 13.71C30.8557 13.6794 30.8414 13.6455 30.8338 13.61C30.8287 13.5843 30.8262 13.5582 30.8264 13.532C30.8261 13.4905 30.8318 13.4491 30.8433 13.409C30.8514 13.3812 30.8627 13.3544 30.8771 13.329C30.8902 13.3055 30.9054 13.283 30.9225 13.262C30.9679 13.2115 31.026 13.1726 31.0914 13.149C31.1732 13.1185 31.2624 13.1102 31.3489 13.125C31.3671 13.1285 31.3848 13.1338 31.4017 13.141C31.4427 13.1572 31.4789 13.1826 31.5073 13.215C31.5073 13.215 31.4535 12.964 31.6603 12.848C31.6603 12.848 31.8989 12.674 32.2821 12.82C32.2821 12.82 32.4932 12.897 32.4805 13.081C32.4782 13.1145 32.4678 13.1471 32.4501 13.1762C32.4323 13.2052 32.4077 13.23 32.3782 13.2486C32.3487 13.2672 32.315 13.2791 32.2798 13.2833C32.2447 13.2875 32.2089 13.284 32.1754 13.273C32.1543 13.2658 32.1353 13.2539 32.1201 13.2382C32.1049 13.2225 32.094 13.2036 32.0883 13.183C32.0826 13.1624 32.0822 13.1408 32.0873 13.1201C32.0924 13.0994 32.1027 13.0801 32.1174 13.064C32.0931 13.0421 32.0613 13.0291 32.0278 13.0275C31.9943 13.0258 31.9613 13.0356 31.9348 13.055C31.887 13.0869 31.854 13.1351 31.8426 13.1894C31.8312 13.2438 31.8423 13.3002 31.8736 13.347C31.9046 13.4052 31.9556 13.4518 32.0182 13.479C32.0468 13.4906 32.0784 13.4938 32.109 13.488C32.1246 13.4834 32.1387 13.4751 32.1501 13.464C32.1985 13.4333 32.2506 13.4081 32.3053 13.389C32.3722 13.3635 32.4446 13.3536 32.5164 13.36C32.569 13.3642 32.6199 13.3791 32.6658 13.4038C32.7117 13.4284 32.7514 13.4622 32.7822 13.5028C32.813 13.5434 32.8342 13.5898 32.8442 13.6388C32.8543 13.6879 32.853 13.7385 32.8405 13.787C32.8405 13.787 32.8067 13.964 32.6906 13.967C32.6378 13.9706 32.5849 13.962 32.5365 13.942C32.5365 13.942 32.3602 13.859 32.5639 13.708C32.5639 13.708 32.5544 13.622 32.4267 13.63C32.2989 13.638 32.262 13.693 32.2156 13.802C32.2068 13.8506 32.2101 13.9004 32.2251 13.9476C32.2401 13.9948 32.2665 14.0381 32.3021 14.074C32.3825 14.1499 32.4896 14.1951 32.603 14.201C32.6615 14.2094 32.7213 14.2057 32.7782 14.19C32.8642 14.172 32.9457 14.138 33.0178 14.09C33.1003 14.0236 33.159 13.9344 33.1856 13.835C33.2219 13.7152 33.2355 13.5903 33.2257 13.466C33.2226 13.3888 33.1921 13.3148 33.1392 13.256C33.0927 13.2 33.0526 13.233 33.0452 13.266C33.0469 13.2865 33.0434 13.3071 33.0349 13.3261C33.0265 13.345 33.0134 13.3618 32.9967 13.375C32.9594 13.387 32.9188 13.3863 32.8819 13.373C32.8451 13.3597 32.8144 13.3345 32.7951 13.302C32.7757 13.272 32.7651 13.2378 32.7641 13.2027C32.7632 13.1676 32.772 13.1328 32.7898 13.102C32.8127 13.059 32.8468 13.0223 32.8889 12.9953C32.9311 12.9683 32.9798 12.9521 33.0305 12.948C33.1846 12.931 33.3556 13.079 33.3914 13.13C33.438 13.1867 33.4616 13.2573 33.4579 13.329Z" fill="#FDF100"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M26.7773 26.87C27.4022 27.464 27.911 27.944 28.2604 28.27C28.8167 28.793 29.203 29.152 29.7772 29.705C30.1171 30.031 30.3916 30.299 30.57 30.474C30.7386 30.6455 30.8876 30.8336 31.0143 31.035C31.0998 31.1589 31.1666 31.2935 31.2128 31.435C31.277 31.6336 31.2879 31.8443 31.2445 32.048C31.2009 32.2209 31.1212 32.3837 31.0101 32.527C30.8775 32.7111 30.7183 32.8767 30.5372 33.019C30.3128 33.2067 30.0751 33.3798 29.8258 33.537C29.5281 33.729 29.2706 33.895 28.8515 34.131C28.6119 34.266 28.0229 34.59 27.2165 34.953C26.8185 35.131 26.3277 35.337 25.7535 35.546C25.365 35.684 24.9491 35.817 24.5079 35.941C23.8382 36.128 23.1586 36.2812 22.4717 36.4C22.2336 36.4455 21.9923 36.4749 21.7497 36.488C21.4948 36.5111 21.2378 36.499 20.9866 36.452C20.8322 36.4234 20.6839 36.371 20.5475 36.297C20.4502 36.2413 20.3608 36.1741 20.2815 36.097C20.1147 35.9271 19.9943 35.7211 19.931 35.497C19.8774 35.3234 19.8421 35.1452 19.8254 34.965C19.8012 34.773 19.7917 34.617 19.7853 34.477C19.7674 34.083 19.7758 33.823 19.7801 33.477C19.7801 33.192 19.7801 32.907 19.7801 32.622C19.7801 30.41 19.7801 30.366 19.7801 30.044C19.7801 29.815 19.7801 29.703 19.7801 29.496C19.7801 29.196 19.7727 29.16 19.7801 29.005C19.7864 28.771 19.8065 28.589 19.8212 28.443C19.8402 28.269 19.8613 28.121 19.8793 28.008C19.9428 27.6855 20.0687 27.377 20.2508 27.098C20.3519 26.9447 20.4697 26.8019 20.6023 26.672C20.7145 26.5627 20.836 26.4624 20.9655 26.372C21.1076 26.2735 21.258 26.1863 21.4151 26.111C21.5806 26.0302 21.7508 25.9584 21.925 25.896C22.1709 25.808 22.5509 25.678 23.0607 25.534C23.2844 25.4794 23.5139 25.4492 23.7447 25.444C23.9126 25.444 24.2271 25.444 24.2271 25.444C24.4129 25.472 24.5969 25.5101 24.7781 25.558C24.9643 25.611 25.1445 25.681 25.3165 25.767C25.4687 25.8417 25.6154 25.9263 25.7556 26.02C25.9485 26.1472 26.1326 26.2862 26.3066 26.436C26.4322 26.553 26.5947 26.7 26.7773 26.87ZM22.819 30.9299L22.723 30.9469C22.6271 30.9678 22.5335 30.9969 22.4432 31.0339C22.383 31.0559 22.3251 31.083 22.2701 31.1149C22.1857 31.1682 22.1084 31.231 22.04 31.3019C22.0284 31.3139 21.9809 31.3589 21.926 31.4239C21.906 31.4459 21.8849 31.4719 21.8025 31.5789L21.7065 31.7029C21.5861 31.8669 21.526 31.9499 21.5217 32.0519C21.5202 32.1224 21.54 32.1918 21.5787 32.2519C21.6101 32.3024 21.6534 32.3452 21.7054 32.3769C21.7405 32.3995 21.7789 32.417 21.8194 32.4289C21.8502 32.4378 21.8822 32.4422 21.9144 32.4419C21.9295 32.443 21.9447 32.443 21.9598 32.4419L21.9893 32.4349H22.0115C22.0189 32.4349 22.02 32.4349 22.0221 32.4299C22.0259 32.428 22.0291 32.4253 22.0316 32.4219C22.0356 32.4164 22.0388 32.4103 22.0411 32.4039L22.0527 32.3869C22.059 32.3769 22.0654 32.3699 22.0675 32.3669C22.0696 32.3639 22.0759 32.3569 22.0875 32.3429C22.0923 32.3359 22.0976 32.3292 22.1033 32.3229C22.1078 32.3169 22.1132 32.3116 22.1192 32.3069L22.1371 32.2919L22.1519 32.2789C22.1878 32.2459 22.2216 32.2179 22.2501 32.1959C22.2929 32.1601 22.3381 32.1267 22.3852 32.0959C22.4205 32.0722 22.4584 32.0521 22.4981 32.0359C22.5157 32.0292 22.5337 32.0235 22.552 32.0189C22.5688 32.0279 22.5921 32.0409 22.6185 32.0579C22.6813 32.0997 22.7378 32.1495 22.7863 32.2059C22.799 32.2199 22.818 32.2419 22.8401 32.2699C22.8782 32.318 22.9104 32.37 22.9362 32.4249C22.9526 32.4609 22.965 32.4985 22.9731 32.5369C22.9834 32.5772 22.9863 32.6188 22.9816 32.6599C22.979 32.6839 22.973 32.7075 22.9636 32.7299C22.939 32.785 22.9031 32.835 22.8581 32.8769L22.7599 32.9999C22.6691 33.1153 22.5859 33.2359 22.5108 33.3609C22.457 33.4499 22.4285 33.5049 22.4052 33.5439C22.382 33.5829 22.3662 33.6269 22.3546 33.6549C22.3229 33.7299 22.3029 33.7859 22.2786 33.8549C22.2543 33.9239 22.2121 34.0419 22.1899 34.1269C22.1899 34.1359 22.1804 34.1649 22.1688 34.2029L22.1445 34.2749C22.1329 34.3069 22.1245 34.3299 22.1076 34.3749C22.0907 34.4199 22.0748 34.4599 22.0748 34.4599H22.5456C22.5581 34.4371 22.5677 34.4129 22.5741 34.3879C22.5819 34.3606 22.5859 34.3323 22.5857 34.3039C22.591 34.2859 22.5984 34.2679 22.6047 34.2499C22.6111 34.2319 22.6258 34.1999 22.6364 34.1779C22.6419 34.1688 22.6487 34.1604 22.6565 34.1529L22.6765 34.1349L22.6913 34.1199C22.6955 34.1131 22.6983 34.1057 22.6997 34.0979C22.7011 34.0893 22.7011 34.0806 22.6997 34.0719C22.6997 34.0589 22.7082 34.0389 22.7156 34.0149C22.7374 33.9405 22.7656 33.868 22.8 33.7979C22.8517 33.6661 22.9227 33.5419 23.0111 33.4289C23.0301 33.4089 23.0628 33.3769 23.1272 33.3139C23.1272 33.3139 23.2032 33.2399 23.3056 33.1529C23.3316 33.1303 23.3591 33.1093 23.388 33.0899C23.4093 33.0754 23.4315 33.0621 23.4545 33.0499C23.4589 33.0529 23.4622 33.0571 23.464 33.0619C23.4649 33.0666 23.4649 33.0713 23.464 33.0759C23.4648 33.0876 23.4648 33.0993 23.464 33.1109C23.464 33.1209 23.464 33.1279 23.464 33.1309C23.464 33.1539 23.4555 33.1889 23.4492 33.2169C23.4276 33.3002 23.4016 33.3823 23.3711 33.4629C23.3658 33.4749 23.3595 33.4919 23.3521 33.5119C23.3431 33.5353 23.3368 33.5594 23.3331 33.5839C23.3284 33.6253 23.3341 33.6671 23.35 33.7059C23.3589 33.7299 23.3702 33.753 23.3837 33.7749C23.4015 33.8021 23.422 33.8275 23.445 33.8509L23.5252 33.9419C23.5357 33.9539 23.5526 33.9719 23.5716 33.9969L23.6043 34.0439L23.6476 34.1059C23.6616 34.1229 23.6768 34.1389 23.693 34.1539C23.7132 34.1698 23.7355 34.1829 23.7595 34.1929C23.7974 34.2099 23.8381 34.2204 23.8798 34.2239C23.9548 34.2329 24.0435 34.2429 24.1458 34.2519C24.1458 34.2379 24.1458 34.2149 24.1385 34.1879C24.1311 34.1609 24.1332 34.1619 24.13 34.1359C24.1268 34.1099 24.13 34.1019 24.1205 34.0659C24.1205 34.0529 24.1205 34.0399 24.1131 34.0229C24.1057 34.0059 24.1131 34.0049 24.1057 33.9869C24.0983 33.9689 24.1057 33.9589 24.0983 33.9509C24.0827 33.9166 24.0566 33.8873 24.0234 33.8669C24.0137 33.8627 24.0034 33.8596 23.9928 33.8579H23.9759C23.9645 33.8557 23.9535 33.852 23.9432 33.8469L23.9231 33.8359C23.8866 33.8015 23.8563 33.7616 23.8334 33.7179C23.8148 33.6861 23.7996 33.6526 23.788 33.6179C23.788 33.6009 23.7796 33.5869 23.7775 33.5769C23.7753 33.5669 23.7775 33.5639 23.7775 33.5539C23.8016 33.4429 23.8554 33.3396 23.9337 33.2539C23.972 33.21 24.0156 33.1704 24.0635 33.1359C24.0871 33.1203 24.1118 33.1063 24.1374 33.0939C24.1509 33.0871 24.1651 33.0814 24.1796 33.0769C24.2077 33.0686 24.2368 33.0636 24.2662 33.0619C24.3073 33.0619 24.3137 33.0539 24.3485 33.0489C24.4273 33.0388 24.5066 33.0328 24.586 33.0309C24.6916 33.0309 24.7433 33.0309 24.87 33.0309C24.9132 33.0309 24.9343 33.0309 24.9555 33.0309C24.9801 33.0297 25.0047 33.0297 25.0293 33.0309C25.056 33.0327 25.0822 33.0377 25.1075 33.0459C25.1283 33.0536 25.1485 33.063 25.1676 33.0739C25.2025 33.0936 25.235 33.1168 25.2647 33.1429C25.2993 33.1722 25.332 33.2032 25.3629 33.2359L25.422 33.2949L25.4558 33.3279C25.4641 33.3365 25.4719 33.3455 25.479 33.3549C25.4849 33.3617 25.4898 33.3691 25.4938 33.3769C25.5043 33.3985 25.5072 33.4227 25.5022 33.4459C25.4945 33.4815 25.4799 33.5155 25.459 33.5459C25.4421 33.5759 25.4336 33.5919 25.422 33.6089C25.3748 33.6789 25.3226 33.7457 25.2658 33.8089C25.2658 33.8089 25.1602 33.9339 25.0251 34.0749L24.9882 34.1149C24.966 34.135 24.9452 34.1564 24.9259 34.1789C24.9127 34.1997 24.9014 34.2214 24.8921 34.2439C24.8789 34.2723 24.8673 34.3014 24.8573 34.3309C24.8462 34.3638 24.837 34.3971 24.8298 34.4309L25.3281 34.4149C25.3281 34.3959 25.3344 34.3789 25.3365 34.3679C25.346 34.3229 25.3534 34.3129 25.3587 34.3079C25.3665 34.2989 25.3757 34.2912 25.3861 34.2849C25.4009 34.2759 25.4041 34.2789 25.4167 34.2709C25.4319 34.2619 25.4448 34.25 25.4547 34.2359C25.4617 34.2246 25.4681 34.2129 25.4737 34.2009C25.4822 34.1829 25.4822 34.1799 25.4906 34.1649L25.5075 34.1379L25.5233 34.1139C25.5297 34.1059 25.5392 34.0929 25.5518 34.0789L25.5825 34.0469L25.6183 34.0079C25.6933 33.9229 25.7746 33.8179 25.7746 33.8179C25.7746 33.8179 25.8284 33.7479 25.8801 33.6799C25.896 33.6579 25.9097 33.6379 25.9107 33.6349C25.9118 33.6319 25.934 33.6009 25.9498 33.5749C25.9561 33.5659 25.9751 33.5349 25.9931 33.5019L26.0089 33.4679C26.0125 33.4605 26.0157 33.4528 26.0184 33.4449C26.0178 33.4413 26.0178 33.4376 26.0184 33.4339C26.0184 33.4199 26.0184 33.4149 26.0184 33.4119C26.0188 33.41 26.0188 33.4079 26.0184 33.4059H26.0553C26.0887 33.4051 26.1219 33.4099 26.1535 33.4199C26.1786 33.4283 26.2022 33.4404 26.2232 33.4559C26.2543 33.4802 26.2795 33.5105 26.2971 33.5449C26.3075 33.5623 26.3166 33.5804 26.3245 33.5989C26.3485 33.6548 26.3679 33.7123 26.3826 33.7709C26.3826 33.7859 26.3921 33.8069 26.4016 33.8369C26.4111 33.8669 26.4079 33.8569 26.4174 33.8859C26.4343 33.9359 26.4332 33.9349 26.4406 33.9579C26.448 33.9809 26.4406 33.9639 26.4744 34.0449C26.4837 34.0709 26.4947 34.0962 26.5071 34.1209L26.5198 34.1439C26.5448 34.1803 26.5775 34.2113 26.6158 34.2349L26.6412 34.2509C26.6477 34.256 26.6548 34.2604 26.6623 34.2639C26.6692 34.2673 26.6767 34.2693 26.6845 34.2699C26.6939 34.2709 26.7035 34.2709 26.713 34.2699H26.9747C26.9842 34.2688 26.9938 34.2688 27.0032 34.2699H27.0159C27.0159 34.2699 27.0222 34.2699 27.0243 34.2699C27.0265 34.2699 27.0243 34.2699 27.0243 34.2639C27.0242 34.2619 27.0242 34.2599 27.0243 34.2579C27.0271 34.2207 27.0271 34.1832 27.0243 34.1459C27.022 34.1143 27.0171 34.0829 27.0096 34.0519C27.0048 34.0222 26.9949 33.9935 26.98 33.9669C26.9694 33.9456 26.9539 33.9268 26.9346 33.9119L26.9135 33.8999C26.9009 33.8937 26.8879 33.8883 26.8745 33.8839C26.8407 33.8709 26.8354 33.8669 26.808 33.8579L26.79 33.8519C26.79 33.8409 26.7816 33.8249 26.7763 33.8049C26.7636 33.7579 26.7499 33.7049 26.732 33.6209C26.7214 33.5739 26.713 33.5319 26.6961 33.4469C26.6961 33.4349 26.6802 33.3649 26.6623 33.2829C26.6623 33.2829 26.6496 33.2199 26.6317 33.1579C26.6317 33.1529 26.6253 33.1389 26.6211 33.1249C26.6205 33.1193 26.6205 33.1136 26.6211 33.1079C26.6198 33.1035 26.6181 33.0991 26.6158 33.0949C26.6125 33.0893 26.6078 33.0845 26.6021 33.0809L26.58 33.0659C26.5612 33.0579 26.5418 33.0512 26.5219 33.0459L26.486 33.0389L26.4406 33.0309L26.4121 33.0249L26.3857 33.0169C26.3735 33.0133 26.362 33.0075 26.352 32.9999C26.3451 32.9947 26.3393 32.9883 26.3351 32.9809C26.3351 32.9759 26.3351 32.9669 26.3351 32.9569C26.3351 32.8369 26.3435 32.7749 26.3425 32.7149C26.3424 32.6695 26.3395 32.6241 26.334 32.5789C26.332 32.5591 26.3288 32.5394 26.3245 32.5199C26.3193 32.4923 26.3105 32.4654 26.2981 32.4399C26.2908 32.4219 26.28 32.4053 26.2665 32.3909C26.2603 32.3844 26.2536 32.3784 26.2464 32.3729L26.2897 32.3899C26.3182 32.4019 26.3488 32.4149 26.3847 32.4339C26.4215 32.4545 26.4568 32.4776 26.4902 32.5029C26.5125 32.519 26.5337 32.5363 26.5536 32.5549C26.5754 32.5747 26.5955 32.5961 26.6137 32.6189C26.6353 32.6462 26.6547 32.675 26.6718 32.7049C26.6907 32.741 26.7072 32.778 26.7214 32.8159C26.732 32.8409 26.7425 32.8689 26.7615 32.9159C26.7805 32.9629 26.7953 33.0079 26.8101 33.0499C26.8248 33.0919 26.8512 33.1759 26.8734 33.2679C26.8734 33.2889 26.8861 33.3139 26.8966 33.3429C26.9072 33.3719 26.9114 33.3839 26.9251 33.4149C26.9409 33.4475 26.9585 33.4792 26.9779 33.5099C26.9984 33.5408 27.0217 33.5699 27.0476 33.5969C27.0736 33.6249 27.1018 33.651 27.132 33.6749C27.1407 33.6825 27.1499 33.6895 27.1595 33.6959C27.179 33.7089 27.1995 33.7206 27.2207 33.7309L27.2703 33.7529C27.299 33.7653 27.3291 33.7747 27.36 33.7809C27.383 33.7853 27.4063 33.7879 27.4297 33.7889C27.4458 33.7904 27.4621 33.7904 27.4782 33.7889C27.553 33.7807 27.6229 33.7498 27.6777 33.7009C27.7007 33.6816 27.7215 33.6602 27.74 33.6369C27.7569 33.6169 27.7725 33.5959 27.7865 33.5739L27.7548 33.5439L27.6714 33.4629C27.644 33.4349 27.625 33.4169 27.6028 33.3929C27.5688 33.3581 27.5371 33.3214 27.5078 33.2829C27.48 33.2467 27.4556 33.2082 27.435 33.1679C27.4181 33.1318 27.4036 33.0948 27.3917 33.0569C27.3811 33.0249 27.3727 32.9979 27.3685 32.9779C27.3642 32.9579 27.3495 32.9049 27.3347 32.8569C27.31 32.7789 27.2793 32.7027 27.2428 32.6289C27.2197 32.5823 27.194 32.5369 27.1658 32.4929C27.132 32.4409 27.1025 32.4049 27.0972 32.3929C27.0335 32.3148 26.9597 32.2446 26.8776 32.1839C26.8336 32.1505 26.7874 32.1198 26.7393 32.0919C26.6701 32.0534 26.5969 32.0215 26.5208 31.9969C26.4184 31.9626 26.3122 31.9394 26.2042 31.9279C26.1527 31.9221 26.1009 31.9191 26.049 31.9189L26.0047 31.8889C25.9264 31.8371 25.8434 31.7919 25.7566 31.7539C25.7228 31.7389 25.7007 31.7289 25.6669 31.7159C25.6088 31.6949 25.5983 31.6969 25.5086 31.6699C25.459 31.6549 25.4315 31.6449 25.3808 31.6259C25.3578 31.6178 25.3352 31.6085 25.3133 31.5979C25.2944 31.5889 25.2761 31.5789 25.2584 31.5679C25.2584 31.5679 25.2373 31.5529 25.2215 31.5379C25.193 31.5095 25.1717 31.4753 25.1592 31.4379C25.1397 31.382 25.1287 31.3238 25.1265 31.2649C25.1237 31.222 25.1237 31.1789 25.1265 31.1359C25.1265 31.0779 25.1265 31.0359 25.1349 30.9869C25.1433 30.9379 25.1455 30.8719 25.1613 30.7869C25.1771 30.7019 25.1982 30.6169 25.1982 30.6169C25.1982 30.6169 25.2109 30.5899 25.2151 30.5819L25.2352 30.5539L25.2552 30.5289L25.2943 30.4819C25.3017 30.4729 25.3038 30.4719 25.3386 30.4359L25.3766 30.3999L25.4505 30.3229L25.6247 30.1449C25.7102 30.0559 25.6595 30.1059 25.7598 29.9989C25.7846 29.972 25.8075 29.9437 25.8284 29.9139C25.8425 29.8944 25.8552 29.8741 25.8664 29.8529C25.8741 29.8417 25.8795 29.8291 25.8822 29.8159C25.8833 29.8063 25.8833 29.7966 25.8822 29.7869C25.8822 29.7649 25.8822 29.7599 25.8822 29.7449C25.8886 29.6649 25.8896 29.6029 25.8896 29.6029C25.8902 29.5395 25.8867 29.476 25.8791 29.4129C25.8738 29.3739 25.8664 29.3409 25.8664 29.3409C25.8601 29.3089 25.8506 29.2679 25.8506 29.2679L25.973 29.2569L25.8453 29.0219L25.9139 29.0639L25.9656 29.0969L26.0163 29.1299L26.0606 29.1569C26.0741 29.1661 26.0891 29.1732 26.105 29.1779C26.1153 29.1806 26.1263 29.1806 26.1366 29.1779C26.1467 29.1753 26.1563 29.1713 26.1651 29.1659C26.1748 29.1599 26.1839 29.1532 26.1926 29.1459C26.2074 29.133 26.2215 29.1193 26.2348 29.1049L26.2612 29.0739C26.2665 29.0683 26.2715 29.0623 26.276 29.0559C26.2812 29.0496 26.2855 29.0425 26.2886 29.0349C26.2924 29.0274 26.2945 29.0193 26.295 29.0109C26.2952 29.0013 26.293 28.9917 26.2886 28.9829C26.2821 28.9696 26.2727 28.9577 26.2612 28.9479C26.2549 28.9409 26.2478 28.9345 26.2401 28.9289C26.2228 28.9143 26.2041 28.9012 26.1841 28.8899C26.1471 28.8689 26.1118 28.8451 26.0786 28.8189C26.0501 28.7969 26.0543 28.7969 26.0258 28.7749C26.0046 28.7599 25.9845 28.7435 25.9656 28.7259C25.9558 28.7165 25.9466 28.7065 25.9382 28.6959C25.9192 28.6749 25.9044 28.6569 25.897 28.6469C25.8615 28.5996 25.8288 28.5506 25.7988 28.4999C25.7904 28.4869 25.782 28.4739 25.7714 28.4559C25.7599 28.4347 25.75 28.4126 25.7418 28.3899C25.7367 28.379 25.7328 28.3676 25.7302 28.3559C25.7288 28.3467 25.7288 28.3372 25.7302 28.3279C25.7298 28.3236 25.7298 28.3193 25.7302 28.3149C25.7302 28.3149 25.7302 28.3079 25.7387 28.3029C25.7489 28.2945 25.7621 28.2902 25.7756 28.2909C25.7925 28.2904 25.8093 28.2928 25.8252 28.2979C25.8474 28.2979 25.8548 28.3069 25.9044 28.3229L25.9371 28.3339L25.9888 28.3539C26.0184 28.3659 26.0437 28.3779 26.0638 28.3879C26.0838 28.3979 26.1335 28.4209 26.1841 28.4479L26.2601 28.4929C26.2814 28.5051 26.3018 28.5184 26.3213 28.5329L26.3372 28.5459L26.3446 28.5519C26.3494 28.5557 26.3537 28.5601 26.3572 28.5649C26.3572 28.5709 26.3572 28.5739 26.3625 28.5739C26.3678 28.5739 26.3625 28.5689 26.3625 28.5589C26.3633 28.5506 26.3633 28.5423 26.3625 28.5339C26.3599 28.503 26.3535 28.4725 26.3435 28.4429C26.3435 28.4359 26.3319 28.4109 26.314 28.3729C26.314 28.3659 26.295 28.3359 26.2749 28.3019C26.2016 28.1836 26.119 28.0706 26.0279 27.9639C26.0047 27.9379 25.9698 27.8979 25.9223 27.8519C25.8575 27.7836 25.7869 27.7204 25.7112 27.6629C25.6915 27.6482 25.6707 27.6349 25.649 27.6229C25.6238 27.6078 25.5977 27.5941 25.5708 27.5819L25.5075 27.5539C25.478 27.5419 25.44 27.5269 25.3956 27.5129C25.3956 27.5129 25.3608 27.5019 25.3196 27.4919C25.3013 27.4877 25.2825 27.4857 25.2637 27.4859H25.2405C25.2114 27.486 25.1831 27.4943 25.1592 27.5099C25.1258 27.5348 25.1033 27.5704 25.0958 27.6099C25.0892 27.6371 25.0871 27.6651 25.0895 27.6929C25.0895 27.7059 25.0895 27.7089 25.0895 27.7319C25.0904 27.7507 25.0925 27.7694 25.0958 27.7879C25.0973 27.7958 25.0994 27.8034 25.1022 27.8109C25.0742 27.7999 25.0457 27.7902 25.0167 27.7819C25.0082 27.7819 24.9766 27.7699 24.946 27.7639C24.8819 27.7477 24.8147 27.7457 24.7496 27.7579C24.7051 27.7658 24.6635 27.7848 24.6293 27.8129C24.6131 27.8294 24.5989 27.8475 24.5871 27.8669C24.574 27.8906 24.5644 27.9158 24.5586 27.9419C24.5577 27.9559 24.5577 27.97 24.5586 27.9839C24.5591 27.9966 24.5616 28.009 24.566 28.0209C24.5652 28.0236 24.5652 28.0263 24.566 28.0289C24.5675 28.0312 24.5697 28.0329 24.5723 28.0339C24.5802 28.0232 24.5902 28.014 24.6018 28.0069C24.6154 27.9995 24.6306 27.9951 24.6462 27.9939C24.6647 27.9913 24.6836 27.9913 24.7021 27.9939C24.7412 28.0051 24.7772 28.0242 24.8077 28.0499C24.8201 28.061 24.8311 28.0734 24.8404 28.0869C24.8437 28.0913 24.8465 28.096 24.8488 28.1009C24.8589 28.1176 24.8637 28.1367 24.8626 28.1559C24.8617 28.1689 24.8577 28.1816 24.851 28.1929H24.6557C24.6061 28.1929 24.566 28.1929 24.5364 28.1999C24.5068 28.2069 24.4731 28.2069 24.4308 28.2149C24.3936 28.2205 24.3577 28.2327 24.3253 28.2509C24.3075 28.2621 24.2921 28.2763 24.2799 28.2929C24.2721 28.3058 24.266 28.3196 24.262 28.3339C24.258 28.3443 24.2556 28.355 24.2546 28.3659C24.252 28.3812 24.252 28.3967 24.2546 28.4119C24.2623 28.4417 24.2736 28.4706 24.2883 28.4979C24.3097 28.5346 24.3364 28.5682 24.3675 28.5979C24.3886 28.6199 24.4055 28.6349 24.4245 28.6529C24.4435 28.6709 24.4636 28.6899 24.5037 28.7229C24.5681 28.7779 24.6219 28.8169 24.6398 28.8309C24.6789 28.8589 24.7348 28.8999 24.813 28.9459C24.8745 28.9863 24.9407 29.0199 25.0103 29.0459C25.0449 29.0579 25.0801 29.0679 25.1159 29.0759C25.0958 29.0389 25.08 29.0059 25.0684 28.9819C25.0568 28.9579 25.0357 28.9139 25.0177 28.8679C25.0061 28.8389 25.0008 28.8249 24.9966 28.8109C24.984 28.7659 24.965 28.6979 24.9966 28.6619C25.0077 28.6518 25.0216 28.6448 25.0367 28.6419C25.0562 28.6416 25.0757 28.6433 25.0948 28.6469C25.1168 28.6503 25.1383 28.6556 25.1592 28.6629C25.1717 28.6663 25.184 28.6703 25.1961 28.6749C25.2691 28.7032 25.3396 28.7366 25.4072 28.7749C25.383 28.8136 25.3638 28.8549 25.3502 28.8979C25.3412 28.9258 25.3341 28.9542 25.3291 28.9829C25.3217 29.0159 25.3122 29.0649 25.3038 29.1299C25.3038 29.1649 25.2953 29.2069 25.2932 29.2549H25.3735C25.3735 29.2909 25.3798 29.3199 25.3819 29.3389C25.384 29.3579 25.3819 29.3849 25.3903 29.4219C25.3903 29.4219 25.3903 29.4409 25.3903 29.4769C25.3915 29.4919 25.3915 29.507 25.3903 29.5219C25.3878 29.5376 25.3836 29.5531 25.3777 29.5679C25.3684 29.591 25.3567 29.6131 25.3428 29.6339C25.3155 29.6737 25.2852 29.7114 25.2521 29.7469C25.2095 29.7932 25.1644 29.8372 25.117 29.8789C25.084 29.9073 25.0487 29.933 25.0114 29.9559C24.992 29.9683 24.9719 29.9797 24.9512 29.9899L24.9227 29.9979H24.8995C24.8805 29.9979 24.8615 29.9979 24.852 29.9909C24.8425 29.9839 24.8436 29.9639 24.852 29.9449C24.8544 29.9297 24.859 29.9149 24.8657 29.9009C24.8657 29.8879 24.8763 29.8699 24.8837 29.8459C24.8948 29.8117 24.9022 29.7766 24.9058 29.7409C24.9166 29.6884 24.915 29.6342 24.9009 29.5823C24.8868 29.5304 24.8608 29.4821 24.8246 29.4409C24.779 29.4005 24.7201 29.3761 24.6578 29.3719C24.6075 29.364 24.5561 29.364 24.5058 29.3719C24.4563 29.3781 24.4086 29.3934 24.3654 29.4169C24.3215 29.44 24.2833 29.4717 24.2535 29.5099C24.2129 29.5611 24.1871 29.6214 24.1786 29.6849C24.1713 29.7401 24.177 29.7961 24.1955 29.8489C24.2011 29.8723 24.21 29.8948 24.2218 29.9159C24.2372 29.9415 24.256 29.965 24.2778 29.9859C24.2938 30.0022 24.3111 30.0172 24.3295 30.0309C24.3496 30.0519 24.3628 30.078 24.3675 30.1059C24.3692 30.1331 24.3638 30.1602 24.3517 30.1849C24.344 30.2089 24.333 30.2318 24.319 30.2529C24.2967 30.2851 24.2701 30.3143 24.2398 30.3399L24.1458 30.4399C24.129 30.4579 24.0698 30.5219 24.015 30.5889C23.9723 30.6573 23.9336 30.7277 23.8988 30.7999C23.8218 30.9209 23.8334 30.9239 23.7627 31.0279C23.731 31.0749 23.7057 31.1069 23.6571 31.1829C23.6276 31.2269 23.6054 31.2639 23.5906 31.2829C23.5283 31.2609 23.4787 31.2469 23.445 31.2369C23.331 31.2059 23.2286 31.1879 23.0449 31.1499L22.9932 31.1389L22.913 31.1209C22.8844 31.115 22.8588 31.1002 22.8401 31.0789C22.8316 31.0649 22.8266 31.0491 22.8254 31.0329C22.8207 30.9988 22.8186 30.9644 22.819 30.9299ZM20.6414 34.3469C20.6414 34.3469 21.0847 34.3779 21.2652 34.4159C21.5338 34.4422 21.8038 34.4526 22.0738 34.4469H22.5445C22.5445 34.4469 24.6778 34.4169 24.8414 34.4119L25.3397 34.3959C25.3397 34.3959 28.1707 34.3539 28.3638 34.3959L27.7717 34.6959C27.7717 34.6959 27.2893 34.7339 26.5578 34.7279C25.8263 34.7219 25.2162 34.7129 24.9269 34.7129C24.6377 34.7129 24.2936 34.7129 23.7152 34.7309C23.1367 34.7489 22.687 34.7639 22.3735 34.7719C22.06 34.7799 21.3254 34.7919 21.0509 34.7829C21.0509 34.7829 20.5527 34.8239 20.5126 34.8289C20.5126 34.8289 20.4904 34.8289 20.5284 34.6289C20.5664 34.4289 20.6087 34.3439 20.6414 34.3469Z" fill="#375BD2"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.06551 29.861C8.9184 29.056 9.49368 28.511 9.86946 28.155C10.1492 27.889 10.4331 27.627 10.7139 27.355C10.9947 27.083 11.1667 26.913 11.4612 26.655C11.6723 26.472 11.8465 26.328 11.9679 26.231C12.1249 26.1081 12.2915 25.9964 12.4661 25.897C12.6248 25.8028 12.7919 25.7218 12.9654 25.655C13.2196 25.5572 13.4866 25.4922 13.7592 25.462C13.9147 25.4449 14.0714 25.4389 14.2278 25.444C14.3874 25.4497 14.5464 25.4651 14.7039 25.49C14.9288 25.5271 15.1507 25.5792 15.3678 25.646C15.4734 25.678 15.599 25.724 15.8481 25.815C16.1764 25.935 16.3411 25.996 16.4688 26.054C16.674 26.1472 16.8703 26.257 17.0557 26.382C17.3819 26.6076 17.6512 26.8989 17.8442 27.235C17.9751 27.4756 18.071 27.732 18.1292 27.997C18.163 28.145 18.1841 28.305 18.1851 28.312C18.2041 28.454 18.2115 28.566 18.221 28.729C18.2305 28.892 18.2337 29.016 18.2347 29.042C18.2474 29.542 18.2252 30.031 18.2252 30.031C18.2252 30.148 18.2252 30.095 18.2252 31.607C18.2252 33.259 18.2252 33.093 18.2252 33.25C18.2252 33.407 18.2252 33.716 18.2252 34.323C18.2252 34.389 18.2252 34.548 18.2073 34.756C18.1978 34.871 18.1862 34.965 18.1788 35.026C18.1657 35.1426 18.1441 35.2582 18.1144 35.372C18.0854 35.4971 18.043 35.6191 17.9877 35.736C17.8996 35.9309 17.7596 36.1008 17.5813 36.229C17.4489 36.3182 17.3005 36.384 17.1433 36.423C17.0778 36.4407 17.0111 36.4544 16.9438 36.464C16.7139 36.4965 16.4808 36.5032 16.2492 36.484C15.9633 36.4621 15.6789 36.4247 15.3974 36.372C14.8348 36.262 14.3841 36.172 13.7328 35.998C13.4108 35.912 13.0235 35.807 12.52 35.632C12.52 35.632 12.3395 35.569 11.3968 35.214C10.5446 34.8672 9.72048 34.4614 8.93107 34C8.60174 33.807 8.29035 33.61 7.9969 33.414C7.81882 33.2998 7.64919 33.1742 7.48918 33.038C7.3184 32.9039 7.16562 32.7504 7.03424 32.581C6.86602 32.3823 6.76094 32.1423 6.73129 31.889C6.72331 31.7751 6.73184 31.6607 6.75663 31.549C6.78517 31.4219 6.83205 31.2991 6.89596 31.184C7.01799 30.9643 7.16678 30.7589 7.33929 30.572C7.48601 30.407 7.6169 30.281 7.87657 30.032C7.95363 29.961 8.01696 29.9 8.06551 29.861ZM18.2136 34.473C18.2136 34.473 14.8126 34.51 14.7451 34.518C14.7451 34.518 15.1905 34.098 14.9752 33.751C14.7598 33.404 14.3524 33.24 13.8605 33.043L13.5248 32.917C13.3864 32.852 13.2602 32.7658 13.1512 32.662C13.0681 32.5852 13.0014 32.4938 12.9548 32.393C12.9548 32.393 12.8313 32.123 13.0688 32.182C13.3063 32.241 13.452 32.145 13.8394 31.945C13.8394 31.945 13.9259 32.105 14.0146 32.11C14.0146 32.11 14.1054 32.11 14.193 31.99C14.2806 31.87 14.4136 31.669 14.4485 31.631C14.5135 31.5502 14.5674 31.4618 14.6089 31.368L14.9256 31.241C14.952 31.2282 14.9813 31.2214 15.0111 31.2214C15.0408 31.2214 15.0701 31.2282 15.0966 31.241L15.2602 31.186L15.3858 31.568C15.3858 31.568 15.4016 31.607 15.4217 31.608L15.4913 31.575C15.5128 31.5751 15.5335 31.5676 15.5494 31.554C15.5594 31.5454 15.5665 31.5342 15.5699 31.5217C15.5733 31.5093 15.5728 31.4962 15.5684 31.484C15.5603 31.4612 15.5493 31.4394 15.5357 31.419L15.4692 31.3031L15.3837 31.157C15.3837 31.157 15.4787 31.133 15.5483 31.119L15.6655 31.1C15.7468 31.085 15.7711 31.078 15.7711 31.078C15.7711 31.078 15.7901 31.078 15.7711 31.015C15.7485 30.9543 15.722 30.8948 15.6919 30.837C15.6687 30.7876 15.6392 30.7409 15.6043 30.698C15.6043 30.698 15.5314 30.732 15.4924 30.753C15.4533 30.774 15.4607 30.769 15.3942 30.812C15.3483 30.8397 15.2999 30.8635 15.2496 30.883L15.1557 30.916L15.0322 30.544C15.0322 30.544 15.009 30.476 14.9266 30.539C14.91 30.5462 14.8952 30.5569 14.8835 30.5702C14.8718 30.5836 14.8635 30.5992 14.8591 30.616C14.86 30.6312 14.8655 30.6458 14.8749 30.658L14.9625 30.791L15.0628 30.942L14.9963 30.965C14.9897 30.9914 14.9774 31.0161 14.9601 31.0376C14.9428 31.0591 14.921 31.077 14.896 31.09L14.61 31.2C14.61 31.2 14.5741 31.066 14.3756 31.105C14.2659 31.1215 14.1658 31.1738 14.0927 31.253C13.9908 31.2021 13.885 31.1586 13.7761 31.123C13.7064 31.111 13.6705 31.106 13.6483 31.229C13.5681 31.257 13.5016 31.278 13.4541 31.293C13.4541 31.293 13.4098 31.307 13.3486 31.323C13.3173 31.3311 13.2856 31.3374 13.2536 31.342C13.2238 31.3496 13.1925 31.3496 13.1628 31.342C13.1473 31.3352 13.1334 31.3257 13.1216 31.314C13.0857 31.2673 13.0692 31.2096 13.0752 31.152C13.0752 31.117 13.0752 31.086 13.0805 31.024C13.0805 31.002 13.0805 30.989 13.0889 30.924C13.1016 30.786 13.1016 30.782 13.1026 30.764C13.1026 30.764 13.109 30.687 13.109 30.61C13.109 30.571 13.109 30.273 12.976 30.097C12.9503 30.0602 12.9198 30.0266 12.8852 29.997C12.8521 29.9718 12.8168 29.9494 12.7796 29.93C12.7518 29.9136 12.7225 29.8996 12.692 29.888C12.6706 29.8804 12.6488 29.874 12.6266 29.869L12.5337 29.847C12.4633 29.8306 12.3947 29.8078 12.3289 29.779C12.2957 29.7644 12.2648 29.7456 12.2371 29.723C12.2212 29.7109 12.208 29.6959 12.198 29.679C12.1892 29.6637 12.1841 29.6466 12.1832 29.629C12.1824 29.6049 12.1886 29.5811 12.2012 29.56C12.218 29.5326 12.2386 29.5074 12.2624 29.485C12.2909 29.455 12.3046 29.44 12.3152 29.431C12.3692 29.3769 12.4157 29.3164 12.4535 29.251C12.4834 29.2049 12.5018 29.1529 12.5073 29.099C12.5096 29.0702 12.5074 29.0413 12.501 29.013C12.4848 28.9324 12.4364 28.8608 12.3658 28.813C12.319 28.7768 12.268 28.7456 12.2138 28.72C12.0279 28.641 11.8283 28.595 11.6248 28.584C11.5193 28.5728 11.4125 28.5858 11.3135 28.622C11.2568 28.6479 11.2045 28.6816 11.1583 28.722C11.1392 28.7404 11.1212 28.7597 11.1045 28.78C11.0872 28.8019 11.0717 28.825 11.058 28.849C11.0036 28.938 10.98 29.0408 10.9905 29.143C11.0055 29.2576 11.0583 29.3646 11.1414 29.449C11.1818 29.4827 11.2192 29.5195 11.2533 29.559C11.2628 29.57 11.2533 29.559 11.3187 29.642C11.3327 29.6588 11.3447 29.6769 11.3546 29.696C11.3668 29.7168 11.3723 29.7404 11.3705 29.764C11.3671 29.7859 11.3572 29.8063 11.342 29.823C11.321 29.8473 11.2937 29.866 11.2628 29.877C11.21 29.8972 11.1552 29.9123 11.0992 29.922C11.0422 29.935 11.0633 29.932 10.9546 29.959C10.9155 29.969 10.886 29.976 10.849 29.989C10.8121 30.002 10.8216 30 10.7825 30.013C10.7086 30.039 10.7002 30.037 10.6664 30.053C10.6392 30.0654 10.6136 30.0808 10.5904 30.099C10.5614 30.1226 10.5352 30.1491 10.5123 30.178C10.4926 30.2012 10.4746 30.2256 10.4585 30.251C10.4216 30.3079 10.3919 30.3687 10.3698 30.432C10.3434 30.5 10.3276 30.54 10.3075 30.605C10.2663 30.736 10.202 30.993 10.1196 31.325C10.0616 31.4595 10.034 31.6039 10.0383 31.749C10.0446 31.7943 10.0556 31.8388 10.0711 31.882C10.08 31.9084 10.0916 31.9339 10.1059 31.958C10.1565 32.0296 10.228 32.0855 10.3117 32.119C10.3523 32.1388 10.3943 32.1559 10.4373 32.17C10.4891 32.186 10.5429 32.199 10.5883 32.211L10.6833 32.235C10.7297 32.248 10.7445 32.253 10.7561 32.257C10.7882 32.2684 10.8182 32.2846 10.8448 32.305L10.8627 32.321C10.8691 32.327 10.8712 32.328 10.8733 32.332C10.876 32.3402 10.876 32.3489 10.8733 32.357C10.872 32.3757 10.872 32.3944 10.8733 32.413C10.8724 32.4382 10.8699 32.4632 10.8659 32.488C10.8388 32.5987 10.7984 32.7061 10.7456 32.808C10.7297 32.838 10.7044 32.884 10.6527 32.975L10.5207 33.21C10.507 33.234 10.4848 33.272 10.4595 33.326C10.4447 33.354 10.4316 33.3827 10.4205 33.412C10.3986 33.4653 10.3813 33.5202 10.3687 33.576C10.3529 33.638 10.3437 33.7013 10.3413 33.765C10.3395 33.8112 10.3423 33.8574 10.3497 33.9031C10.3601 33.9693 10.3789 34.0341 10.4057 34.096C10.4638 34.2225 10.5469 34.3372 10.6506 34.4341H9.8779L9.99084 34.577L10.3075 34.733L18.1925 34.699L18.2136 34.473ZM15.2897 26.723C15.4466 26.7592 15.5978 26.8147 15.7394 26.888C15.8586 26.9474 15.9693 27.021 16.0687 27.107C16.1679 27.1885 16.2515 27.2856 16.3157 27.394C16.3475 27.4497 16.374 27.5079 16.3949 27.568C16.4187 27.6399 16.4308 27.7148 16.4308 27.7901C16.4309 27.8377 16.4263 27.8852 16.4171 27.932C16.3884 28.0707 16.3302 28.2024 16.2461 28.319C16.1803 28.4132 16.1015 28.4987 16.0117 28.573C15.9526 28.6233 15.8894 28.6691 15.8228 28.71C15.6621 28.8143 15.4746 28.8755 15.2802 28.887C15.2337 28.8865 15.1871 28.8834 15.1409 28.8781C15.034 28.8652 14.9294 28.8394 14.8295 28.8011C14.6775 28.7491 14.5382 28.6684 14.42 28.5641C14.3319 28.4978 14.2719 28.4037 14.2511 28.299C14.2486 28.2778 14.2486 28.2563 14.2511 28.235C14.2427 28.2256 14.2372 28.2143 14.235 28.2022C14.2327 28.19 14.2339 28.1776 14.2384 28.166C14.2443 28.1549 14.2528 28.1452 14.2632 28.1375C14.2736 28.1299 14.2857 28.1246 14.2986 28.122C14.3165 28.122 14.345 28.122 14.3788 28.117C14.4368 28.117 14.4685 28.122 14.5118 28.124C14.564 28.1258 14.6163 28.1231 14.668 28.116C14.7391 28.1097 14.8096 28.0987 14.8791 28.0831C15.012 28.0496 15.1346 27.9869 15.237 27.9C15.3324 27.8175 15.4025 27.712 15.4397 27.5947C15.4768 27.4774 15.4798 27.3528 15.4481 27.2341C15.4358 27.1817 15.4185 27.1304 15.3964 27.081C15.3771 27.0329 15.3523 26.987 15.3225 26.944C15.2868 26.9042 15.2615 26.8569 15.2486 26.806C15.2461 26.7948 15.2461 26.7833 15.2486 26.772C15.2553 26.7514 15.27 26.7339 15.2897 26.723ZM14.7525 28.321C14.7555 28.3136 14.7606 28.307 14.7672 28.302C14.7781 28.2956 14.7903 28.2913 14.803 28.2894C14.8157 28.2875 14.8287 28.288 14.8411 28.291H14.9192C14.9445 28.2929 14.9699 28.2929 14.9952 28.291C15.0068 28.291 15.0322 28.291 15.0638 28.284C15.1115 28.2766 15.1582 28.2645 15.2032 28.248C15.2354 28.2355 15.2667 28.2211 15.2971 28.205C15.3689 28.1669 15.4349 28.1198 15.4935 28.065C15.5631 28.0015 15.6222 27.9283 15.6687 27.848C15.7146 27.7702 15.749 27.6867 15.7711 27.6C15.7746 27.5668 15.7746 27.5333 15.7711 27.5C15.7703 27.4749 15.7678 27.4499 15.7637 27.425C15.7736 27.4136 15.7858 27.4041 15.7996 27.397C15.8205 27.3843 15.8456 27.379 15.8703 27.382C15.8875 27.386 15.9037 27.3934 15.9177 27.4038C15.9317 27.4141 15.9433 27.4272 15.9516 27.442C15.9636 27.4589 15.9729 27.4775 15.979 27.497C15.9883 27.5228 15.9953 27.5492 16.0001 27.576C16.0057 27.6058 16.0095 27.6359 16.0117 27.666C16.0117 27.699 16.0117 27.697 16.0117 27.758C16.013 27.7797 16.013 27.8014 16.0117 27.823C16.0108 27.8486 16.0076 27.874 16.0022 27.899C15.9966 27.9331 15.9878 27.9665 15.9758 27.999C15.9571 28.0479 15.9312 28.094 15.8988 28.136C15.8308 28.2276 15.7439 28.3052 15.6433 28.364C15.5773 28.4006 15.5063 28.4286 15.4322 28.447C15.411 28.452 15.3895 28.4557 15.3678 28.458H15.238C15.1779 28.458 15.181 28.458 15.1187 28.458C15.0745 28.4607 15.03 28.4607 14.9857 28.458C14.9622 28.4553 14.9389 28.4509 14.9161 28.445C14.8935 28.4397 14.8713 28.433 14.8496 28.425L14.8221 28.414L14.7947 28.398L14.7715 28.385L14.7588 28.375L14.7472 28.367C14.7439 28.3622 14.7418 28.3567 14.7408 28.351C14.7436 28.3407 14.7475 28.3306 14.7525 28.321ZM11.2216 32.292L11.3747 32.297C11.3747 32.305 11.3842 32.318 11.3916 32.331C11.4039 32.3562 11.4207 32.3792 11.4412 32.399C11.464 32.4204 11.4937 32.4341 11.5256 32.438C11.5628 32.4412 11.6 32.4324 11.6312 32.413C11.6572 32.4001 11.681 32.3836 11.7019 32.364C11.7441 32.3267 11.7798 32.2831 11.8074 32.235H11.8169C11.8454 32.235 11.8824 32.235 11.9658 32.304C11.9994 32.3307 12.0312 32.3594 12.0608 32.39C12.0685 32.3971 12.0774 32.4028 12.0872 32.407C12.1012 32.4124 12.1163 32.4152 12.1315 32.415C12.1508 32.4168 12.1703 32.4168 12.1896 32.415C12.2219 32.4118 12.254 32.4064 12.2856 32.399C12.3198 32.3916 12.3534 32.3815 12.3859 32.369C12.3842 32.282 12.3614 32.1965 12.3194 32.119C12.3033 32.0926 12.2822 32.0692 12.2571 32.05C12.2337 32.0343 12.209 32.0202 12.1832 32.008C12.1488 31.9938 12.1136 31.9815 12.0777 31.971C12.0506 31.9637 12.0231 31.9577 11.9953 31.953C11.967 31.9486 11.9385 31.9456 11.9098 31.944C11.9177 31.9138 11.9177 31.8822 11.9098 31.852C11.9041 31.8322 11.8952 31.8133 11.8834 31.796C11.9201 31.7733 11.9582 31.7526 11.9974 31.734C12.0311 31.7157 12.0664 31.7003 12.103 31.688C12.1424 31.673 12.1841 31.6639 12.2265 31.661C12.2983 31.661 12.3688 31.6797 12.4302 31.715C12.4616 31.73 12.4916 31.7474 12.5199 31.767L12.5622 31.797C12.5863 31.8162 12.6117 31.8339 12.6382 31.85C12.6519 31.8584 12.6668 31.8648 12.6825 31.869C12.7184 31.8744 12.7551 31.8695 12.7881 31.855C12.8305 31.8406 12.8718 31.8233 12.9116 31.803L14.1117 31.365L14.1529 31.511C14.0769 31.537 13.9734 31.575 13.8499 31.62L13.6008 31.72C13.4425 31.782 13.2398 31.863 12.9971 31.984C12.9189 32.022 12.8567 32.056 12.8155 32.078C12.8033 32.0958 12.7933 32.115 12.7859 32.135C12.7712 32.18 12.7651 32.227 12.768 32.274C12.768 32.286 12.768 32.298 12.768 32.318C12.768 32.338 12.768 32.354 12.7596 32.377C12.7511 32.4 12.7543 32.415 12.7522 32.443C12.7411 32.4784 12.7247 32.512 12.7036 32.543C12.6749 32.5854 12.6393 32.6232 12.5981 32.655C12.572 32.6764 12.5445 32.6961 12.5157 32.714C12.4841 32.734 12.4513 32.7524 12.4176 32.769C12.3204 32.8166 12.2186 32.8551 12.1136 32.884C12.0442 32.9037 11.9737 32.9197 11.9024 32.932C11.8433 32.942 11.7969 32.947 11.7842 32.948C11.6989 32.959 11.6127 32.9624 11.5267 32.958C11.4215 32.9551 11.3178 32.9341 11.2206 32.896C11.1777 32.8781 11.1398 32.851 11.1097 32.817C11.0979 32.8053 11.0883 32.7918 11.0812 32.777C11.072 32.7564 11.065 32.735 11.0601 32.713C11.0525 32.6802 11.0504 32.6465 11.0538 32.613C11.0616 32.5524 11.084 32.4942 11.1192 32.443C11.1298 32.426 11.1424 32.409 11.1678 32.375C11.1931 32.341 11.2068 32.311 11.2216 32.292ZM10.9461 31.644C10.9042 31.6361 10.8667 31.6141 10.8406 31.582C10.8171 31.5512 10.8046 31.5141 10.8047 31.476C10.8045 31.4546 10.8063 31.4332 10.81 31.412C10.8139 31.3764 10.8199 31.341 10.8279 31.306L10.8448 31.248C10.8638 31.178 10.8659 31.17 10.8722 31.148C10.8786 31.126 10.887 31.119 10.8955 31.092C10.9039 31.065 10.905 31.061 10.9134 31.028C10.9134 31.018 10.9208 31.008 10.9229 30.998C10.9252 30.9849 10.931 30.9725 10.9398 30.962C10.9398 30.962 10.9472 30.953 10.9514 30.954C10.9556 30.955 10.9693 30.977 10.9757 30.998C10.9794 31.0105 10.9822 31.0232 10.9841 31.036C10.9894 31.056 10.9905 31.062 10.9957 31.084C11.001 31.106 11.0137 31.164 11.0211 31.203C11.0308 31.2467 11.0382 31.2907 11.0432 31.335C11.0527 31.415 11.0728 31.591 10.9915 31.635C10.9775 31.6419 10.9618 31.6451 10.9461 31.644Z" fill="#E40177"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.42672 19.2421L7.7045 19.2321C8.00183 19.2214 8.29958 19.2355 8.59433 19.2741C8.8995 19.3021 9.19922 19.3694 9.48522 19.4741C9.81822 19.6023 10.1229 19.7885 10.3835 20.0231C10.5968 20.225 10.7762 20.4567 10.9155 20.7101C11.0402 20.9311 11.1461 21.1611 11.2322 21.3981C11.3641 21.6953 11.4735 22.0011 11.5594 22.3131C11.667 22.7148 11.6932 23.1321 11.6364 23.5431C11.6094 23.7166 11.5667 23.8875 11.5087 24.0541C11.4359 24.2515 11.3437 24.442 11.2332 24.6231C11.1395 24.7793 11.0336 24.9287 10.9166 25.0701C10.5225 25.5232 10.0994 25.953 9.64989 26.3571C9.2055 26.7681 8.77272 27.1891 8.33466 27.6061L7.46911 28.4271C7.27911 28.6101 7.12394 28.7591 6.89383 28.9731C6.66372 29.1871 6.47161 29.3561 6.34811 29.4731C6.28794 29.5261 6.19928 29.5991 6.08633 29.6801C5.89626 29.8285 5.68248 29.9473 5.453 30.0321C5.28031 30.0953 5.09662 30.1271 4.9115 30.1261C4.29928 30.1091 3.84644 29.6131 3.53294 29.2701C3.43478 29.1631 3.35033 29.0501 3.18144 28.8251C3.09172 28.7051 2.81305 28.3311 2.451 27.7491C1.97811 26.9911 1.67305 26.3801 1.5675 26.1641C1.47144 25.9641 1.30889 25.6261 1.12733 25.1901C1.00066 24.8841 0.751552 24.2601 0.510886 23.4491C0.486608 23.3651 0.370499 22.9711 0.245943 22.4441C0.140388 22.0191 0.102387 21.7761 0.0833869 21.6631C0.0241937 21.354 -0.000921888 21.04 0.00844333 20.7261C0.0126176 20.5702 0.0367186 20.4154 0.0802204 20.2651C0.111844 20.1348 0.166828 20.0107 0.242777 19.8981C0.331249 19.7758 0.444221 19.6711 0.575276 19.5901C0.691201 19.5156 0.817258 19.4564 0.949997 19.4141C1.07124 19.3737 1.1959 19.3433 1.32261 19.3231C1.41972 19.3061 1.53372 19.2881 1.72266 19.2711C1.91161 19.2541 2.1375 19.2391 2.42672 19.2421ZM1.56223 24.0611C1.56223 24.0241 1.57173 23.9721 1.57912 23.9091C1.5865 23.8461 1.59601 23.7631 1.61289 23.6571C1.61289 23.6421 1.62662 23.5701 1.64456 23.4811C1.64456 23.4811 1.65195 23.4401 1.67306 23.3551C1.67919 23.3317 1.68659 23.3087 1.69523 23.2861C1.70281 23.2614 1.71536 23.2383 1.73217 23.2181C1.7439 23.2077 1.75623 23.1981 1.76912 23.1891L1.79023 23.1741C1.82928 23.1481 1.84723 23.1331 1.9739 23.0511C2.13751 22.9431 2.25467 22.8681 2.25467 22.8681C2.38662 22.7851 2.80567 22.5191 3.17301 22.2931L3.41684 22.1451C3.41684 22.1451 3.47701 22.1081 3.55617 22.0621C3.59945 22.0361 3.62056 22.0241 3.64484 22.0111L3.70078 21.9791C3.72401 21.9661 3.73245 21.9591 3.76095 21.9411L3.82217 21.9041C3.84962 21.8881 3.90029 21.8571 3.96573 21.8241C4.01006 21.8011 4.06495 21.7751 4.06495 21.7751V21.0751H4.27606V21.6911C4.3014 21.6821 4.33517 21.6701 4.37529 21.6581C4.46306 21.6314 4.55312 21.612 4.64445 21.6001C4.71856 21.5902 4.79344 21.5865 4.86823 21.5891C4.96309 21.5933 5.0572 21.6071 5.14901 21.6301C5.2036 21.6424 5.25667 21.6602 5.30734 21.6831C5.34362 21.6995 5.37887 21.7178 5.4129 21.7381L5.5649 21.8261C5.62929 21.8641 5.75701 21.9371 6.01351 22.0831C6.05784 22.1091 6.25312 22.2211 6.42623 22.3171C6.62362 22.4281 6.90229 22.5801 7.25484 22.7651L7.39629 22.8371L7.57362 22.9241C7.67918 22.9811 7.65701 22.9711 7.71929 23.0021L7.76468 23.0281C7.78453 23.0414 7.80356 23.0557 7.82168 23.0711C7.83223 23.0811 7.86284 23.1071 7.88923 23.1351C7.92472 23.1761 7.95419 23.2215 7.97684 23.2701C8.00653 23.3324 8.03054 23.3969 8.04862 23.4631C8.06551 23.5151 8.07712 23.5631 8.10034 23.6481C8.11829 23.7141 8.13518 23.7781 8.15523 23.8641C8.17529 23.9501 8.20168 24.0641 8.20062 24.0641C8.12673 24.0771 8.04334 24.0901 7.95362 24.1031C7.84068 24.1191 7.74884 24.1281 7.69501 24.1341C7.45962 24.1571 7.27279 24.1641 7.12923 24.1681L6.9519 24.1731H6.74817C6.65106 24.1731 6.55607 24.1821 6.36818 24.1941L6.17923 24.2061L5.98712 24.2231L5.81718 24.2391L5.6314 24.2581C5.62401 24.1441 5.61767 24.0291 5.61028 23.9151L5.63034 23.8261C5.633 23.8186 5.633 23.8105 5.63034 23.8031C5.6261 23.796 5.6199 23.7901 5.6124 23.7861C5.59582 23.7792 5.57765 23.7764 5.55962 23.7781H5.52162C5.48995 23.7781 5.46779 23.7781 5.36223 23.7781H4.79329C4.63073 23.7781 4.5484 23.7781 4.48717 23.7721C4.43935 23.7697 4.39144 23.7697 4.34362 23.7721C4.33779 23.7702 4.3315 23.7702 4.32567 23.7721C4.31564 23.7765 4.30773 23.7844 4.30351 23.7941C4.30226 23.8034 4.30226 23.8128 4.30351 23.8221C4.30351 23.8331 4.30351 23.8411 4.30351 23.8421C4.30351 23.8431 4.3109 23.9421 4.31934 24.1591C4.22856 24.1531 4.09767 24.1451 3.93934 24.1371C3.72823 24.1271 3.53295 24.1191 3.20045 24.1091C2.77823 24.0961 2.69273 24.0961 2.32962 24.0861C2.13645 24.0811 1.87573 24.0731 1.56223 24.0611ZM1.54852 24.1711C1.83246 24.1941 2.17657 24.2181 2.57029 24.2381C2.67585 24.2381 2.80252 24.2491 3.27857 24.2681L4.3109 24.3091L4.3014 24.8351C4.13463 24.8351 3.87918 24.8351 3.56252 24.8301C3.17829 24.8241 2.96507 24.8151 2.6389 24.8071C2.37185 24.8001 1.9834 24.7931 1.50313 24.7911C1.52107 24.5841 1.53479 24.3781 1.54852 24.1711ZM1.18963 25.3411L1.47252 25.3461L1.49891 24.9351C1.66041 24.9501 1.9053 24.9701 2.20402 24.9801C2.3803 24.9851 2.5418 24.9801 2.85741 24.9801C3.38519 24.9801 3.49074 24.9681 3.79474 24.9751C4.01324 24.9751 4.18952 24.9881 4.29613 24.9951C4.29613 25.1661 4.29613 25.3361 4.29613 25.5071C4.51674 25.5071 4.69724 25.4991 4.82391 25.4951C4.99808 25.4891 5.10363 25.4841 5.27146 25.4831C5.42241 25.4831 5.54591 25.4831 5.6293 25.4831L5.62191 25.0011C5.77602 25.0011 5.99558 25.0011 6.25524 25.0011C6.51491 25.0011 6.7503 24.9901 7.11446 24.9751C7.43957 24.9621 7.86391 24.9441 8.36846 24.9191C8.3938 25.0411 8.42019 25.1631 8.44552 25.2841C8.44221 25.2962 8.44221 25.3089 8.44552 25.3211C8.44975 25.333 8.45652 25.3439 8.46542 25.3532C8.47432 25.3625 8.48516 25.3699 8.49724 25.3751C8.5243 25.3877 8.55371 25.3952 8.5838 25.3971C8.60092 25.3997 8.61819 25.4014 8.63552 25.4021C8.78435 25.4091 8.84663 25.4021 8.84663 25.4021C9.22769 25.3891 9.4293 25.3751 9.4293 25.3751C9.51374 25.3691 9.62036 25.3611 9.76813 25.3621H9.87369L9.95919 25.6951H9.56758C8.72313 25.6951 8.0898 25.7171 7.84491 25.7281L7.37941 25.7501C7.34458 25.7501 7.28546 25.7501 7.2063 25.7601C7.09441 25.7671 7.04374 25.7721 6.98674 25.7771C6.87063 25.7851 6.81996 25.7821 6.62574 25.7771C6.5033 25.7771 6.3798 25.7771 6.25735 25.7771L3.8718 25.7961L2.46052 25.8051L1.41446 25.8131C1.33635 25.6711 1.26246 25.5061 1.18963 25.3411ZM5.61028 24.4311C6.16023 24.3891 6.58562 24.3631 6.87695 24.3471C7.04901 24.3381 7.27595 24.3271 7.58945 24.2971C7.85756 24.2721 8.07712 24.2441 8.22279 24.2231L8.33362 24.7681C8.21434 24.7821 8.03384 24.8011 7.81429 24.8171C7.52929 24.8381 7.30762 24.8441 6.88962 24.8551C6.63734 24.8621 6.6099 24.8601 6.32806 24.8671C6.02723 24.8751 5.78128 24.8841 5.61662 24.8901C5.61556 24.7371 5.61239 24.5841 5.61028 24.4311ZM9.89161 21.7821C9.89794 21.8862 9.88834 21.9906 9.86311 22.0921C9.82621 22.2263 9.75804 22.351 9.66361 22.4571C9.57858 22.5533 9.47323 22.6317 9.35433 22.6871C9.20646 22.7572 9.04254 22.7916 8.87722 22.7871C8.73138 22.7836 8.58776 22.7524 8.455 22.6951C8.28491 22.6239 8.13882 22.5097 8.03278 22.3651C7.8847 22.155 7.82797 21.8988 7.87444 21.6501C7.90799 21.451 8.00187 21.2655 8.14467 21.1161C8.20163 21.0567 8.26617 21.0043 8.33678 20.9601C8.44022 20.8966 8.55397 20.8496 8.6735 20.8211C8.7561 20.8012 8.84064 20.7895 8.92578 20.7861C9.03545 20.7782 9.14573 20.788 9.25194 20.8151C9.34317 20.8389 9.42952 20.8771 9.50739 20.9281C9.7565 21.0971 9.82405 21.3691 9.85889 21.5031C9.88062 21.5946 9.89159 21.6882 9.89161 21.7821ZM3.87496 22.1131C3.87496 22.1131 3.87496 22.1131 3.87496 22.1051C3.87636 22.0953 3.88164 22.0863 3.88974 22.0801C3.9009 22.0694 3.9133 22.0601 3.92668 22.0521C3.97629 22.0261 4.00163 22.0121 4.01957 22.0051C4.03504 21.9995 4.05019 21.9931 4.06496 21.9861L4.10929 21.9621L4.14307 21.9421C4.16312 21.9301 4.2349 21.8891 4.31935 21.8501C4.39158 21.8162 4.46638 21.7874 4.54313 21.7641C4.59689 21.7466 4.65244 21.7346 4.70885 21.7281C4.73557 21.7267 4.76235 21.7267 4.78907 21.7281C4.85628 21.7284 4.92323 21.7361 4.98857 21.7511C5.06152 21.7685 5.1323 21.7933 5.19968 21.8251L5.34957 21.9031L5.46146 21.9631L5.56701 22.0201L5.61346 22.0471C5.61346 22.0471 5.63879 22.0621 5.66518 22.0811L5.68207 22.0961C5.68817 22.1006 5.69351 22.106 5.6979 22.1121C5.70235 22.1194 5.70489 22.1276 5.70529 22.1361C5.70529 22.1531 5.67574 22.1651 5.66729 22.1681C5.54648 22.1943 5.42284 22.2071 5.2989 22.2061L5.0329 22.2111C4.77464 22.2111 4.52237 22.2084 4.27607 22.2031L4.15996 22.1961L4.00479 22.1771C3.9822 22.1735 3.95995 22.1681 3.93829 22.1611C3.91892 22.1572 3.90145 22.1474 3.88868 22.1331C3.88272 22.1274 3.87805 22.1205 3.87496 22.1131ZM9.53273 21.8611C9.52778 21.9012 9.51713 21.9406 9.50106 21.9781C9.46283 22.0745 9.40139 22.1611 9.32162 22.2311C9.22061 22.3247 9.08784 22.3814 8.94689 22.3911C8.82195 22.3971 8.69848 22.3632 8.59628 22.2949C8.49409 22.2265 8.41908 22.1276 8.3833 22.0141C8.34752 21.9005 8.35303 21.7788 8.39896 21.6686C8.44488 21.5583 8.52855 21.4659 8.63656 21.4061C8.73077 21.3546 8.83821 21.329 8.94689 21.3321C9.04975 21.3329 9.15097 21.3565 9.24245 21.4011C9.30016 21.4287 9.35289 21.4648 9.39867 21.5081C9.44135 21.5466 9.47545 21.5928 9.49895 21.6441C9.52936 21.7125 9.54098 21.7872 9.53273 21.8611Z" fill="#E7060A"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.47661 14.139C4.47803 14.1348 4.48104 14.1312 4.48505 14.129C4.49376 14.1223 4.50448 14.1185 4.51566 14.118H4.78588C4.85238 14.118 4.90411 14.118 4.91783 14.118H5.11944L5.22499 14.124H5.29466L5.45299 14.133H5.63561C5.681 14.133 5.71688 14.133 5.76544 14.133C5.81399 14.133 5.83511 14.133 5.84355 14.127L5.90161 14.119L5.95755 14.108H5.95438C5.961 14.1085 5.96746 14.1102 5.97338 14.113C5.98002 14.1165 5.98637 14.1205 5.99238 14.125C6.00927 14.136 6.01561 14.142 6.02616 14.15C6.0346 14.1561 6.04341 14.1618 6.05255 14.167C6.05488 14.1696 6.05667 14.1727 6.05783 14.176C6.05783 14.186 6.05783 14.182 6.05783 14.192C6.05818 14.1963 6.05818 14.2007 6.05783 14.205C6.05783 14.205 6.05783 14.213 6.05783 14.223C6.05783 14.233 6.05783 14.239 6.05783 14.25C6.05821 14.2543 6.05821 14.2587 6.05783 14.263C6.05783 14.293 6.06522 14.329 6.06522 14.329C6.06522 14.352 6.06522 14.346 6.07261 14.391C6.08105 14.47 6.07999 14.463 6.0821 14.483C6.08422 14.503 6.08949 14.535 6.09899 14.595C6.10849 14.655 6.10955 14.665 6.11377 14.695C6.118 14.725 6.12116 14.742 6.12961 14.795C6.14227 14.866 6.15283 14.92 6.15494 14.933C6.2056 15.196 6.26049 15.479 6.26049 15.479C6.30799 15.713 6.33227 15.829 6.35444 15.942C6.384 16.093 6.42622 16.312 6.47266 16.581C6.47266 16.607 6.47266 16.627 6.47266 16.641C6.47266 16.673 6.46422 16.709 6.4621 16.73C6.46252 16.7343 6.46252 16.7387 6.4621 16.743C6.4621 16.752 6.4621 16.756 6.4621 16.765C6.4621 16.774 6.4621 16.774 6.4621 16.779C6.46082 16.7879 6.46082 16.797 6.4621 16.806C6.4621 16.806 6.4621 16.806 6.4621 16.813C6.4591 16.8155 6.45546 16.8172 6.45155 16.818H6.44416C6.43705 16.8206 6.42959 16.8223 6.42199 16.823H6.35761L6.26788 16.83H5.50788L5.24294 16.824L4.85027 16.813L4.60855 16.805H4.33622C4.32146 16.806 4.30664 16.806 4.29188 16.805L4.2655 16.8C4.25069 16.7955 4.23727 16.7876 4.22644 16.777C4.21958 16.7698 4.21453 16.7613 4.21166 16.752C4.20755 16.7442 4.20505 16.7357 4.20427 16.727C4.20219 16.7137 4.20219 16.7002 4.20427 16.687C4.21166 16.635 4.21061 16.64 4.21166 16.636C4.21799 16.605 4.22222 16.597 4.23066 16.556C4.23066 16.544 4.23594 16.534 4.237 16.528C4.23805 16.522 4.24649 16.481 4.25072 16.447C4.25494 16.413 4.25705 16.38 4.25916 16.328C4.25916 16.256 4.25916 16.239 4.26444 16.184C4.26972 16.129 4.26444 16.091 4.27394 16.018C4.28344 15.945 4.28133 15.898 4.2845 15.861L4.29399 15.732C4.29399 15.715 4.29927 15.669 4.30455 15.607C4.30455 15.591 4.31088 15.539 4.31722 15.466C4.31722 15.451 4.32355 15.4 4.33094 15.332C4.33094 15.309 4.33833 15.258 4.34466 15.192C4.34466 15.179 4.351 15.135 4.35733 15.076C4.35733 15.056 4.36472 15.004 4.37316 14.93C4.37316 14.91 4.3795 14.866 4.38688 14.805C4.38688 14.783 4.3985 14.697 4.41116 14.585C4.41116 14.571 4.427 14.45 4.42805 14.447C4.42805 14.424 4.42805 14.401 4.43544 14.378C4.44283 14.355 4.43544 14.345 4.44072 14.329C4.446 14.313 4.44072 14.3 4.44072 14.275C4.44072 14.268 4.44072 14.258 4.44599 14.237C4.45127 14.216 4.446 14.21 4.45338 14.183V14.167C4.46002 14.1569 4.4678 14.1475 4.47661 14.139ZM6.75872 7.94199C7.49233 8.649 8.07816 9.20099 8.48455 9.57999C8.81811 9.89099 9.35222 10.387 10.0742 11.089L10.4489 11.455C10.6674 11.6618 10.8646 11.8879 11.0379 12.13C11.1924 12.3325 11.3224 12.5509 11.4253 12.781C11.6034 13.1897 11.6855 13.6302 11.666 14.072C11.6525 14.328 11.6078 14.5817 11.533 14.828C11.4512 15.1066 11.3504 15.3798 11.2311 15.646C11.1532 15.8504 11.0637 16.0507 10.963 16.246C10.8261 16.51 10.6482 16.753 10.4352 16.967C10.3132 17.0866 10.1792 17.1948 10.0352 17.29C9.8792 17.3899 9.71299 17.4747 9.53905 17.543C9.25907 17.6521 8.96466 17.7245 8.664 17.758C8.44683 17.7874 8.22785 17.8031 8.00849 17.805C7.04794 17.805 6.56872 17.812 5.25772 17.798C4.58005 17.791 3.53822 17.781 2.90172 17.798C2.73388 17.798 2.50694 17.812 2.19133 17.798C1.95172 17.785 1.59811 17.755 1.59811 17.761C1.38074 17.7412 1.16647 17.6979 0.959497 17.632C0.884746 17.6079 0.811754 17.5792 0.740997 17.546C0.622591 17.4878 0.512017 17.4163 0.411664 17.333C0.149886 17.104 0.0781086 16.781 0.0422197 16.616C0.00294389 16.4139 -0.00770426 16.2078 0.0105543 16.003C0.017328 15.8354 0.0353095 15.6684 0.0643887 15.503C0.169944 14.846 0.313498 14.325 0.313498 14.325C0.438054 13.855 0.569998 13.356 0.808554 12.688C1.21991 11.5265 1.75873 10.409 2.41617 9.35399C2.63255 9.00399 2.79827 8.76399 2.95133 8.54399C3.13292 8.27468 3.3299 8.01496 3.54139 7.76599C3.67484 7.60602 3.8236 7.45805 3.98578 7.32399C4.10972 7.21798 4.24734 7.12727 4.39533 7.05399C4.50721 6.99712 4.62694 6.95537 4.75105 6.92999C4.96368 6.89548 5.18217 6.9148 5.38439 6.98599C5.71583 7.08599 5.92905 7.24399 6.22883 7.47599C6.41654 7.61962 6.59359 7.77532 6.75872 7.94199ZM4.10929 9.33497C4.05045 9.327 3.99666 9.2991 3.95785 9.25645C3.91904 9.2138 3.89784 9.15928 3.89818 9.10297C3.8963 9.08335 3.8963 9.0636 3.89818 9.04397C3.90168 9.00223 3.90839 8.96079 3.91824 8.91997C3.93935 8.82897 3.96785 8.74097 3.9858 8.68397C4.04069 8.50597 4.01218 8.60297 4.05652 8.45897C4.0757 8.39061 4.1004 8.32374 4.13041 8.25897C4.14835 8.22197 4.16524 8.19197 4.17685 8.17197L4.01535 7.98997C3.98542 7.95399 3.95792 7.91625 3.93302 7.87697L3.96891 7.84597L4.0903 7.90597L4.22118 7.96797C4.23886 7.97663 4.25721 7.98398 4.27607 7.98997C4.28604 7.99338 4.29628 7.99606 4.30669 7.99797L4.34785 8.00497C4.35332 8.00392 4.35864 8.00224 4.36368 7.99997C4.36872 7.99767 4.37335 7.99463 4.37741 7.99097L4.39641 7.98097L4.46713 7.93997C4.50091 7.92197 4.55896 7.89497 4.61385 7.87297C4.68342 7.8438 4.75591 7.82135 4.83024 7.80597C4.92426 7.78728 5.02082 7.78289 5.1163 7.79297C5.2052 7.80233 5.29226 7.82354 5.37491 7.85597C5.40657 7.86797 5.43402 7.88197 5.43824 7.88397C5.4845 7.90614 5.52896 7.93155 5.57124 7.95997C5.6149 7.99005 5.65585 8.0235 5.69368 8.05997C5.73272 8.09822 5.76805 8.13972 5.79924 8.18397C5.82786 8.22305 5.8526 8.26456 5.87313 8.30797C5.90024 8.36617 5.9211 8.42682 5.93541 8.48897C5.95239 8.55474 5.96438 8.62158 5.9713 8.68897C5.98086 8.78509 5.98086 8.88185 5.9713 8.97797C5.96602 9.04997 5.95863 9.10297 5.95018 9.16197C5.93963 9.23797 5.92802 9.30297 5.88368 9.52997L5.83829 9.75797L6.08002 9.73197C6.11802 9.73197 6.22041 9.71497 6.36713 9.69397C6.60357 9.66097 6.82629 9.62397 6.97618 9.59397L7.02157 9.58597H7.05641C7.07248 9.58347 7.08888 9.58347 7.10496 9.58597C7.11347 9.58592 7.12184 9.58799 7.12924 9.59197C7.14111 9.60023 7.14937 9.61233 7.15246 9.62597C7.15354 9.63528 7.15354 9.64467 7.15246 9.65397C7.15303 9.66196 7.15303 9.66998 7.15246 9.67797C7.15246 9.69397 7.14718 9.70797 7.14296 9.72597C7.13874 9.74397 7.13557 9.76197 7.13452 9.76897C7.13346 9.77597 7.12818 9.79797 7.12713 9.80197C7.11235 9.86297 7.09652 9.90897 7.09652 9.90897C7.08622 9.94349 7.07244 9.97697 7.05535 10.009C7.04574 10.0273 7.03289 10.0438 7.01735 10.058C7.00469 10.0694 6.99049 10.0791 6.97513 10.087C6.95617 10.0977 6.93487 10.1042 6.91285 10.106C6.89554 10.107 6.87822 10.1042 6.86218 10.098C6.84741 10.098 6.82629 10.088 6.80096 10.083C6.77563 10.078 6.74713 10.074 6.71863 10.07C6.6479 10.062 6.59196 10.059 6.58563 10.058C6.43468 10.051 6.31857 10.052 6.31857 10.052C6.12013 10.052 5.93435 10.06 5.83196 10.065C5.83196 10.191 5.82563 10.318 5.82352 10.445L5.80874 10.438C5.79526 10.4358 5.78139 10.4383 5.76968 10.445C5.75592 10.4503 5.74283 10.457 5.73063 10.465C5.7243 10.465 5.71057 10.478 5.69263 10.492C5.67221 10.5097 5.65349 10.5291 5.63668 10.55C5.62688 10.5602 5.61805 10.5713 5.61029 10.583L5.59024 10.617C5.58565 10.6232 5.58176 10.6299 5.57863 10.637C5.57295 10.6471 5.56869 10.6578 5.56596 10.669C5.55754 10.6958 5.55119 10.7232 5.54696 10.751C5.54496 10.7809 5.54496 10.811 5.54696 10.841V10.9C5.54696 10.984 5.5343 11.516 5.53218 11.643C5.6198 11.593 5.69368 11.553 5.74329 11.523C5.79291 11.493 5.9924 11.39 6.19718 11.294L6.34285 11.228L6.48113 11.168C6.57296 11.13 6.64368 11.104 6.66691 11.095C6.75557 11.062 6.84529 11.029 6.96352 10.995C7.05636 10.9675 7.15082 10.9451 7.2464 10.928C7.34693 10.907 7.44959 10.8966 7.55252 10.897C7.6497 10.8941 7.74663 10.908 7.83857 10.938C7.89992 10.9578 7.95735 10.9872 8.00851 11.025C8.07553 11.0714 8.13101 11.1311 8.17107 11.2L7.82907 11.391L7.32663 11.673C7.02791 11.838 6.37663 12.198 5.50896 12.673L5.49102 13.765C5.58707 13.765 5.66729 13.765 5.72957 13.771C5.74752 13.771 5.81402 13.771 5.90057 13.771H6.01774C6.0473 13.771 6.07474 13.771 6.11274 13.762C6.15074 13.753 6.17396 13.751 6.22885 13.744C6.24678 13.743 6.26475 13.743 6.28268 13.744C6.31489 13.7438 6.34706 13.7464 6.37874 13.752C6.4199 13.757 6.39774 13.752 6.42096 13.759C6.44419 13.766 6.44207 13.759 6.44735 13.767C6.45263 13.775 6.44735 13.773 6.45474 13.793C6.45766 13.8045 6.45978 13.8162 6.46107 13.828C6.46107 13.828 6.46107 13.836 6.46107 13.853C6.46107 13.87 6.46107 13.878 6.46107 13.891C6.46107 13.923 6.46107 13.979 6.46107 14.01C6.46107 14.068 6.46635 14.105 6.47163 14.157C6.47163 14.183 6.47902 14.233 6.48852 14.295C6.49591 14.341 6.50224 14.377 6.50646 14.395C6.56663 14.712 6.68168 15.219 6.68168 15.219C6.75452 15.54 6.73974 15.48 6.77352 15.619C6.84424 15.925 6.89807 16.15 6.91918 16.233C6.96141 16.408 6.98991 16.518 7.00152 16.562L7.04585 16.736C7.07435 16.836 7.08702 16.889 7.11235 16.987C7.11235 16.987 7.12185 17.025 7.12924 17.076C7.1327 17.0955 7.13446 17.1152 7.13452 17.135C7.13561 17.1561 7.13347 17.1774 7.12818 17.198C7.12309 17.2125 7.11599 17.2262 7.10707 17.239L6.90441 17.249L6.15496 17.289C6.01668 17.298 5.9618 17.302 5.85624 17.304C5.79502 17.304 5.77602 17.304 5.55541 17.304L5.15535 17.298C5.06668 17.298 5.0498 17.298 5.0023 17.298C4.96713 17.2996 4.9319 17.2996 4.89674 17.298C4.85422 17.2946 4.81193 17.2889 4.77007 17.281C4.71413 17.272 4.65818 17.266 4.60224 17.258L3.59313 17.117C3.58009 17.0785 3.57402 17.0383 3.57518 16.998C3.576 16.9812 3.57812 16.9645 3.58152 16.948C3.59524 16.893 3.6153 16.819 3.63641 16.73C3.67863 16.556 3.74196 16.276 3.80846 15.93C3.81902 15.872 3.9003 15.43 3.95941 14.93C3.96785 14.854 3.98896 14.67 4.00585 14.469C4.01957 14.316 4.02591 14.24 4.03118 14.169L4.03963 14.06C4.03963 14.06 4.03963 14.007 4.05335 13.936C4.05335 13.936 4.05335 13.915 4.06285 13.877C4.06285 13.877 4.06285 13.863 4.0713 13.843C4.07462 13.8322 4.07923 13.8218 4.08502 13.812C4.08703 13.8067 4.09072 13.8022 4.09558 13.799H4.10613L4.15574 13.792C4.22541 13.783 4.30985 13.775 4.44391 13.769C4.47241 13.769 4.5558 13.769 4.69091 13.769C4.78063 13.769 4.90202 13.769 5.03924 13.776L5.06457 12.941L4.73313 13.119C4.5653 13.21 4.45552 13.268 4.40591 13.294L4.12513 13.442C4.12513 13.442 4.06285 13.475 3.94252 13.535L3.88868 13.562L3.83169 13.588L3.79685 13.601C3.7512 13.6124 3.70642 13.6268 3.6628 13.644C3.60648 13.6657 3.55181 13.6911 3.49918 13.72C3.43268 13.756 3.38519 13.787 3.3398 13.82C3.29441 13.853 3.24269 13.884 3.21735 13.901L3.12763 13.96C3.10485 13.9748 3.08124 13.9885 3.05691 14.001C3.03422 14.0133 3.01058 14.024 2.98619 14.033C2.97031 14.0388 2.95356 14.0421 2.93657 14.043C2.91942 14.0449 2.90202 14.0429 2.88591 14.037C2.86829 14.0299 2.85272 14.0189 2.84052 14.005C2.83052 13.9937 2.82202 13.9812 2.81519 13.968C2.80853 13.9564 2.80288 13.9444 2.7983 13.932C2.79766 13.923 2.79766 13.914 2.7983 13.905C2.79801 13.8894 2.80051 13.8738 2.80569 13.859C2.82201 13.8146 2.84475 13.7725 2.87324 13.734C2.94396 13.643 2.9788 13.597 2.99358 13.582C3.15719 13.408 3.23424 13.336 3.23424 13.336C3.4253 13.158 3.58152 13.029 3.58891 13.022C3.89502 12.769 4.15046 12.582 4.19796 12.548C4.64974 12.219 5.10046 11.934 5.10152 11.936C5.10891 11.689 5.11629 11.477 5.12157 11.311C5.14268 10.611 5.13318 10.889 5.13635 10.775C5.13635 10.714 5.14268 10.597 5.14479 10.44V10.269C4.98963 10.283 4.85663 10.293 4.75107 10.3C4.58324 10.311 4.62652 10.305 4.39007 10.318C4.35946 10.318 4.29719 10.318 4.2138 10.318H4.12302C4.11488 10.3165 4.10705 10.3138 4.0998 10.31C4.08608 10.3022 4.07478 10.2912 4.06707 10.278C4.06147 10.2695 4.05687 10.2604 4.05335 10.251C4.04895 10.2418 4.04508 10.2325 4.04174 10.223C4.02929 10.1923 4.01447 10.1626 3.99741 10.134C3.99107 10.123 3.98474 10.115 3.97313 10.096C3.96152 10.077 3.96363 10.08 3.95941 10.07C3.94559 10.0474 3.93494 10.0232 3.92774 9.99797C3.92516 9.98374 3.92516 9.9692 3.92774 9.95497C3.93128 9.94132 3.93815 9.92865 3.94779 9.91797L3.95518 9.91197C3.96112 9.90854 3.96751 9.90584 3.97418 9.90397L4.00585 9.89297C4.04048 9.88572 4.07611 9.88369 4.11141 9.88697C4.1473 9.88697 4.17052 9.88697 4.17052 9.88697C4.31407 9.90397 4.45974 9.92797 4.45974 9.92797L4.6793 9.96397C4.72574 9.97197 4.79752 9.98297 4.89041 9.99497C4.9833 10.007 5.00652 10.009 5.03396 10.011C5.06141 10.013 5.13952 10.016 5.13952 10.016C5.13935 9.94917 5.14287 9.88242 5.15007 9.81597C5.15811 9.74443 5.17009 9.67333 5.18596 9.60297C5.20706 9.51789 5.2335 9.43407 5.26513 9.35197C5.2873 9.28697 5.31896 9.19897 5.36013 9.09697C5.37451 9.05926 5.38684 9.02088 5.39707 8.98197C5.40868 8.93797 5.41502 8.90297 5.41819 8.88697C5.42653 8.84438 5.43147 8.80126 5.43296 8.75797C5.43564 8.70819 5.43317 8.65829 5.42557 8.60897C5.42095 8.57809 5.41353 8.54765 5.40341 8.51797C5.39717 8.49831 5.38904 8.47923 5.37913 8.46097C5.36721 8.43852 5.3527 8.41739 5.33585 8.39797C5.31367 8.37424 5.28766 8.35399 5.2588 8.33797C5.23164 8.32285 5.20255 8.31108 5.17224 8.30297C5.13566 8.29173 5.09827 8.28304 5.06035 8.27697C5.02092 8.26816 4.98053 8.2638 4.94002 8.26397H4.89885C4.85678 8.26839 4.81596 8.28026 4.77852 8.29897C4.74083 8.31594 4.70539 8.33709 4.67296 8.36197C4.67448 8.38528 4.67448 8.40866 4.67296 8.43197C4.67296 8.44097 4.67296 8.45397 4.67296 8.46897C4.66946 8.49334 4.66272 8.5172 4.65291 8.53997C4.64481 8.56214 4.63266 8.58279 4.61702 8.60097C4.60104 8.61656 4.58413 8.63125 4.56635 8.64497L4.53468 8.67297C4.50407 8.69897 4.49774 8.70597 4.47241 8.72797C4.44707 8.74997 4.43441 8.75797 4.42385 8.76897C4.40172 8.79051 4.38321 8.81513 4.36896 8.84197C4.33621 8.9021 4.31173 8.96595 4.29613 9.03197C4.29683 9.03929 4.29683 9.04665 4.29613 9.05397C4.29613 9.05397 4.29613 9.06597 4.29085 9.07897C4.28848 9.0865 4.28672 9.09419 4.28557 9.10197C4.285 9.10796 4.285 9.11399 4.28557 9.11997C4.28439 9.12693 4.28439 9.13402 4.28557 9.14097C4.28722 9.14756 4.2897 9.15394 4.29296 9.15997C4.30021 9.17637 4.30552 9.19347 4.3088 9.21097C4.30991 9.21793 4.30991 9.22501 4.3088 9.23197C4.30939 9.23662 4.30939 9.24132 4.3088 9.24597C4.30349 9.26111 4.29444 9.27482 4.28241 9.28597C4.27138 9.29755 4.25938 9.30825 4.24652 9.31797C4.22954 9.33289 4.21034 9.34536 4.18952 9.35497C4.178 9.3609 4.16551 9.36496 4.15257 9.36697C4.13572 9.35964 4.1209 9.34868 4.10929 9.33497ZM6.08315 15.7C6.04386 15.8782 5.93343 16.0351 5.77493 16.138C5.68727 16.1972 5.58593 16.2356 5.47938 16.25C5.42577 16.2592 5.37129 16.2633 5.31682 16.262C5.24192 16.2614 5.16742 16.2517 5.09515 16.233C5.05086 16.2204 5.00749 16.205 4.96532 16.187L4.91149 16.161C4.89776 16.153 4.86715 16.136 4.83021 16.111C4.79805 16.0881 4.76738 16.0634 4.73838 16.037C4.67468 15.9774 4.62252 15.9077 4.58426 15.831C4.55462 15.7752 4.53399 15.7156 4.52304 15.654C4.5178 15.6235 4.51462 15.5928 4.51354 15.562C4.51354 15.528 4.51354 15.501 4.51354 15.487C4.5143 15.4505 4.51748 15.4141 4.52304 15.378C4.52946 15.3421 4.53863 15.3066 4.55049 15.272C4.56287 15.2308 4.57875 15.1907 4.59799 15.152C4.62151 15.1059 4.65018 15.0623 4.68349 15.022C4.70806 14.9864 4.73597 14.9529 4.76688 14.922C4.80186 14.8904 4.84045 14.8625 4.88193 14.839C4.93934 14.8042 5.00057 14.7753 5.06454 14.753C5.14441 14.7256 5.22788 14.7088 5.3126 14.703C5.41102 14.6938 5.51037 14.7013 5.60604 14.725C5.66235 14.7384 5.71612 14.76 5.76543 14.789C5.81432 14.8193 5.85779 14.8567 5.89421 14.9C5.9618 14.9758 6.01308 15.0635 6.04515 15.158C6.0556 15.1908 6.06406 15.2242 6.07049 15.258C6.08141 15.3039 6.08986 15.3503 6.09582 15.397C6.09582 15.397 6.09582 15.43 6.1011 15.463C6.10564 15.5424 6.09961 15.622 6.08315 15.7ZM4.91043 12.5L4.90304 12.748L4.71199 12.848C4.71199 12.848 4.61593 12.897 4.54204 12.93L4.5051 12.946L4.45338 12.967L4.40587 12.988C4.3626 13.009 4.32882 13.026 4.30032 13.042L4.26338 13.061L4.19476 13.099C4.08921 13.161 3.91715 13.26 3.91715 13.26L3.68071 13.402L3.58888 13.456L3.51182 13.5L3.45482 13.529L3.42737 13.542L3.40627 13.55H3.38937C3.38937 13.55 3.37988 13.55 3.37777 13.55L3.38304 13.537C3.38675 13.5301 3.39136 13.5237 3.39676 13.518C3.40415 13.5101 3.41312 13.5036 3.42315 13.499L3.4506 13.479L3.48648 13.454L3.73665 13.279L3.86859 13.189L4.00793 13.089L4.23382 12.938C4.35732 12.855 4.59693 12.699 4.91043 12.5ZM4.41856 8.42499C4.41397 8.41903 4.40824 8.41395 4.40167 8.40999C4.39421 8.40602 4.38592 8.40363 4.37739 8.40299H4.34784C4.33275 8.4014 4.31753 8.4014 4.30245 8.40299C4.28934 8.40317 4.2764 8.40589 4.26445 8.41099C4.25645 8.41509 4.24958 8.42091 4.24439 8.42799C4.22986 8.44338 4.22237 8.46361 4.22356 8.48423C4.22474 8.50485 4.23451 8.52418 4.25072 8.53799C4.25766 8.5443 4.26547 8.54968 4.27395 8.55399L4.28873 8.55999H4.32356C4.3304 8.5622 4.33783 8.5622 4.34467 8.55999C4.35124 8.55734 4.35703 8.55322 4.36156 8.54799L4.38056 8.52599C4.38703 8.51855 4.39269 8.51051 4.39745 8.50199C4.40422 8.49085 4.40988 8.47913 4.41434 8.46699C4.41488 8.46134 4.41488 8.45564 4.41434 8.44999C4.41468 8.446 4.41468 8.44198 4.41434 8.43799C4.41632 8.43384 4.41774 8.42947 4.41856 8.42499ZM5.51948 12.093L5.51209 12.385C5.93432 12.171 6.35654 11.9543 6.77876 11.735L7.25587 11.488C7.24407 11.4606 7.22384 11.4373 7.19782 11.421C7.1808 11.4108 7.16176 11.404 7.14187 11.401C7.09265 11.3926 7.04226 11.3926 6.99304 11.401C6.93757 11.4098 6.88288 11.4225 6.82943 11.439C6.8136 11.444 6.78298 11.453 6.73232 11.472C6.63732 11.506 6.56448 11.537 6.53598 11.55C6.34704 11.633 6.16232 11.728 6.12115 11.75C6.07998 11.772 5.97337 11.827 5.81926 11.914C5.68309 11.991 5.51632 12.09 5.51632 12.09L5.51948 12.093ZM4.50721 8.48499C4.50083 8.50054 4.49193 8.51505 4.48082 8.52799C4.47064 8.54117 4.45934 8.55355 4.44704 8.56499C4.4127 8.60111 4.36665 8.62539 4.31615 8.63399C4.29933 8.63605 4.2823 8.63605 4.26548 8.63399C4.24768 8.632 4.23026 8.62763 4.21376 8.62099C4.19183 8.61238 4.17283 8.59819 4.15887 8.57999C4.14802 8.5651 4.14114 8.54795 4.13882 8.52999C4.13377 8.51095 4.13377 8.49103 4.13882 8.47199C4.14115 8.46152 4.14506 8.45141 4.15043 8.44199L4.1652 8.41699L4.18209 8.39599C4.19285 8.38296 4.20487 8.37091 4.21798 8.35999C4.23183 8.34719 4.24838 8.33731 4.26654 8.33099C4.2849 8.32524 4.30424 8.32287 4.32354 8.32399C4.34904 8.32611 4.37401 8.33219 4.39743 8.34199C4.41427 8.34913 4.4305 8.35749 4.44598 8.36699C4.46201 8.37675 4.47657 8.38853 4.48926 8.40199C4.49748 8.40888 4.50396 8.41742 4.50826 8.42699C4.5151 8.44584 4.51473 8.46637 4.50721 8.48499Z" fill="#0B98D0"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M30.0696 19.231C30.362 19.231 30.8148 19.238 31.3711 19.241C32.3591 19.246 32.8974 19.241 34.1483 19.241C34.5346 19.241 35.0983 19.241 35.7886 19.241C36.0361 19.2457 36.283 19.2667 36.5275 19.304C36.7804 19.3255 37.0273 19.3892 37.2569 19.492C37.4185 19.5664 37.5623 19.6716 37.6791 19.801C37.74 19.8731 37.7921 19.9516 37.8343 20.035C37.8831 20.1347 37.9186 20.2399 37.9398 20.348C37.9708 20.476 37.9878 20.6067 37.9905 20.738C37.9969 21.0114 37.9771 21.2849 37.9314 21.555C37.8606 22 37.7773 22.338 37.754 22.432C37.6485 22.865 37.5429 23.282 37.3656 23.832C36.9817 25.0175 36.4717 26.1631 35.8435 27.251C35.6493 27.585 35.4772 27.851 35.3579 28.036C35.0427 28.5171 34.6969 28.9796 34.3224 29.421C34.2458 29.5038 34.1647 29.5829 34.0796 29.658C33.9657 29.7621 33.8396 29.8537 33.7039 29.931C33.522 30.0381 33.3157 30.1022 33.1022 30.118C32.9682 30.1248 32.8338 30.1113 32.7043 30.078C32.4925 30.0229 32.293 29.9321 32.1153 29.81C31.9507 29.708 31.7953 29.5933 31.6508 29.467C31.4281 29.281 31.2761 29.126 31.2286 29.075C30.743 28.583 30.2195 28.126 29.717 27.65L29.2505 27.207C28.5739 26.567 28.3068 26.326 27.8213 25.85C27.6017 25.635 27.4919 25.527 27.399 25.432C27.1024 25.11 26.8005 24.777 26.5778 24.278C26.5032 24.1124 26.4435 23.9411 26.3994 23.766C26.3177 23.4101 26.3045 23.0432 26.3604 22.683C26.4102 22.3402 26.5038 22.0044 26.639 21.683C26.6855 21.567 26.7499 21.417 26.7879 21.329C26.9124 21.04 26.9747 20.896 27.0475 20.76C27.1576 20.5562 27.2922 20.3653 27.4486 20.191C27.6755 19.9418 27.9498 19.7352 28.2572 19.582C28.4929 19.4669 28.7444 19.3838 29.0045 19.335C29.1991 19.3022 29.3954 19.2789 29.5925 19.265C29.7951 19.248 29.9566 19.238 30.0696 19.231ZM33.5571 27.634C33.5585 27.6051 33.562 27.5763 33.5677 27.548C33.599 27.4063 33.6639 27.2732 33.7577 27.159C33.8421 27.044 33.9349 26.9347 34.0353 26.832C34.1514 26.714 34.2675 26.614 34.3868 26.511C34.5061 26.408 34.5261 26.397 34.5874 26.335C34.6691 26.2506 34.7443 26.1607 34.8122 26.066C34.8577 26.0074 34.8983 25.9456 34.9336 25.881C34.9573 25.8361 34.9784 25.79 34.9969 25.743C35.0465 25.617 35.0845 25.519 35.1194 25.399C35.1786 25.1824 35.2087 24.9597 35.2091 24.736C35.2067 24.5838 35.1894 24.4321 35.1574 24.283C35.1996 24.283 35.2629 24.283 35.3379 24.29C35.439 24.294 35.5397 24.3033 35.6397 24.318C35.8426 24.3489 36.0476 24.3656 36.253 24.368C36.3625 24.3627 36.4672 24.3241 36.5517 24.258C36.6748 24.17 36.774 24.0555 36.841 23.924C36.8505 23.905 37.0394 23.542 36.6995 23.511C36.6591 23.5086 36.6186 23.5086 36.5781 23.511C36.5085 23.511 36.253 23.525 36.2024 23.532C36.1517 23.539 35.8424 23.553 35.7559 23.556C35.6693 23.559 35.1468 23.57 35.1077 23.567C35.1753 23.3508 35.2091 23.1264 35.208 22.901C35.208 22.801 35.1996 22.713 35.1964 22.683C35.1812 22.5396 35.153 22.3977 35.112 22.259C35.0709 22.1144 35.0158 21.9738 34.9473 21.839C34.8234 21.5846 34.6396 21.3605 34.41 21.184C34.41 21.184 33.9625 20.814 33.8126 20.59C33.6627 20.366 33.5624 20.235 33.5571 20.041C33.5547 19.9511 33.5887 19.8638 33.6521 19.797C33.6902 19.753 33.7184 19.7021 33.7349 19.6474C33.7514 19.5927 33.7559 19.5354 33.7482 19.479C33.7382 19.3925 33.7015 19.3107 33.6426 19.244H33.1666C33.0531 19.3381 32.9657 19.4573 32.9122 19.591C32.8533 19.7127 32.8049 19.8388 32.7676 19.968C32.7116 20.158 32.642 20.417 32.5755 20.727C32.5048 21.055 32.4699 21.299 32.4256 21.596C32.4066 21.72 32.3401 22.181 32.282 22.808C32.2113 23.56 32.206 23.97 32.205 24.049C32.205 24.209 32.205 24.378 32.205 24.378C32.205 24.468 32.205 24.64 32.2187 24.858C32.225 24.981 32.2356 25.213 32.2609 25.498C32.2863 25.8374 32.3318 26.1753 32.3971 26.51C32.4309 26.678 32.4847 26.91 32.5702 27.19C32.6103 27.322 32.6515 27.431 32.6863 27.514C32.7285 27.614 32.7644 27.69 32.7739 27.709C32.8215 27.8082 32.8765 27.9042 32.9386 27.996C32.9819 28.058 33.0209 28.107 33.0441 28.14C33.0515 28.15 33.061 28.163 33.0748 28.179C33.1208 28.2289 33.1733 28.2733 33.231 28.311C33.2712 28.342 33.3151 28.3685 33.3619 28.39C33.3914 28.4034 33.4226 28.4131 33.4548 28.419C33.5117 28.4288 33.5703 28.4257 33.6258 28.41C33.6764 28.3898 33.719 28.3547 33.7471 28.31C33.7684 28.2696 33.7801 28.2253 33.7814 28.1802C33.7826 28.1351 33.7735 28.0903 33.7545 28.049C33.7263 27.989 33.6909 27.9322 33.649 27.88C33.5852 27.8127 33.5522 27.7242 33.5571 27.634ZM31.7469 23.688C31.7568 23.8555 31.7437 24.0236 31.7078 24.188C31.6829 24.2942 31.6475 24.398 31.6023 24.498C31.4936 24.7383 31.3291 24.9523 31.1209 25.124C30.9476 25.2658 30.7473 25.375 30.5309 25.446C30.3139 25.5141 30.0859 25.5455 29.8575 25.539C29.5835 25.5321 29.3141 25.4718 29.0658 25.362C28.7255 25.2204 28.4386 24.9842 28.2432 24.6848C28.0477 24.3853 27.9528 24.0366 27.9712 23.685C27.9804 23.3542 28.08 23.0313 28.2604 22.748C28.4254 22.4887 28.6539 22.2709 28.9264 22.113C29.0857 22.0261 29.2559 21.9589 29.4331 21.913C29.5805 21.8752 29.7315 21.8511 29.8838 21.841C30.0524 21.8248 30.2224 21.8302 30.3894 21.857C30.5423 21.8793 30.6907 21.9234 30.8296 21.988C31.0341 22.089 31.2106 22.2342 31.3447 22.412C31.5283 22.6626 31.647 22.9507 31.691 23.253C31.7221 23.3963 31.7408 23.5418 31.7469 23.688ZM31.0766 23.8C31.0709 23.8768 31.0543 23.9525 31.027 24.025C30.962 24.2051 30.8515 24.3675 30.705 24.498C30.5205 24.6797 30.2734 24.7929 30.0084 24.817C29.8472 24.8254 29.6862 24.7987 29.5376 24.739C29.4293 24.6943 29.3295 24.6332 29.242 24.558C29.1131 24.4457 29.0163 24.3042 28.961 24.1467C28.9056 23.9893 28.8933 23.8211 28.9254 23.658C28.9678 23.4496 29.0787 23.2592 29.242 23.114C29.3447 23.0246 29.4652 22.9558 29.5965 22.9114C29.7278 22.8671 29.8671 22.8483 30.0063 22.856C30.1221 22.8606 30.2367 22.8798 30.3472 22.913C30.4438 22.9401 30.5364 22.9788 30.6227 23.028C30.7752 23.1087 30.9001 23.2291 30.9827 23.375C31.053 23.5063 31.0855 23.6529 31.0766 23.8ZM33.2774 21.108C33.2321 21.318 33.1898 21.537 33.1518 21.763C33.0663 22.274 33.0146 22.763 32.9872 23.211C32.9817 23.2713 32.9863 23.332 33.0009 23.391C33.0091 23.4242 33.023 23.456 33.0421 23.485C33.0518 23.4987 33.0632 23.5115 33.0758 23.523C33.0849 23.5312 33.0948 23.5386 33.1054 23.545C33.1163 23.5513 33.1275 23.557 33.1392 23.562L33.1846 23.579C33.2031 23.5858 33.2221 23.5911 33.2416 23.595C33.2708 23.6012 33.3004 23.6056 33.3302 23.608C33.3654 23.6104 33.4006 23.6104 33.4358 23.608C33.5593 23.608 33.7197 23.593 33.7197 23.593C33.9224 23.574 34.0258 23.565 34.1166 23.564H34.2602C34.2752 23.549 34.289 23.533 34.3013 23.516C34.3233 23.4867 34.3424 23.4556 34.3583 23.423C34.3911 23.3541 34.4142 23.2815 34.4269 23.207C34.438 23.1475 34.4447 23.0873 34.447 23.027C34.4532 22.9195 34.4493 22.8118 34.4354 22.705C34.4192 22.558 34.3837 22.4136 34.3298 22.275C34.2997 22.2025 34.2645 22.132 34.2243 22.064C34.1829 21.9947 34.1345 21.9293 34.0797 21.869C33.9987 21.7852 33.9108 21.7076 33.8168 21.637C33.7926 21.616 33.6416 21.488 33.4843 21.327C33.3893 21.237 33.3207 21.159 33.2774 21.108ZM33.2542 26.5999C33.2289 26.4999 33.2046 26.3999 33.1825 26.2919C33.077 25.8025 33.0121 25.306 32.9882 24.807C32.984 24.7524 32.984 24.6975 32.9882 24.6429C32.991 24.5828 33.0035 24.5235 33.0252 24.4669C33.0313 24.4524 33.0398 24.4389 33.0505 24.427C33.0618 24.413 33.0753 24.4009 33.0906 24.3909C33.1071 24.38 33.1253 24.3716 33.1445 24.3659C33.1785 24.3537 33.2139 24.3453 33.25 24.3409C33.2848 24.3409 33.2817 24.3409 33.326 24.3409C33.3703 24.3409 33.3703 24.335 33.4073 24.331C33.4442 24.327 33.4622 24.331 33.4801 24.325C33.5614 24.325 33.6279 24.315 33.7535 24.308C34.0301 24.294 34.3752 24.289 34.3752 24.289C34.3837 24.309 34.3942 24.3379 34.4048 24.3729C34.4241 24.4408 34.4376 24.51 34.4449 24.5799C34.4567 24.6913 34.4567 24.8036 34.4449 24.915C34.4344 25.0271 34.4135 25.1382 34.3826 25.2469C34.3583 25.3299 34.3276 25.4112 34.2908 25.49C34.2631 25.5467 34.2317 25.6018 34.1968 25.6549C34.1661 25.7054 34.1308 25.7533 34.0913 25.7979C34.0506 25.8423 34.0069 25.8841 33.9604 25.9229L33.895 25.977C33.857 26.009 33.8263 26.035 33.819 26.04C33.7366 26.11 33.6448 26.1959 33.6363 26.2039C33.5952 26.2419 33.5308 26.3039 33.4442 26.3939C33.3862 26.4459 33.3228 26.5159 33.2542 26.5999Z" fill="#0999DD"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3344 19.231H16.7738C16.9113 19.232 17.0483 19.2448 17.1834 19.269C17.2946 19.2865 17.4036 19.315 17.5085 19.354C17.657 19.4068 17.7927 19.4874 17.9075 19.591C18.0054 19.6821 18.0851 19.7891 18.1429 19.907C18.2058 20.0336 18.2481 20.1685 18.2685 20.307C18.2891 20.421 18.2997 20.5364 18.3002 20.652C18.3076 21.024 18.3002 21.325 18.3002 21.477C18.3002 21.829 18.3002 21.777 18.3002 22.217C18.3002 22.446 18.3002 22.551 18.3002 22.745C18.3002 22.855 18.3065 22.916 18.3002 23.022C18.3002 23.197 18.2896 23.339 18.2801 23.434C18.272 23.5664 18.2486 23.6975 18.2104 23.825C18.1749 23.9797 18.1075 24.1262 18.012 24.256C17.8543 24.4608 17.6224 24.6032 17.3607 24.656C17.2804 24.6708 17.1987 24.6775 17.1169 24.676C17.0239 24.677 16.931 24.6703 16.8393 24.656C16.6592 24.6297 16.4823 24.5862 16.3115 24.526C16.1374 24.4667 15.9678 24.3962 15.8038 24.315C15.4975 24.1655 15.2042 23.9933 14.9266 23.8C14.6854 23.6329 14.4562 23.4509 14.2405 23.255C13.9843 23.0211 13.7485 22.7679 13.5354 22.498C13.3078 22.2093 13.1052 21.9036 12.9295 21.584C12.8328 21.412 12.7519 21.2323 12.6878 21.047C12.6473 20.9282 12.6156 20.807 12.5928 20.684C12.5666 20.5674 12.5538 20.4483 12.5548 20.329C12.5547 20.2325 12.5678 20.1364 12.5938 20.043C12.6116 19.9845 12.6349 19.9276 12.6635 19.873C12.7115 19.7753 12.7772 19.6862 12.8577 19.61C12.9236 19.5486 12.9982 19.4961 13.0794 19.454C13.2164 19.3813 13.3645 19.3293 13.5185 19.3C13.6839 19.2645 13.8525 19.244 14.022 19.239C14.1497 19.229 14.2584 19.229 14.3344 19.231Z" fill="#0999DD"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.8297 20.7811C19.8297 20.7741 19.8297 20.7261 19.8297 20.6921C19.8299 20.5948 19.8359 20.4977 19.8476 20.4011C19.8593 20.2956 19.8816 20.1915 19.9141 20.0901C19.9416 20.0021 19.9791 19.9173 20.026 19.8371C20.0679 19.7656 20.1178 19.6985 20.1748 19.6371C20.2925 19.5178 20.4367 19.4249 20.5971 19.3651C20.6731 19.3354 20.7514 19.3113 20.8314 19.2931C20.9214 19.2725 21.0127 19.2575 21.1048 19.2481C21.2246 19.2351 21.3452 19.2288 21.4658 19.2291C22.0727 19.2291 22.6797 19.2291 23.2856 19.2291C23.4344 19.2291 23.6666 19.2291 23.9548 19.2291C24.1123 19.2274 24.2697 19.2375 24.4256 19.2591C24.5633 19.2741 24.6989 19.3036 24.8298 19.3471C24.961 19.3889 25.0838 19.4515 25.1929 19.5321C25.2985 19.6158 25.3866 19.7176 25.4526 19.8321C25.6637 20.1921 25.5719 20.5871 25.5286 20.7761C25.4924 20.9222 25.4448 21.0656 25.3861 21.2051C25.3756 21.2311 25.3323 21.3351 25.2658 21.4661C25.0833 21.8095 24.8715 22.1383 24.6324 22.4491C24.4421 22.6944 24.2333 22.9263 24.0076 23.1431C23.7362 23.4014 23.4421 23.6373 23.1283 23.8481C22.8887 24.0103 22.638 24.1573 22.3778 24.2881C22.1965 24.38 22.0085 24.4596 21.8152 24.5261C21.6168 24.5977 21.4097 24.6454 21.1987 24.6681C21.0776 24.6841 20.9547 24.6841 20.8335 24.6681C20.6841 24.6475 20.5405 24.5989 20.4113 24.5251C20.305 24.4638 20.2113 24.3849 20.1347 24.2921C20.0791 24.2218 20.033 24.1452 19.9975 24.0641C19.9501 23.9641 19.9147 23.8595 19.8919 23.7521C19.8824 23.7151 19.8708 23.6371 19.8476 23.4811C19.8476 23.4461 19.8402 23.4211 19.8402 23.4181C19.8402 23.3861 19.8349 23.3351 19.8339 23.3101C19.8339 23.2401 19.8339 23.2161 19.8276 23.1661C19.8212 23.0141 19.8276 22.7921 19.8276 22.7921C19.8276 22.6081 19.8276 22.4251 19.8276 22.2411V20.9711C19.8297 20.9131 19.8286 20.8601 19.8297 20.7811Z" fill="#FDF100"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.8458 16.2538C19.841 16.3829 19.8491 16.5121 19.8701 16.6398C19.8886 16.8094 19.9394 16.9744 20.02 17.1268C20.0784 17.2388 20.157 17.3403 20.2522 17.4268C20.3358 17.5007 20.4308 17.5621 20.534 17.6088C20.6677 17.6697 20.8098 17.7122 20.9562 17.7348C21.1267 17.7657 21.3 17.7802 21.4735 17.7778C21.8408 17.7778 22.2124 17.7778 22.5776 17.7778C22.9175 17.7778 22.9185 17.7778 23.4484 17.7778H23.992C24.0606 17.7778 24.1472 17.7778 24.2454 17.7718C24.295 17.7718 24.3889 17.7608 24.5071 17.7418C24.6598 17.7196 24.8087 17.6789 24.9505 17.6208C25.0438 17.585 25.1316 17.5372 25.2112 17.4788C25.3043 17.4079 25.3833 17.3219 25.4445 17.2248C25.5124 17.1149 25.5589 16.9943 25.5817 16.8688C25.6121 16.6986 25.6078 16.5244 25.569 16.3558C25.4868 15.9817 25.3444 15.6219 25.1468 15.2888C24.8313 14.7443 24.4346 14.2458 23.9688 13.8088C23.5994 13.465 23.1893 13.163 22.7465 12.9088C22.5186 12.7729 22.2796 12.6546 22.0318 12.5548C21.8284 12.4714 21.6161 12.4091 21.3985 12.3688C21.2312 12.3343 21.0592 12.3245 20.8887 12.3398C20.798 12.3465 20.7086 12.3643 20.6227 12.3928C20.4993 12.4345 20.3854 12.4979 20.287 12.5798C20.1569 12.6943 20.0574 12.8366 19.9967 12.9948C19.9329 13.1492 19.8927 13.3115 19.8775 13.4768C19.861 13.5962 19.8515 13.7164 19.849 13.8368C19.849 13.8938 19.849 13.9188 19.849 14.1298V16.2538H19.8458Z" fill="#76B71F"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.3044 13.7498C18.3044 13.6968 18.2959 13.6228 18.2854 13.5328C18.2738 13.4238 18.259 13.3328 18.2537 13.3118C18.2241 13.0786 18.129 12.8573 17.9782 12.6708C17.8664 12.5438 17.7246 12.4435 17.5644 12.3778C17.2742 12.2608 17.0124 12.3008 16.7654 12.3378C16.5427 12.3753 16.326 12.4394 16.1204 12.5288C15.9382 12.6 15.7618 12.6839 15.5927 12.7798C15.0862 13.0492 14.6191 13.3803 14.2036 13.7648C13.9391 14.0121 13.6965 14.2797 13.4784 14.5648C13.2942 14.8018 13.1284 15.0511 12.9823 15.3108C12.863 15.5168 12.763 15.7322 12.6836 15.9548C12.6229 16.1185 12.5825 16.2883 12.5632 16.4608C12.5439 16.5958 12.5475 16.7329 12.5738 16.8668C12.596 16.9823 12.6392 17.0933 12.7015 17.1948C12.8119 17.3601 12.9697 17.4923 13.1564 17.5758C13.2898 17.6378 13.4321 17.681 13.5787 17.7038C13.72 17.7304 13.8633 17.7465 14.0072 17.7518C14.1867 17.7608 14.3239 17.7568 14.3608 17.7518C14.7831 17.7398 15.2 17.7518 15.6201 17.7518C15.8703 17.7518 16.2302 17.7518 16.6757 17.7518C16.802 17.7532 16.9282 17.7466 17.0536 17.7318C17.1567 17.7208 17.2587 17.7021 17.3586 17.6758C17.4889 17.6437 17.6134 17.5935 17.7281 17.5268C17.9734 17.382 18.1503 17.1531 18.2221 16.8878C18.2822 16.7068 18.3002 16.5528 18.3086 16.0778C18.3086 15.7778 18.3086 15.6778 18.3086 15.1888C18.3086 14.8888 18.3086 14.6428 18.3086 14.3888C18.3086 14.1348 18.3044 13.9038 18.3044 13.7498Z" fill="#DF6837"/>
                    </g>
                    <path d="M60.6882 16.9922H57.8885C57.8374 16.63 57.733 16.3082 57.5753 16.027C57.4176 15.7415 57.2152 15.4986 56.968 15.2983C56.7209 15.098 56.4354 14.9446 56.1115 14.8381C55.7919 14.7315 55.4446 14.6783 55.0696 14.6783C54.392 14.6783 53.8018 14.8466 53.299 15.1832C52.7962 15.5156 52.4063 16.0014 52.1293 16.6406C51.8523 17.2756 51.7138 18.0469 51.7138 18.9545C51.7138 19.8878 51.8523 20.6719 52.1293 21.3068C52.4105 21.9418 52.8026 22.4212 53.3054 22.745C53.8082 23.0689 54.3899 23.2308 55.0504 23.2308C55.4212 23.2308 55.7642 23.1818 56.0795 23.0838C56.3991 22.9858 56.6825 22.843 56.9297 22.6555C57.1768 22.4638 57.3814 22.2315 57.5433 21.9588C57.7095 21.6861 57.8246 21.375 57.8885 21.0256L60.6882 21.0384C60.6158 21.6392 60.4347 22.2188 60.1449 22.777C59.8594 23.331 59.4737 23.8274 58.9879 24.2663C58.5064 24.701 57.9311 25.0462 57.2621 25.3018C56.5973 25.5533 55.8452 25.679 55.0057 25.679C53.8381 25.679 52.794 25.4148 51.8736 24.8864C50.9574 24.358 50.233 23.593 49.7003 22.5916C49.1719 21.5902 48.9077 20.3778 48.9077 18.9545C48.9077 17.527 49.1761 16.3125 49.7131 15.3111C50.25 14.3097 50.9787 13.5469 51.8991 13.0227C52.8196 12.4943 53.8551 12.2301 55.0057 12.2301C55.7642 12.2301 56.4673 12.3366 57.1151 12.5497C57.767 12.7628 58.3445 13.0739 58.8473 13.483C59.3501 13.8878 59.7592 14.3842 60.0746 14.9723C60.3942 15.5604 60.5987 16.2337 60.6882 16.9922ZM74.2708 18.9545C74.2708 20.3821 74.0002 21.5966 73.459 22.598C72.922 23.5994 72.1891 24.3643 71.2601 24.8928C70.3354 25.4169 69.2956 25.679 68.1408 25.679C66.9774 25.679 65.9334 25.4148 65.0087 24.8864C64.084 24.358 63.3532 23.593 62.8162 22.5916C62.2793 21.5902 62.0108 20.3778 62.0108 18.9545C62.0108 17.527 62.2793 16.3125 62.8162 15.3111C63.3532 14.3097 64.084 13.5469 65.0087 13.0227C65.9334 12.4943 66.9774 12.2301 68.1408 12.2301C69.2956 12.2301 70.3354 12.4943 71.2601 13.0227C72.1891 13.5469 72.922 14.3097 73.459 15.3111C74.0002 16.3125 74.2708 17.527 74.2708 18.9545ZM71.4647 18.9545C71.4647 18.0298 71.3262 17.25 71.0492 16.6151C70.7765 15.9801 70.3908 15.4986 69.8922 15.1705C69.3936 14.8423 68.8098 14.6783 68.1408 14.6783C67.4718 14.6783 66.888 14.8423 66.3894 15.1705C65.8908 15.4986 65.503 15.9801 65.226 16.6151C64.9533 17.25 64.8169 18.0298 64.8169 18.9545C64.8169 19.8793 64.9533 20.6591 65.226 21.294C65.503 21.929 65.8908 22.4105 66.3894 22.7386C66.888 23.0668 67.4718 23.2308 68.1408 23.2308C68.8098 23.2308 69.3936 23.0668 69.8922 22.7386C70.3908 22.4105 70.7765 21.929 71.0492 21.294C71.3262 20.6591 71.4647 19.8793 71.4647 18.9545ZM75.889 25.5V12.4091H84.71V14.6911H78.6568V17.8104H84.2562V20.0923H78.6568V23.218H84.7356V25.5H75.889ZM78.3691 11.0668C78.0027 11.0668 77.6873 10.9389 77.4231 10.6832C77.1589 10.4233 77.0268 10.1165 77.0268 9.76278C77.0268 9.40057 77.1589 9.09375 77.4231 8.84233C77.6873 8.59091 78.0027 8.4652 78.3691 8.4652C78.7399 8.4652 79.0531 8.59091 79.3088 8.84233C79.5687 9.09375 79.6987 9.40057 79.6987 9.76278C79.6987 10.1165 79.5687 10.4233 79.3088 10.6832C79.0531 10.9389 78.7399 11.0668 78.3691 11.0668ZM82.2811 11.0668C81.9146 11.0668 81.5992 10.9389 81.335 10.6832C81.0708 10.4233 80.9387 10.1165 80.9387 9.76278C80.9387 9.40057 81.0708 9.09375 81.335 8.84233C81.5992 8.59091 81.9146 8.4652 82.2811 8.4652C82.6518 8.4652 82.965 8.59091 83.2207 8.84233C83.4806 9.09375 83.6106 9.40057 83.6106 9.76278C83.6106 10.1165 83.4806 10.4233 83.2207 10.6832C82.965 10.9389 82.6518 11.0668 82.2811 11.0668ZM85.769 25.5V23.2756L86.1397 23.2436C86.617 23.2053 87.0026 23.0241 87.2967 22.7003C87.5907 22.3722 87.8102 21.8501 87.9551 21.1342C88.1042 20.4141 88.2001 19.4467 88.2427 18.2322L88.46 12.4091H97.345V25.5H94.6539V14.6271H91.0296L90.8251 19.1847C90.7569 20.6506 90.5822 21.848 90.3009 22.777C90.024 23.706 89.5808 24.392 88.9714 24.8352C88.3663 25.2784 87.5375 25.5 86.4849 25.5H85.769ZM101.017 17.2479H104.136C105.176 17.2479 106.071 17.4162 106.821 17.7528C107.575 18.0852 108.157 18.5561 108.566 19.1655C108.975 19.7749 109.177 20.4929 109.173 21.3196C109.177 22.142 108.975 22.8686 108.566 23.4993C108.157 24.1257 107.575 24.6158 106.821 24.9695C106.071 25.3232 105.176 25.5 104.136 25.5H99.2461V12.4091H102.007V23.2756H104.136C104.635 23.2756 105.054 23.1861 105.395 23.0071C105.736 22.8239 105.994 22.5831 106.169 22.2848C106.348 21.9822 106.435 21.652 106.431 21.294C106.435 20.7741 106.239 20.3352 105.843 19.9773C105.451 19.6151 104.882 19.4339 104.136 19.4339H101.017V17.2479ZM113.002 12.4091V25.5H110.24V12.4091H113.002ZM114.847 25.5V12.4091H117.615V17.8104H123.233V12.4091H125.995V25.5H123.233V20.0923H117.615V25.5H114.847ZM141.627 25.5H138.866V14.6719H136.999C136.466 14.6719 136.023 14.7507 135.67 14.9084C135.32 15.0618 135.058 15.2876 134.883 15.5859C134.709 15.8842 134.621 16.2507 134.621 16.6854C134.621 17.1158 134.709 17.4759 134.883 17.7656C135.058 18.0554 135.32 18.2727 135.67 18.4176C136.019 18.5625 136.458 18.6349 136.986 18.6349H139.991V20.8594H136.539C135.537 20.8594 134.681 20.6932 133.969 20.3608C133.258 20.0284 132.714 19.5511 132.339 18.929C131.964 18.3026 131.777 17.5547 131.777 16.6854C131.777 15.8203 131.96 15.0682 132.326 14.429C132.697 13.7855 133.232 13.2891 133.931 12.9396C134.634 12.5859 135.48 12.4091 136.469 12.4091H141.627V25.5ZM134.564 19.5426H137.549L134.366 25.5H131.31L134.564 19.5426ZM145.725 25.5H142.759L147.279 12.4091H150.845L155.358 25.5H152.392L149.113 15.4006H149.011L145.725 25.5ZM145.54 20.3544H152.546V22.5149H145.54V20.3544ZM156.502 12.4091H159.915L163.52 21.2045H163.674L167.279 12.4091H170.692V25.5H168.007V16.9794H167.899L164.511 25.4361H162.683L159.295 16.9474H159.186V25.5H156.502V12.4091Z" fill="#1A2B6B"/>
                    <defs>
                    <clipPath id="clip0_2693_14842">
                    <rect width="38" height="36" fill="white" transform="translate(0 0.5)"/>
                    </clipPath>
                    </defs>
                    </svg>
                    <button class="uk-modal-close-full" type="button" data-uk-close>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.06914 15.833L16.6666 15.833M16.6662 9.99967L3.33325 9.99967M16.6666 4.16634L10.8098 4.16634" stroke="#1A2B6B" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>
            


                
                <div class="uk-light uk-height-viewport tw-mobile-modal uk-flex uk-flex-middle uk-flex-center" data-uk-scrollspy="target:>ul>li,>div>a; cls:uk-animation-slide-bottom-medium; delay: 150;">
                    <?php lvly_mobilemenu(); ?>
                    <?php lvly_fullmenu_social(); ?>
                </div>
            </div>
        </div><?php
    }
}
/* Logo */
if (!function_exists('lvly_logo')) {
    function lvly_logo($color = 'tw-header-light') {
        $before = $after = '';
        if (is_page_template('page-splitpage.php')||is_page_template('page-magazinepage.php')) {
            $logo=lvly_get_option('logo');
            $logoLight=lvly_get_option('logo_light');
        }else{
            $logo = $color == 'tw-header-light' ? lvly_get_option('logo') : lvly_get_option('logo_light');
        }
        if (empty($logo['url'])) {
            $before='<h3 class="site-name">';
            $after='</h3>';
        }
        $output = '<div class="tw-logo">';
            $output .= $before;
                $output .= '<a href="' . esc_url(home_url('/')) . '">';
                    if (!empty($logo['url'])) {
                        $output .= '<img class="logo-img" src="' . esc_url($logo['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                        if (!empty($logoLight['url'])) {
                            $output .= '<img class="logo-img logo-light" src="' . esc_url($logoLight['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                        }
                    }else{
                        $output .= get_bloginfo('name');
                    }
                $output .= '</a>';
            $output .= $after;
        $output .= '</div>';
        echo ($output);
    }
}
if (!function_exists('lvly_footer_logo')) {
    function lvly_footer_logo() {
        $footerTop = lvly_get_option( 'footer_top_logo' );
        $output = '';
            $output .= '<div class="moc-footer-top">';
                
                //top footer left
                $output .= '<div class="tw-footer-top-left">';
                    $output .= '<img class="footer-top-img" src="' . esc_url($footerTop['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                $output .= '</div>';

                //Phone
                $footerPhoneLogo = lvly_get_option( 'footer_phone_logo' );
                $footerFax = lvly_get_option( 'footer_fax', esc_html__( 'Шуурхай утас, ФАКС', 'lvly' ) );
                $footer_phone_text = lvly_get_option( 'footer_phone_text', esc_html__( 'Шуурхай утас, ФАКС', 'lvly' ) );

                //Mail
                $footerMailLogo = lvly_get_option( 'footer_mail_logo' );
                $footerMail = lvly_get_option( 'footer_mail', esc_html__( 'Шуурхай утас, ФАКС', 'lvly' ) );
                $footerMailText = lvly_get_option( 'footer_mail_text', esc_html__( 'Шуурхай утас, ФАКС', 'lvly' ) );
                //top footer right
                $output .= '<div class="tw-footer-top-right">';
                    $output .= '<div class="footer-entry">';
                        
                        //Phone
                        $output .= '<div class="phone">';
                                if ( ! empty( $footerPhoneLogo['url']) ) {
                                    $output .= '<img class="footer-phone-img" src="' . esc_url($footerPhoneLogo['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                                }
                                $output .= '<div class="footer-non-icon-phone">';
                                    if ( ! empty( $footerFax ) ) {
                                        $output .= '<div class="footer-fax">' . esc_attr( $footerFax ) . '</div>';
                                    }
                                    if ( ! empty( $footer_phone_text ) ) {
                                        $output .= '<div class="footer-phone">';
                                            $footer_phone_items = explode( ',', $footer_phone_text );
                                            foreach ( $footer_phone_items as $i => $footer_phone_item ) {
                                                if ( $i ) { $output .= ', '; }
                                                $output .= '<a target="_blank" href="tel:' . esc_attr( trim( $footer_phone_item ) ) . '">' . esc_html( trim( $footer_phone_item ) ) . '</a>';
                                            } 
                                        $output .= '</div>';
                                    }
                                $output .= '</div>';
                        $output .= '</div>';

                        //Mail
                        $output .= '<div class="mail">';
                            if ( ! empty( $footerMailLogo['url']) ) {
                                $output .= '<img class="footer-phone-img" src="' . esc_url($footerMailLogo['url']) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                            }
                            $output .= '<div class="footer-non-icon">';
                                if ( ! empty( $footerMail ) ) {
                                    $output .= '<div class="footer-fax">' . esc_attr( $footerMail ) . '</div>';
                                }
                                if ( ! empty( $footerMailText ) ) {
                                    $output .= '<div class="footer-phone">';
                                        $footer_mail_items = explode( ',', $footerMailText );
                                        foreach ( $footer_mail_items as $i => $footer_mail_item ) {
                                            if ( $i ) { $output .= ', '; }
                                            $output .= '<a target="_blank" href="mailto:' . esc_attr( trim( $footer_mail_item ) ) . '">' . esc_html( trim( $footer_mail_item ) ) . '</a>';
                                        }
                                    $output .= '</div>';
                                }
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</div>';
                
            $output .= '</div>';
        return $output;
    }
}
if (!function_exists('lvly_top_bar')) {
    function lvly_top_bar( $container = false ) {
        if ( ! defined( 'ICT_PORTAL_MAIN' ) && $main_site_url = lvly_get_option( 'main_site_url') ) {
            $cache_key = 'tw_main_site_menu_main_' . esc_sql( esc_url( $main_site_url ) );
            $tw_main_site_menu_main = get_transient( $cache_key );
            if ( empty( $tw_main_site_menu_main ) ) {
                $response = wp_remote_get( trailingslashit( $main_site_url ) . 'wp-json/ict/v1/menu/main', array( 'timeout' => 1 ) );
                if ( is_array( $response ) && ! is_wp_error( $response ) && ! empty( $response['body'] ) ) {
                    $main_site_menu = json_decode( $response['body'], true );
                    if ( ! empty( $main_site_menu ) && ! empty( $main_site_menu['result'] ) ) {
                        $tw_main_site_menu_main = $main_site_menu['result'];
                        set_transient( $cache_key, $tw_main_site_menu_main, 60 * 60 );
                    }
                }
            }

            $output = '<section class="uk-section tw-topbar uk-light uk-section-secondary uk-padding-remove-vertical">';
                if ( $container ) {
                    $output .= '<div class="uk-container">';
                }
                    $output .= '<div data-uk-grid>';
                        if ( defined ( 'ICT_PORTAL_MAIN' )  ) { 
                            $output .= '<div class="tw-topbar-left uk-width-1-6@m">';
                            if ( ! empty( $tw_main_site_menu_main ) && ! empty( $tw_main_site_menu_main['topbar_logo'] ) ) {
                                $output .= '<a href="' . esc_url( $main_site_url ) . '">';
                                    $output .= '<img class="logo-img" src="' . esc_url( $tw_main_site_menu_main['topbar_logo'] ) . '" />';
                                $output .= '</a>';
                            }
                        $output .= '</div>';
                        } else {
                            $output .= '<div class="tw-topbar-left tw-sub-topbar uk-width-1-6@m">';
                            if ( ! empty( $tw_main_site_menu_main ) && ! empty( $tw_main_site_menu_main['topbar_logo'] ) ) {
                                $output .= '<a href="' . esc_url( $main_site_url ) . '">';
                                    $output .= '<img class="logo-img" src="' . esc_url( $tw_main_site_menu_main['topbar_logo'] ) . '" />';
                                $output .= '</a>';
                            }
                        $output .= '</div>';
                        }
                        

                        //top bar right
                        $output .= '<div class="tw-topbar-right uk-width-expand@m">';
                            if ( ! empty( $tw_main_site_menu_main ) && ! empty( $tw_main_site_menu_main['menu'] ) && is_array( $tw_main_site_menu_main['menu'] ) ) {
                                $output .= '<ul id="menu-top-bar-menu" class="tw-top-bar-menu uk-visible@m topbar">';
                                    foreach( $tw_main_site_menu_main['menu'] as $menu_item ) {
                                        if ( ! empty( $menu_item['text'] ) ) {
                                            $output .= '<li class="menu-item">';
                                                $output .= '<a href="' . esc_url( ! empty( $menu_item['link'] ) ? $menu_item['link'] : '#' ) . '">';
                                                    $output .= esc_html( $menu_item['text'] );
                                                $output .= '</a>';
                                                if ( ! empty( $menu_item['organization-menu'] ) ) {
                                                    $output .= $menu_item['organization-menu'];
                                                }
                                            $output .= '</li>';
                                        }
                                    }
                                $output .= '</ul>';
                            }
                        $output .= '</div>';
                    $output .= '</div>';
                if ($container) {
                    $output .= '</div>';
                }
            $output .= '</section>';

            return $output;
        }
    }
}
/*
  Pagination - Simple

 */

if (!function_exists('law_pagination_simple')) {

    function law_pagination_simple($atts=array()) {

        global $wp_query;
        $ict_query = isset( $atts['query'] ) ? $atts['query'] : $wp_query;
        $pages = intval( $ict_query->max_num_pages );

        if (empty($pages)) {
            $pages = 1;
        }
        if (1 != $pages) {
            $big = 9999; // need an unlikely integer
            $current = max(1, get_query_var('paged'));
            echo "<div class='tw-law-pagination'>";
                $pagination = paginate_links(
                    array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'total' => $pages,
                        'current' => $current,
                        // 'current' => max(1, get_query_var('paged')),
                        'end_size' => 2,
                        'mid_size' => 2,
                        'prev_text' => '<svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_9_3)">
                            <path d="M6 8L1.99998 3.99998L6 -2.54292e-07L6 8Z" fill="#171821"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_9_3">
                            <rect width="8" height="8" fill="white" transform="matrix(4.37114e-08 -1 -1 -4.37114e-08 8 8)"/>
                            </clipPath>
                            </defs>
                        </svg>',
                        'next_text' => '<svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_659_4285)">
                            <path d="M2 8L6.00002 3.99998L2 0L2 8Z" fill="#171821"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_659_4285">
                            <rect width="8" height="8" fill="white" transform="translate(0 8) rotate(-90)"/>
                            </clipPath>
                            </defs>
                        </svg>',
                        'type' => 'array',
                        'prev_next' => true,
                    )
                );
                $prev_link = '<span class="law-prev"><svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_659_4264)">
                    <path d="M6 8L1.99998 3.99998L6 0L6 8Z" fill="#E8ECF3"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_659_4264">
                    <rect width="8" height="8" fill="white" transform="matrix(4.37114e-08 -1 -1 -4.37114e-08 8 8)"/>
                    </clipPath>
                    </defs>
                    </svg></span>';
                $next_link = '<span class="law-next"><svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_2_8)">
                    <path d="M1.99999 8L6.00001 3.99998L1.99999 2.22545e-07L1.99999 8Z" fill="#E8ECF3"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_2_8">
                    <rect width="8" height="8" fill="white" transform="translate(0 8) rotate(-90)"/>
                    </clipPath>
                    </defs>
                    </svg></span>';

                if ($current === 1 ){
                    array_unshift($pagination, $prev_link);
                }
                if( $current == $ict_query->max_num_pages){
                    array_push($pagination, $next_link);
                }
            echo implode($pagination);
            echo "</div>";
        }
    }

}
if (!function_exists('lvly_fullmenu_social')) {
    function lvly_fullmenu_social() {
        $output = '';
        $fullmenu_social = lvly_get_option('fullmenu_social');
            if ($fullmenu_social) {
                $output .= '<div class="tw-socials social-minimal">';
                    foreach($fullmenu_social as $text) {
                        $a_end = '';
                        if ($text) {
                            $pieces = explode("|", $text);
                                if (!empty($pieces[1])) {
                                    $output .= '<a href="'.esc_url($pieces[1]).'">';
                                    $a_end .= '</a>';
                                }
                                if (!empty($pieces[0])) {
                                    $output .= '<i class="'.esc_attr($pieces[0]).'"></i>';
                                }
                            $output .= $a_end;
                        }
                    }
                $output .= '</div>';
            }
        return $output;
    }
}
/* Template */
if (!function_exists('lvly_template_header')) {
    function lvly_template_header() {
        $header = lvly_get_option('header_layout', 'classic');
        $color = lvly_get_option('header_color', 'tw-header-light');
        $scroll_menu = lvly_get_option('scroll_menu', 'hide');
        $header_container = lvly_get_option('header_container', 'uk-container');
        $magazine = false;
        if ( is_page() ) {
            if ( is_page_template('page-magazinepage.php') ) {
                $magazine = true;
                $pheader = 'magazine';
            } elseif ( is_page_template( 'page-splitpage.php' ) ) {
                $pheader = 'splitpage';
                $pcolor = 'tw-header-transparent uk-light';
            } elseif ( is_page_template( 'page-fullpage.php' ) ) {
                $pscroll_menu=lvly_meta('fullpage_scroll_menu');
                $pheader = 'fullpage';
                $pcolor = 'tw-header-transparent uk-light';
                
            }else {
                $pheader = lvly_meta('header_layout');
                $pcolor = lvly_meta('header_color');
                $pscroll_menu = lvly_meta('scroll_menu');
                $pheader_container = lvly_meta('header_container');
            }
        } elseif( is_404() ) {
            $page_404_metas = lvly_get_att( 'page_404_metas' );
            if ( isset( $page_404_metas['header_layout'] ) ) {
                $pheader = $page_404_metas['header_layout'];
            }
            if ( isset( $page_404_metas['header_color'] ) ) {
                $pcolor = $page_404_metas['header_color'];
            }
            if ( isset( $page_404_metas['scroll_menu'] ) ) {
                $pscroll_menu = $page_404_metas['scroll_menu'];
            }
            if ( isset( $page_404_metas['header_container'] ) ) {
                $pheader_container = $page_404_metas['header_container'];
            }
        }

        if ( ! empty( $pheader ) ) {
            $header = $pheader;
        }
        if ( ! empty( $pcolor ) ) {
            $color = $pcolor;
        }
        if ( ! empty( $pscroll_menu ) ) {
            $scroll_menu = $pscroll_menu;
        }
        if ( ! empty( $pheader_container ) ) {
            $header_container = $pheader_container;
        }


        lvly_set_atts(array(
            'header_color'      => $color,
            'header_container'  => $header_container,
            'scroll_menu'       => $scroll_menu
        ));
        get_template_part( 'template/header/header', $header );
        /* Magazine */
        if ( $magazine ) { ?>
            <div class="tw-magazine-title"><?php
                lvly_template_feature( true ); ?>
            </div><?php
        } 
    }
}
if (!function_exists('lvly_template_feature')) {
    function lvly_template_feature($do=false) {
        if ( $do ) {
            $meta_block = '';
            $heading_type = lvly_get_option( 'blog_heading', 'none' );
            $heading_block = lvly_get_option('blog_heading_content');
            if ( is_page_template( 'page-simple.php' ) ) {
                $heading_type = 'none';
            } elseif (is_page()) {
                $title = str_replace('%post_title%', get_the_title(), lvly_get_option('page_heading_title', get_the_title()));
                $heading_type = lvly_get_option( 'page_heading', 'none' );
                $heading_block = lvly_get_option('page_heading_content');
                $meta_block = is_page_template( 'page-magazinepage.php' ) ? lvly_meta('magazine_content') : lvly_meta('heading_content');
            } elseif (is_singular('post')) {
                $title = str_replace('%post_title%', get_the_title(), lvly_get_option('single_heading_title', esc_html__('Blog', 'lvly')));
                $heading_type = lvly_get_option( 'single_heading', 'none' );
                $heading_block = lvly_get_option('single_heading_content');
                $meta_block = lvly_meta('heading_content');
            } elseif (is_category()) {
                $title = str_replace("%category%", single_cat_title("", false), lvly_get_option('cat_heading_title'));
            } elseif (is_tag()) {
                $title = str_replace("%category%", single_tag_title("", false), lvly_get_option('tag_heading_title'));
            } elseif (is_tax()) {
                $query = get_queried_object();
                if (!empty($query->taxonomy)) {
                    global $post;
                    $tax = get_taxonomy($query->taxonomy);
                    if (isset($tax->singular_label) && isset($post->post_type)) {
                        $code = array('%post_type%', '%category%', '%taxonomy%');
                        $text = array($post->post_type, single_term_title("", false), $tax->singular_label);
                        $title = str_replace($code, $text, lvly_get_option('tax_heading_title'));
                    }
                }
            } elseif (is_search()) {
                $title = str_replace("%search%", get_search_query(), lvly_get_option('search_heading_title'));
            } elseif (is_archive()) {
                if (is_day()) {
                    $title = str_replace("%archive%", get_the_date(), lvly_get_option('archive_heading_title'));
                } elseif (is_month()) {
                    $title = str_replace("%archive%", get_the_date("F Y"), lvly_get_option('archive_heading_title'));
                } elseif (is_year()) {
                    $title = str_replace("%archive%", get_the_date("Y"), lvly_get_option('archive_heading_title'));
                } elseif (is_author()) {
                    global $author;
                    $userdata = get_userdata($author);
                    $title = str_replace("%author%", $userdata->display_name, lvly_get_option('author_heading_title'));
                }
            }
            if ($meta_block == 'none') {
                $heading_type = 'none';
            }elseif ($meta_block) {
                $heading_type = 'block';
                $heading_block = $meta_block;
            }
            if ($heading_type == 'title' && !empty($title)) {
                lvly_set_atts(array('post_title'=>$title));
                get_template_part( 'template/title/title', 'blogs' );
            } elseif ($heading_type == 'block' && !in_array($heading_block, array('','none'))) {
                echo lvly_get_post_content_by_slug($heading_block,'lovelyblock');
            } elseif ( ! is_page() && ! is_404() && lvly_get_att( 'header_color' ) == 'tw-header-transparent uk-light' ) {
                get_template_part( 'template/title/title', 'none' );
            }
        }
    }
}

if ( ! function_exists( 'lvly_template_footer' ) ) {
    function lvly_template_footer() {
        if ( ! is_page() || ! is_page_template( array( 'page-splitpage.php', 'page-magazinepage.php' ) ) ) {
            $footer_layout         = lvly_get_option( 'footer_layout', '4-4-4-4' );
            $footer_content        = lvly_get_option( 'footer_content' );

            $pfooter = lvly_meta( ( is_page_template( 'page-fullpage.php' ) ? 'full_page_':'' ) . 'footer_content' );
            if ( is_404() ) {
                $page_404_metas = lvly_get_att( 'page_404_metas' );
                if ( isset( $page_404_metas['footer_content'] ) ) {
                    $pfooter = $page_404_metas['footer_content'];
                }
            }
            if ( $pfooter == 'none' ) {
                $footer_layout = '';
            } elseif ( $pfooter ) {
                $footer_layout = 'block';
                $footer_content = $pfooter;
            }

            if ( $footer_layout ) { ?>
                <footer class="uk-section uk-padding-remove-vertical"><?php
                    if ( $footer_layout == 'block' ) {
                        echo lvly_get_post_content_by_slug( $footer_content, 'lovelyblock' );
                    } else {
                        lvly_set_atts( array( 'footer_layout' => $footer_layout ) );
                        get_template_part( 'template/footer/footer', 'classic' );
                    } ?>
                </footer><?php
            }
        }
    }
}
if ( ! function_exists( 'lvly_template_blog' ) ) {
    function lvly_template_blog() {
        $atts = array(
            'img_size'      => 'lvly_thumb',
            'more_text'     => lvly_get_option( 'more_text', esc_html__( 'Read more', 'lvly' ) ),
            'excerpt_count' => lvly_get_option( 'blog_excerpt' ),
            'pagination'    => lvly_get_option( 'blog_pagination', 'normal' ),
            'sidebar'       => lvly_get_option( 'blog_sidebar', 'right-sidebar' ),
        );
        $blog_layout = ( ! empty( $atts['sidebar'] ) && $atts['sidebar'] != 'none' ) ? $atts['sidebar'] : '';
        lvly_set_atts( $atts );
        echo '<section class="uk-section uk-section-blog">';
            echo '<div class="uk-container">';
                echo '<div class="' . esc_attr( $blog_layout ) . '" data-uk-grid>';
                    echo '<div class="content-area uk-width-expand@m">';
                    if ( have_posts() ) {
                        echo '<div class="tw-blog">';
                            while ( have_posts() ) { the_post();
                                get_template_part( 'template/loop/post' );
                            }
                        echo '</div>';
                        if ( $atts['pagination'] ) {
                            lvly_pagination( $atts );
                        }
                    }
                    echo '</div>';
                    if ( $blog_layout ) {
                        get_sidebar();
                    }
                echo '</div>';
            echo '</div>';
        echo '</section>';
    }
}
/* Pagination */
if ( ! function_exists( 'lvly_pagination' ) ) {
    function lvly_pagination( $atts = array( 'pagination' => 'default' ), $return = false ) {

        global $wp_query;
        $lvly_query = isset( $atts['query'] ) ? $atts['query'] : $wp_query;

        if ( $lvly_query === 'not_query' ) {
          $pages = empty( $atts['max_num_pages'] ) ? 1 : intval( $atts['max_num_pages'] );
        } else {
          $pages = intval( $lvly_query->max_num_pages );
        }
        $paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : ( get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1);
        if ( empty( $pages ) ) {
            $pages = 1;
        }
        $output='';


        if ( isset( $atts['pagination'] ) && $pages>1 ) {
            switch ( $atts['pagination'] ) {
                case 'infinite':
                    $output .= '<div class="tw-pagination tw-infinite-scroll uk-text-center' . ( $atts['infinite_auto'] ? ' infinite-auto' : '' ) . '" data-has-next="' . ( $paged >= $pages ? 'false' : 'true' ) . '"' . ( $atts['infinite_auto'] ? ( ' data-infinite-auto-offset="' . intval( $atts['infinite_auto_offset'] ) . '"' ) : '' ) . '>';
                        $output .= '<a href="#" class="ldr">';
                            // $output .= '<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M50 25C50 38.8071 38.8071 50 25 50C11.1929 50 0 38.8071 0 25C0 11.1929 11.1929 0 25 0C38.8071 0 50 11.1929 50 25ZM10 25C10 33.2843 16.7157 40 25 40C33.2843 40 40 33.2843 40 25C40 16.7157 33.2843 10 25 10C16.7157 10 10 16.7157 10 25Z" fill="url(#paint0_angular_337_7613)"/><defs><radialGradient id="paint0_angular_337_7613" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(25 25) rotate(90) scale(25)"><stop stop-color="#1A2B6B"/><stop offset="1" stop-color="#1A2B6B" stop-opacity="0"/></radialGradient></defs></svg>';
                            $output .= '<div data-uk-spinner></div>';
                        $output .= '</a>';
                        $output .= '<a href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '" class="next uk-button uk-button-default uk-button-small uk-button-radius uk-button-silver tw-hover">';
                            $output .= '<span class="tw-hover-inner">';
                                $output .= '<span>' . ( empty( $atts['infinite_text'] ) ? lvly_get_option( 'text_loadmore', esc_html__( 'Load More', 'lvly' ) ) : esc_html( $atts['infinite_text'] ) ) . '</span>';
                                $output .= '<i class="ion-ios-arrow-thin-right"></i>'; 
                            $output .= '</span>';
                        $output .= '</a>';
                    $output .= '</div>';
                break;
                case 'default':
                    $big = 9999; // need an unlikely integer
                    $output.= "<div class='tw-pagination'>";
                        $output.= paginate_links(
                            array(
                                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                'end_size' => 3,
                                'mid_size' => 6,
                                'format' => '?paged=%#%',
                                'current' => max( 1, $paged ),
                                'total' => $pages,
                                'type' => 'list',
                                'prev_text' => '<',
                                'next_text' => '>',
                            )
                        );
                    $output.= "</div>";
                break;
                case 'minimal':
                    $next = get_next_posts_link( '<span class="tw-hover-inner"><span>' . lvly_get_option( 'text_older', esc_html__( 'Older Posts', 'lvly' ) ) . '</span><i class="ion-ios-arrow-thin-right"></i></span>', $pages );
                    $prev = get_previous_posts_link( '<span class="tw-hover-inner"><span>' . lvly_get_option( 'text_newer', esc_html__( 'Newer Posts', 'lvly' ) ) . '</span><i class="ion-ios-arrow-thin-left"></i></span>', $pages );
                    if ( $next || $prev ) {
                        $output .= '<div class="tw-pagination pagination-border">';
                            if ( $next ) {
                                $output .= '<div class="older">' . str_replace( '<a', '<a class="uk-button uk-button-default uk-button-small uk-button-radius uk-button-silver tw-hover"', $next ) . '</div>';
                            }
                            if ( $prev ) {
                                $output .= '<div class="newer">' . str_replace( '<a', '<a class="uk-button uk-button-default uk-button-small uk-button-radius uk-button-silver tw-hover"', $prev ) . '</div>';
                            }
                        $output .= '</div>';
                    }
                break;
            }
        }
        if ( $return ) {
            return $output;
        } else {
            echo ( $output );
        }
    }
}
/* Waves Code */

/* Waves HTML Data */
if (!function_exists('lvly_html_data')) {
    function lvly_html_data($dAr) {
        $data='';
        if (!empty($dAr)&&is_array($dAr)) {
            foreach($dAr as $key=>$val) {
                $data.=' '.esc_attr($key).'="'.esc_attr(implode(' ', $val)).'"';
            }
        }
        return $data;
    }
}

/* Waves Anim */
if (!function_exists('lvly_anim')) {
    function lvly_anim($atts) {
        $data='';
        if (isset($atts['animation_customize'])&&$atts['animation_customize']==='true') {
            $data.=$atts['animation_custom'];
        }else{
            if (isset($atts['animation'])&&$atts['animation']!=='none') {
                /* Visual Composer Animate CSS enqueue */
                wp_enqueue_style( 'animate-css' );
                $data.='target:'.htmlspecialchars($atts['animation_target']).'; cls:'.$atts['animation'].'; delay:'.(empty($atts['animation_delay'])?'0':str_replace(' ','',$atts['animation_delay']));
                if (!empty($atts['animation_repeat'])&&$atts['animation_repeat']==='true') {
                    $data.='; repeat:true';
                }
            }
        }
        if ($data) {
            $data=' data-uk-scrollspy="'.esc_attr(str_replace('cls:','cls:animated ',$data)).'"';
        }
        return $data;
    }
}
/* Waves Item */
if (!function_exists('lvly_item')) {
    function lvly_item($atts) {
        $tag='div';
        $data=$video='';
        /* Carousel */
        foreach(array('dots','dots-each','nav','loop','autoplay','autoplay-hover-pause','autoplay-timeout','auto-width','items','center','margin','auto-height-lowest') as $val) {
            if ( isset( $atts[ $val ] ) ) {
                $atts['element_atts']['data-'.$val][]=$atts[$val];
            }
        }
        /* Elem */
        if (!empty($atts['uk_light'])&&$atts['uk_light']==='true') {$atts['element_atts']['class'][]= 'uk-light';}
        if (!empty($atts['large_screens'])&&$atts['large_screens']==='true') {$atts['element_atts']['class'][]= 'tw-hidden-large';}
        if (!empty($atts['desktop'])&&$atts['desktop']==='true') {$atts['element_atts']['class'][]= 'tw-hidden-desktop';}
        if (!empty($atts['tablet'])&&$atts['tablet']==='true') {$atts['element_atts']['class'][]= 'tw-hidden-tablet';}
        if (!empty($atts['mobile'])&&$atts['mobile']==='true') {$atts['element_atts']['class'][]= 'tw-hidden-mobile';}
        if (!empty($atts['custom_class'])) {$atts['element_atts']['class'][] = $atts['custom_class'];}
        if (!empty($atts['base'])&&!empty($atts['css'])) {
            $atts['element_atts']['class'][] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $atts['css'], ' ' ), $atts['css'], $atts );
        }
        if (!empty($atts['custom_id'])) {$atts['element_atts']['id'][] = $atts['custom_id'];}
        if (!empty($atts['parallax'])) {$atts['element_atts']['data-uk-parallax'][] = $atts['parallax'];}
        if (!empty($atts['overlay'])) {$atts['element_atts']['data-overlay'][] = $atts['overlay'];}
        if (!empty($atts['tw_dimension_type'])) {
            $atts['element_atts']['data-tw-dimension-type'][]= $atts['tw_dimension_type'];
            if ($atts['tw_dimension_type']==='custom-min-height'&&!empty($atts['tw_dimension_height'])) {
                $atts['element_atts']['data-tw-dimension-height'][]= $atts['tw_dimension_height'];
                $atts['element_atts']['style'][]= 'min-height:'.$atts['tw_dimension_height'].'px;';
            }
        }
        /* Background Video */
        // if (!empty($atts['bg_video'])) {
        //     $atts['element_atts']['class'][]= 'data-uk-cover-container';
        //     $video .= '<div class="tw-background-video" data-uk-cover data-video-embed="'.esc_attr(apply_filters("the_content", rawurldecode(lvly_decode($atts['bg_video'])))).'"></div>';
        // }
        /* Font Style */
        $font_styles = '';
        if ( !empty( $atts['custom_font']) && 'yes'== $atts['custom_font']) {
            $atts['element_atts']['class'][] = 'tw-heading-custom-font';
            $google_fonts_obj = new Vc_Google_Fonts();

            $google_fonts_field_settings = isset( $atts['google_fonts_field']['settings'], $atts['google_fonts_field']['settings']['fields'] ) ? $atts['google_fonts_field']['settings']['fields'] : array();
            
            $google_fonts_data = strlen( $atts['google_fonts'] ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings, $atts['google_fonts'] ) : '';
            if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
                $google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
                $font_styles .= 'font-family:' . $google_fonts_family[0].';';
                $google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
                $font_styles .= 'font-weight:' . $google_fonts_styles[1].';';
                $font_styles .= 'font-style:' . $google_fonts_styles[2].';';

                $subsets = '';
                $google_fonts_subsets = get_option( 'wpb_js_google_fonts_subsets' );
                if ( is_array( $google_fonts_subsets ) && ! empty( $google_fonts_subsets ) ) {
                        $subsets = '&subset=' . implode( ',', $google_fonts_subsets );
                }
                wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
            }
            if (!empty($atts['font_size'])) {
                $font_styles .= 'font-size:'.esc_attr($atts['font_size']).'px;';
            }
            if (isset($atts['letter_spacing'])) {
                $font_styles .= 'letter-spacing:'.($atts['letter_spacing'] / 1000).'em;';
            }
            if (!empty($atts['text_transform'])) {
                $font_styles .= 'text-transform:'.esc_attr($atts['text_transform']).';';
            }
            if (!empty($atts['margin'])) {
                $font_styles .= 'margin:'.esc_attr($atts['margin']).';';
            }
        }
        /* ---------------- */
        if (!empty($atts['tag'])) {$tag=$atts['tag'];}
        
        /* anim */
        $data.=lvly_anim($atts);
        if (isset($atts['element_atts'])) {
            $data.= lvly_html_data($atts['element_atts']);
        }

        $output = '<'.esc_attr($tag).' '.$data.'>'.$video;
        return array($output,$font_styles);
    }
}
if (!function_exists('lvly_get_image_by_id')) {
    function lvly_get_image_by_id($id,$url=false,$size='full') {
        $lrg_img=wp_get_attachment_image_src($id,$size);
        $output='';
        $attachment_title='';
        $attachment_title = get_the_title($id);
        if (isset($lrg_img[0])) {
            if ($url) {
                $output.=$lrg_img[0];
            }else{
                $output .= '<img alt="'.esc_attr($attachment_title).'" src="'.esc_url($lrg_img[0]).'" />';
            }
        }
        return $output;
    }
}
if (!function_exists('lvly_svg_icon')) {
    function lvly_svg_icon( $icon_name = '' ) {
        if ( $icon_name ) {
            return '<img src="' . esc_url( LVLY_DIR . 'assets/images/' . $icon_name ) . '" data-uk-svg  class="uk-preserve" />';
        }
        return '';
    }
}

if (!function_exists('lvly_icon')) {
    function lvly_icon($atts,$styled=false) {
        $output='';
        if (is_array($atts)&&!empty($atts['icon'])&&!empty($atts[$atts['icon']])&&$atts['icon']!=='none') {
            vc_icon_element_fonts_enqueue($atts['icon']);
            $style = '';
            $class = $atts[$atts['icon']];
            if ($atts['icon']==='fi_image') {
                $output.= lvly_get_image_by_id($class);
            }elseif ($atts['icon']==='fi_text') {
                $output.= $atts[$atts['icon']];
            }else{
                if ($styled) {
                    if (!empty($atts['fi_color'])) {
                        $style .='color:'.esc_attr($atts['fi_color']).';';
                    }
                    if (!empty($atts['fi_bgcolor'])) {
                        $style .='background-color:'.esc_attr($atts['fi_bgcolor']).';';
                    }
                    if (!empty($atts['fi_brcolor'])) {
                        $style .='border-color:'.esc_attr($atts['fi_brcolor']).';';
                    }
                }
                $output .= '<i class="fi '.esc_attr($class.($style?' uk-border-circle layout-2':'')).'" style="'.esc_attr($style).'"></i>';
            }

        }
        return $output;
    }
}
if ( ! function_exists( 'lvly_font_family' ) ) {
    function lvly_font_family( $font_family ) {
        return '"' . str_replace( array( '"', "'", ',' ), array( '', '', '","' ), $font_family ) . '"';
    }
}
if (!function_exists('lvly_main_data')) {
    function lvly_main_data($data=array()) {
        $data['class'][]= 'main-container';
        if (is_page_template( 'page-splitpage.php' )) {
            $data['class'][]= 'tw-splitpage';
        }
        if (is_page_template( 'page-fullpage.php' )) {
            $metaboxes = lvly_metas();
            $full_page_anim = isset($metaboxes['full_page_anim'])?$metaboxes['full_page_anim']:'';
            $data['data-speed'][]= '1000';
            switch ($full_page_anim) {
                case 'rotate_room':
                    $data['data-down-in'][]= 'pt-page-rotateRoomTopIn';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateRoomTopOut pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateRoomBottomIn';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateRoomBottomOut pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_room_carousel':
                    $data['data-down-in'][]= 'pt-page-rotateRoomTopIn';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateCarouselTopOut pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateCarouselBottomIn';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateCarouselBottomOut pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_cube':
                    $data['data-down-in'][]= 'pt-page-rotateCubeTopIn';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateCubeTopOut pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateCubeBottomIn';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateCubeBottomOut pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_side':
                    $data['data-down-in'][]= 'pt-page-moveFromBottom pt-page-ontop';
                    $data['data-down-in-delay'][]= '200';
                    $data['data-down-out'][]= 'pt-page-rotateBottomSideFirst';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromTop pt-page-ontop';
                    $data['data-up-in-delay'][]= '200';
                    $data['data-up-out'][]= 'pt-page-rotateTopSideFirst';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_fall':
                    $data['data-down-in'][]= 'pt-page-scaleUp';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateFall pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-scaleUp';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateFall pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_newspaper':
                    $data['data-down-in'][]= 'pt-page-rotateInNewspaper';
                    $data['data-down-in-delay'][]= '500';
                    $data['data-down-out'][]= 'pt-page-rotateOutNewspaper';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateInNewspaper';
                    $data['data-up-in-delay'][]= '500';
                    $data['data-up-out'][]= 'pt-page-rotateOutNewspaper';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_fush_move':
                    $data['data-down-in'][]= 'pt-page-moveFromTop';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotatePushBottom';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottom';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotatePushTop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_fush_pull':
                    $data['data-down-in'][]= 'pt-page-rotatePullTop';
                    $data['data-down-in-delay'][]= '180';
                    $data['data-down-out'][]= 'pt-page-rotatePushBottom';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotatePullBottom';
                    $data['data-up-in-delay'][]= '180';
                    $data['data-up-out'][]= 'pt-page-rotatePushTop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_fold':
                    $data['data-down-in'][]= 'pt-page-moveFromTopFade';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-rotateFoldBottom';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottomFade';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-rotateFoldTop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_unfold':
                    $data['data-down-in'][]= 'pt-page-rotateUnfoldBottom';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToTopFade';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateUnfoldTop';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToBottomFade';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_slide':
                    $data['data-down-in'][]= 'pt-page-rotateSlideIn';
                    $data['data-down-in-delay'][]= '200';
                    $data['data-down-out'][]= 'pt-page-rotateSlideOut';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateSlideIn';
                    $data['data-up-in-delay'][]= '200';
                    $data['data-up-out'][]= 'pt-page-rotateSlideOut';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'rotate_slides':
                    $data['data-down-in'][]= 'pt-page-rotateSidesIn';
                    $data['data-down-in-delay'][]= '200';
                    $data['data-down-out'][]= 'pt-page-rotateSlidesOut';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-rotateSlidesIn';
                    $data['data-up-in-delay'][]= '200';
                    $data['data-up-out'][]= 'pt-page-rotateSlidesOut';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move':
                    $data['data-down-in'][]= 'pt-page-moveFromBottom';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToTop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromTop';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToBottom';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move_fade':
                    $data['data-down-in'][]= 'pt-page-moveFromBottom pt-page-ontop';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-fade';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromTop pt-page-ontop';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-fade';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move_fade_2':
                    $data['data-down-in'][]= 'pt-page-moveFromTopFade';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToBottomFade';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottomFade';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToTopFade';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move_easing':
                    $data['data-down-in'][]= 'pt-page-moveFromTop';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToBottomEasing pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottom';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToTopEasing pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'move_scale':
                    $data['data-down-in'][]= 'pt-page-moveFromTop pt-page-ontop';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-scaleDown';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-moveFromBottom pt-page-ontop';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-scaleDown';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'scale':
                    $data['data-down-in'][]= 'pt-page-scaleUp';
                    $data['data-down-in-delay'][]= '300';
                    $data['data-down-out'][]= 'pt-page-scaleDownUp';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-scaleUpDown';
                    $data['data-up-in-delay'][]= '300';
                    $data['data-up-out'][]= 'pt-page-scaleDown';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'scale_move':
                    $data['data-down-in'][]= 'pt-page-scaleUp';
                    $data['data-down-in-delay'][]= '0';
                    $data['data-down-out'][]= 'pt-page-moveToBottom pt-page-ontop';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-scaleUp';
                    $data['data-up-in-delay'][]= '0';
                    $data['data-up-out'][]= 'pt-page-moveToTop pt-page-ontop';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'scale_center':
                    $data['data-down-in'][]= 'pt-page-scaleUpCenter';
                    $data['data-down-in-delay'][]= '300';
                    $data['data-down-out'][]= 'pt-page-scaleDownCenter';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-scaleUpCenter';
                    $data['data-up-in-delay'][]= '300';
                    $data['data-up-out'][]= 'pt-page-scaleDownCenter';
                    $data['data-up-out-delay'][]= '0';
                break;
                case 'flip':
                    $data['data-down-in'][]= 'pt-page-flipInTop';
                    $data['data-down-in-delay'][]= '500';
                    $data['data-down-out'][]= 'pt-page-flipOutBottom';
                    $data['data-down-out-delay'][]= '0';
                    $data['data-up-in'][]= 'pt-page-flipInBottom';
                    $data['data-up-in-delay'][]= '500';
                    $data['data-up-out'][]= 'pt-page-flipOutTop';
                    $data['data-up-out-delay'][]= '0';
                break;
            }
        }
        echo lvly_html_data($data);
    }
}

if (!function_exists('lvly_get_post_content_by_slug')) {
    function lvly_get_post_content_by_slug($slug,$postType='post') {
        $output='';
        $pposts = get_posts( array('name' => $slug,'post_type' => $postType, 'posts_per_page' => 1) );
        if ( !empty($pposts[0]) && !empty($pposts[0]->post_content)) {
            $output = do_shortcode( $pposts[0]->post_content );
        }
        return $output;
    }
}
if (!function_exists('lvly_get_ID_by_slug')) {
    function lvly_get_ID_by_slug($slug,$postType='post') {
        $id='';
        if ($slug) {
            $my_posts = get_posts( array('name' => $slug,'post_type' => $postType, 'posts_per_page' => 1) );
            if ( !empty($my_posts[0]) && !empty($my_posts[0]->ID)) {
                $id=$my_posts[0]->ID;
            }
        }
        return $id;
    }
}

/* quotes fix for some googlefont */
if ( ! function_exists( 'lvly_the_content_filter' ) ) {
    function lvly_the_content_filter( $content ) {
        if ( is_single() || is_page() ){
            $content = html_entity_decode($content, ENT_QUOTES, "UTF-8");
        }
        return $content;
    }
    add_filter( 'the_content', 'lvly_the_content_filter', 20 );
}

if ( ! function_exists( 'lvly_the_title_filter' ) ) {
    function lvly_the_title_filter( $content ) {
        $content = html_entity_decode($content, ENT_QUOTES, "UTF-8");
        return $content;
    }
    add_filter( 'the_title', 'lvly_the_title_filter', 20 );
}

/**
 * Latest News Tab
 */
if ( ! function_exists( 'lvly_latest_news_tab' ) ) {
    function lvly_latest_news_tab( $atts ) {
        global $tw_post__not_in;
        if ( empty( $tw_post__not_in ) ) {
            $tw_post__not_in = array();
        }
        
        $output = '<ul data-uk-tab>';
            if ( ! empty( $atts['left_tab_title'] ) ) {
                $output .= '<li><a href="#">';
                    $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6663 8.00016C14.6663 11.6802 11.6797 14.6668 7.99967 14.6668C4.31967 14.6668 1.33301 11.6802 1.33301 8.00016C1.33301 4.32016 4.31967 1.3335 7.99967 1.3335C11.6797 1.3335 14.6663 4.32016 14.6663 8.00016Z" stroke="#95A1BB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path opacity="0.4" d="M10.4731 10.1202L8.40638 8.88684C8.04638 8.6735 7.75305 8.16017 7.75305 7.74017V5.00684" stroke="#95A1BB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                    $output .= esc_html( $atts['left_tab_title'] );
                $output .= '</a></li>';
            }
            if ( ! empty( $atts['right_tab_title'] ) ) {
                $output .= '<li><a href="#">';
                    $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.06665 7.99999V7.01333C6.06665 5.73999 6.96665 5.22666 8.06665 5.85999L8.91998 6.35333L9.77332 6.84666C10.8733 7.47999 10.8733 8.51999 9.77332 9.15333L8.91998 9.64666L8.06665 10.14C6.96665 10.7733 6.06665 10.2533 6.06665 8.98666V7.99999Z" stroke="#95A1BB" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.00004 14.6668C11.6819 14.6668 14.6667 11.6821 14.6667 8.00016C14.6667 4.31826 11.6819 1.3335 8.00004 1.3335C4.31814 1.3335 1.33337 4.31826 1.33337 8.00016C1.33337 11.6821 4.31814 14.6668 8.00004 14.6668Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                    $output .= esc_html( $atts['right_tab_title'] );
                $output .= '</a></li>';
            }
        $output .= '</ul>';
        $output .= '<ul class="uk-switcher tw-news-tab-body">';
            if ( ! empty( $atts['left_tab_title'] ) ) {
                $output .= '<li class="tw-news-latest">';
                    $output .= '<div class="tw-news-items">';

                        /* Left Tab */
                        $query = array(
                            'post_type' => 'post',
                            'posts_per_page' => $atts['left_tab_posts_per_page'],
                            'post__not_in'   => $tw_post__not_in,
                            'no_found_rows'  => true,
                        );
                        $cats = false;
                        if ( ! empty( $atts['left_tab_cats'] ) ) {
                            if ( is_array( $atts['left_tab_cats'] ) ) {
                                $cats = $atts['left_tab_cats'];
                            } else {
                                $cats = explode( ",", $atts['left_tab_cats'] );
                            }
                        }
                        if ( $cats ) {
                            $query['tax_query'] = Array(Array(
                                    'taxonomy' => 'category',
                                    'terms' => $cats,
                                    'field' => 'slug'
                                )
                            );
                        }

                        $lvly_query = new WP_Query( $query );
                        if ( $lvly_query->have_posts() ) {
                            while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                                $tw_post__not_in[] = get_the_ID();
                                $output .= '<div class="tw-news-item">';
                                    
                                    $image = lvly_image( 'lvly_news_tab', true );

                                    if ( ! empty($image['url'] ) ) {
                                        $output .= '<div class="tw-item-image">';
                                            $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                        $output .= '</div>';
                                    }

                                    $output .= '<div class="tw-right">';
                                        $output .= '<h6 class="tw-item-title">';
                                            $output .= '<a href="' . esc_url( get_permalink() ) .'">';
                                                $output .= get_the_title();
                                            $output .= '</a>';
                                        $output .= '</h6>';
                                        $output .= '<div class="tw-meta">';
                                            $output .= '<div class="tw-meta entry-date">';
                                                $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6667 8.00016C14.6667 11.6802 11.68 14.6668 8.00001 14.6668C4.32001 14.6668 1.33334 11.6802 1.33334 8.00016C1.33334 4.32016 4.32001 1.3335 8.00001 1.3335C11.68 1.3335 14.6667 4.32016 14.6667 8.00016Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4733 10.1202L8.40666 8.88684C8.04666 8.6735 7.75333 8.16017 7.75333 7.74017V5.00684" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                                $output .= '<a href="' . esc_url( get_permalink() ) .'">' . esc_attr( get_the_time( get_option( 'date_format' ) ) ) . '</a>';
                                            $output .= '</div>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                $output .= '</div>';
                            }
                            wp_reset_postdata();
                        }
                        /***/

                    $output .= '</div>';
                $output .= '</li>';
            }
            if ( ! empty( $atts['right_tab_title'] ) ) {
                $output .= '<li class="tw-news-video">';
                    $output .= '<div class="tw-news-items">';
                        
                        /* Right Tab */
                        $query = array(
                            'post_type' => 'post',
                            'posts_per_page' => $atts['right_tab_posts_per_page'],
                        );
                        $cats = false;
                        if ( ! empty( $atts['right_tab_cats'] ) ) {
                            if ( is_array( $atts['right_tab_cats'] ) ) {
                                $cats = $atts['right_tab_cats'];
                            } else {
                                $cats = explode( ",", $atts['right_tab_cats'] );
                            }
                        }
                        if ($cats) {
                            $query['tax_query'] = Array(Array(
                                    'taxonomy' => 'category',
                                    'terms' => $cats,
                                    'field' => 'slug'
                                )
                            );
                        }

                        $lvly_query = new WP_Query( $query );
                        if ( $lvly_query->have_posts() ) {
                            while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                                $tw_post__not_in[] = get_the_ID();
                                $output .= '<div class="tw-news-item">';
                                    
                                    $image = lvly_image( 'lvly_news_tab', true );

                                    if ( ! empty($image['url'] ) ) {
                                        $output .= '<div class="tw-item-image">';
                                            $output .= '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" />';
                                        $output .= '</div>';
                                    }

                                    $output .= '<div class="tw-right">';
                                        $output .= '<h6 class="tw-item-title">';
                                            $output .= '<a href="' . esc_url( get_permalink() ) .'">';
                                                $output .= get_the_title();
                                            $output .= '</a>';
                                        $output .= '</h6>';
                                        $output .= '<div class="tw-meta">';
                                            $output .= '<div class="tw-meta entry-date">';
                                                $output .= '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.6667 8.00016C14.6667 11.6802 11.68 14.6668 8.00001 14.6668C4.32001 14.6668 1.33334 11.6802 1.33334 8.00016C1.33334 4.32016 4.32001 1.3335 8.00001 1.3335C11.68 1.3335 14.6667 4.32016 14.6667 8.00016Z" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.4733 10.1202L8.40666 8.88684C8.04666 8.6735 7.75333 8.16017 7.75333 7.74017V5.00684" stroke="#95A1BB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
                                                $output .= '<a href="' . esc_url( get_permalink() ) .'">' . esc_attr( get_the_time( get_option( 'date_format' ) ) ) . '</a>';
                                            $output .= '</div>';
                                        $output .= '</div>';
                                    $output .= '</div>';
                                $output .= '</div>';
                            }
                            wp_reset_postdata();
                        }
                        /***/

                    $output .= '</div>';
                $output .= '</li>';
            }
        $output .= '</ul>';

        return $output;
    }
}

// Filter by Title
add_filter( 'posts_where', 'lvly_filter_title', 10, 2 );
if ( ! function_exists( 'lvly_filter_title' ) ) {
    function lvly_filter_title( $where, $wp_query ) {
        global $wpdb;
        if ( $filter_text = $wp_query->get( 'filter_text' ) ) {
            $where .= " AND " . $wpdb->posts . ".post_title LIKE '%" . esc_sql( $wpdb->esc_like( $filter_text ) ) . "%'";
        }
        return $where;
    }
}

// Save Location ID on Event Meta
if ( ! function_exists( 'tw_save_post_event' ) ) {
    add_action( 'save_post_event', 'tw_save_post_event', 10, 3 );
     
    function tw_save_post_event( $post_id, $post, $update ) {
        if ( ! empty( $_REQUEST['location_id'] ) &&  class_exists( 'EM_Location' ) ) {
            $crr_event_location = new EM_Location( intval( $_REQUEST['location_id'] ) );
            if ( ! empty( $crr_event_location ) && ! empty( $crr_event_location -> post_id ) ) {
                update_post_meta( $post_id, 'location', $crr_event_location->post_id );
            }
        }
    }
}

// Like
if ( ! function_exists( 'tw_get_like_count' ) ) {
    function tw_get_like_count( $pid ) {
        $likeCount = get_post_meta( $pid, 'like_count', true );
        return $likeCount ? intval( $likeCount ) : 0;
    }
}
if ( ! function_exists( 'tw_get_liked' ) ) {
    function tw_get_liked( $pid ) {
        return ! empty( $_COOKIE['tw_liked_' . $pid] );
    }
}

add_action( 'wp_ajax_lvly_like_ajax', 'lvly_like_ajax' );
add_action( 'wp_ajax_nopriv_lvly_like_ajax', 'lvly_like_ajax' );
function lvly_like_ajax() {
    if ( ! empty($_REQUEST['pid']) ) {
        $pid = intval( $_REQUEST['pid'] );
        $liked = tw_get_liked( $pid );
        setcookie( 'tw_liked_' . $pid, ! $liked, time() + (86400 * 30), "/" );
        $add = $liked ? -1 : 1;
        $likeCount = tw_get_like_count( $pid ) + $add;
        update_post_meta( $pid, 'like_count', $likeCount > 0 ? $likeCount : 0 );
    }
    wp_die();
}

// Accessibility
if ( ! function_exists( 'tw_get_accessibility' ) ) {
    function tw_get_accessibility( ) {
        $tw_accessibility = array();
        if ( ! empty( $_COOKIE['tw_accessibility'] ) ) {
            $tw_accessibility = json_decode( $_COOKIE['tw_accessibility'], true );
        }
        return $tw_accessibility;
    }
}

add_action( 'wp_ajax_set_tw_accessibility_ajax', 'set_tw_accessibility_ajax' );
add_action( 'wp_ajax_nopriv_set_tw_accessibility_ajax', 'set_tw_accessibility_ajax' );
function set_tw_accessibility_ajax() {
    setcookie( 'tw_accessibility_color',      ! empty( $_REQUEST['color'] )      ? $_REQUEST['color']          : 'normal', time() + ( 86400 * 30 ), "/" );
    setcookie( 'tw_accessibility_size',       ! empty( $_REQUEST['size'] )       ? intval( $_REQUEST['size'] ) : 0,        time() + ( 86400 * 30 ), "/" );
    setcookie( 'tw_accessibility_hide_image', ! empty( $_REQUEST['hide_image'] ) ? $_REQUEST['hide_image']     : '',       time() + ( 86400 * 30 ), "/" );

    wp_die();
}

// Аймаг Сум
if ( ! function_exists( 'tw_get_region' ) ) {
    function tw_get_region() {
        $cache_key = 'tw_region_option';
        $tw_region_option = get_transient( $cache_key );

        if ( empty( $tw_region_option ) ) {

            // fix invalid taxonomy
            if ( ! taxonomy_exists( 'heritage_region' ) ) {
                register_taxonomy( 'heritage_region', array( 'heritage' ), array() );
            }

            $tw_region_option = array();
            $heritage_region_aimag = get_terms(array(
                'taxonomy'   => 'heritage_region',
                'parent'     => 0,
                'hide_empty' => false,
            ));

            foreach ( $heritage_region_aimag as $heritage_region_aimag_item ) {
                $tw_region_option[] = array(
                    'id'   => $heritage_region_aimag_item->term_id,
                    'name' => $heritage_region_aimag_item->name,
                    'slug' => $heritage_region_aimag_item->slug,
                    'name_en' => get_field( 'name_en', $heritage_region_aimag_item ),
                    'lat_long' => get_field( 'lat_long', $heritage_region_aimag_item ),
                );
                $heritage_region_sum = get_terms(array(
                    'taxonomy'   => 'heritage_region',
                    'parent'     => $heritage_region_aimag_item->term_id,
                    'hide_empty' => false,
                ));
                foreach ( $heritage_region_sum as $heritage_region_sum_item ) {
                    $tw_region_option[] = array(
                        'id'   => $heritage_region_sum_item->term_id,
                        'name' => '-' . $heritage_region_sum_item->name,
                        'slug' => $heritage_region_sum_item->slug,
                        'name_en' => '-' . get_field( 'name_en', $heritage_region_sum_item ),
                        'lat_long' => get_field( 'lat_long', $heritage_region_sum_item ),
                    );
                }
            }
            set_transient( $cache_key, $tw_region_option, 60 * 60 );
        }

        return $tw_region_option;
    }
}


// Get Subsites URLs
if ( ! function_exists( 'tw_get_subsite_urls' ) ) {
    function tw_get_subsite_urls() {
        $cache_key = 'tw_subsite_urls';
        $tw_subsite_urls = get_transient( $cache_key );
        if ( empty( $tw_subsite_urls ) ) {
            $tw_subsite_urls = array();

            $query = array(
                'post_type' => 'organization',
                'posts_per_page' => -1,
                'no_found_rows'  => true,
            );

            $lvly_query = new WP_Query( $query );
            if ( $lvly_query->have_posts() ) {
                while ( $lvly_query->have_posts() ) { $lvly_query->the_post();
                    if( $site_url = get_field('site_url') ) {
                        $tw_subsite_urls[] = $site_url;
                    }
                }
            }
            
            set_transient( $cache_key, $tw_subsite_urls, 60 * 60 );
        }

        return $tw_subsite_urls;
    }
}