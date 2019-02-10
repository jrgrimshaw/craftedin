<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    $posts = [];

    $start = isset($_GET['start']) ? (int)$_GET['start'] - 1 : 0;
    $count = isset($_GET['count']) ? (int)$_GET['count'] : 1;

    $db = DB::getInstance();

    if(Input::get('type') === 'stream') {
        $post = $db->query("SELECT SQL_CALC_FOUND_ROWS p.*
                            FROM posts p
                            INNER JOIN following f
                            ON(p.user_id = f.user_following_id)
                            WHERE (p.user_id = {$user->data()->id} OR f.user_id = {$user->data()->id})
                            GROUP BY p.id
                            ORDER BY p.date DESC LIMIT {$start}, {$count}");
    } else if(Input::get('type') === 'search') {
        $q = trim(escape(Input::get('q')));
        $post = $db->query("SELECT SQL_CALC_FOUND_ROWS p.*
                            FROM posts p
                            INNER JOIN comments c
                            ON(p.id = c.post_id)
                            WHERE ((p.content LIKE '%{$q}%') OR c.content LIKE '%{$q}%')
                            GROUP BY p.id
                            ORDER BY p.date DESC LIMIT {$start}, {$count}");
    } else if(Input::get('type') === 'profile') {
        $id = escape(Input::get('user'));
        $post = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM posts WHERE user_id = '{$id}' ORDER BY date DESC LIMIT {$start}, {$count}");
    } else if(Input::get('type') === 'popular') {
        $post = $db->query("SELECT SQL_CALC_FOUND_ROWS posts.*, COUNT(likes.post_id) AS likes 
                            FROM posts 
                            LEFT JOIN likes ON likes.post_id=posts.id 
                            GROUP BY posts.id
                            ORDER BY likes DESC, posts.date DESC LIMIT {$start}, {$count}");
    } else if(Input::get('type') === 'latest') {
        $post = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM posts ORDER BY date DESC LIMIT {$start}, {$count}");
    } else {
        $post = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM posts LIMIT {$start}, {$count}");
    }

    $postsTotal = $post->count();

    if($postsCount = $post->count()) {
        $posts = $post->results();
    }

    $comment = new Comment;

    foreach($posts as $p) {
        echo streamPost($p, $user, $comment);
    }
}