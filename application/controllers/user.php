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
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$this->load->view('user/dashboard',$data);
	}
	function mycourses()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
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
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['courses'] = $this->admin_model->get_course(array('type'=>'RECOMMENDED','user_id'=>$this->session->userdata('user_id')));
		$this->load->view('user/recommended',$data);
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */