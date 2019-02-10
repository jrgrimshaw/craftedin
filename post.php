<?php
require_once dirname(__FILE__) . '/app/init.php';

if(Input::get('post')) {
    $post = new Post;
    $comment = new Comment;
    $id = (int)escape(Input::get('post'));

    $data = $post->get($id);

    if($data) {
        $notification = new Notification;
        $read = (int)escape(Input::get('read_n')); // always use this secure value.
        if($read) {
            if($notification->exists($read)) {
                DB::getInstance()->query("UPDATE notifications SET seen = 1 WHERE id = {$read}");
            }
        }

        $title = $user->get($data->user_id)->name . '\'s Post';
        $content = 'post';

        require_once dirname(__FILE__) . '/app/views/view.php';
    } else {
        Redirect::to(404);
    }
} else {
    Redirect::to(404);
}