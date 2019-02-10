<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn() || !$user->hasPermission('moderator')) {
    Redirect::to(404);
}

// Query string acceptor / No view
$report_id = (int)escape(Input::get('report_id'));
$type = escape(Input::get('type'));
DB::getInstance()->query("UPDATE reports SET acted = '1' WHERE id = $report_id");
Redirect::to('/moderator/reported-'.$type);