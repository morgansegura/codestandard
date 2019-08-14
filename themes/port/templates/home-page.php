<?php

/**
 * Template Name: Home Page
 */
$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;
$context['news'] = Timber::get_posts('post_type=post&numberposts=6&tag=news');

$context['trending'] = Timber::get_posts(array(
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'orderby'        => array('meta_value_num' => 'DESC', 'date' => 'DESC'),
    'meta_key'       => 'post_views_count'
));

$context['latest_stories'] = Timber::get_posts(array(
    'post_type'      => 'post',
    'posts_per_page' => 8,
    'post__not_in'   => excludeHerePosts()
));

Timber::render(array('front-page.twig', 'page.twig'), $context);
