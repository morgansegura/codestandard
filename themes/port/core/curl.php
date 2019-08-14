<?php
	
	namespace SpeedTheme\Core;
	
	class Curl {
		static public function curl( $link, $parameters = null, $method = 'GET', $headers = null, $file = null ) {
			$curl = curl_init();
			curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, $method );
			curl_setopt( $curl, CURLOPT_URL, $link );
			curl_setopt( $curl, CURLOPT_HEADER, 0 );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
			if ( $headers != null ) {
				curl_setopt( $curl, CURLOPT_HTTPHEADER, array( $headers ) );
			}
			if ( ( $method == 'POST' or $method == 'PUT' ) AND $parameters != null ) {
				if ( $file ) {
					if ( ! class_exists( '\CURLFile' ) ) {
						curl_setopt( $curl, CURLOPT_SAFE_UPLOAD, false );
					}
					curl_setopt( $curl, CURLOPT_POSTFIELDS, $parameters );
				} else {
					curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );
				}
			}
			
			$response = curl_exec( $curl );
			
			$info = curl_getinfo( $curl )["http_code"];
			
			$arr             = array();
			$arr['status']   = $info;
			$arr['response'] = json_decode( $response, true );
			
			return $arr;
		}
	}