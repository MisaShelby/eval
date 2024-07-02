<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_admin');
    }

    public function index() {
   
        $this->load->view('templates/header');
        
        $this->load->view('body');
         // Passage des données à la vue
    }
    public function chiffre_affaires_mensuel() {
        // Vérification si le formulaire a été soumis
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $date_debut = $this->input->post('date_debut');
            $date_fin = $this->input->post('date_fin');

            // Appel à la méthode du modèle pour obtenir le chiffre d'affaires mensuel
            $data['results'] = $this->Model_admin->getChiffreAffairesMensuel($date_debut, $date_fin);
            $this->load->view('templates/header');

            // Charger la vue avec les résultats
            $this->load->view('body', $data); // Assurez-vous que votre vue s'appelle 'body.php'
        } else {
        $this->load->view('templates/header');

            // Afficher le formulaire par défaut
            $this->load->view('body');
        }
    }
    public function details_mois() {
        // Récupérer le mois et l'année depuis la requête GET
        $mois_complet = $this->input->get('mois'); // Par exemple, "2023-february"
    
        // Extraire le mois et l'année
        $mois = date('m', strtotime($mois_complet)); // Extrait le mois au format numérique (par exemple, "02" pour février)
        $annee = date('Y', strtotime($mois_complet)); // Extrait l'année au format numérique (par exemple, "2023")
    
        // Construire la requête SQL pour récupérer les détails du mois
        $sql = "SELECT lm.id_location_mois, lm.mois, lm.paye, lm.numero_proprio, lm.email_client, lm.numero_comission,
                       lm.loyer, lm.comission, l.id_location, l.duree, l.date_debut, l.date_fin, l.comission AS location_comission,
                       l.loyer AS location_loyer, l.reference, l.email
                FROM location_mois lm
                JOIN location l ON lm.id_location = l.id_location
                WHERE EXTRACT(MONTH FROM lm.mois) = ? AND EXTRACT(YEAR FROM lm.mois) = ?
                ORDER BY lm.mois ASC";
    
        // Exécuter la requête SQL avec les valeurs de mois et année
        $query = $this->db->query($sql, array($mois, $annee));
    
        // Récupérer les résultats
        $data['details_mois'] = $query->result_array();
    
        // Charger la vue avec les résultats
        $this->load->view('templates/header');
        $this->load->view('details_mois_view', $data);
    }
    
}

?>