<?php
class Team {
    private $_db,
            $_user = array();

    public function __construct() {
        $this->_db = DB::getInstance();
        $this->_user = new User();
    }

    // Check if current user is part of specified team.
    public function isTeamMember($team) {
        $query = $this->_db->query("SELECT * FROM team_members WHERE team_id = {$team} AND user_id = {$this->_user->data()->id}");

        if($query->count()) {
            return true;
        } else {
            return false;
        }
    }

    // Check if specified user is part of current team.
    public function isUserTeamMember($user) {
        $query = $this->_db->query("SELECT * FROM team_members WHERE team_id = {$this->_user->data()->id} AND user_id = {$user}");

        if($query->count()) {
            return true;
        } else {
            return false;
        }
    }

    // Get teams that current user is members of.
    public function getTeams() {
        $query = $this->_db->get('team_members', ['user_id', '=', $this->_user->data()->id]);

        return $query;
    }

    // Get team members of specified team.
    public function getTeamMembers($team) {
        $query = $this->_db->get('team_members', ['team_id', '=', $team]);

        return $query;
    }
}