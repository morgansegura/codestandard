<?php
	function loadMorePosts() {
	  
	  $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
	  header("Content-Type: text/html");
	  
	  $exclude = excludeHerePosts();
	  
	  $args = array(
	    "posts_per_page" => 8,
	    "paged"          => $page,
	    "orderby"        => "post_date",
	    "order"          => "DESC",
	    "post__not_in"          => $exclude,
	    "post_type"      => "post",
	    "post_status"    => "publish"
	  );
	  
	  if ($page % 2) {
	    $largePost = 3;
	  } else {
	    $largePost = 4;
	  }
	  
	  $count_posts = wp_count_posts();
	  $published_posts = $count_posts->publish;
	  
	  if ( ($published_posts - count($exclude) ) > 8 * $page ) {
	    $disableButton = false;
	  } else {
	    $disableButton = true;
	  }
	  
	  
	  $posts = get_posts($args);
	  
	  $response = array(
	    'data' => Timber::compile(
	      array('partial/home_stories_blocks.twig'),
	      array('posts' => $posts, 'large_post' => $largePost )
	    ),
	    'disableButton' => $disableButton
	  );
	  wp_send_json($response);
	  
	  die();
	}
	add_action('wp_ajax_nopriv_more_post_ajax', 'loadMorePosts');
	add_action('wp_ajax_more_post_ajax', 'loadMorePosts');
	
	
	function categoryLoadMorePosts() {
		
		$page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
		header("Content-Type: text/html");
		
		$postsPerPage = get_field('category_posts_per_page', 'options') ? get_field('category_posts_per_page', 'options') : 6;
		$categoryId = (isset($_POST['category'])) ? $_POST['category'] : 0;
		$exclude = excludeCategoryHeroPosts($categoryId);
		
		$args = array(
			"posts_per_page" => $postsPerPage,
			"paged"          => $page,
			"post__not_in"   => $exclude,
			"post_type"      => "post",
			'category'       => $categoryId,
			"post_status"    => "publish",
			"orderby"        => "post_date",
			"order"          => "DESC",
		);
		$posts = new WP_Query($args);
		
		if ($posts->max_num_pages <= $page) {
			$disableButton = true;
		} else {
			$disableButton = false;
		}
		
		
		$response = array(
			'data' => Timber::compile(
				array('category/ajax-articles-block.twig'),
				array('posts' => $posts->posts)
			),
			'disableButton' => $disableButton
		);
		wp_send_json($response);
		
		die();
	}
	add_action('wp_ajax_nopriv_category_more_post_ajax', 'categoryLoadMorePosts');
	add_action('wp_ajax_category_more_post_ajax', 'categoryLoadMorePosts');