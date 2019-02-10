<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/');
}

// Handle post (Create a new page)
if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 1,
                'max' => 15,
                'unique' => 'users'),
            'name' => array(
                'required' => true,
                'min' => 1,
                'max' => 28),
            'about' => array(
                'required' => false,
                'max' => 300)
        ));

        if($validation->passed()) {
            if(preg_match('`^[a-zA-Z0-9_]{1,}$`', Input::get('username'))) {
                try {
                    $user->create(array(
                        'username'      => Input::get('username'),
                        'name'          => Input::get('name'),
                        'joined'        => date('Y-m-d H:i:s'),
                        'page'          => 1,
                        'avatar'        => 'default-page.jpg',
                        'about'         => Input::get('about')
                    ));

                    $lastId = DB::getInstance()->_pdo->lastInsertId();

                    DB::getInstance()->insert('page_members', array(
                        'page_id'  => $lastId,
                        'user_id'  => $user->data()->id,
                        'owner'    => 1
                    ));

                    // Redirect them to /welcome (getting started guide)
                    Redirect::to('/page/' .  Input::get('username'));
                } catch(Exception $e) {
                    die($e->getMessage());
                }
            } else {
                Session::flash('error', 'Page handle can only contain letters, numbers and underscores.');
                Redirect::to('?create=1');
            }
        } else {
            Session::flash('error', $validate->errors());
            Redirect::to('?create=1');
        }
    }
}

// Statistics calculations
$totalPages = $user->getPages()->count();
$totalPosts = 0;
foreach($user->getPages()->results() as $p) {
    $totalPosts += $post->getUserPosts($p->page_id)->count();
}
$totalFollowers = 0;
foreach($user->getPages()->results() as $p) {
    $totalFollowers += DB::getInstance()->get('following', array('user_following_id', '=', $p->page_id))->count();
}
$totalViews = 0;
foreach($user->getPages()->results() as $p) {
    $totalViews += $user->get($p->page_id)->views;
}


$title = 'Pages Manager';
$content = 'pages';

require_once dirname(__FILE__) . '/app/views/view.php';