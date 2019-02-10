<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
	Redirect::to('/login?return_to=/account/password');
}

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true,
				'min' => 6),
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

			if(!$bcrypt->verify(Input::get('password_current'), $user->data()->password)) {
                Session::flash('error', 'Your current password is wrong.');
			} else {
				try {
                    $user->update(array(
                        'password' => $bcrypt->hash(Input::get('password_new'))
                    ));

					Session::flash('success', 'Your password has been changed!');
					Redirect::to('/account/password');
				} catch(Exception $e) {
					die($e->getMessage());
				}
			}
		} else {
			Session::flash('error', $validate->errors());
		}
	}
}

$title = 'Account - Password';
$content = 'account-password';

require_once dirname(__FILE__) . '/app/views/view.php';