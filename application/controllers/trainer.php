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
	function requests(){
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$data['requests'] = $this->admin_model->get_assessment(array('type'=>'REQUESTS','user_id'=>$this->session->userdata('user_id')));
		//var_dump($data['requests']);exit();
		$this->load->view('trainer/assessment_requests',$data);
	}
	function evaluate($asmt_user_id=0){
		$pageData['page'] = 'COURSE';
		$pageData['data'] = $this->admin_model->get_header();
		$data['head'] = $this->load->view('templates/head',$pageData,true);
		$data['header'] = $this->load->view('templates/header',$pageData,true);
		$data['footer'] = $this->load->view('templates/footer',$pageData,true);
		$assessment = $this->admin_model->get_assessment(array('type'=>'ASMT_USER_ID','asmt_user_id'=>$asmt_user_id));
		if($assessment){
			$data['assessment'] = $assessment;
			$data['asmt_user_id'] = $asmt_user_id;
			$data['questions'] = $this->admin_model->get_assessment(array('type'=>'QLA','id'=>$assessment->id,'asmt_user_id'=>$asmt_user_id));			
			$data['options'] = $this->admin_model->get_assessment(array('type'=>'OL','id'=>$assessment->id,'asmt_user_id'=>$asmt_user_id));
			//var_dump($data['questions']);exit();
			$this->load->view('trainer/assessment_evaluation',$data);
		}
	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */