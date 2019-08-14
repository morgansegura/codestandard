<?php
	//Renamed Posts to Stories
	function changeDefaultPostLabel() {
		global $menu;
		global $submenu;
		$menu[5][0]                 = 'Stories';
		$submenu['edit.php'][5][0]  = 'Stories';
		$submenu['edit.php'][10][0] = 'Add Stories';
		$submenu['edit.php'][16][0] = 'Stories Tags';
	}
	
	add_action( 'admin_menu', 'changeDefaultPostLabel' );
	
	function changeDefaultPostObject() {
		global $wp_post_types;
		$labels                     = &$wp_post_types['post']->labels;
		$labels->name               = 'Stories';
		$labels->singular_name      = 'Story';
		$labels->add_new            = 'Add Stories';
		$labels->add_new_item       = 'Add Stories';
		$labels->edit_item          = 'Edit Stories';
		$labels->new_item           = 'Stories';
		$labels->view_item          = 'View Stories';
		$labels->search_items       = 'Search Stories';
		$labels->not_found          = 'No Stories found';
		$labels->not_found_in_trash = 'No Stories found in Trash';
		$labels->all_items          = 'All Stories';
		$labels->menu_name          = 'Stories';
		$labels->name_admin_bar     = 'Stories';
	}
	
	add_action( 'init', 'changeDefaultPostObject' );
	
	function removePostFormatBox() {
		remove_theme_support( 'post-formats' );
	}
	
	//Remove the post format meta box
	add_action( 'init', 'removePostFormatBox' );