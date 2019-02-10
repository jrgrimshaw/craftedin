<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/messages/inbox');
}

$message = new Message;


$read = (int)escape(Input::get('read')); // always use this secure value.
$kn = (int)escape(Input::get('kn')); // always use this secure value.

if($read) {
    if($message->belongs('recipient', $read)) {
        if($message->exists($read)) {
            DB::getInstance()->query("UPDATE messages SET seen = 1 WHERE id = {$read}");
            $showMessage = true;
        }
    } else {
        Redirect::to('/messages/inbox');
    }
}

if($kn) {
    if($message->belongs('recipient', $kn)) {
        if($message->exists($kn)) {
            DB::getInstance()->query("UPDATE messages SET seen = 0 WHERE id = {$kn}");
            Redirect::to('/messages/inbox');
        }
    }
}

$title = 'Messages - Inbox';
$content = 'messages-inbox';

require_once dirname(__FILE__) . '/app/views/view.php';