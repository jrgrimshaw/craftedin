<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/messages/sent');
}

$message = new Message;

$read = (int)escape(Input::get('read')); // always use this secure value.
if($read) {
    if($message->belongs('sender', $read)) {
        if($message->exists($read)) {
            $showMessage = true;
        }
    } else {
        Redirect::to('/messages/sent');
    }
}

$title = 'Messages - Sent';
$content = 'messages-sent';

require_once dirname(__FILE__) . '/app/views/view.php';