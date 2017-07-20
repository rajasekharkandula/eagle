<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
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
		$data['reports'] = $this->admin_model->get_dashboard(array('type'=>'USER'));
		$data['courses'] = $this->admin_model->get_course(array('type'=>'RECENT'));
		$data['assessments'] = $this->admin_model->get_assessment(array('type'=>'RECENT'));
		//var_dump($data['reports']);exit();
		$this->load->view('user/dashboard',$data);
	}
	function mycourses()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['courses'] = $this->admin_model->get_course(array('type'=>'MYCOURSES','user_id'=>$this->session->userdata('user_id')));		
		$this->load->view('user/mycourses',$data);
	}
	function recommended()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['courses'] = $this->admin_model->get_course(array('type'=>'RECOMMENDED','user_id'=>$this->session->userdata('user_id')));
		$this->load->view('user/recommended',$data);
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */