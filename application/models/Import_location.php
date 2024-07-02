<?php

    class Import_location extends CI_Model{
        public function get_personne(){
            return $this->db->get('location')->result();
        }
        public function import_into_temporary_table( $datas ){
            
            $query = "delete from temporary_location";
            $this->db->query($query);
            $this->db->trans_begin();
            foreach( $datas as $data ){
           
                

                $d = array(
                    'reference'=>trim($data[0]),
                    'date_debut'=>trim($data[1]),
                    'duree'=>trim($data[2]),
                    'email'=>trim($data[3]),
                  
                    
                );
                $this->db->insert('temporary_location',$d);
                
            }
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return $this->db->error()['message'];
            }else{
                $insert_function = "import_loca()";     
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
                'client','location'
            ];
            $this->db->trans_off();
            foreach( $tables as $table ){
                $this->db->query('truncate table '.$table.' restart identity cascade');
                // sleep(1);
            }
        }


        // export pdf milay be
        
    }