<?php
	function updatePostViews() {
		$key     = 'post_views_count';
		$post_id = get_the_ID();
		$count   = (int) get_post_meta( $post_id, $key, true );
		$count ++;
		update_post_meta( $post_id, $key, $count );
	}
	
	//Exclude Hero Post
	function excludeHerePosts() {
		$frontpage_id    = get_option( 'page_on_front' );
		$homepageContent = get_field( "content", $frontpage_id );
		
		$exclude = array();
		
		if ( isset( $homepageContent ) ) {
			foreach ( $homepageContent as $block ) {
				if ( $block['acf_fc_layout'] == "block_hero" ) {
					$exclude[] = $block['hero_post']->ID;
				}
				
				if ( isset( $block['second_hero_posts'] ) ) {
					foreach ( $block['second_hero_posts'] as $secondBlock ) {
						$exclude[] = $secondBlock->ID;
					}
				}
				
			}
		}
		
		return $exclude;
	}
	
	function excludeCategoryHeroPosts( $categoryId ) {
		$exclude = array();
		
		if ( $categoryId ) {
			
			$categoryData    = new Timber\Term( $categoryId );
			$context['term'] = $categoryData;
			
			$hero = $categoryData->get_field( 'hero' );
			if ( $hero['type_view_hero_post'] == 'custom_post' ) {
				if ( ! empty( $hero['select_custom_posts'] ) && isset( $hero['select_custom_posts'][0] ) ) {
					$exclude[] = $hero['select_custom_posts'][0]->ID;
				}
			} else {
				$args = array(
					'post_type'      => 'post',
					'posts_per_page' => 1,
					'category'       => $categoryData->ID,
					'orderby'        => 'date',
					'order'          => 'DESC',
				);
				if ( $hero['type_view_hero_post'] == 'most_viewed' ) {
					$args = array(
						'post_type'      => 'post',
						'posts_per_page' => 1,
						'category'       => $categoryData->ID,
						'orderby'        => array(
							'meta_value_num' => 'DESC',
							'date'           => 'DESC'
						),
						'meta_key'       => 'post_views_count'
					);
				}
				$exclude[] = Timber::get_posts( $args )[0]->ID;
			}
			
			$middlePostData = $categoryData->get_field( 'middle_post' );
			if ( $middlePostData ) {
				$exclude[] = $middlePostData->ID;
			}
		}
		
		return $exclude;
	}