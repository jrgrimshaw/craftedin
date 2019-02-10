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
                'comment_id' => array(
                    'required' => true
                ),
                'comment' => array(
                    'required' => true,
                    'max' => 1000
                )
            ));

            if($validation->passed()) {
                $comment = new Comment;
                $postId = (int)Input::get('post_id');
                $commentId = (int)Input::get('comment_id');
                $userId = $comment->get($commentId)->user_id;

                if($userId === $user->data()->id) {
                    try {
                        $db = DB::getInstance();
                        $comment = Input::get('comment');
                        
                        // THIS LINE TOOK 2 FUCKING HOURS TO WORK I WANT TO DIE (1am-3am)
                        // ITS AN SQL QUERY?? WHY DID IT TAKE SO LONG TO FUCKING WORK
                        $db->query("UPDATE comments SET content = \"{$comment}\", edited = 1 WHERE id = {$commentId}");

                        // NEED TO FIX -- due to complication, we are not notifying or adding
                        //                hashtags to the db when a post is edited. 
                        // $get_hashtags = Hashmention::getHashTags(Input::get('post'));
                        // Hashmention::updateHashtag($get_hashtags);
                        // $get_mention = Hashmention::getMention(Input::get('post'));
                        // Hashmention::notifyUser($get_mention, 'post_mention', $lastId);
                    } catch(Exception $e) {
                        die($e->getMessage());
                    }
                }
            }
            // } else if(isset($commentId) && isset($postId)) {
            //     $validate = new Validate();
            //     $validation = $validate->check($_POST, array(
            //         'post_id' => array(
            //             'required' => true
            //         ),
            //         'comment_id' => array(
            //             'required' => true
            //         ),
            //         'comment' => array(
            //             'required' => true,
            //             'min' => 1,
            //             'max' => 1000
            //         )
            //     ));

            //     if($validation->passed()) {
            //         try {
            //             $db = DB::getInstance();
            //             $post = new Post;

            //             $db->update('comments', $commentId, array(
            //                 'content' => Input::get('comment')
            //             ));

            //             Redirect::to('/post/' . $postId);

            //             // $get_hashtags = Hashmention::getHashTags(Input::get('comment'));
            //             // Hashmention::updateHashtag($get_hashtags);
            //             // $get_mention = Hashmention::getMention(Input::get('comment'));
            //             // Hashmention::notifyUser($get_mention, 'comment_mention', Input::get('post_id'));
            //         } catch(Exception $e) {
            //             die($e->getMessage());
            //         }
            //     }

        }
    } else {
        Redirect::to('/');
    }
} else {
    Redirect::to('/');
}