<?php
require_once dirname(__FILE__) . '/app/init.php';

// if($user->isLoggedIn()) {
//     if(Input::get('read') === 'all') {
//         try {
//             DB::getInstance()->query("UPDATE notifications SET seen = 1 WHERE recipient_user_id = {$user->data()->id}");
//             Redirect::to('/stream');
//         } catch(Exception $e) {
//             die($e->getMessage());
//         }
//     } else {
//         Redirect::to('/');
//     }
// } else {
//     Redirect::to('/');
// }

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/notifications');
}

$notification->readAll();

$title = 'Notifications';
$content = 'notifications';

require_once dirname(__FILE__) . '/app/views/view.php';