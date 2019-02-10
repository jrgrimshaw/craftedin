<?php
require_once dirname(dirname(__FILE__)) . '/app/init.php';

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    if($user->isLoggedIn()) {
        if(Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'post_id' => array(
                    'required' => true
                ),
                'comment' => array(
                    'required' => true,
                    'min' => 1,
                    'max' => 1000
                )
            ));

            if($validation->passed()) {
                try {
                    $db = DB::getInstance();
                    $post = new Post;

                    $notification = new Notification;
                    
                    // Notify post owner that there has been a comment.
                    $notification->create($post->get(Input::get('post_id'))->user_id, 'comments', Input::get('post_id'));

                    // Notify each user following the post.
                    foreach($post->following(Input::get('post_id'))->results() as $uf) {
                        $notification->create($uf->user_id, 'post_following', Input::get('post_id'));
                    }

                    // Follow post if not already following, and you don't own the post.
                    if(!$post->isFollowing(Input::get('post_id'))) {
                        if($post->get(Input::get('post_id'))->user_id !== $user->data()->id) {
                            $post->follow(Input::get('post_id'));
                        }
                    }

                    $db->insert('comments', array(
                        'user_id'   => $user->data()->id,
                        'post_id'   => Input::get('post_id'),
                        'post_user_id' => $post->get(Input::get('post_id'))->user_id,
                        'content'   => Input::get('comment'),
                        'date'      => date('Y-m-d H:i:s')
                    ));

                    $lastId = $db->_pdo->lastInsertId();
                    $p = $db->get('posts', array('id', '=', Input::get('post_id')))->first();
                    $c = $db->get('comments', array('id', '=', $lastId))->first();

                    $get_hashtags = Hashmention::getHashTags(Input::get('comment'));
                    Hashmention::updateHashtag($get_hashtags);
                    $get_mention = Hashmention::getMention(Input::get('comment'));
                    Hashmention::notifyUser($get_mention, 'comment_mention', Input::get('post_id'));

                    echo streamPostComment($p, $c, $user, $new = true);
                } catch(Exception $e) {
                    die($e->getMessage());
                }
            }
        }
    } else {
        Redirect::to('/');
    }
} else {
    Redirect::to('/');
}