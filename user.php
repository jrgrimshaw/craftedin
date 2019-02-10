<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$username = Input::get('user')) {
    Redirect::to('/');
} else {
    $profile = new User($username);

    if($profile->data()->page) {
        Redirect::to('/page/' . $username);
    } else if(!$profile->usernameExists($username)) {
        Redirect::to(404);
    } else {
        $data = $profile->data();

        if($user->isSuspended($user->get($username)->id)) {
            $data = $user->get($username);

            $title = 'User Suspended';
            $content = 'user-suspended';

            require_once dirname(__FILE__) . '/app/views/view.php';
        } else {
            $post = new Post;
            $posts = $post->getUserPosts($data->id)->results();

            if(Input::get('action') === 'follow' && $user->isLoggedIn()) {
                $user->followUser($data->id);
                $notification->create($data->id, 'following');
                Redirect::to('/user/' . $data->username);
            }

            if(Input::get('action') === 'unfollow' && $user->isLoggedIn()) {
                $user->unfollowUser($data->id);
                Redirect::to('/user/' . $data->username);
            }

            if(Input::get('leaveteam') === '1') {
                if($user->isTeam($data->id) && $team->isTeamMember($data->id)) {
                    DB::getInstance()->query("DELETE FROM team_members WHERE team_id = '{$data->id}' AND user_id = {$user->data()->id}");
                    Redirect::to('/user/' . $data->username);
                }
            }

            // Get Stats
            $postsCount = $post->getUserPosts($data->id)->count();
            $followingCount = DB::getInstance()->get('following', array('user_id', '=', $data->id))->count();
            $followersCount = DB::getInstance()->get('following', array('user_following_id', '=', $data->id))->count();
            $viewCount = $data->views;
            // if($data->team) {
            //     $membersCount = $team->getTeamMembers($data->id)->count();
            // }

            $read = (int)escape(Input::get('read_n')); // always use this secure value.
            if($read) {
                if($notification->exists($read)) {
                    DB::getInstance()->query("UPDATE notifications SET seen = 1 WHERE id = {$read}");
                }
            }

            $reputation = $user->reputation($data->id);

            // Update view count
            if($user->isLoggedIn() && $data->id !== $user->data()->id) {
                DB::getInstance()->update('users', $data->id, ['views' => $viewCount+1]);
            }

            $title = $data->name;
            $content = 'user';

            require_once dirname(__FILE__) . '/app/views/view.php';
        }
    }
}