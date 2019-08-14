<?php
$templates = array('search.twig', 'archive.twig', 'index.twig');

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;

$context['title']         = get_search_query();
$context['search_query']  = get_search_query();
$context['search_result'] = new Timber\PostQuery();

Timber::render($templates, $context);
