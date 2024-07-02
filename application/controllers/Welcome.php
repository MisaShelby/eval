<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Location_model');
		
    }

	public function index()
	{
		$this->load->view('login_proprio');
		// $this->load->view('ProfilRequis');
		// $this->load->view('Footer');
	}
	public function index_client()
	{
		$this->load->view('login_client');
		// $this->load->view('ProfilRequis');
		// $this->load->view('Footer');
	}
	public function index_admin()
	{
		$this->load->view('login_form');
		// $this->load->view('ProfilRequis');
		// $this->load->view('Footer');
	}
	public function importation() {
        $this->load->view('importation');
		$this->load->view('templates/Header');
    }
	public function dropbase() {
        $this->load->view('Base');
		$this->load->view('templates/Header');
    }
	public function location() {
		
        
        $data['clients'] = $this->Location_model->get_clients();
        $data['biens'] = $this->Location_model->get_biens();
		$this->load->view('templates/Header');
        $this->load->view('ajout_location.php',$data);
    }
	
	public function index2()
	{
		$this->load->view('HeaderClient');
		$this->load->view('AccueilClient');
		$this->load->view('Footer');
	}
}