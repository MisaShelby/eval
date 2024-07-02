<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Location_model');
    }

    public function index() {
        // Récupérer les données du formulaire
        $email_client = $this->input->post('email_client');
        $reference_bien = $this->input->post('bien');
        $duree = $this->input->post('duree');
        $date_debut = $this->input->post('date_debut');

        // Calculer la date de fin
        $date_fin = date('Y-m-d', strtotime("+$duree months", strtotime($date_debut)));

        // Récupérer le loyer et la commission
        $query_bien = $this->db->get_where('bien', array('reference' => $reference_bien));
        $bien = $query_bien->row_array();
        $loyer = $bien['loyer'];

        $query_type_bien = $this->db->query("SELECT comission FROM type_bien WHERE id_type_bien = 
            (SELECT id_type_bien FROM bien WHERE reference = ?)",
            array($reference_bien));
        $type_bien = $query_type_bien->row_array();
        $comission = $type_bien['comission'];

        // Vérification si la période chevauche une période existante dans la table location
        $query = $this->db->query("SELECT COUNT(*) AS count FROM location WHERE reference = ? 
                                   AND (date_debut <= ? AND date_fin >= ?)", 
                                   array($reference_bien, $date_fin, $date_debut));

        $result = $query->row_array();
        $count = $result['count'];

        if ($count > 0) {
            // La combinaison existe déjà, gérer l'erreur ou retourner un message à l'utilisateur
            echo "Cette période chevauche déjà une période existante pour ce bien.";
            return;
        } else {
            // Insérer dans la table location
            $data_location = array(
                'duree' => $duree,
                'date_debut' => $date_debut,
                'date_fin' => $date_fin, // Ajout de la date de fin
                'reference' => $reference_bien,
                'email' => $email_client,
                'loyer' => $loyer,
                'comission' => $comission
            );

            $this->db->insert('location', $data_location);
            $id_location = $this->db->insert_id();

            // Appel de la fonction PostgreSQL pour insérer dans location_mois
            $this->db->query("SELECT update_location_date_fin()");
            $this->db->query("SELECT insert_into_location_mois_where(?)", array($id_location));

            // Redirection ou autre traitement après l'insertion réussie
            redirect('welcome/location');
        }
    }
}
?>
