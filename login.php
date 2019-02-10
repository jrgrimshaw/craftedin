<?php
require_once dirname(__FILE__) . '/app/init.php';

if($user->isLoggedIn()) {
    Redirect::to('/');
}

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$user = new User();

		$remember = (Input::get('remember') === 'on') ? true : false;
		$login = $user->login(Input::get('username'), Input::get('password'), $remember);

		if($login) {
			if(Input::get('return_to')) {
				Redirect::to(escape(Input::get('return_to')));
			} else {
				Redirect::to('/');
			}
		} else {
			Session::flash('error', 'That username and password wasn\'t recognised.');
		}
	}
}

$title = 'Login';
$content = 'login';
$blank = true;

require_once dirname(__FILE__) . '/app/views/view.php';