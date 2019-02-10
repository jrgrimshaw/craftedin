<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn() || !$user->hasPermission('moderator')) {
    Redirect::to(404);
}

$moderator = new Moderator;
$post = new Post;

$title = 'Moderator - Reported Posts';
$content = 'moderator-reported-posts';

require_once dirname(__FILE__) . '/app/views/view.php';