<?php
class User_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_user($username, $password) {
        $query = $this->db->get_where('login', array('login' => $username, 'pwd' => $password));
        return $query->row_array();
    }

    public function get_user1($username) {
        $query = $this->db->get_where('proprio', array('numero' => $username));
        return $query->row_array();
    }

    public function get_user2($username) {
        $query = $this->db->get_where('client', array('email' => $username));
        return $query->row_array();
    }
    
    
}