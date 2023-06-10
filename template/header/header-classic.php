<?php 
echo lvly_top_bar(true);
?>
<header class="header-container tw-header tw-header-top">
    <div class="uk-container"> 
        <nav class="uk-navbar-container uk-flex-center" data-uk-navbar>
            <?php if ( defined ( 'ICT_PORTAL_MAIN' )  ) {
                echo '<div class="uk-navbar-left uk-logo">';
                    echo lvly_logo();
                echo '</div>';
            } else {
                echo '<div class="uk-navbar-left uk-logo tw-subsite-logo">';
                    echo lvly_logo();
                echo '</div>';
            }
            echo '<div class="uk-navbar-right">';
                echo '<div class="tw-header-meta">';
                    // Socials
                    lvly_menu_social_links();
                    
                    // Languages
                    $langs = array( 
                        'mn' => 'МН',
                        'en' => 'EN',
                        'mb' => 'MNG',
                    );
                    $lang_content_act = '';
                    $lang_content = '';
                    $lang_other_count = 0;
                    foreach( $langs as $lang => $text ) {
                        $flag = '<img src="' . esc_url( LVLY_DIR . 'assets/images/flag-' . $lang . '.svg' ) . '" data-uk-svg  class="uk-preserve" />' . $text;

                        if ( ICT_LANG === $lang ) {
                            $lang_content_act .= '<li>' . $flag . '</li>';
                        } else {
                            if( $site_url = lvly_get_option( $lang . '_site_url' ) ) {
                                $lang_other_count ++;
                                $lang_content .= '<li>';
                                    $lang_content .= '<a href="' . esc_url( $site_url ) . '" title="' . $text . '">';
                                        $lang_content .= $flag;
                                    $lang_content .= '</a>';
                                $lang_content .= '</li>';   
                            }
                        }
                    }
                    if ( $lang_content_act && $lang_content ) {
                        echo '<ul class="tw-languages">';
                            if ( $lang_other_count > 1 ) {
                                echo $lang_content_act;
                                echo $lang_content;
                                // echo '<ul>';
                            }
                            // if ( $lang_other_count > 1 ) {
                            //     echo '</ul>';
                            // }
                        echo '</ul>';
                    }
                echo '</div>';
            echo '</div>'; ?>
        </nav>
    </div>
</header>
<header class="header-container tw-header tw-header-bottom">
    <div class="uk-container"> 
        <nav class="uk-navbar-container uk-flex-center" data-uk-navbar><?php
                echo '<div class="uk-navbar-center uk-visible@m">';
                    lvly_menu();
                echo '</div>';
                echo '<div class="uk-navbar-right">';
                    echo '<div class="tw-header-meta">';
                        /* Search */
                        echo '<a class="search-btn uk-navbar-toggle" href="#search-modal" data-uk-toggle></a>';
                        /* Accessibility */ ?>
                        <button class="uk-button tw-accessibility-btn" type="button" uk-toggle="target: #tw-accessibility-modal"><svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.16" d="M20 40C31.0457 40 40 31.0457 40 20C40 8.9543 31.0457 0 20 0C8.9543 0 0 8.9543 0 20C0 31.0457 8.9543 40 20 40Z" fill="white"/><path d="M20 35C28.2843 35 35 28.2843 35 20C35 11.7157 28.2843 5 20 5C11.7157 5 5 11.7157 5 20C5 28.2843 11.7157 35 20 35Z" fill="white"/><path d="M27.5 15.7984C27.5044 16.2124 27.2142 16.5709 26.8094 16.6515C25.929 16.8454 24.1521 17.3022 23.0702 17.5523C22.5668 17.6668 22.2097 18.1169 22.2119 18.6354C22.2163 19.7997 22.2313 21.7253 22.28 22.2382C22.3398 22.9896 22.4389 23.7365 22.5773 24.4772C22.7113 25.2213 22.8813 25.9616 23.0867 26.6918C23.285 27.4137 23.5225 28.1239 23.7983 28.8196L23.8127 28.8558C23.9838 29.2826 23.7772 29.7683 23.3514 29.9394C22.9444 30.1034 22.481 29.9216 22.2927 29.5243C21.9422 28.7785 21.6338 28.0133 21.3696 27.2319C21.1039 26.4622 20.8746 25.6803 20.6825 24.8862C20.6194 24.63 20.5629 24.3721 20.5086 24.1132C20.4825 23.9854 20.3696 23.8931 20.2389 23.8931H19.7616C19.6309 23.8931 19.518 23.9853 19.4914 24.1137C19.4377 24.3727 19.3806 24.6306 19.3175 24.8867C19.1259 25.6808 18.8967 26.4628 18.6304 27.2325C18.3657 28.0133 18.0578 28.7785 17.7073 29.5248C17.5102 29.9405 17.0146 30.1167 16.601 29.9188C16.2051 29.7299 16.024 29.2642 16.1873 28.8563L16.2017 28.8202C16.4775 28.1244 16.715 27.4142 16.9133 26.6923C17.1187 25.9621 17.2887 25.2219 17.4227 24.4777C17.5611 23.737 17.6608 22.9901 17.72 22.2387C17.7688 21.7258 17.7832 19.8002 17.7881 18.636C17.7898 18.118 17.4332 17.6679 16.9298 17.5528C15.8479 17.3022 14.071 16.846 13.1906 16.652C12.7858 16.5714 12.4956 16.213 12.5 15.799C12.5172 15.3388 12.9031 14.9798 13.3616 14.9976C13.4104 14.9993 13.4585 15.0054 13.5062 15.016L13.5566 15.0271C15.6679 15.5361 17.8285 15.8073 19.9996 15.8356C22.1708 15.8073 24.3319 15.5356 26.4427 15.0271L26.4931 15.016C26.9416 14.9182 27.384 15.2038 27.481 15.654C27.4922 15.7012 27.4983 15.7501 27.5 15.7984ZM20.0004 14.4458C21.2235 14.4458 22.2153 13.4505 22.2153 12.2229C22.2153 10.9953 21.2235 10 20.0004 10C18.7772 10 17.7855 10.9953 17.7855 12.2229C17.7855 13.4505 18.7772 14.4458 20.0004 14.4458Z" fill="#1A2B6B"/></svg></button><?php
                        lvly_modal_accessibility();
                        /* Mobile Menu */
                        echo '<a class="mobile-menu uk-navbar-toggle uk-hidden@m" href="#" data-uk-toggle="target: #mobile-menu-modal">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 4.66797H14" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M2 8H14" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M2 11.332H14" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        </a>';
                    echo '</div>';
                echo '</div>';
            lvly_modal_search( true ); 
            ?>
        </nav><?php
        lvly_modal_mobile_menu();
        echo '<a class="search-btn uk-navbar-toggle" href="#search-modal" data-uk-toggle></a>'; ?>
    </div>
</header>