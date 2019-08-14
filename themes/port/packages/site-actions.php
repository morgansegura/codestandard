<?php
	function initializePostViewsOnInsert( $post_ID ) {
		if ( ! wp_is_post_revision( $post_ID ) ) {
			add_post_meta( $post_ID, 'post_views_count', 0, true );
		}
	}
	
	add_action( 'publish_post', 'initializePostViewsOnInsert' );
	
	function headVariables() {
		
		echo '<script type="text/javascript">
	         var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";
	       </script>';
	}
	add_action( 'wp_head', 'headVariables' );