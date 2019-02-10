<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('user_id') !== null) {
            $userId = escape(Input::get('user_id'));

            if($user->exists($userId)) {
                if(!$user->isFollowing($userId)) {
                    if($userId !== $user->data()->id) {
                        try {
                            $user->followUser($userId);
                            $notification = new Notification;
                            $notification->create($userId, 'following');
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