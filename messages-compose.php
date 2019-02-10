<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/messages/compose');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'to' => array(
                'required' => true),
            'subject' => array(
                'required' => true,
                'max' => 100),
            'message' => array(
                'required' => true,
                'max' => 2000)
        ));

        if($validation->passed()) {
            if($user->exists(escape(Input::get('to')))) {
                try {
                    DB::getInstance()->insert('messages', array(
                        'sender_user_id'    => $user->data()->id,
                        'recipient_user_id' => $user->get(Input::get('to'))->id,
                        'subject'           => Input::get('subject'),
                        'message'           => Input::get('message'),
                        'date'              => date('Y-m-d H:i:s'),
                    ));

                    Session::flash('success', 'Your message has been sent successfully!');
                    Redirect::to('/messages/inbox');
                } catch(Exception $e) {
                    die($e->getMessage());
                }
            } else {
                Session::flash('error', 'That user does not exist.');
            }
        } else {
            Session::flash('error', $validate->errors());
        }
    }
}

$title = 'Messages - Compose';
$content = 'messages-compose';

require_once dirname(__FILE__) . '/app/views/view.php';