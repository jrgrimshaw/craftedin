<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('post_id') !== null) {
            $userId = $user->data()->id;
            $postId = (int)escape(Input::get('post_id'));

            $post = new Post;

            if($post->exists($postId)) {
                try {
                    DB::getInstance()->insert('reports', array(
                        'user_id'   => $userId,
                        'type'      => 'posts',
                        'content_id'=> $postId,
                        'date'      => date('Y-m-d H:i:s')
                    ));
                } catch(Exception $e) {
                    die($e->getMessage());
                }
            }
        }
    } else {
        Redirect::to('/');
    }
} else {
    Redirect::to('/');
}