<?php
class Website {
    private $_db,
            $_user = array();

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_user = new User();
    }

    public function get($website = null) {
        if($website) {
            $query = $this->_db->get('websites', array('id', '=', $website));

            if($query->count()) {
                return $query->first();
            }
        }
    }

    public function exists($website = null) {
        if($website) {
            $query = $this->_db->get('websites', array('id', '=', $website));

            if($query->count()) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function getFeaturedWebsites() {
        return DB::getInstance()->query("SELECT * FROM websites WHERE featured = 1 ORDER BY date DESC");
    }

    public function getLatestWebsites() {
        return DB::getInstance()->query("SELECT * FROM websites ORDER BY date DESC");
    }

    public function getWebsites() {
        return DB::getInstance()->query("SELECT * FROM websites ORDER BY name ASC");
    }
}