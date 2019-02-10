<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn() && Input::get('email') && Input::get('code')) {
    $email = escape(Input::get('email'));
    $code = escape(Input::get('code'));

    if($user->find($email)) {
        $account = $user->get($email);

        if($account->reset == 1 && $account->reset_code === $code) {
            if(Input::exists()) {
                if(Token::check(Input::get('token'))) {
                    $validate = new Validate();
                    $validation = $validate->check($_POST, array(
                        'password_new' => array(
                            'required' => true,
                            'min' => 6),
                        'password_new_again' => array(
                            'required' => true,
                            'min' => 6,
                            'matches' => 'password_new')
                    ));

                    if($validation->passed()) {
                        $bcrypt = new Bcrypt;

                        try {
                            $user->update(array(
                                'password'    => $bcrypt->hash(Input::get('password_new')),
                                'reset'       => 0,
                                'reset_code'  => ''
                            ), $account->id);

                            Session::flash('success', 'Your password has been changed! You can now log in.');
                            Redirect::to('/login');
                        } catch(Exception $e) {
                            die($e->getMessage());
                        }
                    } else {
                        Session::flash('error', $validate->errors());
                    }
                }
            }

            $title = 'Reset Password';
            $content = 'reset-password';
            $blank = true;

            require_once dirname(__FILE__) . '/app/views/view.php';            
        } else {
            Session::flash('error', 'There was a problem resetting your password.');
            Redirect::to('/');
        }
    } else {
        Session::flash('error', 'There was a problem resetting your password.');
        Redirect::to('/');
    }
} else {
    Redirect::to(404);
}