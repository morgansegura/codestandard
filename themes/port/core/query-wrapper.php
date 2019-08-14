<?php
	namespace SpeedTheme\Core;
	
	class QueryWrapper {
		
		private $args;
		
		private $metaFields;
		
		private $taxonomies;
		
		public $results;
		
		public $pagination;
		
		public function __construct($args = array('post_type' => 'post'), $metaFields = array(), $taxonomies=array()) {
			$this->args = $args;
			$this->metaFields = $metaFields;
			$this->taxonomies = $taxonomies;
			
			$this->results = $this->getValues();
		}
		
		private function getArgs() {
			return $this->args;
		}
		
		public function getValues() {
			$data = array();
			
			$query = new \WP_Query($this->getArgs());
			if ($query->have_posts()) {
				while ($query->have_posts()) {
					$query->the_post();
					
					$item = array(
						'id'          => get_the_ID(),
						'url'         => get_permalink(get_the_ID()),
						'title'       => get_the_title(get_the_ID()),
						'excerpt'     => wp_trim_words(get_post_field('post_content', get_the_ID())),
						'image'       => ST_ThemeFunctions::getFeaturedImage(get_the_ID(), 'full'),
						'publish_date' => get_the_date('U') ? get_the_date('U') : null
					);
					
					if (!empty($this->metaFields) && is_array($this->metaFields)) {
						foreach ($this->metaFields as $field) {
							$item[$field] = get_field($field, get_the_ID()) ?  get_field($field, get_the_ID()) : null;
						}
					}
					
					if (!empty($this->taxonomies) && is_array($this->taxonomies)) {
						foreach ($this->taxonomies as $taxonomy) {
							$item[$taxonomy] = wp_get_post_terms(get_the_ID(), $this->taxonomies);
						}
					}
					
					$data[] = $item;
				}
				
				wp_reset_postdata();
			}
			
			if (!empty($data)) {
				if (!empty($this->args['posts_per_page']) AND $this->args['posts_per_page'] == 1) {
					return $data[0];
				}
			}
			
			return $data;
		}
		
		public function getNavigationHtml() {
			$query = new \WP_Query($this->getArgs());
			
			return wp_pagenavi(array('query' => $query, 'echo'=>false));
		}
		
	}
