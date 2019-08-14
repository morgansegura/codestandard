<?php

// Setup
define( 'DEV_MODE', true );
define( 'THEME_URL', get_bloginfo( 'stylesheet_directory' ) . '/' );
define( 'THEME_PATH', __DIR__ . '/' );

/** Initializing Vendors */
require_once( __DIR__ . '/vendor/autoload.php' );

/** Initializing Timber */
$timber = new \Timber\Timber();

/**
 * Sets the directories (inside your theme) to find .twig files
 */
$timber::$dirname = array( 'templates/views', 'views' );

\Timber\Timber::$autoescape = false;

require_once "core/init-core.php";

if ( file_exists( __DIR__ . '/packages/load-packages.php' ) ) {
	require_once( 'packages/load-packages.php' );
}

new SpeedTheme\Core\CustomGlobalContent();

// Includes
include(get_theme_file_path('/includes/utils.php'));
include( get_theme_file_path( '/includes/front/enqueue.php' ));

// Hooks
add_action('wp_enqueue_scripts', '_themename_assets');
add_action('admin_enqueue_scripts', '_themename_admin_assets');

// Shortcodes