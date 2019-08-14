<?php

$uri        =   get_theme_file_uri();
$version    =   DEV_MODE ? time() : false;

function _themename_assets($uri, $version)
{
    // Register Styles
    wp_register_style('_themename-admin-stylesheet', $uri . '/dist/assets/css/bundle.css', [], $version, 'all');

    // Register Scripts
    wp_register_script('_themename-scripts', $uri . '/dist/assets/js/bundle.js', array('jquery'), $version, true);

    // Enqueue Theme Styles
    wp_enqueue_style('_themename-stylesheet');
    // Enqueue Theme Scripts
    wp_enqueue_script('_themename-scripts');
}

function _themename_admin_assets($uri, $version)
{
    // Register Admin Styles
    wp_register_style('_themename-admin-stylesheet', $uri . '/dist/assets/css/admin.css', [], $version, 'all');

    // Register Admin Scripts
    wp_register_script('_themename-admin-scripts', $uri . '/dist/assets/js/admin.js', array('jquery'), $version, true);

    // Enqueue Theme Admin Styles
    wp_enqueue_style('_themename-admin-stylesheet');
    // Enqueue Theme Admin Scripts
    wp_enqueue_script('_themename-admin-scripts');
}
