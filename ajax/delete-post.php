<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('post_id') !== null) {
            $userId = $user->data()->id;
            $postId = (int)escape(Input::get('post_id'));

            $getPost = DB::getInstance()->get('posts', array('id', '=', $postId))->first();

            $post = new Post;

            if($post->exists($postId)) {
                if($getPost->user_id === $userId || $user->isPageMember($getPost->user_id)) {
                    try {
                        DB::getInstance()->query("INSERT INTO deleted_posts select * from posts where id = $postId");
                        DB::getInstance()->query("DELETE FROM posts where id = $postId");
                        //add unlink to remove post images
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