<?php
require_once dirname(__FILE__) . '/app/init.php';

if(Input::get('email') && Input::get('code')) {
    $email = escape(Input::get('email'));
    $code = escape(Input::get('code'));

    if($user->find($email)) {
        $account = $user->get($email);

        if($account->active == 0 && $account->active_code === $code) {
            $user->update(array(
                'active'        => 1,
                'active_code'   => ''
            ), $account->id);

            Session::flash('success', 'Your account has been activated successfully.');
            Redirect::to('/');
        } else {
            Session::flash('error', 'There was a problem activating your account.');
            Redirect::to('/');
        }
    } else {
        Session::flash('error', 'There was a problem activating your account.');
        Redirect::to('/');
    }
} else if($user->isLoggedIn() && $user->data()->active == 0 && Input::get('resend')) {
    $mail = new Mail;
    $mail->sendActivationEmail(escape($user->data()->name), escape($user->data()->email), $user->data()->active_code);
    Session::flash('success', 'A confirmation email has been sent to you.');
    Redirect::to('/');
} else {
    Redirect::to('/');
}