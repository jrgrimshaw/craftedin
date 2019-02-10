<?php
require_once dirname(__FILE__) . '/app/init.php';

if($user->isLoggedIn()) {
    Redirect::to('/');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $user = new User();

        if($user->find(Input::get('username'))) {
            $account = $user->get(Input::get('username'));
            $code = uniqid('', true) . time();

            try {
                $user->update(array(
                    'reset'         => 1,
                    'reset_code'   => $code
                ), $account->id);

                $mail = new Mail;
                $mail->sendResetEmail(escape($account->name), escape($account->email), $code);

                Session::flash('success', 'Password reset instructions have been sent to your email.');
                Redirect::to('/login');
            } catch(Exception $e) {
                die($e->getMessage());
            }
        } else {
            Session::flash('error', 'That username or email wasn\'t recognised.');
        }
    }
}

$title = 'Forgot Password';
$content = 'forgot';
$blank = true;

require_once dirname(__FILE__) . '/app/views/view.php';