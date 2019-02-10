<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn() || !$user->hasPermission('moderator')) {
    Redirect::to(404);
}

$moderator = new Moderator;
$comment = new Comment;

$title = 'Moderator - Reported Comments';
$content = 'moderator-reported-comments';

require_once dirname(__FILE__) . '/app/views/view.php';