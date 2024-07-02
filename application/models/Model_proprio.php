<?php

    class Model_proprio extends CI_Model{
        public function __construct() {
            parent::__construct();
            $this->load->database(); // Chargement de la base de données dans le modèle
        }
        public function getBiensByProprioNumero($numero) {
            $this->db->select('bien.*, type_bien.nom_bien as type_nom');
            $this->db->from('bien');
            $this->db->join('type_bien', 'bien.id_type_bien = type_bien.id_type_bien', 'left'); // Assuming LEFT JOIN
            $this->db->where('bien.numero', $numero);
            $query = $this->db->get();
            
            if ($query->num_rows() > 0) {
                return $query->result_array(); // Return array of properties if found
            } else {
                return array(); // Return empty array if no properties found
            }
        }
        public function getChiffreAffairesMensuel($date_debut, $date_fin) {
            // Récupérer le numéro du propriétaire depuis la session
            $numero_proprio = $this->session->userdata('proprio'); // Assurez-vous que 'proprio' correspond à la clé de session correcte
            
            $sql = "SELECT
                        TO_CHAR(mois, 'YYYY-Month') AS mois,
                        SUM(total_loyer) AS total_loyer,
                        SUM(total_comission) AS total_comission
                    FROM
                        chiffre_affaires_mensuel
                    WHERE
                        mois BETWEEN DATE_TRUNC('month', CAST(? AS DATE)) AND (DATE_TRUNC('month', CAST(? AS DATE)) + INTERVAL '1 month' - INTERVAL '1 day')
                        AND numero_proprio = ?
                    GROUP BY
                        TO_CHAR(mois, 'YYYY-Month'),
                        EXTRACT(YEAR FROM mois),
                        EXTRACT(MONTH FROM mois)
                    ORDER BY
                        EXTRACT(YEAR FROM mois),
                        EXTRACT(MONTH FROM mois)";
            
            $query = $this->db->query($sql, array($date_debut, $date_fin, $numero_proprio));
            return $query->result_array();
        }
        
        
}


