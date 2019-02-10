<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('comment_id') !== null) {
            $userId = $user->data()->id;
            $commentId = (int)escape(Input::get('comment_id'));

            $comment = new Comment;
            $like = new Like;

            if($comment->exists($commentId)) {
                if(!$like->hasLikedComment($commentId)) {
                    try {
                        DB::getInstance()->insert('comment_likes', array(
                            'user_id'   => $userId,
                            'comment_id'   => $commentId,
                            'comment_user_id' => DB::getInstance()->get('comments', array('id', '=', $commentId))->first()->user_id
                        ));

                        $notification = new Notification;
                        $notification->create($comment->get($commentId)->user_id, 'comment_likes', $commentId);

                        echo DB::getInstance()->get('comment_likes', array('comment_id', '=', $commentId))->count();
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