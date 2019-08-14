<?php
	namespace SpeedTheme\Core;
	
	use Timber\Menu;
	
	class CustomGlobalContent extends ST_GlobalContent {
		
		public function addToContext( $context ) {
			
			$context['header_menu'] = new Menu( 'Header Menu' );
			$context['footer_menu'] = new Menu( 'Footer Menu' );
			$context['site']        = $this;
			
			return $context;
		}
		
		public function registerPostTypes() {
		
		}
		
		public function registerTaxonomies() {
		
		}
		
	}