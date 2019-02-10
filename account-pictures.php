<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/account/pictures');
}

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

                if($user->data()->avatar != null && $user->data()->avatar != 'default.jpg' && $user->data()->avatar != 'default-page.jpg') {
                    unlink('static/images/user/avatars/' . $user->data()->avatar);
                    unlink('static/images/user/avatars/thumbs/' . $user->data()->avatar);
                }

                if(move_uploaded_file($file_tmp, $file_destination)) {
                    $simage = new SimpleImage($file_destination);
                    $simage->thumbnail('300')->save($file_thumb);

                    $user->update(array(
                        'avatar' => $file_name_new
                    ));

                    Session::flash('success', 'Your avatar has been updated!');
                    Redirect::to('/user/' . $user->data()->username);
                }
            } else {
                Session::flash('error', 'Your avatar must be less than 2MB.');
                Redirect::to('/account/pictures');
            }
        } else {
            Session::flash('error', 'There was a problem uploading your avatar.');
            Redirect::to('/account/pictures');
        }
    } else {
        Session::flash('error', 'You must select an avatar in jpg, png or gif format.');
        Redirect::to('/account/pictures');
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

                if($user->data()->header != null && $user->data()->header != 'default.jpg') {
                    unlink('static/images/user/headers/' . $user->data()->header);
                    unlink('static/images/user/headers/thumbs/' . $user->data()->header);
                }

                if(move_uploaded_file($file_tmp, $file_destination)) {
                    $simage = new SimpleImage($file_destination);
                    $simage->adaptive_resize('2000', '1000')->save($file_thumb);

                    $user->update(array(
                        'header' => $file_name_new
                    ));

                    Session::flash('success', 'Your header picture has been updated!');
                    Redirect::to('/user/' . $user->data()->username);
                }
            } else {
                Session::flash('error', 'Your header picture must be less than 5MB.');
                Redirect::to('/account/pictures');
            }
        } else {
            Session::flash('error', 'There was a problem uploading your header picture.');
            Redirect::to('/account/pictures');
        }
    } else {
        Session::flash('error', 'You must select a header picture in jpg, png or gif format.');
        Redirect::to('/account/pictures');
    }
}

$title = 'Account - Pictures';
$content = 'account-pictures';

require_once dirname(__FILE__) . '/app/views/view.php';