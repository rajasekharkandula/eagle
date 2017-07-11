<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('home_model');
	}
	function index()
	{
		if($this->session->userdata("logged_in") == true){
			if($this->session->userdata("role_name") == $this->config->item("admin_role"))
				redirect('admin');
			if($this->session->userdata("role_name") == $this->config->item("manager_role"))
				redirect('manager');
			if($this->session->userdata("role_name") == $this->config->item("trainer_role"))
				redirect('trainer');
			if($this->session->userdata("role_name") == $this->config->item("user_role"))
				redirect('user');
		}
		
		$data = array();$pageData = array();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$this->load->view('home/login',$data);
	}
	function login(){
		echo json_encode($this->home_model->login($this->input->post('email'),$this->input->post('password')));
	}
	function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */