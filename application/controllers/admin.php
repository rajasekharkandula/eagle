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
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['reports'] = $this->admin_model->get_dashboard(array('type'=>'HR'));
		$this->load->view('admin/dashboard',$data);
	}
	
	function designations()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$pageData['data'] = $this->admin_model->get_header();
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
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['designation'] = $this->admin_model->get_designation(array('type'=>'S','id'=>$id));
		$this->load->view('admin/manage/designation',$data);
	}
	
		function departments()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['departments'] = $this->admin_model->get_department(array('type'=>'ALL'));
		$this->load->view('admin/manage/departments',$data);
	}
	
	function department($id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['department'] = $this->admin_model->get_department(array('type'=>'S','id'=>$id));
		$this->load->view('admin/manage/department',$data);
	}
	
	function skills()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$pageData['data'] = $this->admin_model->get_header();
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
		$pageData['data'] = $this->admin_model->get_header();
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
		$pageData['data'] = $this->admin_model->get_header();
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
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['user'] = $this->admin_model->get_user(array('type'=>'S','id'=>$id));
		$data['roles'] = $this->admin_model->get_role(array('type'=>'ALL'));
		$data['designations'] = $this->admin_model->get_designation(array('type'=>'ALL'));
		$data['managers'] = $this->admin_model->get_user(array('type'=>'MANAGERS'));
		$this->load->view('admin/manage/user',$data);
	}
		
	function groups()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['groups'] = $this->admin_model->get_group(array('type'=>'ALL','user_id'=>$this->session->userdata('user_id')));		
		$this->load->view('admin/manage/groups',$data);
	}
	function group($id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'MANAGE';
		$data['id'] = $id;
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['group'] = $this->admin_model->get_group(array('type'=>'S','id'=>$id));
		$data['group_users'] = $this->admin_model->get_group(array('type'=>'GROUP_USERS','id'=>$id));
		//var_dump($data['group_users']);exit();
		$data['users'] = $this->admin_model->get_user(array('type'=>'ALL','id'=>$this->session->userdata('user_id')));
		$this->load->view('admin/manage/group',$data);
	}
	
	function course_categories()
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
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
		$pageData['data'] = $this->admin_model->get_header();
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
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		if($this->session->userdata('role_name') == $this->config->item('manager_role')){
			$data['courses'] = $this->admin_model->get_course(array('type'=>'COURSES'));
			$data['course_cat'] = $this->admin_model->get_course_category(array('type'=>'ALL'));
			$this->load->view('manager/courses',$data);
		}else{
			$data['courses'] = $this->admin_model->get_course(array('type'=>'ALL'));
			$this->load->view('admin/course/courses',$data);
		}
		
	}
	function course($page='basic',$id=0,$sid=0,$cid=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$data['page'] = $page;
		$data['section_id'] = $sid;
		$data['chapter_id'] = $cid;
		$data['id'] = $id;
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['sidebar'] = $this->load->view('admin/course/course_sidebar',$data,true);
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S','id'=>$id));
		$data['categories'] = $this->admin_model->get_course_category(array('type'=>'ALL'));
		if($page == 'basic'){
			$data['trainers'] = $this->admin_model->get_user(array('type'=>'TRAINERS'));
			$trainers = $this->admin_model->get_course(array('type'=>'TRAINERS','id'=>$id));
			$st = array();foreach($trainers as $t)array_push($st,$t->id);
			$data['selected_trainers'] = $st;
			$this->load->view('admin/course/course_basic',$data);
		}elseif($page == 'overview' && $course){
			$this->load->view('admin/course/course_overview',$data);
		}elseif($page == 'content' && $course){
			$data['sections'] = $this->admin_model->get_course(array('type'=>'SECTIONS','id'=>$id));
			$this->load->view('admin/course/course_sections',$data);
		}elseif($page == 'chapters' && $course){
			$data['chapters'] = $this->admin_model->get_course(array('type'=>'CHAPTERS','id'=>$id,'section_id'=>$sid));
			$this->load->view('admin/course/course_chapters',$data);
		}elseif($page == 'chapter' && $course){
			$data['assessments'] = $this->admin_model->get_assessment(array('type'=>'L'));
			$data['chapter'] = $this->admin_model->get_course(array('type'=>'CHAPTER','id'=>$id,'chapter_id'=>$cid));
			$assessments = $this->admin_model->get_course(array('type'=>'ASSESSMENTS','id'=>$id,'chapter_id'=>$cid));
			$sa = array();foreach($assessments as $a)array_push($sa,$a->assessment_id);
			$data['selected_asmts'] = $sa;
			//var_dump($data['selected_asmts']);exit();
			$this->load->view('admin/course/course_chapter',$data);
		}elseif($page == 'publish' && $course){
			$this->load->view('admin/course/course_publish',$data);
		}else{
			echo 'Invalid URL';
		}
		
	}
	function course_sessions($id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S','id'=>$id));
		$data['sessions'] = $this->admin_model->get_course(array('type'=>'SESSIONS','id'=>$id));
		if($course){
			$this->load->view('admin/course/sessions',$data);
		}else{
			echo 'Invalid URL';
		}
	}
	function course_session($id=0,$session_id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S','id'=>$id));
		$data['session'] = $this->admin_model->get_course(array('type'=>'SESSION','id'=>$id,'session_id'=>$session_id));
		if($course){
			$this->load->view('admin/course/session',$data);
		}else{
			echo 'Invalid URL';
		}
	}
	function assessments()
	{		
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['assessments'] = $this->admin_model->get_assessment(array('type'=>'L'));
		//var_dump($data['assessments']);exit();
		$this->load->view('admin/course/assessments',$data);
	}
	function assessment($page='basic',$id=0)
	{		
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['assessment'] = $assessment = $this->admin_model->get_assessment(array('type'=>'S','id'=>$id));
		if($page == 'basic'){
			$this->load->view('admin/course/assessment_basic',$data);
		}elseif($page=='questions' && $assessment){
			$data['questions'] = $this->admin_model->get_assessment(array('type'=>'QL','id'=>$id));
			$data['options'] = $this->admin_model->get_assessment(array('type'=>'OL','id'=>$id));
			$this->load->view('admin/course/assessment_questions',$data);
		}else{
			echo 'Invalid URL';
		}
	}
	function course_users($id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['users'] = $this->admin_model->get_course(array('type'=>'USERS','id'=>$id));
		$data['designations'] = $this->admin_model->get_course(array('type'=>'DESIGNATIONS','id'=>$id));
		$data['groups'] = $this->admin_model->get_course(array('type'=>'GROUPS','id'=>$id));
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S_P','id'=>$id));
		//var_dump($data['designations']);exit();
		if($course)
			$this->load->view('admin/course/users',$data);
		else
			echo 'Invalid URL';
	}
	function course_assign($id=0)
	{		
		$data = array();$pageData = array();
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['users'] = $this->admin_model->get_user(array('type'=>'ALL'));
		$data['course'] = $course = $this->admin_model->get_course(array('type'=>'S_P','id'=>$id));
		$data['users'] = $this->admin_model->get_user(array('type'=>'ALL','id'=>$this->session->userdata('user_id')));
		$data['groups'] = $this->admin_model->get_group(array('type'=>'ALL','user_id'=>$this->session->userdata('user_id')));
		$data['designations'] = $this->admin_model->get_designation(array('type'=>'ALL'));
		
		if($course)
			$this->load->view('admin/course/assign',$data);
		else
			echo 'Invalid URL';
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
	function ins_upd_department(){
		echo json_encode($this->admin_model->ins_upd_department());
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
	function ins_upd_group(){
		echo json_encode($this->admin_model->ins_upd_group());
	}
	function assign_course(){
		echo json_encode($this->admin_model->assign_course());
	}
	function ins_upd_assessment(){
		echo json_encode($this->admin_model->ins_upd_assessment());
	}
	function submit_assessment(){
		echo json_encode($this->admin_model->submit_assessment());
	}
	function course_registration(){
		echo json_encode($this->admin_model->course_registration());
	}
	function get_question_template(){
		$data['i'] = (int)$this->input->post('i') ? (int)$this->input->post('i') : 1;
		$data['qtype'] = $this->input->post('qtype');
		$data['marks'] = $this->input->post('marks');
		echo $this->load->view('admin/course/assessment_question_template',$data,true);
	}
	function get_user(){
		$data = array(
			'type'=>$this->input->post('type'),
			'id'=>$this->input->post('id'),
			'group_id'=>$this->input->post('group_id')
		);
		echo json_encode($this->admin_model->get_user($data));
	}
	function get_group(){
		$data = array(
			'type'=>$this->input->post('type'),
			'id'=>$this->input->post('id')
		);
		echo json_encode($this->admin_model->get_group($data));
	}
	function get_designation(){
		$data = array(
			'type'=>$this->input->post('type'),
			'id'=>$this->input->post('id')
		);
		echo json_encode($this->admin_model->get_designation($data));
	}
	
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */