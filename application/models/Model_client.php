<?php

class Model_client extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database(); // Chargement de la base de données dans le modèle
    }

    public function getChiffreAffairesMensuel($date_debut, $date_fin) {
        // Récupérer le numéro du propriétaire depuis la session
        $email_client = $this->session->userdata('client'); // Assurez-vous que 'client' correspond à la clé de session correcte
        
        // Exécute la fonction update_paye_status pour mettre à jour les statuts de paiement
        $this->db->query("SELECT update_paye_status()");
        
        $sql = "SELECT
                    TO_CHAR(mois, 'YYYY-Month') AS mois,
                    SUM(total_loyer) AS total_loyer,
                    paye
                FROM
                    chiffre_affaires_mensuel
                WHERE
                    mois BETWEEN DATE_TRUNC('month', CAST(? AS DATE)) AND (DATE_TRUNC('month', CAST(? AS DATE)) + INTERVAL '1 month' - INTERVAL '1 day')
                    AND email_client = ?
                GROUP BY
                    TO_CHAR(mois, 'YYYY-Month'),
                    EXTRACT(YEAR FROM mois),
                    EXTRACT(MONTH FROM mois),
                    paye
                ORDER BY
                    EXTRACT(YEAR FROM mois),
                    EXTRACT(MONTH FROM mois)";
        
        $query = $this->db->query($sql, array($date_debut, $date_fin, $email_client));
        return $query->result_array();
    }
}
?>
