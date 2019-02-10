<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('comment_id') !== null) {
            $userId = $user->data()->id;
            $commentId = (int)escape(Input::get('comment_id'));

            $comment = new Comment;

            if($comment->exists($commentId)) {
                try {
                    DB::getInstance()->insert('reports', array(
                        'user_id'   => $userId,
                        'type'      => 'comments',
                        'content_id'=> $commentId,
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