<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Defines
define('APP_URL', 'http://localhost/');
define('STATIC_URL', 'http://localhost/static/');
define('STATIC_MOBILE_URL', 'http://localhost/static-mobile/');
define('USER_AVATAR_DIR', 'http://localhost/static/images/user/avatars/thumbs/');
define('USER_AVATAR_FS_DIR', 'http://localhost/static/images/user/avatars/');
define('USER_HEADER_DIR', 'http://localhost/static/images/user/headers/');
define('POST_DIR', 'http://localhost/static/images/user/posts/thumbs/');
define('POST_FS_DIR', 'http://localhost/static/images/user/posts/');
define('WEBSITE_DIR', 'http://localhost/static/images/user/websites/');

// Create a global configuration
$GLOBALS['config'] = array(
    'mysql' => array(
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => 'root',
        'db'        => 'craftedin'
    ),
    'remember' => array(
        'cookie_name'   => 'hash',
        'cookie_expiry' =>  31556926
    ),
    'session' => array(
        'session_name'  => 'user',
        'token_name'    => 'token'
    )
);

// Composer
require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

// Autoload classes
function autoload($class) {
    require_once 'classes/' . $class . '.php';
}
spl_autoload_register('autoload');

// Include functions
require_once 'functions/general.php';
require_once 'functions/sanitize.php';
require_once 'functions/sidebar.php';

// Check for users that have requested to be remembered
if(Cookie::exists(Config::get('remember/cookie_name'))) {
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

    if($hashCheck->count()) {
        $user = new User($hashCheck->first()->user_id);
        $user->login();
    }
}

$stripe = [
    'publishable' => '',
    'private' => ''
];

Stripe::setApiKey($stripe['private']);

$user = new User;

if($user->isLoggedIn()) {
    // possibly change this.
    if($user->data()->reset == 1) {
        $user->update(array(
            'reset' => 0,
            'reset_code' => ''
        ));
    }

    $user->update(array(
        'last_online' => date('Y-m-d H:i:s')
    ));

    $post = new Post;
    $comment = new Comment;
    $message = new Message;
    $notification = new Notification;
    $moderator = new Moderator;
}