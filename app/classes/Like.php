<?php
class Like {
    private $_db,
            $_user = array();

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_user = new User();
    }

    public function postLikes($post) {
        return $this->_db->get('likes', array('post_id', '=', $post))->count();
    }

    public function hasLiked($post) {
        if($this->_user->isLoggedIn()) {
            if($this->_db->query("SELECT * FROM likes WHERE post_id = {$post} AND user_id = {$this->_user->data()->id}")->count()) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function hasLikedComment($comment) {
        if($this->_user->isLoggedIn()) {
            if($this->_db->query("SELECT * FROM comment_likes WHERE comment_id = {$comment} AND user_id = {$this->_user->data()->id}")->count()) {
                return true;
            }

            return false;
        }

        return false;
    }
}