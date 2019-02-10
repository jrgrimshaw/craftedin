<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/account/security');
}

$data = DB::getInstance()->get('users_session', array('user_id', '=', $user->data()->id))->results();
$geo = new Geo;
$ua = new UA;

if(Input::get('rl')) {
    $id = (int)escape(Input::get('rl'));
    $user->remoteLogout($id);
    Redirect::to('/account/security');
}

$title = 'Account - Security';
$content = 'account-security';

require_once dirname(__FILE__) . '/app/views/view.php';