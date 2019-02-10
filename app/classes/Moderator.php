<?php
class Moderator {
    private $_db,
            $_user = array();

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_user = new User();
    }

    public function getUnacted() {
        return $reports = $this->_db->get('reports', ['acted', '=', 0])->count();
    }

    // For counting only
    public function getUnactedReports($type) {
        return $this->_db->query("SELECT * FROM reports WHERE type = '$type' AND acted = 0")->count();
    }

    // Repeated code because I'm stupid, and I didn't think of this before putting count on the other functions.
    public function displayUnactedReports($type) {
        return $this->_db->query("SELECT * FROM reports WHERE type = '$type' AND acted = 0");
    }
}