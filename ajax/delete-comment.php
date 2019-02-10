<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('comment_id') !== null) {
            $userId = $user->data()->id;
            $commentId = (int)escape(Input::get('comment_id'));

            $getComment = DB::getInstance()->get('comments', array('id', '=', $commentId))->first();

            $comment = new Comment;

            if($comment->exists($commentId)) {
                if($getComment->user_id === $userId) {
                    try {
                        DB::getInstance()->query("INSERT INTO deleted_comments select * from comments where id = $commentId");
                        DB::getInstance()->query("DELETE FROM comments where id = $commentId");
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