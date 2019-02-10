<?php
require_once dirname(__FILE__) . '/app/init.php';

if($user->isLoggedIn()) {
    $user->logout();
    Redirect::to('/download?ref=logout');
} else {
    Redirect::to('/');
}