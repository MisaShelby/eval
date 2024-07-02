<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accueil_proprio extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Model_proprio');
    }

    public function index() {
   
        $this->load->view('HeaderProprio'); // Passage des données à la vue
    }
    public function liste_bien() {
   
        $this->load->view('HeaderProprio');
        $numero_proprio = $this->session->userdata('proprio'); // Replace with your session variable
        
        // Fetch properties (biens) associated with the owner (proprio)
        $data['cv'] = $this->Model_proprio->getBiensByProprioNumero($numero_proprio);
        
        // Load your view and pass $data to it
        $this->load->view('liste_bien', $data);  // Passage des données à la vue
    }
    public function chiffre_affaire_proprio() {
        $this->load->view('HeaderProprio');
            // Vérification si le formulaire a été soumis
            
                $date_debut = $this->input->post('date_debut');
                $date_fin = $this->input->post('date_fin');
    
                // Appel à la méthode du modèle pour obtenir le chiffre d'affaires mensuel
                $data['results'] = $this->Model_proprio->getChiffreAffairesMensuel($date_debut, $date_fin);
                
    
                // Charger la vue avec les résultats
                $this->load->view('affaire_proprio', $data); // Assurez-vous que votre vue s'appelle 'body.php'
            
        
        }
        public function details_mois() {
            // Récupérer le mois et l'année depuis la requête GET
            $mois_complet = $this->input->get('mois'); // Par exemple, "2023-february"
        
            // Extraire le mois et l'année
            $mois = date('m', strtotime($mois_complet)); // Extrait le mois au format numérique (par exemple, "02" pour février)
            $annee = date('Y', strtotime($mois_complet)); // Extrait l'année au format numérique (par exemple, "2023")
            $numero_proprio = $this->session->userdata('proprio');
            // Construire la requête SQL pour récupérer les détails du mois
            $sql = "SELECT lm.id_location_mois, lm.mois, lm.paye, lm.numero_proprio, lm.email_client, lm.numero_comission,
                           lm.loyer, lm.comission, l.id_location, l.duree, l.date_debut, l.date_fin, l.comission AS location_comission,
                           l.loyer AS location_loyer, l.reference, l.email
                    FROM location_mois lm
                    JOIN location l ON lm.id_location = l.id_location
                    WHERE EXTRACT(MONTH FROM lm.mois) = ? AND EXTRACT(YEAR FROM lm.mois) = ? AND numero_proprio= ?
                    ORDER BY lm.mois ASC";
        
            // Exécuter la requête SQL avec les valeurs de mois et année
            $query = $this->db->query($sql, array($mois, $annee,$numero_proprio));
        
            // Récupérer les résultats
            $data['details_mois'] = $query->result_array();
        
            // Charger la vue avec les résultats
            $this->load->view('HeaderProprio');
            $this->load->view('details_mois_proprio', $data);
        }
         // Passage des données à la vue
    }


?>