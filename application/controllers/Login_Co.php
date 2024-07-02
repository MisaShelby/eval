<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class login_co extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('user_model');
            $this->load->helper('url');
            $this->load->library('session');


        }


        public function login_miditra() {
            // Récupère les données du formulaire
            $username = $this->input->post('username');
            $password = $this->input->post('password');
        
            // Vérifie les informations d'identification dans la base de données
            $user = $this->user_model->get_user($username, $password);
        
            if ($user) {
                $this->session->set_userdata('login', $user['id_login']);
                // L'utilisateur est authentifié avec succès
               /*if ($user['admin'] == 1)  {
                    // Rediriger l'administrateur vers la page d'accueil admin
                    redirect('accueil_admin');
                } else {
                    // Stocker l'id_equipe dans la session
                    $this->session->set_userdata('login', $user['id_login']);
        
                    // Rediriger l'utilisateur non-admin vers une autre page
                    redirect('accueil_user');
                }*/  redirect('accueil_admin');
            } else {
                // Mauvaises informations d'identification, afficher un message d'erreur
                $data['error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
                $this->load->view('login_form', $data);
            }
        }
        public function deconnexion(){
            $this->session->sess_destroy();
            redirect("Welcome/index_admin");
        }
        public function drop_data() {
            // Charger la bibliothèque de base de données
            $this->load->database();
        
            // Liste des tables à exclure de la suppression
            $excluded_tables = array('login');  // Ajoutez d'autres tables si nécessaire
        
            // Récupérer la liste des tables dans la base de données
            $tables = $this->db->list_tables();
        
            // Désactiver les triggers pour permettre la troncature
            foreach ($tables as $table) {
                // Vérifier si l'objet est une vue
                $query = $this->db->query("SELECT table_name FROM information_schema.views WHERE table_name = '$table'");
                if ($query->num_rows() == 0 && !in_array($table, $excluded_tables)) {
                    $this->db->query('ALTER TABLE ' . $table . ' DISABLE TRIGGER ALL');
                }
            }
        
            // Parcourir chaque table et la vider, sauf celles exclues et les vues
            foreach ($tables as $table) {
                // Vérifier si l'objet est une vue
                $query = $this->db->query("SELECT table_name FROM information_schema.views WHERE table_name = '$table'");
                if ($query->num_rows() == 0 && !in_array($table, $excluded_tables)) {
                    $this->db->query('TRUNCATE TABLE ' . $table . ' CASCADE');
                }
            }
        
            // Réactiver les triggers
            foreach ($tables as $table) {
                // Vérifier si l'objet est une vue
                $query = $this->db->query("SELECT table_name FROM information_schema.views WHERE table_name = '$table'");
                if ($query->num_rows() == 0 && !in_array($table, $excluded_tables)) {
                    $this->db->query('ALTER TABLE ' . $table . ' ENABLE TRIGGER ALL');
                }
            }
        
            // Redirection vers une page après avoir supprimé les données
            redirect(site_url('Welcome/dropbase'));
        }
        
        
        
///////////////////////////Login proprietaire//////////////////////////////////////////

public function login_miditra1() {
    // Récupère les données du formulaire
    $username = $this->input->post('username');

    // Vérifie les informations d'identification dans la base de données
    $user = $this->user_model->get_user1($username);

    if ($user) {
        $this->session->set_userdata('proprio', $user['numero']);
        // L'utilisateur est authentifié avec succès
       /*if ($user['admin'] == 1)  {
            // Rediriger l'administrateur vers la page d'accueil admin
            redirect('accueil_admin');
        } else {
            // Stocker l'id_equipe dans la session
            $this->session->set_userdata('login', $user['id_login']);

            // Rediriger l'utilisateur non-admin vers une autre page
            redirect('accueil_user');
        }*/  redirect('Accueil_proprio');
    } else {
        // Mauvaises informations d'identification, afficher un message d'erreur
        $data['error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
        $this->load->view('login_proprio', $data);
    }
}
public function deconnexion1(){
    $this->session->sess_destroy();
    redirect("Welcome/index");
}


//////////////////////////////////////////////////////login client///////////////////////////////////////


public function login_miditra2() {
    // Récupère les données du formulaire
    $username = $this->input->post('username');

    // Vérifie les informations d'identification dans la base de données
    $user = $this->user_model->get_user2($username);

    if ($user) {
        $this->session->set_userdata('client', $user['email']);
        // L'utilisateur est authentifié avec succès
       /*if ($user['admin'] == 1)  {
            // Rediriger l'administrateur vers la page d'accueil admin
            redirect('accueil_admin');
        } else {
            // Stocker l'id_equipe dans la session
            $this->session->set_userdata('login', $user['id_login']);

            // Rediriger l'utilisateur non-admin vers une autre page
            redirect('accueil_user');
        }*/  redirect('Accueil_client');
    } else {
        // Mauvaises informations d'identification, afficher un message d'erreur
        $data['error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
        $this->load->view('login_client', $data);
    }
}
public function deconnexion2(){
    $this->session->sess_destroy();
    redirect("Welcome/index_client");
}


        
}