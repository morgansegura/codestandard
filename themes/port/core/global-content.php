<?php

namespace SpeedTheme\Core;

use Timber\Menu;

class ST_GlobalContent extends \Timber\Site {
  /** Add timber support. */
  public function __construct() {
    add_action( 'after_setup_theme', array( $this, 'addThemeSupports' ) );
    add_filter( 'timber/context', array( $this, 'addToContext' ) );
    add_action( 'init', array( $this, 'registerPostTypes' ) );
    add_action( 'init', array( $this, 'registerTaxonomies' ) );
    parent::__construct();
  }

  public function addThemeSupports() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    
    add_theme_support(
      'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
      )
    );
    
    add_theme_support(
      'post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
      )
    );
    
    add_theme_support( 'menus' );
  }
}
