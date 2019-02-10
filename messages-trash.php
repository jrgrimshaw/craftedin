<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/messages/trash');
}

$message = new Message;

$read = (int)escape(Input::get('read')); // always use this secure value.
$d = (int)escape(Input::get('d')); // always use this secure value.
$r = (int)escape(Input::get('r')); // always use this secure value.

if($read) {
    if($message->belongs('recipient', $read)) {
        if($message->exists($read)) {
            $showMessage = true;
        }
    } else {
        Redirect::to('/messages/trash');
    }
}

if($d) {
    if($message->belongs('recipient', $d)) {
        if($message->exists($d)) {
            if($message->get($d)->seen === '1') {
                DB::getInstance()->insert('deleted_messages', ['message_id' => $d]);
                Redirect::to('/messages/inbox');
            }
        }
    }
} else if($r) {
    if($message->belongs('recipient', $r)) {
        if($message->isDeleted($r)) {
            DB::getInstance()->delete('deleted_messages', array('message_id', '=', $r));
            Redirect::to('/messages/trash');
        }
    }
}

$title = 'Messages - Trash';
$content = 'messages-trash';

require_once dirname(__FILE__) . '/app/views/view.php';