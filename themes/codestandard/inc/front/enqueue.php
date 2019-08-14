<?php

function cs_enqueue() {
    $uri     = get_theme_file_uri();
    $version = CS_DEV_MODE ? time() : false;

    wp_register_style( 'cs_google_fonts', 'https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i', [], $version);
    wp_register_style( 'cs_bootstrap', $uri . '/assets/css/bootstrap.css', [], $version );
    wp_register_style( 'cs_style', $uri . '/assets/css/style.css', [], $version );
    wp_register_style( 'cs_dark', $uri . '/assets/css/dark.css', [], $version );
    wp_register_style( 'cs_font_icons', $uri . '/assets/css/font-icons.css', [], $version );
    wp_register_style( 'cs_animate', $uri . '/assets/css/animate.css', [], $version );
    wp_register_style( 'cs_magnific_popup', $uri . '/assets/css/magnific-popup.css', [], $version );
    wp_register_style( 'cs_responsive', $uri . '/assets/css/responsive.css', [], $version );
    wp_register_style( 'cs_custom', $uri . '/assets/css/custom.css', [], $version );

    wp_enqueue_style( 'cs_google_fonts' );
    wp_enqueue_style( 'cs_bootstrap' );
    wp_enqueue_style( 'cs_style' );
    wp_enqueue_style( 'cs_dark' );
    wp_enqueue_style( 'cs_font_icons' );
    wp_enqueue_style( 'cs_animate' );
    wp_enqueue_style( 'cs_magnific_popup' );
    wp_enqueue_style( 'cs_responsive' );
    wp_enqueue_style( 'cs_custom' );

    wp_register_script( 'cs_plugins', $uri . '/assets/js/plugins.js', [], $version, true );
    wp_register_script( 'cs_functions', $uri . '/assets/js/functions.js', [], $version, true );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'cs_plugins' );
    wp_enqueue_script( 'cs_functions' );
}