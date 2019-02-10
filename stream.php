<?php
require_once dirname(__FILE__) . '/app/init.php';

// STREAM IS CURRENTLY IN BETA

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/stream');
}

$post = new Post();
$posts = $post->getHomePosts()->results();
$postsCount = $post->getHomePosts()->count();

$comment = new Comment;
$team = new Team;

$title = 'Stream';
$content = 'stream';

require_once dirname(__FILE__) . '/app/views/view.php';