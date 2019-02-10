<?php
class Post {
    private $_db,
            $_user = array();

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_user = new User();
    }

    public function get($post = null) {
        if($post) {
            $query = $this->_db->get('posts', array('id', '=', $post));

            if($query->count()) {
                return $query->first();
            }
        }
    }

    public function exists($post = null) {
        if($post) {
            $query = $this->_db->get('posts', array('id', '=', $post));

            if($query->count()) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function following($id) {
        // $id = post_id
        return $query = $this->_db->get('post_following', array('post_id', '=', $id));
    }

    public function isFollowing($id) {
        $query = $this->_db->query("SELECT * FROM post_following WHERE user_id = ? AND post_id = ?", array($this->_user->data()->id, $id));

        if($query->count()) {
            return true;
        } else {
            return false;
        }
    }

    public function follow($id) {
        $userId = $this->_user->data()->id;
        $postId = $id;

        if($postId !== $userId) {
            if(!$this->isFollowing($postId)) {
                $this->_db->insert('post_following', array(
                    'user_id' => $userId,
                    'post_id' => $postId
                ));
            }
        }
    }

    public function unfollow($id) {
        $userId = $this->_user->data()->id;
        $postId = $id;

        if($postId !== $userId) {
            if($this->isFollowing($postId)) {
                $query = $this->_db->query("DELETE FROM post_following WHERE user_id = ? AND post_id = ?", array($userId, $postId));
            }
        }
    }

    public function getHomePosts() {
        $query = $this->_db->query("SELECT p.*
                                    FROM posts p
                                    INNER JOIN following f
                                    ON(p.user_id = f.user_following_id)
                                    WHERE ((p.user_id = {$this->_user->data()->id}) OR f.user_id = {$this->_user->data()->id})
                                    GROUP BY p.id
                                    ORDER BY p.date DESC");

        return $query;
    }

    public function getUserPosts($user) {
        $query = $this->_db->query("SELECT * FROM posts WHERE user_id = '{$user}' ORDER BY date DESC");

        return $query;
    }

    public function getPopularPosts() {
        return DB::getInstance()->query("SELECT posts.*, COUNT(likes.post_id) AS likes 
                                        FROM posts 
                                        LEFT JOIN likes ON likes.post_id=posts.id 
                                        GROUP BY posts.id
                                        ORDER BY likes DESC, posts.date DESC");
    }

    public function getLatestPosts() {
        return DB::getInstance()->query("SELECT * FROM posts ORDER BY date DESC");
    }

    public function getPosts() {
        return DB::getInstance()->query("SELECT * FROM posts ORDER BY id ASC");
    }
}