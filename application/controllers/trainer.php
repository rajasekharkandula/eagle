<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trainer extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('admin_model');
		
		if($this->session->userdata("logged_in") == false)
			redirect(base_url());
	}
	function index()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'DASHBOARD';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['reports'] = $this->admin_model->get_dashboard(array('type'=>'TRAINER'));
		//var_dump($data['reports']);exit();
		$this->load->view('trainer/dashboard',$data);
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */