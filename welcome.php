<?php
require_once dirname(__FILE__) . '/app/init.php';

if(!$user->isLoggedIn()) {
    Redirect::to('/login?return_to=/welcome');
}

if($user->data()->setup === 1) {
    Redirect::to('/');
}

$page = (int)escape(Input::get('page'));

if($page != null) {
    if($page < 2 || $page > 5) {
        Redirect::to('/welcome');
    }
}

// Backend for data submitted through setup guide.
if($page === 2) {
    if(Input::exists()) {
        if(Token::check(Input::get('token'))) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 28),
                'job' => array(
                    'required' => false,
                    'max' => 30),
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
                        'job' => Input::get('job'),
                        'location' => Input::get('location'),
                        'website' => Input::get('website'),
                        'about' => Input::get('about')
                    ));
                } catch(Exception $e) {
                    die($e->getMessage());
                }

                Redirect::to('/welcome/3');
            } else {
                Session::flash('error', $validate->errors());
            }
        }
    }
} else if($page === 3) {
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

                    if($user->data()->avatar != null && $user->data()->avatar != 'default.jpg' && $user->data()->avatar != 'default-business.jpg') {
                        unlink('static/images/user/avatars/' . $user->data()->avatar);
                        unlink('static/images/user/avatars/thumbs/' . $user->data()->avatar);
                    }

                    if(move_uploaded_file($file_tmp, $file_destination)) {
                        $simage = new SimpleImage($file_destination);
                        $simage->thumbnail('300')->save($file_thumb);

                        $user->update(array(
                            'avatar' => $file_name_new
                        ));

                        Redirect::to('/welcome/4');
                    }
                } else {
                    Session::flash('error', 'Your avatar must be less than 5MB.');
                    Redirect::to('/welcome/3');
                }
            } else {
                Session::flash('error', 'There was a problem uploading your avatar.');
                Redirect::to('/welcome/3');
            }
        } else {
            Session::flash('error', 'You must select an avatar in jpg, png or gif format.');
            Redirect::to('/welcome/3');
        }
    }
} else if($page === 4) {
    // Optional, no logic here.
} else if($page === 5) {
    if(Input::exists()) {
        try {
            $user->update(array(
                'setup' => 1
            ));
        } catch(Exception $e) {
            die($e->getMessage());
        }

        Redirect::to('/');
    }
}

$title = 'Welcome';
$content = 'welcome';

require_once dirname(__FILE__) . '/app/views/view.php';