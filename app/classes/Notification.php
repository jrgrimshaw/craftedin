<?php
class Notification {
    private $_db,
            $_user = array();

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_user = new User();
    }

    public function exists($notification = null) {
        if($notification) {
            $query = $this->_db->get('notifications', array('id', '=', $notification));

            if($query->count()) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function create($recipient_user_id, $type, $type_id = null) {
        if($this->_user->data()->id !== $recipient_user_id) {
            $this->_db->insert('notifications', array(
                'actor_user_id'     => $this->_user->data()->id,
                'recipient_user_id' => $recipient_user_id,
                'type'              => $type,
                'type_id'           => $type_id,
                'date'              => date('Y-m-d H:i:s')
            ));
        }
    }

    public function readAll() {
        $pages = "";
        $pagesOwned = $this->_db->query("SELECT * FROM page_members WHERE user_id = {$this->_user->data()->id} AND owner = 1");

        if($pagesOwned->count()) {
            foreach($pagesOwned->results() as $pageOwned) {
                $pages .= " OR recipient_user_id = {$pageOwned->page_id}";
            }
        }

        $this->_db->query("UPDATE notifications SET seen = 1 WHERE (recipient_user_id = {$this->_user->data()->id}{$pages})");
    }

    public function getAllNotifications() {
        $pages = "";
        $pagesOwned = $this->_db->query("SELECT * FROM page_members WHERE user_id = {$this->_user->data()->id} AND owner = 1");

        if($pagesOwned->count()) {
            foreach($pagesOwned->results() as $pageOwned) {
                $pages .= " OR recipient_user_id = {$pageOwned->page_id}";
            }
        }

        return $this->_db->query("SELECT * FROM notifications WHERE (recipient_user_id = {$this->_user->data()->id} {$pages}) AND actor_user_id <> {$this->_user->data()->id} ORDER BY date DESC");
    }

    public function getNotifications() {
        $pages = "";
        $pagesOwned = $this->_db->query("SELECT * FROM page_members WHERE user_id = {$this->_user->data()->id} AND owner = 1");

        if($pagesOwned->count()) {
            foreach($pagesOwned->results() as $pageOwned) {
                $pages .= " OR recipient_user_id = {$pageOwned->page_id}";
            }
        }

        return $this->_db->query("SELECT * FROM notifications WHERE (recipient_user_id = {$this->_user->data()->id} {$pages}) AND actor_user_id <> {$this->_user->data()->id} ORDER BY date DESC LIMIT 5");
    }

    public function getUnreadNotifications() {
        $pages = "";
        $pagesOwned = $this->_db->query("SELECT * FROM page_members WHERE user_id = {$this->_user->data()->id} AND owner = 1");

        if($pagesOwned->count()) {
            foreach($pagesOwned->results() as $pageOwned) {
                $pages .= " OR recipient_user_id = {$pageOwned->page_id}";
            }
        }

        return $this->_db->query("SELECT * FROM notifications WHERE seen = 0 AND (recipient_user_id = {$this->_user->data()->id} {$pages}) AND actor_user_id <> {$this->_user->data()->id} ORDER BY date DESC");
    }
}