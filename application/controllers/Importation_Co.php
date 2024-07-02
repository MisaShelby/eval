<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importation_Co extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PersonneModel', 'pers');
        $this->load->model('Import_etape', 'etap');
        $this->load->model('Import_location', 'loc');
    }
	public function index()
	{
		$this->load->view('login_form');
		
	}
    public function all_pers(){
        $data['bien']=$this->pers->get_personne();
        $this->load->view('liste',$data);
    }
  
    
    //duree
    public function duree(){
        $this->load->view('calculduree');
    }
    
    public function traitement(){
        
    }
    public function drop_data(){
        $this->pers->clear_database();
        redirect(site_url('Importation_Co/all_pers'));
    }
    // public function import( $errors = [] , $success = '' ){
    //     //
    //     $data['view'] = 'welcome_message';
    //     if( count($errors) > 0 ){
    //         $data['errors'] = $errors;
    //     }
    //     else if( $success != '' ){
    //         $data['success'] = $success;
    //     }
    //     $this->render($data);
    // }

    
    public function upload(){
        $file = $_FILES['personne'];
        $readed_file = fopen($file['tmp_name'], 'r');
        $header = fgetcsv($readed_file);
        $datas = [];
        $errors = [];
        $ligne = 0;
        $success = '';
        while ($line = fgetcsv($readed_file)) {
            
            $ligne = $ligne + 1;
            try {

                // $this->maison->validate_line( $line );
                $datas[] = $line;
                var_dump($line);

            } catch (Exception $e) {
                $errors[] = "Une erreur s'est produite à la ligne " . $ligne ." : " . $e->getMessage();
            }
        }

        if( count($errors) == 0 ){
            $success = 'Import réussi';
            $response = $this->pers->import_into_temporary_table( $datas );
            if( $response != NULL && $response != '' ){
                $errors[] = $response;
                var_dump( $errors );
                $success = '';
            }

        }
        
        // $this->import( $errors, $success );

    }
    




    public function all_pers1(){
        $data['type_bien']=$this->etap->get_personne();
        $this->load->view('liste1',$data);
    }
  
    
    //duree
    public function duree1(){
        $this->load->view('calculduree');
    }
    
  
    public function drop_data1(){
        $this->etap->clear_database();
        redirect(site_url('Importation_Co/all_pers'));
    }
    // public function import( $errors = [] , $success = '' ){
    //     //
    //     $data['view'] = 'welcome_message';
    //     if( count($errors) > 0 ){
    //         $data['errors'] = $errors;
    //     }
    //     else if( $success != '' ){
    //         $data['success'] = $success;
    //     }
    //     $this->render($data);
    // }

    
    public function upload1(){
        $file = $_FILES['itapy'];//anaty view ito
        $readed_file = fopen($file['tmp_name'], 'r');
        $header = fgetcsv($readed_file);
        $datas = [];
        $errors = [];
        $ligne = 0;
        $success = '';
        while ($line = fgetcsv($readed_file)) {
            
            $ligne = $ligne + 1;
            try {

                // $this->maison->validate_line( $line );
                $datas[] = $line;
                var_dump($line);

            } catch (Exception $e) {
                $errors[] = "Une erreur s'est produite à la ligne " . $ligne ." : " . $e->getMessage();
            }
        }

        if( count($errors) == 0 ){
            $success = 'Import réussi';
            $response = $this->etap->import_into_temporary_table( $datas );
            if( $response != NULL && $response != '' ){
                $errors[] = $response;
                var_dump( $errors );
                $success = '';
            }

        }
        
        // $this->import( $errors, $success );

    }





    
    public function all_pers2(){
        $data['location']=$this->loc->get_personne();
        $this->load->view('liste1',$data);
    }
  
    
    //duree
    public function duree2(){
        $this->load->view('calculduree');
    }
    
  
    public function drop_data2(){
        $this->loc->clear_database();
        redirect(site_url('Importation_Co/all_pers'));
    }
    // public function import( $errors = [] , $success = '' ){
    //     //
    //     $data['view'] = 'welcome_message';
    //     if( count($errors) > 0 ){
    //         $data['errors'] = $errors;
    //     }
    //     else if( $success != '' ){
    //         $data['success'] = $success;
    //     }
    //     $this->render($data);
    // }

    
    public function upload2(){
        $file = $_FILES['loca'];//anaty view ito
        $readed_file = fopen($file['tmp_name'], 'r');
        $header = fgetcsv($readed_file);
        $datas = [];
        $errors = [];
        $ligne = 0;
        $success = '';
        while ($line = fgetcsv($readed_file)) {
            
            $ligne = $ligne + 1;
            try {

                // $this->maison->validate_line( $line );
                $datas[] = $line;
                var_dump($line);

            } catch (Exception $e) {
                $errors[] = "Une erreur s'est produite à la ligne " . $ligne ." : " . $e->getMessage();
            }
        }

        if( count($errors) == 0 ){
            $success = 'Import réussi';
            $response = $this->loc->import_into_temporary_table( $datas );
            if( $response != NULL && $response != '' ){
                $errors[] = $response;
                var_dump( $errors );
                $success = '';
            }

        }
        
        // $this->import( $errors, $success );

    }

}

