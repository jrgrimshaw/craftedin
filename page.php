<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$pagename = Input::get('page')) {
    Redirect::to('/');
} else {
    $page = new User($pagename);
    
    if(!$page->data()->page) {
        Redirect::to('/user/' . $pagename);
    } else if(!$page->pagenameExists($pagename)) {
        Redirect::to(404);
    } else {
        $data = $page->data();

        if(Input::get('manage') && $user->isPageMember($data->id)) {
            if(Input::get('manage') === 'settings') {
                if(Input::exists()) {
                    if(Token::check(Input::get('token'))) {
                        $validate = new Validate();
                        $validation = $validate->check($_POST, array(
                            'name' => array(
                                'required' => true,
                                'min' => 1,
                                'max' => 28),
                            'location' => array(
                                'required' => false,
                                'max' => 30),
                            'website' => array(
                                'required' => false,
                                'url' => true),
                            'about' => array(
                                'required' => false,
                                'max' => 300)
                        ));

                        if($validation->passed()) {
                            try {
                                $user->update(array(
                                    'name' => Input::get('name'),
                                    'location' => Input::get('location'),
                                    'website' => Input::get('website'),
                                    'about' => Input::get('about')
                                ), $data->id);
                            } catch(Exception $e) {
                                die($e->getMessage());
                            }

                            Session::flash('success', 'The page details have been updated.');
                            Redirect::to('/page/' . $data->username);
                        } else {
                            Session::flash('error', $validate->errors());
                        }
                    }
                }

                $title = $data->name . ' - Settings';
                $content = 'page-settings';

                require_once dirname(__FILE__) . '/app/views/view.php';
            } else if(Input::get('manage') === 'pictures') {


                if(isset($_FILES['avatar'])) {
                    $file = $_FILES['avatar'];

                    // file properties
                    $file_name = $file['name'];
                    $file_tmp = $file['tmp_name'];
                    $file_size = $file['size'];
                    $file_error = $file['error'];

                    // work out extension
                    $file_ext = explode('.', $file_name);
                    $file_ext = strtolower(end($file_ext));

                    $allowed = array('jpg', 'jpeg', 'png', 'gif');

                    if(in_array($file_ext, $allowed)) {
                        if($file_error === 0) {
                            if($file_size <= 2097152) { // 2mb
                                $file_name_new = uniqid('', true) . '.' . $file_ext;
                                $file_destination = 'static/images/user/avatars/' . $file_name_new;
                                $file_thumb = 'static/images/user/avatars/thumbs/' . $file_name_new;

                                if($data->avatar != null && $data->avatar != 'default.jpg' && $data->avatar != 'default-page.jpg') {
                                    unlink('static/images/user/avatars/' . $data->avatar);
                                    unlink('static/images/user/avatars/thumbs/' . $data->avatar);
                                }

                                if(move_uploaded_file($file_tmp, $file_destination)) {
                                    $simage = new SimpleImage($file_destination);
                                    $simage->thumbnail('300')->save($file_thumb);

                                    $user->update(array(
                                        'avatar' => $file_name_new
                                    ), $data->id);

                                    Session::flash('success', 'The page avatar has been updated!');
                                    Redirect::to('/page/' . $data->username);
                                }
                            } else {
                                Session::flash('error', 'The page avatar must be less than 2MB.');
                                Redirect::to('?manage=pictures');
                            }
                        } else {
                            Session::flash('error', 'There was a problem uploading the avatar.');
                            Redirect::to('?manage=pictures');
                        }
                    } else {
                        Session::flash('error', 'You must select an avatar in jpg, png or gif format.');
                        Redirect::to('?manage=pictures');
                    }
                } else if(isset($_FILES['header'])) {
                    $file = $_FILES['header'];

                    // file properties
                    $file_name = $file['name'];
                    $file_tmp = $file['tmp_name'];
                    $file_size = $file['size'];
                    $file_error = $file['error'];

                    // work out extension
                    $file_ext = explode('.', $file_name);
                    $file_ext = strtolower(end($file_ext));

                    $allowed = array('jpg', 'jpeg', 'png', 'gif');

                    if(in_array($file_ext, $allowed)) {
                        if($file_error === 0) {
                            if($file_size <= 5242880) { // 5mb
                                $file_name_new = uniqid('', true) . '.' . $file_ext;
                                $file_destination = 'static/images/user/headers/' . $file_name_new;
                                $file_thumb = 'static/images/user/headers/thumbs/' . $file_name_new;

                                if($data->header != null && $data->header != 'default.jpg') {
                                    unlink('static/images/user/headers/' . $data->header);
                                    unlink('static/images/user/headers/thumbs/' . $data->header);
                                }

                                if(move_uploaded_file($file_tmp, $file_destination)) {
                                    $simage = new SimpleImage($file_destination);
                                    $simage->adaptive_resize('2000', '1000')->save($file_thumb);

                                    $user->update(array(
                                        'header' => $file_name_new
                                    ), $data->id);

                                    Session::flash('success', 'The page header picture has been updated!');
                                    Redirect::to('/page/' . $data->username);
                                }
                            } else {
                                Session::flash('error', 'The page header picture must be less than 5MB.');
                                Redirect::to('?manage=pictures');
                            }
                        } else {
                            Session::flash('error', 'There was a problem uploading the header picture.');
                            Redirect::to('?manage=pictures');
                        }
                    } else {
                        Session::flash('error', 'You must select a header picture in jpg, png or gif format.');
                        Redirect::to('?manage=pictures');
                    }
                }

                $title = $data->name . ' - Pictures';
                $content = 'page-pictures';

                require_once dirname(__FILE__) . '/app/views/view.php';
            } else if(Input::get('manage') === 'members' && $user->isPageOwner($data->id)) {
                if(Input::get('remove')) {
                    $id = escape(Input::get('remove'));
                    if($user->isUserPageMember($data->id, $id) && !$user->isPageOwner($data->id, $id)) {
                        DB::getInstance()->query("DELETE FROM page_members WHERE page_id = '{$data->id}' AND user_id = '{$id}'");
                        Redirect::to('?manage=members');
                    }
                }

                if(Input::exists()) {
                    if(Token::check(Input::get('token'))) {
                        $validate = new Validate();
                        $validation = $validate->check($_POST, array(
                            'username' => array(
                                'required' => true)
                        ));

                        if($validation->passed()) {
                            if(!$user->isUserPageMember($data->id, $user->get(Input::get('username'))->id) && $user->isUser($user->get(Input::get('username'))->id) && $user->get(Input::get('username'))) {
                                try {
                                    DB::getInstance()->insert('page_members', array(
                                        'page_id'  => $data->id,
                                        'user_id'  => $user->get(Input::get('username'))->id
                                    ));

                                    $notification = new Notification;
                                    $notification->create($user->get(Input::get('username'))->id, 'team_members');
                                } catch(Exception $e) {
                                    die($e->getMessage());
                                }

                                Session::flash('success', 'New administrator has been added successfully.');
                                Redirect::to('?manage=members');
                            } else {
                                Session::flash('error', 'The user specified is already part of the page or is not valid.');
                            }
                        } else {
                            Session::flash('error', $validate->errors());
                        }
                    }
                }

                $title = $data->name . ' - Administrators';
                $content = 'page-members';

                require_once dirname(__FILE__) . '/app/views/view.php';
            } else {
                Redirect::to(404);
            }
        } else if($user->isSuspended($user->get($pagename)->id)) {
            $data = $user->get($pagename);

            $title = 'User Suspended';
            $content = 'user-suspended';

            require_once dirname(__FILE__) . '/app/views/view.php';
        } else {
            $posts = $post->getUserPosts($data->id)->results();

            if(Input::get('action') === 'follow' && $user->isLoggedIn()) {
                $user->followUser($data->id);
                $notification->create($data->id, 'following');
                Redirect::to('/page/' . $data->username);
            }

            if(Input::get('action') === 'unfollow' && $user->isLoggedIn()) {
                $user->unfollowUser($data->id);
                Redirect::to('/page/' . $data->username);
            }

            if(Input::get('leavepage') === '1') {
                if($user->isPageMember($data->id) && !$user->isPageOwner($data->id)) {
                    DB::getInstance()->query("DELETE FROM page_members WHERE page_id = '{$data->id}' AND user_id = {$user->data()->id}");
                    Redirect::to('/page/' . $data->username);
                }
            }

            //Get Stats
            $postsCount = $post->getUserPosts($data->id)->count();
            $followersCount = DB::getInstance()->get('following', array('user_following_id', '=', $data->id))->count();
            $viewCount = $data->views;
            
            $membersCount = $page->getPageMembers($data->id)->count();

            // $reputation = $user->reputation($data->id);

            // Update view count
            if($user->isLoggedIn() && $data->id !== $user->data()->id) {
                DB::getInstance()->update('users', $data->id, ['views' => $viewCount+1]);
            }

            $title = $data->name;
            $content = 'page';

            require_once dirname(__FILE__) . '/app/views/view.php';
        }
    }
}