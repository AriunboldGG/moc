<?php
/**
 * ReduxFramework Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux' ) ) {return;}

// This is your option name where all the Redux data is stored.
$opt_name = LVLY_OPTIONS_NAME;

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get( 'Name' ),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get( 'Version' ),
    // Version that appears at the top of your panel
    'menu_type'            => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => false,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__( 'Сайтын тохиргоо', 'lvly'),
    'page_title'           => esc_html__( 'Theme Options', 'lvly'),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => '',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => true,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => true,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'update_notice'        => false,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => false,
    // Enable basic customizer support
    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',
    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
    'page_permissions'     => 'manage_options',
    // Permissions needed to access the options panel.
    'menu_icon'            => '',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => '',
    // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'red',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);
Redux::setArgs( $opt_name, $args );

$headings = array(
    'none' => 'Disable',
    'title' => 'Only Title',
    'block' => 'Content Block',
);
$footers = array('' => 'Disable',
    '12'      => '1 Column (12)',
    '6-6'     => '2 Columns (6-6)',
    '4-4-4'   => '3 Columns (4-4-4)',
    '3-3-3-3' => '4 Columns (3-3-3-3)',
    '3-6-3' => '3 Columns (3-6-3)',
    'block' => 'Content Block',
);
$content_block = array('' => 'Select Block');
$posts_array = get_posts( array('post_type' => 'lovelyblock', 'posts_per_page' => '-1','orderby'=> 'title', 'order' => 'ASC') );
foreach($posts_array as $post_array) {
    $content_block[$post_array->post_name] = $post_array->post_title;
}


$pages = $pagesDefaultTemplate = array(
    '' => 'Disable (Default)',
);
$pages_array = get_posts( array( 'post_type' => 'page', 'posts_per_page' => '-1', 'orderby'=> 'title', 'order' => 'ASC') );
foreach($pages_array as $page_array) {
    $pages[ $page_array->post_name ] = $page_array->post_title;
}
$pages_array = get_posts( array( 'post_type' => 'page', 'posts_per_page' => '-1', 'orderby'=> 'title', 'order' => 'ASC', 'meta_key'  =>'_wp_page_template', 'meta_value' => 'default') );
foreach($pages_array as $page_array) {
    $pagesDefaultTemplate[ $page_array->post_name ] = $page_array->post_title;
}

/*
 * ---> END ARGUMENTS
 */


/*
 *
 * ---> START SECTIONS
 *
 */

/*

    As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


 */

// -> START Basic Fields
$options_general=array(
    array(
        'id'       => 'favicon',
        'type'     => 'media',
        'url'      => true,
        'title'    => esc_html__( 'Сайтны толгой зургаа оруулна уу!', 'lvly'),
        'subtitle' => esc_html__( '', 'lvly'),
        'compiler' => 'true',
        'desc'     => '',
        'default'  => LVLY_DIR . 'assets/img/favicon.png',
    ),
    array(
        'id'       => 'logo',
        'type'     => 'media',
        'url'      => true,
        'title'    => esc_html__( 'Лого оруулах', 'lvly'),
        'subtitle' => esc_html__( 'Recommended Size: 247x72', 'lvly'),
        'compiler' => 'true',
        'desc'     => '',
        'default'  => LVLY_DIR . 'assets/images/Logo-main.png',
    ),
    array(
        'id'       => 'logo_subsite',
        'type'     => 'media',
        'url'      => true,
        'title'    => esc_html__( 'Topbar лого оруулах', 'lvly'),
        'subtitle' => esc_html__( 'Recommended Size: 147x40', 'lvly'),
        'compiler' => 'true',
        'desc'     => '',
        'default'  => LVLY_DIR . 'assets/images/Logo-main.png',
    ),
    array(
        'id'       => 'social_links',
        'type'     => 'multi_text',
        'title'    => esc_html__('Сошиал холбоосууд', 'lvly'),
        'default'  => array(
            'https://www.facebook.com/#',
            'https://www.instagram.com/#',
            'https://twitter.com/#',
            'https://www.youtube.com/#',

        ),
    )
);
if ( defined( 'ICT_PORTAL_MAIN' ) ) {
    $options_general[] =  array(
        'id'       => 'page_organization',
        'type'     => 'select',
        'title'    => esc_html__( 'Байгууллагууд Хуудас', 'lvly'),
        'options'  => $pagesDefaultTemplate,
    );
    $options_general[] = array(
        'id'       => 'cities',
        'type'     => 'multi_text',
        'title'    => esc_html__('Аймаг / Хот', 'lvly'),
        'default'  => array(
            'ulaanbatar|Улаанбаатар|47.919846100063204|106.91733986062114',
            'uvs|Увс|50.477949636236296|93.59766679963921',
        ),
    );
    $options_general[] =  array(
        'id'       => 'imap_mskey',
        'type'     => 'text',
        'title'    => esc_html__( 'iMap - MSKEY', 'lvly'),
        'default'  => '1acef98a9210a155fb1a55fc4374ac22',
    );
} else {
    array_unshift( $options_general, array(
        'id'       => 'main_site_url',
        'type'     => 'text',
        'title'    => esc_html__( 'Үндсэн сайтын URL оруулна уу ( https://portal.moc.gov.mn/ )', 'lvly' ),
        'default'  => 'https://portal.moc.gov.mn/'
    ) );

    $options_general[] = array(
        'id'=>'counter-options',
        'type' => 'section',
        'title' => esc_html__('Counter options', 'lvly'),
        'indent' => true // Indent all options below until the next 'section' option is set.
    );
    $options_general[] = array(
        'id'       => 'count_art',
        'type'     => 'text',
        'title'    => esc_html__( 'Уран бүтээл', 'lvly'),
        'default'  => '1500|+',
    );
    $options_general[] = array(
        'id'       => 'count_event',
        'type'     => 'text',
        'title'    => esc_html__( 'Үзвэр үйлчилгээ', 'lvly'),
        'default'  => '400|+',
    );
    $options_general[] = array(
        'id'       => 'count_physical_cultural_heritage',
        'type'     => 'text',
        'title'    => esc_html__( 'Соёлын биет өв', 'lvly'),
        'default'  => '120',
    );
    $options_general[] = array(
        'id'       => 'count_intangible_cultural_heritage',
        'type'     => 'text',
        'title'    => esc_html__( 'Соёлын биет бус өв', 'lvly'),
        'default'  => '300|+',
    );
    $options_general[] = array(
        'id'       => 'count_documentary_heritage',
        'type'     => 'text',
        'title'    => esc_html__( 'Баримтат өв', 'lvly'),
        'default'  => '300|+',
    );
    $options_general[] = array(
        'id'       => 'count_actors',
        'type'     => 'text',
        'title'    => esc_html__( 'Жүжигчид', 'lvly'),
        'default'  => '200|+',
    );
    $options_general[] = array(
        'id'       => 'count_play_performed',
        'type'     => 'text',
        'title'    => esc_html__( 'Тоглосон жүжиг', 'lvly'),
        'default'  => '100|+',
    );
}

if ( defined( 'ICT_LANG' ) ) {
    if ( ICT_LANG !== 'mn' ) {
        $options_general[] = array(
            'id'       => 'mn_site_url',
            'type'     => 'text',
            'title'    => esc_html__( 'MN Site URL', 'lvly' ),
            'default'  => ''
        );
    }
    if ( ICT_LANG !== 'en' ) {
        $options_general[] = array(
            'id'       => 'en_site_url',
            'type'     => 'text',
            'title'    => esc_html__( 'Англи сайтын URL оруулна уу', 'lvly' ),
            'default'  => ''
        );
    }
    if ( ICT_LANG !== 'mb' ) {
        $options_general[] = array(
            'id'       => 'mb_site_url',
            'type'     => 'text',
            'title'    => esc_html__( 'Монгол бичгийн сайтын URL оруулна уу', 'lvly' ),
            'default'  => ''
        );
    }
}

$options_footer=array(
    array(
        'id'       => 'footer_layout',
        'type'     => 'select',
        'title'    => esc_html__( 'Footer Widget Layout', 'lvly'),
        'subtitle'    => esc_html__( 'Total Grid Column is 12 and back numbers are defined the Column Grid', 'lvly'),
        'desc'    => esc_html__( '(6-3-3) => (col-md-6, col-md-3, col-md-3)', 'lvly'),
        'options'   => $footers,
        'default'  => '',
    ),
    array(
        'id'       => 'footer_content',
        'type'     => 'select',
        'title'    => esc_html__( 'Footer Content Bloc Content', 'lvly'),
        'options'  => $content_block,
        'default'  => '',
        'required' => array(
            array('footer_layout','=','block'),
        )
    ),
    array(
        'id'       => 'footer_width',
        'type'     => 'select',
        'title'    => esc_html__( 'Footer Width', 'lvly'),
        'options'   => array('' => '1170px', 'fullwidth' => 'Fullwidth'),
        'default'  => '',
        'required' => array(
            array( 'footer_layout', '!=', '' ),
            array( 'footer_layout', '!=','block' ),
        ),
    ),
    /*Footer top*/ 
    array(
        'id'       => 'footer_top_logo',
        'type'     => 'media',
        'url'      => true,
        'title'    => esc_html__( 'Footer дээд хэсгийн лого', 'lvly'),
        'subtitle' => esc_html__( 'Recommended Size: 230x80', 'lvly'),
        'compiler' => 'true',
        'desc'     => '',
        'default'  => LVLY_DIR . 'assets/images/footer-top-img.png',
    ),
    //Phone
    array(
        'id'       => 'footer_phone_logo',
        'type'     => 'media',
        'url'      => true,
        'title'    => esc_html__( 'Footer Утасны зураг', 'lvly'),
        'subtitle' => esc_html__( 'Recommended Size: 230x80', 'lvly'),
        'compiler' => 'true',
        'desc'     => '',
        'default'  => LVLY_DIR . 'assets/images/icon-phone.png',
    ),
    array(
        'id'       => 'footer_fax',
        'type'     => 'textarea',
        'title'    => esc_html__('Footer утасны текст', 'lvly'),
        'subtitle' => esc_html__('You can use HTML tags on this area', 'lvly'),
        'default'  => esc_html__('You can use HTML tags on this area', 'lvly'),
    ),
    
    array(
        'id'       => 'footer_phone_text',
        'type'     => 'textarea',
        'title'    => esc_html__('Footer утасны дугаар', 'lvly'),
        'subtitle' => esc_html__('You can use HTML tags on this area', 'lvly'),
        'default'  => wp_kses_post(sprintf(__( '&copy; 2018 - All rights reserved Developed by <a href="%s">Themewaves.com</a>', 'lvly'), 'https://themeforest.net/user/themewaves')),
    ),
    //Mail
    array(
        'id'       => 'footer_mail_logo',
        'type'     => 'media',
        'url'      => true,
        'title'    => esc_html__( 'Footer Mail лого', 'lvly'),
        'subtitle' => esc_html__( 'Recommended Size: 230x80', 'lvly'),
        'compiler' => 'true',
        'desc'     => '',
        'default'  => LVLY_DIR . 'assets/images/icon-mail.png',
    ),
    array(
        'id'       => 'footer_mail',
        'type'     => 'textarea',
        'title'    => esc_html__('Footer Mail текст', 'lvly'),
        'subtitle' => esc_html__('You can use HTML tags on this area', 'lvly'),
        'default'  => esc_html__('И-мэйл хаяг', 'lvly'),
    ),
    array(
        'id'       => 'footer_mail_text',
        'type'     => 'textarea',
        'title'    => esc_html__('Mail', 'lvly'),
        'subtitle' => esc_html__('You can use HTML tags on this area', 'lvly'),
        'default'  => wp_kses_post(sprintf(__( '&copy; 2018 - All rights reserved Developed by <a href="%s">Themewaves.com</a>', 'lvly'), 'https://themeforest.net/user/themewaves')),
    ),
    /*Footer bottom*/ 
    array(
        'id'       => 'footer_text',
        'type'     => 'textarea',
        'title'    => esc_html__('Copyright текстээ бичнэ үү', 'lvly'),
        'subtitle' => esc_html__('You can use HTML tags on this area', 'lvly'),
        'default'  => wp_kses_post(sprintf(__( '&copy; 2018 - All rights reserved Developed by <a href="%s">Themewaves.com</a>', 'lvly'), 'https://themeforest.net/user/themewaves')),
        'required' => array(
            array( 'footer_layout', '!=', '' ),
            array( 'footer_layout', '!=','block' ),
        )
    ),
    array(
        'id'       => 'footer_text2',
        'type'     => 'textarea',
        'title'    => esc_html__( 'Footer дээш буцах текст', 'lvly' ),
        'subtitle' => esc_html__( 'You can use HTML tags on this area', 'lvly' ),
        'default'  => esc_html__( 'Back to Top', 'lvly'),
        'required' => array(
            array( 'footer_layout', '!=', '' ),
            array( 'footer_layout', '!=','block' ),
        )
    ),
    array(
        'id'       => 'footer_custom_class',
        'type'     => 'multi_text',
        'title'    => esc_html__( 'Footer Area - Custom Class', 'lvly' ),
        'subtitle' => esc_html__( 'Автоматаар тохируулагдсан классууд өөрчлөх шаардлагагүй ', 'lvly' ),
        'default'  => array( '' ),
        'add_text'    => esc_html__( 'Add Class', 'lvly' ),
        'required' => array(
            array( 'footer_layout', '!=', '' ),
            array( 'footer_layout', '!=','block' ),
        ),
    ),
);

Redux::setSection( $opt_name, array(
    'title'            => esc_html__( 'Сайтын ерөнхий тохиргоо', 'lvly'),
    'id'               => 'general',
    'customizer_width' => '400px',
    'icon'             => 'el el-home',
    'fields'           => $options_general
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Footer', 'lvly'),
    'id'         => 'footer',
    'icon'       => 'el el-photo',
    'fields'     => $options_footer
) );