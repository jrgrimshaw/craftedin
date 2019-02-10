<?php
require_once dirname(__FILE__) . '/app/init.php';

$comment = new Comment;

if($user->isLoggedIn()) {
    if($user->data()->setup === '0') {
        Redirect::to('/welcome');
    } else {
        Redirect::to('/stream');
    }
}

$popularPosts = DB::getInstance()->query("SELECT * FROM posts LIMIT 4")->results();

$title = 'The premier hangout for web developers, designers and more';
$content = 'home';
$hero = true;

require_once dirname(__FILE__) . '/app/views/view.php';