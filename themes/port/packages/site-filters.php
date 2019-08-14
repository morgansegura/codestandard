<?php
	function uploadMimeTypes( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		
		return $mimes;
	}
	
	add_filter( 'upload_mimes', 'uploadMimeTypes' );
	
	//Load theme options
	function loadThemeOptionsIntoContext( $context ) {
		$context['options'] = get_fields( 'option' );
		
		return $context;
	}
	
	add_filter( 'timber_context', 'loadThemeOptionsIntoContext' );
	
	//filter to only show top level category of current cpt
	function filterPostsByCategory( $args, $field, $post_ID ) {
		
		if ( ! isset( $args['tax_query'] ) ) {
			$args['tax_query'] = array();
		}
		
		$tesm_id = str_replace( "term_", "", $post_ID );
		
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'id',
				'terms'    => $tesm_id
			)
		);
		
		return $args;
	}
	
	add_filter( 'acf/fields/relationship/query/name=select_custom_posts', 'filterPostsByCategory', 10, 3 );
	
	function middlePstObjectFilterPostsByCategory( $args, $field, $post_ID ) {
		if ( ! isset( $args['tax_query'] ) ) {
			$args['tax_query'] = array();
		}
		
		$term_id           = str_replace( "term_", "", $post_ID );
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'id',
				'terms'    => $term_id
			)
		);
		
		return $args;
	}
	
	add_filter( 'acf/fields/post_object/query/name=middle_post', 'middlePstObjectFilterPostsByCategory', 10, 3 );
	
	// disable gutenberg by default if WP < 5.0 beta
	//add_filter('gutenberg_can_edit_post', '__return_false', 5);
	// disable gutenberg by default if WP >= 5.0
	add_filter( 'use_block_editor_for_post', '__return_false', 5 );