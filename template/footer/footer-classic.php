<?php 
$footer_layout         = lvly_get_att( 'footer_layout' );

$footer_width          = lvly_get_option( 'footer_width' );
$footer_custom_class   = lvly_get_option( 'footer_custom_class' );

$container_class = $widget_before = $widget_after = '';
if ( ! empty( $footer_width ) ) {
    $container_class = ' uk-container-expand';
    $widget_before   = '<div class="uk-padding">';
    $widget_after    = '</div>';
}
/* Doing the Validate */
$allowed_tags = array( 
    'aside' => array(
            'id' => array(),
            'class' => array()
    ),
    'div' => array(
            'id' => array(),
            'class' => array()
    ),
    'h3' => array(
        'class' => array()
    ),
    'span' => array(
        'class' => array()
    ),
    'a' => array(
        'href' => array(),
        'data-uk-scroll' => array(),
    ),
    'i' => array(
        'class' => array()
    ),
);
if ( $footer_layout ) {
    switch ( $footer_layout ) {
        case '6-6':
            $footer_layout_class = ' uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-grid-medium';
        break;
        case '4-4-4':
            $footer_layout_class = ' uk-child-width-1-1 uk-child-width-1-3@s uk-child-width-1-3@m uk-grid-medium';
        break;
        case '3-3-3-3':
            $footer_layout_class = ' uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-4@m uk-grid-medium';
        break;
        case '3-6-3':
            $footer_layout_class = ' footer-contact';
        break;
        default :
            $footer_layout_class = ' uk-child-width-1-1@s';
        break;
    } ?>
    <div class="bottom-area">
        <div class="uk-container<?php echo esc_attr( $container_class );?>">
        <?php echo lvly_footer_logo() ?>
            <div class="<?php echo esc_attr( $footer_layout_class ); ?>" data-uk-grid><?php
                if ( ! is_array( $footer_custom_class ) ) {
                    $footer_custom_class = array();
                }
                
                $i = 1;
                foreach ( explode( '-', $footer_layout ) as $g ) {
                    $j = $i-1;

                    echo '<div' . ( empty( $footer_custom_class[ $j ] ) ? '' : ( ' class="' . esc_attr( $footer_custom_class[ $j ] ) . '"' ) ) . '>';
                        echo wp_kses( $widget_before, $allowed_tags );
                            dynamic_sidebar( 'lvly-footer-sidebar-' . esc_attr( $i ) );
                        echo wp_kses( $widget_after, $allowed_tags );
                    echo '</div>';
                    $i++;
                } ?>
            </div>
        </div>
    </div><?php
} ?>
<div class="footer-area footer-small uk-light">
    <div class="uk-container<?php echo esc_attr( $container_class );?>">
        <div class="uk-flex-middle uk-child-width-1-1 uk-child-width-expand@m" data-uk-grid><?php
            $copyright = lvly_get_option( 'footer_text', esc_html__( '&copy; Copyright 2018 - All Rights Reserved', 'lvly' ) );
            if ( ! empty( $copyright ) ) {
                echo '<div class="copyright">' . wp_kses_post( $copyright ) . '</div>';
            }
            $text_right = lvly_get_option( 'footer_text2', esc_html__( 'Back To Top &nbsp;&nbsp;', 'lvly' ) );
            if ( ! empty( $text_right ) ) {
                echo '<div class="uk-text-right"><a class="moc-scroll" href="#" title="'.esc_attr__('Scroll to top','lvly').'" data-uk-scroll>';
                echo wp_kses_post( $text_right );
                echo '</a></div>';
            } ?>
        </div>
    </div>
</div>