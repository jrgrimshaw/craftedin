<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn() || !$user->hasPermission('moderator')) {
    Redirect::to(404);
}

$moderator = new Moderator;

$title = 'Moderator';
$content = 'moderator';

require_once dirname(__FILE__) . '/app/views/view.php';