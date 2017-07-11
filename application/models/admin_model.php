<?php
	
class Admin_model extends CI_Model{
		
	public function __construct(){
		parent::__construct();
		$this->db->query("SET SESSION time_zone = '+05:30'");
		$this->user_id = $this->session->userdata("user_id");
		$this->entity_id = $this->session->userdata("entity_id");
	}
	
	function get_user($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'ALL'){
			return $this->db->query("SELECT * FROM tbl_user")->result();
		}
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_user WHERE id = $id")->row();
		}
		if($type == 'MANAGERS'){
			return $this->db->query("SELECT * FROM tbl_user u INNER JOIN tbl_role r ON r.id = u.role_id WHERE r.name = '".$this->config->item('manager_role')."'")->result();
		}
		if($type == 'TRAINERS'){
			return $this->db->query("SELECT * FROM tbl_user u INNER JOIN tbl_role r ON r.id = u.role_id WHERE r.name = '".$this->config->item('trainer_role')."'")->result();
		}
		
	}
	function ins_upd_user(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$first_name = (string)$this->input->post('first_name');
		$last_name = (string)$this->input->post('last_name');
		$user_image = (string)$this->input->post('user_image');
		$username = (string)$this->input->post('username');
		$password = (string)$this->input->post('password');
		$email = (string)$this->input->post('email');
		$phone = (string)$this->input->post('phone');
		$user_role = $this->input->post('user_role');
		$designation = (int)$this->input->post('designation');
		$manager_id = (int)$this->input->post('manager_id');
		
		$user_image = file_exists($user_image) ? $user_image : $this->config->item('default_user_img');
		
		if($type == 'INSERT'){			
			$user = $this->db->query("SELECT * FROM tbl_user WHERE username = '$username' OR email = '$email'")->row();
			if($user){
				if($user->username == $username)
					$return['message'] = 'Username already exists';
				if($user->email == $email)
					$return['message'] = 'Username already exists';
				return $return;
			}
			$this->db->query("INSERT INTO tbl_user (entity_id, first_name, last_name, username, email, password, image, role_id, designation, manager_id, created_by, updated_by, created_date, updated_date, status) VALUES ($this->entity_id, '$first_name', '$last_name', '$username', '$email', '$password', '$user_image', $user_role, $designation, $manager_id, $this->user_id, $this->user_id, NOW(), NOW(), 'Active'); ");
			$return['status'] = true;
			$return['message'] = 'User created successfully';
		}
		if($type == 'UPDATE'){			
			$user = $this->db->query("SELECT * FROM tbl_user WHERE (username = '$username' OR email = '$email') AND id != $id")->row();
			if($user){
				if($user->username == $username)
					$return['message'] = 'Username already exists';
				if($user->email == $email)
					$return['message'] = 'Username already exists';
				return $return;
			}
			$this->db->query("UPDATE tbl_user SET first_name = '$first_name', last_name = '$last_name', username = '$username', email = '$email', image = '$user_image', role_id = $user_role, designation = '$designation', manager_id = $manager_id, updated_by = $this->user_id, updated_date = NOW() WHERE id = $id");
			
			if($password != ''){
				$this->db->query("UPDATE tbl_user SET password = '$password' WHERE id = $id");
			}
			
			$return['status'] = true;
			$return['message'] = 'User updated successfully';
		}
		return $return;
	}
	
	function get_role($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'ALL'){
			return $this->db->query("SELECT * FROM tbl_role")->result();
		}		
	}
	
	function get_designation($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'ALL'){
			return $this->db->query("SELECT * FROM tbl_designation")->result();
		}
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_designation WHERE id = $id")->row();
		}		
	}
	function ins_upd_designation(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$name = (string)$this->input->post('name');
		
		if($type == 'INSERT'){			
			$this->db->query("INSERT INTO tbl_designation (name, entity_id, created_by, created_date, status) VALUES ('$name', $this->entity_id, $this->user_id, NOW(), 'Active'); ");
			$return['status'] = true;
			$return['message'] = 'Designation created successfully';
		}
		if($type == 'UPDATE'){			
			$this->db->query("UPDATE tbl_designation SET name = '$name', created_by = $this->user_id, created_date = NOW() WHERE id = $id");
			
			$return['status'] = true;
			$return['message'] = 'Designation updated successfully';
		}
		return $return;
	}
	function get_skill($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'ALL'){
			return $this->db->query("SELECT * FROM tbl_skill")->result();
		}
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_skill WHERE id = $id")->row();
		}	
		
	}
	function ins_upd_skill(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$name = (string)$this->input->post('name');
		
		if($type == 'INSERT'){			
			$this->db->query("INSERT INTO tbl_skill (name, entity_id, created_by, created_date, status) VALUES ('$name', $this->entity_id, $this->user_id, NOW(), 'Active'); ");
			$return['status'] = true;
			$return['message'] = 'Skill created successfully';
		}
		if($type == 'UPDATE'){			
			$this->db->query("UPDATE tbl_skill SET name = '$name', created_by = $this->user_id, created_date = NOW() WHERE id = $id");			
			$return['status'] = true;
			$return['message'] = 'Skill updated successfully';
		}
		return $return;
	}
	function get_course_category($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'ALL'){
			return $this->db->query("SELECT * FROM tbl_course_category")->result();
		}
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_course_category WHERE id = $id")->row();
		}		
	}
	function ins_upd_course_category(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$name = (string)$this->input->post('name');
		
		if($type == 'INSERT'){			
			$this->db->query("INSERT INTO tbl_course_category (name, entity_id, created_by, created_date, status) VALUES ('$name', $this->entity_id, $this->user_id, NOW(), 'Active'); ");
			$return['status'] = true;
			$return['message'] = 'Course category created successfully';
		}
		if($type == 'UPDATE'){			
			$this->db->query("UPDATE tbl_course_category SET name = '$name', created_by = $this->user_id, created_date = NOW() WHERE id = $id");			
			$return['status'] = true;
			$return['message'] = 'Course category updated successfully';
		}
		return $return;
	}
	function get_course($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'ALL'){
			return $this->db->query("SELECT c.*,cc.name as category_name FROM tbl_course c INNER JOIN tbl_course_category cc ON cc.id = c.category_id")->result();
		}
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_course WHERE id = $id")->row();
		}
		if($type == 'S_P'){
			return $this->db->query("SELECT p.*,c.name as category_name FROM tbl_course_published p INNER JOIN tbl_course_category c ON c.id=p.category_id WHERE p.id = $id")->row();
		}		
	}
	function ins_upd_course(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$name = (string)$this->input->post('name');
		$category_id = (int)$this->input->post('category_id');
		$image = (string)$this->input->post('image');
		$overview = (string)$this->input->post('overview');
		$faq = (string)$this->input->post('faq');
		$benefits = (string)$this->input->post('benefits');
		$prerequisite = (string)$this->input->post('prerequisite');
		$features = (array)$this->input->post('features');
		$features = json_encode($features);
		
		$image = file_exists($image) ? $image : $this->config->item('default_img');
		
		if($type == 'INSERT_BASIC'){			
			$this->db->query("INSERT INTO tbl_course (entity_id, name, category_id, image, created_by, updated_by, created_date, updated_date, status) VALUES ($this->entity_id, '$name', $category_id, '$image', $this->user_id, $this->user_id, NOW(), NOW(), 'Saved')");
			$return['status'] = true;
			$return['id'] = $this->db->query("SELECT MAX(id) AS id FROM tbl_course")->row()->id;
			$return['message'] = 'Course created successfully';
		}
		if($type == 'UPDATE_BASIC'){			
			$this->db->query("UPDATE tbl_course SET name = '$name', category_id = $category_id, image = '$image', created_by = $this->user_id, updated_by = $this->user_id, created_date = NOW(), updated_date = NOW(), status = 'Saved' WHERE id = $id");			
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Course updated successfully';
		}
		if($type == 'UPDATE_OVERVIEW'){			
			$this->db->query("UPDATE tbl_course SET overview = '$overview', faq = '$faq', benefits = '$benefits', features = '$features', prerequisite = '$prerequisite', created_by = $this->user_id, updated_by = $this->user_id, created_date = NOW(), updated_date = NOW(), status = 'Saved' WHERE id = $id");			
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Course updated successfully';
		}
		if($type == 'PUBLISH'){
			$this->db->query("DELETE FROM tbl_course_published WHERE id = $id");
			$this->db->query("INSERT INTO tbl_course_published SELECT * FROM tbl_course WHERE id = $id");			
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Course published successfully';
		}
		return $return;
	}
	function get_elearning($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_elearning WHERE id = $id")->row();
		}
		if($type == 'TRAINERS'){
			return $this->db->query("SELECT u.* FROM tbl_user u INNER JOIN tbl_elearning_trainers t ON u.id=t.user_id WHERE t.course_id = $id")->result();
		}		
	}
	function ins_upd_elearning(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$trainers = (array)$this->input->post('trainers');
		$promo_content_type = (string)$this->input->post('content_type');
		$promo_content_file = (string)$this->input->post('content_file');
		$promo_content_url = (string)$this->input->post('content_url');
		
		if($type == 'INSERT_UPDATE'){			
			$course = $this->db->query("SELECT * FROM tbl_elearning WHERE id = $id")->row();
			if($course){
				$this->db->query("UPDATE tbl_elearning SET promo_content_type = '$promo_content_type', promo_content_file = '$promo_content_file', promo_content_url = '$promo_content_url', updated_by = $this->user_id, updated_date = NOW(), status = 'Saved' WHERE id = $id");
			}else{
				$this->db->query("INSERT INTO tbl_elearning (id, promo_content_type, promo_content_file, promo_content_url, created_by, updated_by, created_date, updated_date, status) VALUES ($id, '$promo_content_type', '$promo_content_file', '$promo_content_url', $this->user_id, $this->user_id, NOW(), NOW(), 'Saved')");
			}
			
			$this->db->query("DELETE FROM tbl_elearning_trainers WHERE id = $id");
			foreach($trainers as $t){
				$this->db->query("INSERT INTO tbl_elearning_trainers (course_id, user_id) VALUES ($id, $t)");
			}
			
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Elearning course saved successfully';
		}
		
		if($type == 'PUBLISH'){
			$this->db->query("DELETE FROM tbl_course_published WHERE id = $id");
			$this->db->query("INSERT INTO tbl_course_published SELECT * FROM tbl_course WHERE id = $id");			
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Course published successfully';
		}
		return $return;
	}
	
	/**
 * Method upload_file for uploading files into server
 * @param object
 * @return string
 **/
		public function upload_file($file, $uploaddir=''){
			$return['status'] = false;
			$return['message'] = 'Failed';
			
			$user_id = $this->session->userdata("user_id");
			
			if(!isset($file["name"])){
				$return['message'] = 'No file found';
				return $return;
			}
			$temp = explode(".", $file["name"]);
			$extension = end($temp);
			if($uploaddir==''){$uploaddir = $this->config->item('upload_path');}
				if(!is_dir($uploaddir)) {mkdir($uploaddir,0777);}
			$path = $uploaddir.date('Ymdhis').'_'.$user_id.'.'.$extension;
			
			if(move_uploaded_file($file["tmp_name"],$path)){
				$return['status'] = true;
				$return['message'] = 'Success';
				$return['path'] = $path;
			}
			else{
				$path= 'Failed: File cant move';
			}
			
			return $return;
		}
	
}
?>