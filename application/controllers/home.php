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
				redirect('trainer');
			if($this->session->userdata("role_name") == $this->config->item("user_role"))
				redirect('user');
		}
		
		$data = array();$pageData = array();
		$pageData['data'] = $this->admin_model->get_header();
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

	function profile($id=0){
		$data = array();$pageData = array();
		$pageData['page'] = '';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		if($id == 0)$id = $this->session->userdata('user_id');
		$data['user'] = $user = $this->admin_model->get_user(array('type'=>'S','id'=>$id));
		if($user){
			$data['courses'] = $this->admin_model->get_course(array('type'=>'USERALL','user_id'=>$id));
			$data['ongoing'] = $this->admin_model->get_course(array('type'=>'ONGOING','user_id'=>$id));
			$data['completed'] = $this->admin_model->get_course(array('type'=>'COMPLETED','user_id'=>$id));
			$data['assessments'] = $this->admin_model->get_assessment(array('type'=>'USERALL','user_id'=>$id));
			//var_dump($data['assessments']);exit();
			$this->load->view('home/profile',$data);
		}else{
			echo 'Invalid URL';
		}
	}
	function changepassword(){
		$data = array();$pageData = array();
		$pageData['page'] = '';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['user'] = $this->admin_model->get_user(array('type'=>'S','id'=>$this->session->userdata('user_id')));
		$this->load->view('home/changepassword',$data);
	}

	
	function course_view($id=0){
		
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$reg_sessions = $this->admin_model->get_course(array('type'=>'REG_STATUS','id'=>$id,'user_id'=>$this->session->userdata('user_id')));
		$rs = array();foreach($reg_sessions as $s)array_push($rs,$s->session_id);
		$data['reg_sessions'] = $rs;
		
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S_P','id'=>$id));
		$data['sections'] = $this->admin_model->get_course(array('type'=>'SECTIONS_LIST','id'=>$id));
		$data['chapters'] = $this->admin_model->get_course(array('type'=>'CHAPTERS_LIST','id'=>$id));
		$data['sessions'] = $this->admin_model->get_course(array('type'=>'SESSIONS','id'=>$id));
		if($course)
			$this->load->view('home/course/view',$data);
		else
			echo 'Invalid URL';
	}
	function course($id=0,$cid=0,$aid=0){
		
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$reg_status = $this->admin_model->get_course(array('type'=>'REG_STATUS','id'=>$id,'user_id'=>$this->session->userdata('user_id')));
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S_P','id'=>$id));
		$data['chapter'] = $chapter = $this->admin_model->get_course(array('type'=>'CHAPTER_PLAY','id'=>$id,'chapter_id'=>$cid));
		//var_dump($data['chapter']);exit();
		$data['sections'] = $this->admin_model->get_course(array('type'=>'SECTIONS_LIST','id'=>$id));
		$data['chapters'] = $this->admin_model->get_course(array('type'=>'CHAPTERS_LIST','id'=>$id));
		$data['assessments'] = $this->admin_model->get_course(array('type'=>'ASMT_LP','id'=>$id));
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