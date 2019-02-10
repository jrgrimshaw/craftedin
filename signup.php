<?php
require_once dirname(__FILE__) . '/app/init.php';

if($user->isLoggedIn()) {
    Redirect::to('/');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 1,
                'max' => 15,
                'unique' => 'users'),
            'email' => array(
                'required' => true,
                'email' => true,
                'unique' => 'users',
                'max' => 1024),
            'password' => array(
                'required' => true,
                'min' => 6),
            'name' => array(
                'required' => true,
                'min' => 1,
                'max' => 28)
        ));

        if($validation->passed()) {
            if(preg_match('`^[a-zA-Z0-9_]{1,}$`', Input::get('username'))) {
                $bcrypt = new Bcrypt;
                $code = uniqid('', true) . time();

                $resp = null;
                // The error code from reCAPTCHA, if any
                $error = null;
                $reCaptcha = new ReCaptcha('6Lfp9gITAAAAAE6ElUx0-KqC9aMsoBbmP9ihL_zw');
                // Was there a reCAPTCHA response?
                if(Input::get('g-recaptcha-response')) {
                    $resp = $reCaptcha->verifyResponse(
                        $_SERVER['HTTP_CF_CONNECTING_IP'],
                        $_POST["g-recaptcha-response"]
                    );
                }

                if($resp != null && $resp->success) {
                    try {
                        $user->create(array(
                            'username'      => Input::get('username'),
                            'email'         => Input::get('email'),
                            'password'      => $bcrypt->hash(Input::get('password')),
                            'active_code'   => $code,
                            'name'          => Input::get('name'),
                            'job'           => Input::get('job'),
                            'joined'        => date('Y-m-d H:i:s'),
                            'group'         => 1
                        ));

                        $mail = new Mail;
                        $mail->sendActivationEmail(escape(Input::get('name')), escape(Input::get('email')), $code);

                        // Log user in
                        $lastId = DB::getInstance()->_pdo->lastInsertId(); // Get the user id
                        $user = new User($lastId);
                        $user->login();

                        // Redirect them to /welcome (getting started guide)
                        Redirect::to('/welcome');
                    } catch(Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    Session::flash('error', 'Captcha verification failed.');
                }
            } else {
                Session::flash('error', 'Username can only contain letters, numbers and underscores.');
            }
        } else {
            Session::flash('error', $validate->errors());
        }
    }
}

$title = 'Sign Up';
$content = 'signup';
$blank = true;

require_once dirname(__FILE__) . '/app/views/view.php';