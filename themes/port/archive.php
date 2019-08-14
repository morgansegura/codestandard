<?php
$templates = array('archive.twig', 'index.twig');
$context = Timber::context();

$context['title'] = 'Archive';
if (is_day()) {
    $context['title'] = 'Archive: ' . get_the_date('D M Y');
} else if (is_month()) {
    $context['title'] = 'Archive: ' . get_the_date('M Y');
} else if (is_year()) {
    $context['title'] = 'Archive: ' . get_the_date('Y');
} else if (is_tag()) {
    $context['title'] = single_tag_title('', false);
} else if (is_category()) {
    $context['title'] = single_cat_title('', false);
    array_unshift($templates, 'archive-' . get_query_var('cat') . '.twig');
} else if (is_post_type_archive()) {
    $context['title'] = post_type_archive_title('', false);
    array_unshift($templates, 'archive-' . get_post_type() . '.twig');
}

$categoryData    = new Timber\Term();
$postsPerPage    = get_field('category_posts_per_page', 'options') ? get_field('category_posts_per_page', 'options') : 6;
$timber          = new Timber\Timber();
$context['term'] = $categoryData;

$hero = $categoryData->get_field('hero');
if ($hero['type_view_hero_post'] == 'custom_post') {
    if (!empty($hero['select_custom_posts']) && isset($hero['select_custom_posts'][0])) {
        $context['hero_post'] = Timber::get_post($hero['select_custom_posts'][0]->ID);
    }
} else {
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'category'       => $categoryData->ID,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    if ($hero['type_view_hero_post'] == 'most_viewed') {
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
    $context['hero_post'] = Timber::get_posts($args)[0];
}

$middlePostData = $categoryData->get_field('middle_post');
$middlePostId   = 0;
if ($middlePostData) {
    $middlePostId           = $middlePostData->ID;
    $context['middle_post'] = Timber::get_post($middlePostData->ID);
}

$exclude                        = array($context['hero_post']->ID, $middlePostId);
$args2                          = array(
    'posts_per_page' => $postsPerPage,
    'category_name'  => $context['term']->slug,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'post__not_in'   => $exclude
);
$context['first_content_posts'] = Timber::get_posts($args2);

$args3 = array(
    'posts_per_page' => $postsPerPage,
    'paged'          => 2,
    'category_name'  => $context['term']->slug,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'post__not_in'   => $exclude
);
//$context['second_content_posts'] = Timber::get_posts($args3);
$context['second_content_posts'] = new Timber\PostQuery($args3, 'TimberPost');

$args4 = array(
    'posts_per_page' => 5,
    'category_name'  => $context['term']->slug,
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'post__not_in'   => $exclude,
    'orderby'        => array(
        'meta_value_num' => 'DESC',
        'date'           => 'DESC'
    ),
    'meta_key'       => 'post_views_count'
);

$context['trending'] = $timber::get_posts($args4);

if ($context['second_content_posts']->pagination()->total <= 2) {
    $context['show_more_disabled'] = true;
}

Timber::render($templates, $context);
