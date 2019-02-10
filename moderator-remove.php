<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn() || !$user->hasPermission('moderator')) {
    Redirect::to(404);
}

// Query string acceptor / No view
$report_id = (int)escape(Input::get('report_id'));
$content_id = (int)escape(Input::get('content_id'));
$type = escape(Input::get('type'));

if($type === 'users') {
    DB::getInstance()->insert('users_suspended', ['user_id' => $content_id]);
    DB::getInstance()->query("UPDATE reports SET acted = '1' WHERE id = $report_id");
} else {
    $new_table = 'deleted_'.$type;
    DB::getInstance()->query("INSERT INTO $new_table select * from $type where id = $content_id");
    DB::getInstance()->query("DELETE FROM $type where id = $content_id");
    DB::getInstance()->query("UPDATE reports SET acted = '1' WHERE id = $report_id");
}
Redirect::to('/moderator/reported-'.$type);