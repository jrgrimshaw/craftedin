<?php
require_once dirname(__FILE__) . '/app/init.php';

if($user->isLoggedIn()) {
    if(Input::exists()) {
        if(Token::check(Input::get('token'))) {
            if(isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'post' => array(
                        'required' => false,
                        'max' => 5000
                    ),
                    'as' => array(
                        'required' => true
                    )
                ));

                if($validation->passed()) {
                    $file = $_FILES['photo'];

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
                            if($file_size <= 5242880) { // 2mb
                                $file_name_new = uniqid('', true) . '.' . $file_ext;
                                $file_destination = 'static/images/user/posts/' . $file_name_new;
                                $file_thumb = 'static/images/user/posts/thumbs/' . $file_name_new;

                                if(move_uploaded_file($file_tmp, $file_destination)) {
                                    try {
                                        $simage = new SimpleImage($file_destination);
                                        $simage->best_fit('1200', '600')->save($file_thumb);

                                        $asInput = escape(Input::get('as'));

                                        if($asInput !== $user->data()->id) {
                                            if($user->isPageMember($asInput)) {
                                                $as = $asInput;
                                                $isPage = 1;
                                            }
                                        } else {
                                            $as = $user->data()->id;
                                            $isPage = 0;
                                        }
                                        
                                        DB::getInstance()->insert('posts', array(
                                            'user_id'  => $as,
                                            'content'  => Input::get('post'),
                                            'page'     => $isPage,
                                            'photo'    => $file_name_new,
                                            'date'     => date('Y-m-d H:i:s')
                                        ));

                                        $db = DB::getInstance();
                                        $lastId = $db->_pdo->lastInsertId();

                                        $get_hashtags = Hashmention::getHashtags(Input::get('post'));
                                        Hashmention::updateHashtag($get_hashtags);
                                        $get_mention = Hashmention::getMention(Input::get('post'));
                                        Hashmention::notifyUser($get_mention, 'post_mention', $lastId);
                          
                                        if(Input::get('profile')) {
                                            Redirect::to('/user/' . $user->data()->username);
                                        } else {
                                            Redirect::to('/stream');
                                        }
                                    } catch(Exception $e) {
                                        die($e->getMessage());
                                    }
                                }
                            } else {
                                Session::flash('error', 'Your photo must be less than 5MB.');
                                Redirect::to('/stream');
                            }
                        } else {
                            Session::flash('error', 'There was a problem uploading your photo.');
                            Redirect::to('/stream');
                        }
                    } else {
                        Session::flash('error', 'You must select a photo in jpg, png or gif format.');
                        Redirect::to('/stream');
                    }
                } else {
                    Session::flash('error', $validate->errors());
                    // check callback location
                    Redirect::to('/stream');
                }
            } else {
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'post' => array(
                        'required' => true,
                        'max' => 5000
                    )
                ));

                if($validation->passed()) {
                    try {
                        $asInput = escape(Input::get('as'));

                        if($asInput !== $user->data()->id) {
                            if($user->isPageMember($asInput)) {
                                $as = $asInput;
                                $isPage = 1;
                            }
                        } else {
                            $as = $user->data()->id;
                            $isPage = 0;
                        }
                        
                        DB::getInstance()->insert('posts', array(
                            'user_id'  => $as,
                            'content'  => Input::get('post'),
                            'page'     => $isPage,
                            'date'     => date('Y-m-d H:i:s')
                        ));

                        $db = DB::getInstance();
                        $lastId = $db->_pdo->lastInsertId();

                        $get_hashtags = Hashmention::getHashTags(Input::get('post'));
                        Hashmention::updateHashtag($get_hashtags);
                        $get_mention = Hashmention::getMention(Input::get('post'));
                        Hashmention::notifyUser($get_mention, 'post_mention', $lastId);

                        if(Input::get('profile')) {
                            Redirect::to('/user/' . $user->data()->username);
                        } else {
                            Redirect::to('/stream');
                        }
                    } catch(Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    Session::flash('error', $validate->errors());
                    // check callback location
                    Redirect::to('/stream');
                }
            }
        }
    } else {
        Redirect::to('/');
    }
} else {
    Redirect::to('/login?return_to=/stream');
}