<?php
class Redirect {
	public static function to($location = null) {

		if($location) {
			if(is_numeric($location)) {
				switch($location) {
					case 404:
                        $user = new User;
					    $post = new Post;
					    $comment = new Comment;
					    $message = new Message;
					    $notification = new Notification;
					    $moderator = new Moderator;
						header('HTTP/1.0 404 Not Found');
						include 'error.php';
						exit();
					break;
				}
			} else {
				header('Location: ' . $location);
				exit();
			}
		}
	}
}