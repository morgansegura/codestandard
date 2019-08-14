<?php
/*
	 * Template Name: Single Blog V2
	 * Template Post Type: post
	 */

$context         = Timber::context();
$timber_post     = Timber::query_post();
$categories      = Timber::get_terms('category');
$context['post'] = $timber_post;

$args                = array(
    'post_type'      => 'post',
    'posts_per_page' => 1,
    'category'       => $timber_post->category->ID,
    'post__not_in'   => array($timber_post->ID),
    'orderby'        => array(
        'meta_value_num' => 'DESC',
        'date'           => 'DESC'
    ),
    'meta_key'       => 'post_views_count'
);
$context['trending'] = Timber::get_posts($args)[0];

$excludeArticles = array($timber_post->ID);
if (!empty($context['trending']) && isset($context['trending']->ID)) {
    $excludeArticles[] = $context['trending']->ID;
}

$args2 = array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'category'       => $timber_post->category->ID,
    'post__not_in'   => $excludeArticles
);

$context['related_posts'] = Timber::get_posts($args2);

$postTags = Timber::get_terms('post_tag');
$args3    = array(
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'category'       => $timber_post->category->ID,
    'post__not_in'   => array($timber_post->ID),
);
if (!empty($postTags)) {
    $tags = array();
    foreach ($postTags as $tag) {
        $tags[] = $tag->term_id;
    }

    $args3['tax_query'] = array(
        array(
            'taxonomy' => 'post_tag',
            'field'    => 'term_id',
            'terms'    => $tags,
            'operator' => 'IN'
        )
    );
}
$context['recommended_posts'] = Timber::get_posts($args3);

updatePostViews();

if (post_password_required($timber_post->ID)) {
    Timber::render('single-password.twig', $context);
} else {
    Timber::render(array('single-' . $timber_post->ID . '.twig', 'single-post-v2.twig', 'single-' . $timber_post->post_type . '.twig', 'single.twig'), $context);
}
