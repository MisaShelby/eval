<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database(); // Chargement de la base de données dans le modèle
    }
    public function get_clients() {
        return $this->db->get('client')->result_array();
    }

    public function get_biens() {
        return $this->db->get('bien')->result_array();
    }  
       
    
    // Ajouter une méthode pour insérer une nouvelle location si nécessaire
}
?>
