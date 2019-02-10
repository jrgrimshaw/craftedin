<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn() || !$user->hasPermission('moderator')) {
    Redirect::to(404);
}

$moderator = new Moderator;

// suspend
// unsuspend
// verify
// unverify

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        if(Input::get('suspend')) {
            $suspend = $user->get(escape(Input::get('suspend')))->id;
            if($user->get($suspend)) {
                if(!$user->isSuspended($suspend)) {
                    DB::getInstance()->insert('users_suspended', ['user_id' => $suspend]);
                }
            }
        }

        if(Input::get('unsuspend')) {
            $unsuspend = $user->get(escape(Input::get('unsuspend')))->id;
            if($user->get($unsuspend)) {
                if($user->isSuspended($unsuspend)) {
                    DB::getInstance()->delete('users_suspended', ['user_id', '=', $unsuspend]);
                }
            }
        }

        if(Input::get('verify')) {
            $verify = $user->get(escape(Input::get('verify')))->id;
            if($user->get($verify)) {
                DB::getInstance()->query("UPDATE users SET verified = 1 WHERE id = $verify");
            }
        }

        if(Input::get('unverify')) {
            $unverify = $user->get(escape(Input::get('unverify')))->id;
            if($user->get($unverify)) {
                DB::getInstance()->query("UPDATE users SET verified = 0 WHERE id = $unverify");
            }
        }

        Session::flash('success', 'Any changes have been made successfully.');
    }
}

$title = 'Moderator - Manage';
$content = 'moderator-manage';

require_once dirname(__FILE__) . '/app/views/view.php';