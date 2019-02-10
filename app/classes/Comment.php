<?php
class Comment {
    private $_db,
            $_user = array();

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_user = new User();
    }

    public function get($comment = null) {
        if($comment) {
            $query = $this->_db->get('comments', array('id', '=', $comment));

            if($query->count()) {
                return $query->first();
            }
        }
    }

    public function exists($comment = null) {
        if($comment) {
            $query = $this->_db->get('comments', array('id', '=', $comment));

            if($query->count()) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function getPostId($comment) {
        return $this->_db->query("SELECT post_id FROM comments WHERE id = {$comment}")->first()->post_id;
    }

    public function getPostComments($post) {
        if($post) {
            // $query = $this->_db->query("(SELECT * FROM comments WHERE post_id = {$post} ORDER BY id DESC LIMIT 4) ORDER BY id ASC"); // Shows last 5
            $query = $this->_db->query("SELECT * FROM comments WHERE post_id = {$post} ORDER BY id DESC LIMIT 4");

            return $query;
        }
    }

    public function getAllPostComments($post) {
        if($post) {
            $query = $this->_db->query("SELECT * FROM comments WHERE post_id = {$post} ORDER BY id DESC");

            return $query;
        }
    }
}