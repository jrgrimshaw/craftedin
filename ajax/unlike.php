<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('post_id') !== null) {
            $userId = $user->data()->id;
            $postId = (int)escape(Input::get('post_id'));

            $post = new Post;
            $like = new Like;

            if($post->exists($postId)) {
                if($like->hasLiked($postId)) {
                    try {
                        DB::getInstance()->query("DELETE FROM likes WHERE user_id = ? AND post_id = ?", array($userId, $postId));

                        echo DB::getInstance()->get('likes', array('post_id', '=', $postId))->count() . ' like';
                        if(DB::getInstance()->get('likes', array('post_id', '=', $postId))->count() != '1') { echo 's'; }
                    } catch(Exception $e) {
                        die($e->getMessage());
                    }
                }
            }
        }
    } else {
        Redirect::to('/');
    }
} else {
    Redirect::to('/');
}