<?php
class Message {
    private $_db,
            $_user = array();

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_user = new User();
    }

    public function get($message = null) {
        if($message) {
            $query = $this->_db->get('messages', array('id', '=', $message));

            if($query->count()) {
                return $query->first();
            }
        }
    }

    public function exists($message = null) {
        if($message) {
            $query = $this->_db->get('messages', array('id', '=', $message));

            if($query->count()) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function isDeleted($message = null) {
        if($message) {
            $query = $this->_db->get('deleted_messages', array('message_id', '=', $message));

            if($query->count()) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function belongs($type = null, $message = null) {
        if($message) {
            if($type === 'both') {
                $query = $this->_db->query("SELECT * FROM messages WHERE (id = {$message} AND sender_user_id = {$this->_user->data()->id}) OR (id = {$message} AND recipient_user_id = {$this->_user->data()->id})");

                if($query->count()) {
                    return true;
                }

                return false;
            } else if($type === 'recipient') {
                $query = $this->_db->query("SELECT * FROM messages WHERE id = {$message} AND recipient_user_id = {$this->_user->data()->id}");

                if($query->count()) {
                    return true;
                }

                return false;
            } else if($type === 'sender') {
                $query = $this->_db->query("SELECT * FROM messages WHERE id = {$message} AND sender_user_id = {$this->_user->data()->id}");

                if($query->count()) {
                    return true;
                }

                return false;
            }
        }

        return false;
    }

    public function getMessages() {
        return $this->_db->query("SELECT * FROM messages WHERE recipient_user_id = {$this->_user->data()->id} AND id NOT IN (SELECT message_id FROM deleted_messages) ORDER BY date DESC");
    }

    public function getFiveMessages() {
        return $this->_db->query("SELECT * FROM messages WHERE recipient_user_id = {$this->_user->data()->id} AND id NOT IN (SELECT message_id FROM deleted_messages) ORDER BY date DESC LIMIT 5");
    }

    public function getUnreadMessages() {
        return $this->_db->query("SELECT * FROM messages WHERE seen = 0 AND recipient_user_id = {$this->_user->data()->id} ORDER BY date DESC");
    }

    public function getSentMessages() {
        return $this->_db->query("SELECT * FROM messages WHERE sender_user_id = {$this->_user->data()->id} ORDER BY date DESC"); //UNION SELECT * FROM deleted_messages
    }

    public function getTrashMessages() {
        return $this->_db->query("SELECT * FROM messages WHERE recipient_user_id = {$this->_user->data()->id} AND id IN (SELECT message_id FROM deleted_messages) ORDER BY date DESC");
    }
}