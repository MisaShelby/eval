<?php

    class Import_etape extends CI_Model{
        public function get_personne(){
            return $this->db->get('type_bien')->result();
        }
        public function import_into_temporary_table( $datas ){
            
            $query = "delete from temporary_type";
            $this->db->query($query);
            $this->db->trans_begin();
            foreach( $datas as $data ){
                $d2 = str_replace('%', '', trim($data[1]));
                $d2=str_replace(',','.',$d2);
                

                $d = array(
                    'nom_bien'=>trim($data[0]),
                    'comission'=>trim($d2)
                  
                    
                );
                $this->db->insert('temporary_type',$d);
                
            }
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return $this->db->error()['message'];
            }else{
                $insert_function = "import_type_comission()";     
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
                'type_bien'
            ];
            $this->db->trans_off();
            foreach( $tables as $table ){
                $this->db->query('truncate table '.$table.' restart identity cascade');
                // sleep(1);
            }
        }


        // export pdf milay be
        
    }