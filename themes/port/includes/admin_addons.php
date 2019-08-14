<?php

/////////////////////////////////////////////////////////////////////
// Custom plugins, function and addons for admin area (wp-admin)  //
////////////////////////////////////////////////////////////////////

if ( ! function_exists('paid_posts_post_type') ) {

// Register Custom Post Type
function paid_posts_post_type() {

	$labels = array(
		'name'                  => _x( 'Paid Posts', 'Post Type General Name', 'zox' ),
		'singular_name'         => _x( 'Paid Post', 'Post Type Singular Name', 'zox' ),
		'menu_name'             => __( 'Paid Posts', 'zox' ),
		'name_admin_bar'        => __( 'Paid Post', 'zox' ),
		'archives'              => __( 'Paid Post Archives', 'zox' ),
		'attributes'            => __( 'Paid Post Attributes', 'zox' ),
		'parent_item_colon'     => __( 'Parent Item:', 'zox' ),
		'all_items'             => __( 'All Paid Posts', 'zox' ),
		'add_new_item'          => __( 'Add New Paid Post', 'zox' ),
		'add_new'               => __( 'Add New', 'zox' ),
		'new_item'              => __( 'New Paid Post', 'zox' ),
		'edit_item'             => __( 'Edit Paid Post', 'zox' ),
		'update_item'           => __( 'Update Paid Post', 'zox' ),
		'view_item'             => __( 'View Paid Post', 'zox' ),
		'view_items'            => __( 'View Paid Post', 'zox' ),
		'search_items'          => __( 'Search Paid Post', 'zox' ),
		'not_found'             => __( 'Not found', 'zox' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'zox' ),
		'featured_image'        => __( 'Featured Image', 'zox' ),
		'set_featured_image'    => __( 'Set featured image', 'zox' ),
		'remove_featured_image' => __( 'Remove featured image', 'zox' ),
		'use_featured_image'    => __( 'Use as featured image', 'zox' ),
		'insert_into_item'      => __( 'Insert into item', 'zox' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'zox' ),
		'items_list'            => __( 'Items list', 'zox' ),
		'items_list_navigation' => __( 'Items list navigation', 'zox' ),
		'filter_items_list'     => __( 'Filter items list', 'zox' ),
	);
	$args = array(
		'label'                 => __( 'Paid Post', 'zox' ),
		'description'           => __( 'Create Paid Posts like a hero', 'zox' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-media-text',
		'show_in_admin_bar'     => false,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'paid_posts', $args );

}
add_action( 'init', 'paid_posts_post_type', 0 );

}

/**
* Create Custom Logo Setting and Upload Control
**/
function paid_theme_new_customizer_settings($wp_customize) {
	$wp_customize->add_setting('paid_theme_logo');
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'paid_theme_logo',
		array(
		'label' => 'Upload Paid Logo',
		'section' =>'title_tagline',
		'settings' => 'paid_theme_logo'
		)
	));
}
add_action('customize_register', 'paid_theme_new_customizer_settings');
