<?php

    class PersonneModel extends CI_Model{
        public function get_personne(){
            return $this->db->get('bien')->result();
        }
        public function import_into_temporary_table( $datas ){
            
            $query = "delete from temporary_bien";
            $this->db->query($query);
            $this->db->trans_begin();
            foreach( $datas as $data ){
                $d = array(
                    'reference'=>trim($data[0]),
                    'nom'=>trim($data[1]),
                    'description'=>trim($data[2]),
                    'nom_bien'=>trim($data[3]),
                    'region'=>trim($data[4]),
                    'loyer'=>trim($data[5]),
                    'numero'=>trim($data[6])
                 
                    
                );
                $this->db->insert('temporary_bien',$d);
                
            }
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return $this->db->error()['message'];
            }else{
                $insert_function = "import_bonne()";     
                if($this->db->query( 'SELECT ' .$insert_function)){
                    $this->db->trans_commit();
                }else{
                    $this->db->trans_rollback();
                    return $this->db->error()['message'];
                }

            }
        }

        //manadio base de donner
        public function clear_database()
        {
            $tables = [
                'proprio','type_bien','bien'
            ];
            $this->db->trans_off();
            foreach( $tables as $table ){
                $this->db->query('truncate table '.$table.' restart identity cascade');
                // sleep(1);
            }
        }


        // export pdf milay be
        
    }