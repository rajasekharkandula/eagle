<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('home_model');
		$this->load->model('admin_model');
	}
	function index()
	{
		if($this->session->userdata("logged_in") == true){
			if($this->session->userdata("role_name") == $this->config->item("admin_role"))
				redirect('admin');
			if($this->session->userdata("role_name") == $this->config->item("manager_role"))
				redirect('manager');
			if($this->session->userdata("role_name") == $this->config->item("trainer_role"))
				redirect('admin');
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
	
	function course_view($id=0){
		
		$pageData['page'] = 'COURSE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['reg_status'] = $this->admin_model->get_course(array('type'=>'REG_STATUS','id'=>$id,'user_id'=>$this->session->userdata('user_id')));
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S_P','id'=>$id));
		$data['elearning'] = $this->admin_model->get_elearning(array('type'=>'S','id'=>$id));
		$data['sections'] = $this->admin_model->get_elearning(array('type'=>'SECTIONS_LIST','id'=>$id));
		$data['chapters'] = $this->admin_model->get_elearning(array('type'=>'CHAPTERS_LIST','id'=>$id));
		if($course)
			$this->load->view('home/course/view',$data);
		else
			echo 'Invalid URL';
	}
	function course($id=0,$cid=0,$aid=0){
		
		$pageData['page'] = 'COURSE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$reg_status = $this->admin_model->get_course(array('type'=>'REG_STATUS','id'=>$id,'user_id'=>$this->session->userdata('user_id')));
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S_P','id'=>$id));
		$data['chapter'] = $chapter = $this->admin_model->get_elearning(array('type'=>'CHAPTER_PLAY','id'=>$id,'chapter_id'=>$cid));
		//var_dump($data['chapter']);exit();
		$data['sections'] = $this->admin_model->get_elearning(array('type'=>'SECTIONS_LIST','id'=>$id));
		$data['chapters'] = $this->admin_model->get_elearning(array('type'=>'CHAPTERS_LIST','id'=>$id));
		$data['assessments'] = $this->admin_model->get_elearning(array('type'=>'ASMT_LP','id'=>$id));
		$data['assessment'] = $this->admin_model->get_assessment(array('type'=>'S','id'=>$aid));
		if($data['assessment']){
			$data['questions'] = $this->admin_model->get_assessment(array('type'=>'QL','id'=>$aid));
			
			$data['options'] = $this->admin_model->get_assessment(array('type'=>'OL','id'=>$aid));
			$data['assessment_status'] = $this->admin_model->get_assessment(array('type'=>'STATUS','id'=>$aid,'user_id'=>$this->session->userdata("user_id")));
			//var_dump($data['assessment_status']);exit();
		}
		if($course && $reg_status && $chapter)
			$this->load->view('home/course/play',$data);
		else
			echo 'Invalid URL';
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */