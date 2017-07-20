<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manager extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('manager_model');
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
		$data['reports'] = $this->admin_model->get_dashboard(array('type'=>'MANAGER'));
		$this->load->view('manager/dashboard',$data);
	}
	function users()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['users'] = $this->admin_model->get_user(array('type'=>'MANAGER_TEAM','id'=>$this->session->userdata('user_id')));
		$this->load->view('manager/users',$data);
	}
	function trainers()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['users'] = $this->admin_model->get_user(array('type'=>'TRAINERS'));
		//var_dump($data['users']);exit();
		$this->load->view('manager/trainers',$data);
	}
	
	function course_search(){
		$search=array(
			'type'=>'SEARCH',
			'categories'=>$this->input->post('categories'),
			'searchkey'=>$this->input->post('searchkey')
		);
		echo json_encode($this->admin_model->get_course($search));
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */