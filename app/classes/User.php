<?php
class User {
    protected $_bcrypt;

    private $_db,
            $_sessionName = null,
            $_cookieName = null,
            $_data = array(),
            $_isLoggedIn = false;

    public function __construct($user = null) {
        $this->_bcrypt = new Bcrypt;
        $this->_db = DB::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        // Check if a session exists and set user if so.
        if(Session::exists($this->_sessionName) && !$user) {
            $user = Session::get($this->_sessionName);

            if($this->find($user)) {
                $this->_isLoggedIn = true;
            } else {
                $this->logout();
            }
        } else {
            $this->find($user);
        }
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function find($user = null) {
        // Check if user_id specified and grab details
        if($user) {
            if(filter_var($user, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $field = (is_numeric($user)) ? 'id' : 'username';
            }

            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function findPage($page = null) {
        if($page) {
            $field = (is_numeric($page)) ? 'id' : 'username';
            $data = $this->_db->query("SELECT * FROM users WHERE ? = ? AND page = 1", [$field, $page]);

            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function usernameExists($user = null) {
        // Check if user_id specified and grab details
        if($user) {
            $data = $this->_db->query("SELECT * FROM users WHERE username = ? AND page = 0", [$user]);

            if($data->count()) {
                return true;
            }
        }
        return false;
    }

    public function pagenameExists($page = null) {
        // Check if user_id specified and grab details
        if($page) {
            $data = $this->_db->query("SELECT * FROM users WHERE username = ? AND page = 1", [$page]);

            if($data->count()) {
                return true;
            }
        }
        return false;
    } 

    public function get($user = null) {
        if($user) {
            if(filter_var($user, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            } else {
                $field = (is_numeric($user)) ? 'id' : 'username';
            }

            $query = $this->_db->get('users', array($field, '=', $user));

            if($query->count()) {
                return $query->first();
            }
        }
    }

    public function getPage($page = null) {
        if($page) {
            $field = (is_numeric($page)) ? 'id' : 'username';
            $data = $this->_db->query("SELECT * FROM users WHERE $field = $page AND page = 1");

            if($query->count()) {
                return $query->first();
            }
        }
    }

    public function isUser($user = null) {
        if($user) {
            $data = $this->_db->query("SELECT * FROM users WHERE id = ? AND page = 0", [$user]);

            if($data->count()) {
                return true;
            }
        }
        return false;
    }

    public function create($fields = array()) {
        if(!$this->_db->insert('users', $fields)) {
            throw new Exception('There was a problem creating an account.');
        }
    }

    public function update($fields = array(), $id = null) {
        if(!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }

        if(!$this->_db->update('users', $id, $fields)) {
            throw new Exception('There was a problem updating.');
        }
    }

    public function login($username = null, $password = null, $remember = false) {
        if(!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($username);

            if($user) {
                if(!$this->isSuspended($this->get($username)->id) && !$this->isPage($this->get($username)->id)) {
                    if($this->_bcrypt->verify($password, $this->data()->password)) {
                        Session::put($this->_sessionName, $this->data()->id);

                        if($remember) {
                            $hash = Hash::unique();

                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash,
                                'ip' => $_SERVER['HTTP_CF_CONNECTING_IP'],
                                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                                'date' => date('Y-m-d H:i:s')
                            ));

                            Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                        }

                        return true;
                    }
                } else {
                    Session::flash('error', 'This account isn\'t active or has been suspended.');
                    Redirect::to('/login');
                }
            }
        }

        return false;
    }

    public function hasPermission($key) {
        $group = $this->_db->query("SELECT * FROM groups WHERE id = ?", array($this->data()->group));

        if($group->count()) {
            $permissions = json_decode($group->first()->permissions, true);

            if($permissions[$key] === 1) {
                return true;
            }
        }

        return false;
    }

    public function isSuspended($id) {
        $query = $this->_db->get('users_suspended', array('user_id', '=', $id));

        if($query->count()) {
            return true;
        } else {
            return false;
        }
    }

    public function isPremium($id = null) {
        if(!$id) {
            if(date("U") < $this->data()->plus_until) {
                return true;
            } else {
                return false;
            }
        } else {
            if(date("U") < $this->get($id)->plus_until) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function forHire($id = null) {
        if(!$id) {
            if($this->get($this->data()->id)->hire == 1) {
                return true;
            }
        } else {
            if($this->get($id)->hire == 1) {
                return true;
            }
        }
    }

    /*
     * FOLLOWING SYSTEM
     */

    public function isFollowing($id) {
        $query = $this->_db->query("SELECT * FROM following WHERE user_id = ? AND user_following_id = ?", array($this->data()->id, $id));

        if($query->count()) {
            return true;
        } else {
            return false;
        }
    }

    public function followUser($id) {
        $user_id = $this->data()->id;
        $user_following_id = $id;

        if($user_following_id !== $user_id) {
            if(!$this->isFollowing($user_following_id)) {
                $this->_db->insert('following', array(
                    'user_id' => $this->data()->id,
                    'user_following_id' => $user_following_id
                ));
            }
        }
    }

    public function unfollowUser($id) {
        $user_id = $this->data()->id;
        $user_following_id = $id;

        if($user_following_id !== $user_id) {
            if($this->isFollowing($user_following_id)) {
                $query = $this->_db->query("DELETE FROM following WHERE user_id = ? AND user_following_id = ?", array($user_id, $user_following_id));
            }
        }
    }

    public function whoToFollow() {
        // Recommended people algorithm (needs rewriting)
        // OLD: $query = $this->_db->query("SELECT * FROM users WHERE id <> {$this->data()->id} ORDER BY RAND() DESC LIMIT 4");
        return $query = $this->_db->query("SELECT * FROM users WHERE id NOT IN (SELECT user_following_id FROM following WHERE user_id = {$this->data()->id}) AND id <> {$this->data()->id} ORDER BY RAND() ASC LIMIT 4");
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

    public function data() {
        return $this->_data;
    }

    public function logout() {
        $this->_db->delete('users_session', array('hash', '=', Cookie::get(Config::get('remember/cookie_name'))));
        Cookie::delete($this->_cookieName);
        Session::delete($this->_sessionName);
    }

    public function remoteLogout($id) {
        $session = (int)escape($id);
        $user = $this->_db->get('users_session', array('id', '=', $session))->first()->user_id;

        if($user) {
            if($user === $this->data()->id) {
                $this->_db->delete('users_session', array('id', '=', $session));
            }
        }
    }

    public function reputation($id) {
        // fix me plz
        $db = $this->_db;
        /* Followers (1) */ $followers = $db->get('following', array('user_following_id', '=', $id))->count();
        /* Likes (5) */ $likes = $db->query("SELECT * FROM likes WHERE post_user_id = $id AND user_id <> $id")->count() * 5;
        /* Comment Likes (5) */ $comment_likes = $db->query("SELECT * FROM comment_likes WHERE comment_user_id = $id AND user_id <> $id")->count() * 5;
        /* Comments (10) */ $comments = $db->query("SELECT * FROM comments WHERE post_user_id = $id AND user_id <> $id")->count() * 10;

        /* Total */ $rep = $comments + $likes + $comment_likes + $followers;

        return $rep;
    }



    // // // // // // // // // // // // // // // // // // // // // //

    public function isPage($page) {
        if($page) {
            $query = $this->_db->query("SELECT * FROM page_members WHERE page_id = {$page}")->first();

            if($query && $query->page) {
                return true;
            }

            return false;
        }
    }

    public function isPageOwner($page, $user = null) {
        if($user) {
            $query = $this->_db->query("SELECT * FROM page_members WHERE page_id = {$page} AND user_id = {$user}")->first();
        } else {
            $query = $this->_db->query("SELECT * FROM page_members WHERE page_id = {$page} AND user_id = {$this->data()->id}")->first();
        }

        if($query->owner) {
            return true;
        } else {
            return false;
        }
    }

    // Check if current user is part of specified team.
    public function isPageMember($page) {
        $query = $this->_db->query("SELECT * FROM page_members WHERE page_id = {$page} AND user_id = {$this->data()->id}");

        if($query->count()) {
            return true;
        } else {
            return false;
        }
    }

    // Check if specified user is part of current team.
    public function isUserPageMember($page, $user) {
        $query = $this->_db->query("SELECT * FROM page_members WHERE page_id = {$page} AND user_id = {$user}");

        if($query->count()) {
            return true;
        } else {
            return false;
        }
    }

    // Get teams that current user is members of.
    public function getPages() {
        $query = $this->_db->get('page_members', ['user_id', '=', $this->data()->id]);

        return $query;
    }

    // Get team members of specified team.
    public function getPageMembers($page) {
        $query = $this->_db->get('page_members', ['page_id', '=', $page]);

        return $query;
    }
}