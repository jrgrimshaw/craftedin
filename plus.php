<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/plus');
}

if($user->isPremium()) {
    Redirect::to('/account/plus');
}

$title = 'Plus';
$content = 'plus';

require_once dirname(__FILE__) . '/app/views/view.php';