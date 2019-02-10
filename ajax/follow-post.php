<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('post_id') !== null) {
            $post = new Post;
            $postId = escape(Input::get('post_id'));

            if($post->exists($postId)) {
                if(!$post->isFollowing($postId)) {
                    if($post->get($postId)->user_id !== $user->data()->id) {
                        try {
                            $post->follow($postId);
                            echo 'Ok';
                        } catch(Exception $e) {
                            die($e->getMessage());
                        }
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