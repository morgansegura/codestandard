<?php

// Setup
define( 'CS_DEV_MODE', true );

// Includes
include( get_theme_file_path( '/inc/front/enqueue.php' ) );
include( get_theme_file_path( '/inc/setup.php' ) );

// Hooks
add_action( 'wp_enqueue_scripts', 'cs_enqueue' );
add_action( 'after_setup_theme', 'cs_setup_theme' );


// Shortcodes
