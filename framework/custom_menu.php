<?php
/**
 * ThemeWaves Menu
 */

class Lvly_Menu extends Walker_Nav_Menu {
    var $type='main';
    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		// Restores the more descriptive, specific name for use within this method.
		$menu_item = $data_object;

        $icon              = get_field( 'icon',              $menu_item -> ID );
        $icon_color        = get_field( 'icon_color',        $menu_item -> ID );
        $organization_menu = defined( 'ICT_PORTAL_MAIN' ) ? get_field( 'organization_menu', $menu_item -> ID ) : false;
        $page_organization = lvly_get_option( 'page_organization' );

        $page_organization_link = '';
        if ( $page_organization ) { 
            $my_posts = get_posts( array('name' => $page_organization,'post_type' => 'page', 'posts_per_page' => 1) );
            if ( !empty($my_posts[0]) && !empty($my_posts[0]->ID)) {
                $page_organization_link = get_the_permalink( $my_posts[0]->ID );
            }
        }

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param WP_Post  $menu_item Menu item data object.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

		/**
		 * Filters the CSS classes applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string[] $classes   Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id   The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $menu_item The current menu item.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $class_names . '>';

		$atts           = array();
		$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
		$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
		if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}
		$atts['href']         = ! empty( $menu_item->url ) ? $menu_item->url : '';
		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title        Title attribute.
		 *     @type string $target       Target attribute.
		 *     @type string $rel          The rel attribute.
		 *     @type string $href         The href attribute.
		 *     @type string $aria-current The aria-current attribute.
		 * }
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );

		$attributes = '';
        // if ( $organization_menu ) {
        //     if ( empty( $atts['class'] ) ) {
        //         $atts['class'] = 'tw-org-menu-parent-item';
        //     } else {
        //         $atts['class'] .= ' tw-org-menu-parent-item';
        //     }
        // }
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title     The menu item's title.
		 * @param WP_Post  $menu_item The current menu item object.
		 * @param stdClass $args      An object of wp_nav_menu() arguments.
		 * @param int      $depth     Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
            if ( ! empty( $icon_color ) ) {
                $item_output .= '<span style="background-color:' . esc_attr( $icon_color ) . ';"></span>';
            }
            if ( ! empty( $icon ) && ! empty( $icon['url'] ) ) {
                $item_output .= '<div class="menu-item-icon">';
                    $item_output .= '<img src="' . esc_url( $icon['url'] ) . '" data-uk-svg class="uk-preserve" />';
                $item_output .= '</div>';
            }
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;


        if ( $organization_menu ) {
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
            $item_output .= '<div class="organization-menu"' . ( empty( $org_style ) ? '' : ( ' style="' . esc_attr( $org_style ) . '"' ) ) . '>';
                $organization_cats = get_terms( 'organization_cat', array( 'hide_empty' => true, 'parent' => 0, 'order' => 'DESC' ) );
                foreach ( $organization_cats as $organization_cat ) {
                    $organization_cat_image = get_field( 'image', $organization_cat );
                    $organization_cat_icon  = get_field( 'icon',  $organization_cat );
                    $page_organization_link_filter =  $page_organization_link . ( strpos( $page_organization_link, '?' ) === false ? '?' : '&'  ) . 'filter_cat=' . $organization_cat->term_id;
                    $item_output .= '<a class="organization-menu-item" href="' . esc_url( $page_organization_link_filter ) . '">';
                        if ( ! empty( $organization_cat_image['sizes'] ) && ! empty( $organization_cat_image['sizes']['lvly_menu_thumb'] ) ) {
                            $item_output .= '<img src="' . esc_url( $organization_cat_image['sizes']['lvly_menu_thumb'] ) . '"' . ( empty( $organization_cat_image['title'] ) ? '' : ( ' alt="' . esc_attr( $organization_cat_image['title'] ) . '"' ) ) . ' />';
                        }
                        $item_output .= '<div class="tw-menu-item-icon">';
                            if ( ! empty( $organization_cat_icon['url'] ) ) {
                                $item_output .= '<img src="' . esc_url( $organization_cat_icon['url'] ) . '" data-uk-svg class="uk-preserve" />';
                            }
                            $item_output .= $organization_cat -> count;
                        $item_output .= '</div>';
                        $item_output .= '<h5># ';
                            $item_output .= esc_html( $organization_cat -> name );
                        $item_output .= '</h5>';
                    $item_output .= '</a>';
                }
            $item_output .= '</div>';
        }

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $menu_item   Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
	}
}

// class Lvly_Menu_Top extends Walker_Nav_Menu {
//     var $type='menutop';
//     var $isMega=false;
//     var $column=false;
//     function start_lvl( &$output, $depth = 0, $args = array() ) {
//         $indent = str_repeat("\t", $depth);
//         $class = $attr =$inner = $outer = '';
//         if ($this->type==='menutop') {
//             if ($this->isMega&&$depth===1) {
//                 $outer.='<div>';
//                 $class.=' uk-nav uk-navbar-dropdown-nav';
//             }elseif ($this->isMega&&$depth===0) {
//                 $class.=' uk-navbar-dropdown';
//                 $attr .=' data-uk-drop="boundary: !nav; boundary-align: true; pos: bottom-justify;delay-hide: 0;"';
//                 $inner .='<li class="uk-container"><ul class="uk-navbar-dropdown-grid uk-child-width-1-'.esc_attr($this->column).'" data-uk-grid>';
//             }else{
//                 $class.=' uk-box-shadow-small sub-menu uk-animation-fade';
//             }
//         }else{
//             $class.=' uk-nav-sub';
//         }
//         $output .=  $outer;
//             $output .= ($indent).'<ul class="'.esc_attr($class).'"'.($attr).'>';
//                 $output .= $inner;
//     }
//     function end_lvl( &$output, $depth = 0, $args = array() ) {
//         $inner =  $outer = '';
//         if ($this->type==='menutop') {
//             if ($this->isMega&&$depth===1) {
//                 $outer.='</div>';
//             }elseif ($this->isMega&&$depth===0) {
//                 $inner .= '</ul></li>';
//             }
//         }
        
//                 $output .= $inner;
//             $indent = str_repeat("\t", $depth);
//             $output .= "$indent</ul>\n";
//         $output .=  $outer;
//     }
//     function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
//         $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

//         $class_names = $value = '';

//         $classes = empty( $item->classes ) ? array() : (array) $item->classes;
//         $classes[] = 'menu-item-' . $item->ID;

//         /**
//          * Filter the CSS class(es) applied to a menu item's <li>.
//          */
//         $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
//         if (isset($item->megamenu)&&$item->megamenu&&$depth===0) {
//             $this->isMega=true;
//             if (!empty($item->column)&&$depth===0) {
//                 $this->column=$item->column;
//             }else{
//                 $this->column=2;
//             }
//         }
//         $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

//         /**
//          * Filter the ID applied to a menu item's <li>.
//          */
//         $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
//         $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
//         $output .= $indent . '<li' . $id . $value . $class_names .'>';

//         $atts = array();
//         if( !empty( $item->attr_title ) ){
//             $atts['title'] = $item->attr_title;
//         }
//         if( !empty( $item->target ) ){
//             $atts['target'] = $item->target;
//         }
//         if( !empty( $item->xfn ) ){
//             $atts['rel']    = $item->xfn;
//         }
//         if( !empty( $item->url ) ){
//             $atts['href']   = esc_url( $item->url );
//         }

//         if (is_page_template( 'page-onepage.php' ) && $atts['href']) {
//             $onepagelink = explode("#", $atts['href']);
//             if (!empty($onepagelink[1])) {
//                 $atts['data-uk-scroll']='';
//             }
//         }
//         /**
//          * Filter the HTML attributes applied to a menu item's <a>.
//          */
//         $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

//         $attributes = '';
//         foreach ( $atts as $attr => $value ) {
//             $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
//             $attributes .= ' ' . $attr . '="' . $value . '"';
//         }
//         $show = true;
//         $hot=$new=$item_output='';
//         if ($this->isMega) {
//             if ($depth===1&&isset($item->hidetitle)&&$item->hidetitle) {$show = false;}
//             if ($depth>1&&isset($item->hot)&&$item->hot) {$hot='<span class="uk-label menu-hot">'.esc_html__('hot','lvly').'</span>';}
//             if ($depth>1&&isset($item->new)&&$item->new) {$new='<span class="uk-label menu-new">'.esc_html__('new','lvly').'</span>';}
//         }
//         if ($show) {
//             $item_output = $args->before;
//             if ($this->type==='menutop'&&$this->isMega&&$depth===1) {
//                 $item_output .= '<div class="mega-menu-title">';
//             }else{
//                 $item_output .= '<a'. $attributes .'>';
//             }
//                 /** This filter is documented in wp-includes/post-template.php */
//                 $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
//             if ($this->type==='menutop'&&$this->isMega&&$depth===1) {
//                 $item_output .= '</div>';
//             }else{
//                 $item_output .= $hot.$new.'</a>';
//             }
//             $item_output .= $args->after;
//         }
//         /**
//          * Filter a menu item's starting output.
//          */
//         $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
//     }
//     function end_el( &$output, $item, $depth = 0, $args = array() ) {
//         if ($depth===0) {$this->isMega=false;$this->column=false;}
//         $output .= "</li>\n";
//     }
// }
class Lvly_Menu_Mobile extends Lvly_Menu {
    var $type='mobile';
}