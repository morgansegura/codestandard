<?php

namespace SpeedTheme\Core;

class ST_ThemeFunctions {
  
  public static function getFeaturedImage($post_id, $size = 'medium') {
    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
    
    if (is_array($image)) {
      $image[4] = self::getAltForImage($post_id);
      $image[5] = get_field('image_code', get_post_thumbnail_id($post_id));
    }
    
    return $image;
  }
  
  public static function getAltForImage($postID = false) {
    if (!$postID) {
      return false;
    }
    
    $imageID = get_post_thumbnail_id($postID);
    
    if (get_post_meta($imageID, '_wp_attachment_image_alt', true)) {
      return get_post_meta($imageID, '_wp_attachment_image_alt', true);
    }
    
    $attach = get_post($imageID);
    
    return $attach->post_title;
  }
  
  public static function getRelatedArticles($postId, $postTypes = array(), $tagTaxonomy = false) {
    $tags = array();
    $args = array(
      'post_type'      => $postTypes,
      'posts_per_page' => 2,
      'post__not_in'   => array($postId)
    );
    
    if ($tagTaxonomy) {
      $tags = wp_get_post_terms($postId, $tagTaxonomy);
    }
    
    if (!empty($tags)) {
      $tagsArray = array();
      
      foreach ($tags as $tag) {
        $tagsArray[] = $tag->term_id;
      }
      
      $args['tax_query'] = array(
        array(
          'taxonomy' => $tagTaxonomy,
          'field'    => 'term_id',
          'terms'    => $tagsArray,
        )
      );
    }
    
    $posts = new \WP_Query($args);
    $postsID = array();
    
    while ($posts->have_posts()) {
      $posts->the_post();
      $postsID[] = get_the_ID();
    }
    
    wp_reset_postdata();
    
    if (!empty($postsID)) {
      return $postsID;
    }
    
    return self::getRelatedArticles($postTypes, $postsID);
  }
  
  public static function generateID() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $randomString;
  }
  
  public static function isSafari() {
    return stripos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false;
  }
  
  public static function getImageURL($imageURL) {
    if (defined('CDN_ACTIVE') && CDN_ACTIVE) {
      return str_replace(home_url('/'), CDN_CNAME, $imageURL);
    }
    
    return $imageURL;
  }
}
