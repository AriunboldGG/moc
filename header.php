<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <?php lvly_favicon(); ?>
        <?php wp_head(); ?>
    </head>
    <body <?php 
        body_class();
        echo ' data-acc-color="'      . esc_attr( empty( $_COOKIE['tw_accessibility_color'] )       ? 'normal' :         $_COOKIE['tw_accessibility_color'] ) . '"';
        echo ' data-acc-size="'       . esc_attr( empty( $_COOKIE['tw_accessibility_size'] )        ? 0        : intval( $_COOKIE['tw_accessibility_size'] ) ) . '"';
        echo ' data-acc-hide-image="' . esc_attr( empty( $_COOKIE['tw_accessibility_hide_image'] )  ? ''       :         $_COOKIE['tw_accessibility_hide_image'] ) . '"'; ?>
    ><div class="tw-preloader"><div data-uk-spinner></div></div><?php
        lvly_template_header(); ?>
        <div<?php lvly_main_data(); ?>><?php
            lvly_template_feature();