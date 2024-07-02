<?php

    class Model_admin extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Chargement de la base de données dans le modèle
    }

    public function getChiffreAffairesMensuel($date_debut, $date_fin) {
        $sql = "SELECT
                    TO_CHAR(mois, 'YYYY-Month') AS mois,
                    SUM(total_loyer) AS total_loyer,
                    SUM(total_comission) AS total_comission
                FROM
                    chiffre_affaires_mensuel
                WHERE
                    mois BETWEEN DATE_TRUNC('month', CAST(? AS DATE)) AND (DATE_TRUNC('month', CAST(? AS DATE)) + INTERVAL '1 month' - INTERVAL '1 day')
                GROUP BY
                    TO_CHAR(mois, 'YYYY-Month'),
                    EXTRACT(YEAR FROM mois),
                    EXTRACT(MONTH FROM mois)
                ORDER BY
                    EXTRACT(YEAR FROM mois),
                    EXTRACT(MONTH FROM mois)";
    
        $query = $this->db->query($sql, array($date_debut, $date_fin));
        return $query->result_array();
    }
    
    
    }
    