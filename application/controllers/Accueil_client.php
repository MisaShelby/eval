<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil_client extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_client');
    }

    public function index() {
   
        $this->load->view('HeaderClient'); // Passage des données à la vue
    }

    public function chiffre_affaire_client() {
        $this->load->view('HeaderClient');
            // Vérification si le formulaire a été soumis
            
                $date_debut = $this->input->post('date_debut');
                $date_fin = $this->input->post('date_fin');
    
                // Appel à la méthode du modèle pour obtenir le chiffre d'affaires mensuel
                $data['results'] = $this->Model_client->getChiffreAffairesMensuel($date_debut, $date_fin);
                
    
                // Charger la vue avec les résultats
                $this->load->view('loyer', $data); // Assurez-vous que votre vue s'appelle 'body.php'
        }
         // Passage des données à la vue
    
   
}