<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct(){
		parent::__construct();
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
		$this->load->view('admin/dashboard',$data);
	}
	
	function designations()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['designations'] = $this->admin_model->get_designation(array('type'=>'ALL'));
		$this->load->view('admin/manage/designations',$data);
	}
	function designation($id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['designation'] = $this->admin_model->get_designation(array('type'=>'S','id'=>$id));
		$this->load->view('admin/manage/designation',$data);
	}
	
	function skills()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['skills'] = $this->admin_model->get_skill(array('type'=>'ALL'));
		$this->load->view('admin/manage/skills',$data);
	}
	function skill($id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['skill'] = $this->admin_model->get_skill(array('type'=>'S','id'=>$id));
		$this->load->view('admin/manage/skill',$data);
	}
	
	function users()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['users'] = $this->admin_model->get_user(array('type'=>'ALL'));
		$this->load->view('admin/manage/users',$data);
	}
	function user($id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$data['id'] = $id;
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['user'] = $this->admin_model->get_user(array('type'=>'S','id'=>$id));
		$data['roles'] = $this->admin_model->get_role(array('type'=>'ALL'));
		$data['designations'] = $this->admin_model->get_designation(array('type'=>'ALL'));
		$data['managers'] = $this->admin_model->get_user(array('type'=>'MANAGERS'));
		$this->load->view('admin/manage/user',$data);
	}
	
	function course_categories()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['categories'] = $this->admin_model->get_course_category(array('type'=>'ALL'));
		$this->load->view('admin/course/categories',$data);
	}
	function course_category($id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['category'] = $this->admin_model->get_course_category(array('type'=>'S','id'=>$id));
		$this->load->view('admin/course/category',$data);
	}
	
	function courses()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['courses'] = $this->admin_model->get_course(array('type'=>'ALL'));
		$this->load->view('admin/course/courses',$data);
	}
	function course($page='basic',$id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$data['page'] = $page;
		$data['id'] = $id;
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['sidebar'] = $this->load->view('admin/course/course_sidebar',$data,true);
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S','id'=>$id));
		$data['categories'] = $this->admin_model->get_course_category(array('type'=>'ALL'));
		if($page == 'basic'){
			$this->load->view('admin/course/course_basic',$data);
		}elseif($page == 'overview' && $course){
			$this->load->view('admin/course/course_overview',$data);
		}elseif($page == 'publish' && $course){
			$this->load->view('admin/course/course_publish',$data);
		}else{
			echo 'Invalid URL';
		}
		
	}
	function elearning($page='basic',$id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$data['page'] = $page;
		$data['id'] = $id;
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['sidebar'] = $this->load->view('admin/elearning/sidebar',$data,true);
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S_P','id'=>$id));
		
		if($page == 'basic' && $course){
			$data['trainers'] = $this->admin_model->get_user(array('type'=>'TRAINERS'));
			$data['elearning'] = $this->admin_model->get_elearning(array('type'=>'S','id'=>$id));
			$trainers = $this->admin_model->get_elearning(array('type'=>'TRAINERS','id'=>$id));
			$st = array();foreach($trainers as $t)array_push($st,$t->id);
			$data['selected_trainers'] = $st;
			$this->load->view('admin/elearning/basic',$data);
		}elseif($page == 'content' && $course){
			$this->load->view('admin/elearning/content',$data);
		}elseif($page == 'publish' && $course){
			$this->load->view('admin/elearning/publish',$data);
		}else{
			echo 'Invalid URL';
		}
		
	}
	public function upload_files($type){
		$file = $_FILES['files'];
		$uploaddir = '';
		
		if($type == 'image')
			$uploaddir = $this->config->item('upload_img');
		else if($type == 'audio')
			$uploaddir = $this->config->item('upload_audio');
		else if($type == 'video')
			$uploaddir = $this->config->item('upload_video');
		else if($type == 'document')
			$uploaddir = $this->config->item('upload_document');
		else if($type == 'scorm')
			$uploaddir = $this->config->item('upload_scorm');			
		
		echo json_encode($this->admin_model->upload_file($file, $uploaddir));
	}
	function ins_upd_user(){
		echo json_encode($this->admin_model->ins_upd_user());
	}
	function ins_upd_designation(){
		echo json_encode($this->admin_model->ins_upd_designation());
	}
	function ins_upd_skill(){
		echo json_encode($this->admin_model->ins_upd_skill());
	}
	function ins_upd_course_category(){
		echo json_encode($this->admin_model->ins_upd_course_category());
	}
	function ins_upd_course(){
		echo json_encode($this->admin_model->ins_upd_course());
	}
	function ins_upd_elearning(){
		echo json_encode($this->admin_model->ins_upd_elearning());
	}
	
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */