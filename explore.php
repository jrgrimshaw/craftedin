<?php
require_once dirname(__FILE__) . '/app/init.php';

$post = new Post;
$popularPostsCount = $post->getPopularPosts()->count();
$latestPostsCount = $post->getLatestPosts()->count();

$title = 'Explore';
$content = 'explore';

require_once dirname(__FILE__) . '/app/views/view.php';