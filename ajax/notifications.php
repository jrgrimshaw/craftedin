<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';
error_reporting(0);

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::get('read') === 'all') {
            try {
                $notification->readAll();
                Redirect::to('/stream');
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            Redirect::to('/');
        }
    } else {
        Redirect::to('/');
    }
} else {
    Redirect::to('/');
}