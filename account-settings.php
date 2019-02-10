<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
	Redirect::to('/login?return_to=/account/settings');
}

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'required' => true,
				'min' => 1,
				'max' => 28),
            'email' => array(
                'required' => true,
                'email' => true,
                'max' => 1024),
            'job' => array(
                'required' => false,
                'max' => 30),
            'location' => array(
                'required' => false,
                'max' => 30),
            'website' => array(
                'required' => false,
                'url' => true),
            'about' => array(
                'required' => false,
                'max' => 300)
		));

		if($validation->passed()) {
            $hire = '0'; if($user->isPremium() && Input::get('hire') === 'yes') { $hire = '1'; }

			try {
				$user->update(array(
					'name' => Input::get('name'),
                    'email' => Input::get('email'),
                    'job' => Input::get('job'),
                    'location' => Input::get('location'),
                    'website' => Input::get('website'),
                    'about' => Input::get('about'),
                    'hire' => $hire
				));
			} catch(Exception $e) {
				die($e->getMessage());
			}

			Session::flash('success', 'Your details have been updated.');
            Redirect::to('/user/' . $user->data()->username);
		} else {
			Session::flash('error', $validate->errors());
		}
	}
}

$title = 'Account - Settings';
$content = 'account-settings';

require_once dirname(__FILE__) . '/app/views/view.php';