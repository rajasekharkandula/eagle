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
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$this->load->view('manager/dashboard',$data);
	}
	function users()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'TEAM';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['users'] = $this->admin_model->get_user(array('type'=>'MANAGER_TEAM','id'=>$this->session->userdata('user_id')));
		$this->load->view('manager/users',$data);
	}
	function userview($id)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'TEAM';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['user'] = $this->admin_model->get_user(array('type'=>'S','id'=>$id));
		$this->load->view('manager/userview',$data);
	}
	function courses(){
		$pageData['page'] = 'TEAM';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['courses'] = $this->admin_model->get_course(array('type'=>'COURSES'));
		$data['course_cat'] = $this->admin_model->get_course_category(array('type'=>'ALL'));
		$this->load->view('manager/courses',$data);
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