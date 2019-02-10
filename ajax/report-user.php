<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('user_id') !== null) {
            $userId = $user->data()->id;
            $id = (int)escape(Input::get('user_id'));

            if($user->get($id)) {
                try {
                    DB::getInstance()->insert('reports', array(
                        'user_id'   => $userId,
                        'type'      => 'users',
                        'content_id'=> $id,
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