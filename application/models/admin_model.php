<?php
	
class Admin_model extends CI_Model{
		
	public function __construct(){
		parent::__construct();
		$this->db->query("SET SESSION time_zone = '+05:30'");
		$this->user_id = (int)$this->session->userdata("user_id");
		$this->entity_id = (int)$this->session->userdata("entity_id");
	}
	public function remove_spl($string=''){
		return str_replace("'","\\'",str_replace("\\","\\\\",($string)));
	}
	function get_header(){
		$return['notifications'] = $this->db->query("SELECT * FROM tbl_notification WHERE user_id = $this->user_id ORDER BY created_date DESC LIMIT 5")->result();
		return $return;
	}
	function get_user($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'ALL'){
			return $this->db->query("SELECT u.*,r.name as role_name,d.name as designation FROM tbl_user u INNER JOIN tbl_role r ON r.id = u.role_id INNER JOIN tbl_designation d ON d.id = u.designation")->result();
		}
		if($type == 'S'){
			return $this->db->query("SELECT u.*, (select name from tbl_designation where id =u.designation limit 1 )as designation FROM tbl_user u WHERE u.id = $id")->row();
		}
		if($type == 'MANAGERS'){
			return $this->db->query("SELECT * FROM tbl_user u INNER JOIN tbl_role r ON r.id = u.role_id WHERE r.name = '".$this->config->item('manager_role')."'")->result();
		}
		if($type == 'TRAINERS'){
			return $this->db->query("SELECT u.*,d.name AS designation FROM tbl_user u INNER JOIN tbl_designation d ON d.id = u.designation INNER JOIN tbl_role r ON r.id = u.role_id WHERE r.name='".$this->config->item('trainer_role')."'")->result();
		}	

		if($type == 'MANAGER_TEAM'){
			return $this->db->query("SELECT u.*,d.name as designation FROM tbl_user u INNER JOIN tbl_designation d on d.id= u.designation WHERE u.manager_id = '".$id."'")->result();
		}
		if($type == 'USERVIEW'){
			return $this->db->query("SELECT * FROM tbl_user u INNER JOIN tbl_designation d on d.id= u.designation WHERE u.id = '".$id."'")->row();
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
		$uid = (string)$this->input->post('uid');
		$phone = (string)$this->input->post('phone');
		$user_role = $this->input->post('user_role');
		$designation = (int)$this->input->post('designation');
		$manager_id = (int)$this->input->post('manager_id');
		
		$user_image = file_exists($user_image) ? $user_image : $this->config->item('default_user_img');
		
		
		if($type == 'INSERT' || $type == 'UPDATE'){
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$return['message'] = 'Invalid Email';
				return $return;
			}
			if (strlen($password) < 5 && $password != '') {
				$return['message'] = 'Password must contain atleast 5 characters';
				return $return;
			}
		}
		
		if($type == 'INSERT'){			
			$user = $this->db->query("SELECT * FROM tbl_user WHERE username = '$username' OR email = '$email' OR uid = '$uid'")->row();
			if($user){
				if($user->username == $username)
					$return['message'] = 'Username already exists';
				if($user->email == $email)
					$return['message'] = 'Username already exists';
				if($user->uid == $uid)
					$return['message'] = 'Employee ID already exists';
				return $return;
			}
			$this->db->query("INSERT INTO tbl_user (entity_id, uid, first_name, last_name, username, email, password, image, role_id, designation, manager_id, created_by, updated_by, created_date, updated_date, status) VALUES ($this->entity_id, '$uid', '$first_name', '$last_name', '$username', '$email', '$password', '$user_image', $user_role, $designation, $manager_id, $this->user_id, $this->user_id, NOW(), NOW(), 'Active'); ");
			$return['status'] = true;
			$return['message'] = 'User created successfully';
		}
		if($type == 'UPDATE'){			
			$user = $this->db->query("SELECT * FROM tbl_user WHERE (username = '$username' OR email = '$email' OR uid = '$uid') AND id != $id")->row();
			if($user){
				if($user->username == $username)
					$return['message'] = 'Username already exists';
				if($user->email == $email)
					$return['message'] = 'Email already exists';
				if($user->uid == $uid)
					$return['message'] = 'Employee ID already exists';
				return $return;
			}
			$this->db->query("UPDATE tbl_user SET uid = '$uid', first_name = '$first_name', last_name = '$last_name', username = '$username', email = '$email', image = '$user_image', role_id = $user_role, designation = '$designation', manager_id = $manager_id, updated_by = $this->user_id, updated_date = NOW() WHERE id = $id");
			
			if($password != ''){
				$this->db->query("UPDATE tbl_user SET password = '$password' WHERE id = $id");
			}
			
			$return['status'] = true;
			$return['message'] = 'User updated successfully';
		}
		if($type == 'CHANGEPASSWORD'){
			$newpassword = (string)$this->input->post('newpassword');
			$password=$this->db->query("select * from tbl_user where id=$this->user_id and password='$password'")->row();
			if($password){
				$this->db->query("UPDATE tbl_user SET password = '$newpassword' WHERE id = $this->user_id");
				$return['status'] = true;
				$return['message'] = 'Password updated successfully';
			}else{
				$return['message'] = 'Current password incorrect';
			}
		}

		if($type == 'DELETE'){			
			$this->db->query("DELETE from tbl_user WHERE id = $id");
			
			$return['status'] = true;
			$return['message'] = 'User removed successfully';
		}
		if($type == 'UPDATE_PIC'){
			$file = $_FILES['image'];
			if(isset($file['name'])){
				$temp = explode(".", $file["name"]);
				$extension = end($temp);
				if(!in_array($extension,(array)$this->config->item('ext_img'))){
					$return['message']= 'Invalid extention';
					return $return;
				}
				$uploaddir = $this->config->item('upload_img');
				if(!is_dir($uploaddir)) {mkdir($uploaddir,0777);}
				$path = $uploaddir.date('Ymdhis').'_'.$this->user_id.'.'.$extension;
				
				if(move_uploaded_file($file["tmp_name"],$path)){
					$this->db->query("UPDATE tbl_user SET image = '$path' WHERE id = $this->user_id");
					$this->session->set_userdata('profile_pic',$path);
					$return['status'] = true;
					$return['message'] = 'Success';
					$return['path'] = $path;
				}
				else{
					$return['message']= 'Failed: File cant move';
				}
			}else{
				$return['message'] = 'Please try again later';
			}

		}
		
		return $return;
	}
	
	function get_group($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		$user_id = isset($data['user_id']) ? (int)$data['user_id'] : 0;
		
		if($type == 'ALL'){
			return $this->db->query("SELECT *,(SELECT COUNT(*) FROM tbl_group_users WHERE group_id = g.id) AS users FROM tbl_group g WHERE g.created_by = $user_id")->result();
		}
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_group WHERE id = $id")->row();
		}
		if($type == 'GROUP_USERS'){
			return $this->db->query("SELECT u.first_name,u.last_name,u.email,u.id,u.uid,d.name as designation FROM tbl_user u INNER JOIN tbl_designation d ON d.id = u.designation INNER JOIN tbl_group_users g ON g.user_id = u.id WHERE g.group_id = $id")->result();
		}		
	}
	function ins_upd_group(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$name = (string)$this->input->post('name');
		$users = (array)$this->input->post('users');
		
		if($type == 'INSERT'){			
			$this->db->query("INSERT INTO tbl_group (name, created_by, created_date, status) VALUES ('$name', $this->user_id, NOW(), 'Active'); ");
			$return['status'] = true;
			$return['id'] = $this->db->query("SELECT MAX(id) AS id FROM tbl_group")->row()->id;
			$return['message'] = 'Group created successfully';
		}
		if($type == 'UPDATE'){			
			$this->db->query("UPDATE tbl_group SET name = '$name', created_by = $this->user_id, created_date = NOW() WHERE id = $id");			
			$return['status'] = true;
			$return['message'] = 'Group updated successfully';
		}
		if($type == 'INSERT' || $type == 'UPDATE'){
			$this->db->query("DELETE FROM tbl_group_users WHERE group_id = $id");
			foreach($users as $u)
			$this->db->query("INSERT INTO tbl_group_users (user_id, group_id) VALUES ($u, $id)");
		}
		if($type == 'DELETE'){
			$this->db->query("DELETE from tbl_group WHERE id = $id");
			
			$return['status'] = true;
			$return['message'] = 'Group removed successfully';
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
		if($type == 'USERS'){
			return $this->db->query("SELECT u.first_name,u.last_name,u.email,u.id,u.uid,d.name as designation FROM tbl_user u INNER JOIN tbl_designation d ON d.id = u.designation WHERE d.id = $id")->result();
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
		if($type == 'DELETE'){			
			$this->db->query("DELETE from tbl_designation WHERE id = $id");
			
			$return['status'] = true;
			$return['message'] = 'User removed successfully';
		}
		return $return;
	}

	function get_department($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		
		if($type == 'ALL'){
			return $this->db->query("SELECT * FROM tbl_department")->result();
		}
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_department WHERE id = $id")->row();
		}		
	}
	
	function ins_upd_department(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$name = (string)$this->input->post('name');
		
		if($type == 'INSERT'){			
			$this->db->query("INSERT INTO tbl_department (name, entity_id, created_by, created_date, status) VALUES ('$name', $this->entity_id, $this->user_id, NOW(), 'Active'); ");
			$return['status'] = true;
			$return['message'] = 'Department created successfully';
		}
		if($type == 'UPDATE'){			
			$this->db->query("UPDATE tbl_department SET name = '$name', created_by = $this->user_id, created_date = NOW() WHERE id = $id");
			
			$return['status'] = true;
			$return['message'] = 'Department updated successfully';
		}
		
		if($type == 'DELETE'){			
			$this->db->query("DELETE from tbl_department WHERE id = $id");
			
			$return['status'] = true;
			$return['message'] = 'Department removed successfully';
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
		if($type == 'DELETE'){			
			$this->db->query("DELETE from tbl_skill WHERE id = $id");
			
			$return['status'] = true;
			$return['message'] = 'Skill removed successfully';
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

		$categories = isset($data['categories']) ? $data['categories'] : false;
		$searchkey = isset($data['searchkey']) ? $data['searchkey'] : '';
		$section_id = isset($data['section_id']) ? (int)$data['section_id'] : 0;
		$chapter_id = isset($data['chapter_id']) ? (int)$data['chapter_id'] : 0;
		$session_id = isset($data['session_id']) ? (int)$data['session_id'] : 0;

		$user_id = isset($data['user_id']) ? (int)$data['user_id'] : 0;

		
		if($type == 'ALL'){
			return $this->db->query("SELECT c.*,cc.name as category_name FROM tbl_course c INNER JOIN tbl_course_category cc ON cc.id = c.category_id WHERE c.created_by = $this->user_id")->result();
		}
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_course WHERE id = $id")->row();
		}
		if($type == 'S_P'){
			return $this->db->query("SELECT p.*,c.name as category_name FROM tbl_course_published p INNER JOIN tbl_course_category c ON c.id=p.category_id WHERE p.id = $id")->row();

		}
		if($type == 'COURSES'){
			return $this->db->query("SELECT cp.*,cc.name as category_name FROM tbl_course_published cp INNER JOIN tbl_course_category cc on cc.id=cp.category_id")->result();
		}
		if($type == 'SEARCH'){
			
			$query="SELECT cp.*,cc.name as category_name FROM tbl_course_published cp INNER JOIN tbl_course_category cc on cc.id=cp.category_id where cp.status='Saved' ";
			if($categories){
				$query.=" and cc.id in (" .implode(",",$categories) .")" ;
			}
			
			if($searchkey != "")
				$query.=" and cp.name like '%" .$searchkey ."%'";
			 
			return $this->db->query($query)->result();

		}	
		if($type == 'USERS'){
			return $this->db->query("SELECT u.first_name,u.last_name,u.email,u.id,u.uid,d.name as designation,cu.register_type,cu.course_type,cu.status as register_status,IF((SELECT COUNT(*) FROM tbl_course_session_users WHERE course_id = cu.course_id AND user_id = u.id AND end_date < NOW()),'Completed','Not completed') AS status FROM tbl_user u INNER JOIN tbl_designation d ON d.id = u.designation INNER JOIN tbl_course_users cu ON cu.user_id = u.id WHERE cu.course_id = $id")->result();
		}
		if($type == 'DESIGNATIONS'){
			return $this->db->query("SELECT d.*,(SELECT COUNT(*) FROM tbl_course_users WHERE designation_id = d.id) AS users FROM tbl_designation d INNER JOIN tbl_course_designations dc ON d.id = dc.designation_id WHERE dc.course_id = $id")->result();
		}
		if($type == 'GROUPS'){
			return $this->db->query("SELECT g.*,(SELECT COUNT(*) FROM tbl_course_users WHERE group_id = g.id) AS users FROM tbl_group g INNER JOIN tbl_course_groups gc ON g.id = gc.group_id WHERE gc.course_id = $id")->result();
		}
		if($type == 'MYCOURSES'){
			return $this->db->query("SELECT c.*,cc.name as category_name FROM tbl_course_published c INNER JOIN tbl_course_users cu ON cu.course_id = c.id INNER JOIN tbl_course_category cc ON cc.id = c.category_id WHERE cu.user_id = $user_id AND cu.status = 'Registered' ORDER BY cu.date_time DESC")->result();
		}
		if($type == 'RECOMMENDED'){
			return $this->db->query("SELECT c.*,cc.name as category_name FROM tbl_course_published c INNER JOIN tbl_course_users cu ON cu.course_id = c.id INNER JOIN tbl_course_category cc ON cc.id = c.category_id WHERE cu.user_id = $user_id AND cu.course_type = 'Recommended' ORDER BY cu.date_time DESC")->result();
		}
		if($type == 'REG_STATUS'){
			return $this->db->query("SELECT * FROM tbl_course_session_users WHERE user_id = $user_id AND course_id = $id AND status = 'Registered'")->result();
		}
		if($type == 'TRAINERS'){
			return $this->db->query("SELECT u.* FROM tbl_user u INNER JOIN tbl_course_trainers t ON u.id=t.user_id WHERE t.course_id = $id")->result();
		}
		if($type == 'SECTIONS'){
			return $this->db->query("SELECT s.*,(SELECT COUNT(*) FROM tbl_course_chapters WHERE section_id=s.id) AS chapters FROM tbl_course_sections s WHERE s.course_id = $id")->result();
		}
		if($type == 'CHAPTERS'){
			return $this->db->query("SELECT * FROM tbl_course_chapters WHERE section_id = $section_id")->result();
		}
		if($type == 'CHAPTER'){
			return $this->db->query("SELECT * FROM tbl_course_chapters WHERE id = $chapter_id")->row();
		}
		if($type == 'ASSESSMENTS'){
			return $this->db->query("SELECT * FROM tbl_course_assessments WHERE course_id = $id AND chapter_id = $chapter_id")->result();
		}
		if($type == 'SECTIONS_LIST'){
			return $this->db->query("SELECT * FROM tbl_course_sections_published WHERE course_id = $id")->result();
		}
		if($type == 'CHAPTERS_LIST'){
			return $this->db->query("SELECT * FROM tbl_course_chapters_published WHERE course_id = $id")->result();
		}
		if($type == 'SESSIONS'){
			return $this->db->query("SELECT * FROM tbl_course_sessions WHERE course_id = $id")->result();
		}
		if($type == 'SESSION'){
			return $this->db->query("SELECT * FROM tbl_course_sessions WHERE id = $session_id")->row();
		}
		if($type == 'CHAPTER_PLAY'){
			if($chapter_id)
				return $this->db->query("SELECT * FROM tbl_course_chapters_published WHERE id = $chapter_id AND course_id = $id")->row();
			else
				return $this->db->query("SELECT * FROM tbl_course_chapters_published WHERE course_id = $id")->row();
		}
		if($type == 'ASMT_LP'){
			return $this->db->query("SELECT a.*,ea.chapter_id FROM tbl_assessment a INNER JOIN tbl_course_assessments_published ea ON ea.assessment_id = a.id WHERE ea.course_id = $id")->result();
		}
		if($type == 'RECENT'){
			return $this->db->query("SELECT c.*,cu.date_time,IF((SELECT COUNT(*) FROM tbl_course_session_users WHERE course_id = c.id AND user_id = $this->user_id AND end_date < NOW()),'Completed','Not completed') AS status  FROM tbl_course_published c INNER JOIN tbl_course_users cu ON cu.course_id = c.id WHERE cu.user_id = $this->user_id ORDER BY cu.date_time DESC LIMIT 5")->result();
		}
		if($type == 'USERALL'){
			return $this->db->query("SELECT c.*,cu.course_type, IF((SELECT COUNT(*) FROM tbl_course_session_users WHERE course_id = c.id AND user_id = $user_id AND end_date < NOW()),'Completed','Not completed') AS status FROM tbl_course_published c INNER JOIN tbl_course_users cu ON cu.course_id = c.id WHERE cu.user_id = $user_id")->result();
		}
		if($type == 'ONGOING'){
			return $this->db->query("SELECT c.*,cu.course_type, csu.end_date FROM tbl_course_published c INNER JOIN tbl_course_users cu ON cu.course_id = c.id INNER JOIN tbl_course_session_users csu WHERE cu.user_id = $user_id AND csu.end_date >= NOW() GROUP BY csu.course_id")->result();
		}
		if($type == 'COMPLETED'){
			return $this->db->query("SELECT c.*, cu.course_type, csu.end_date FROM tbl_course_published c INNER JOIN tbl_course_users cu ON cu.course_id = c.id INNER JOIN tbl_course_session_users csu WHERE cu.user_id = $user_id AND csu.end_date < NOW() GROUP BY csu.course_id")->result();
		}
		
	}
	function ins_upd_course(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$name = (string)$this->input->post('name');
		$category_id = (int)$this->input->post('category_id');
		$image = (string)$this->input->post('image');
		$elearning = (int)$this->input->post('elearning');
		$overview = $this->remove_spl($this->input->post('overview'));
		$faq = $this->remove_spl($this->input->post('faq'));
		$benefits = $this->remove_spl($this->input->post('benefits'));
		$prerequisite = $this->remove_spl($this->input->post('prerequisite'));
		$features = (array)$this->input->post('features');
		$features = $this->remove_spl(json_encode($features));
		$trainers = (array)$this->input->post('trainers');
		$promo_content_type = (string)$this->input->post('content_type');
		$promo_content = (string)$this->input->post('promo_content');
		if($promo_content_type == 'URL')
			$promo_content = (string)$this->input->post('promo_content_url');
		$assessments = is_array($this->input->post('assessments')) ? $this->input->post('assessments') : array();
		$session_id = (int)$this->input->post('session_id');
		$image = file_exists($image) ? $image : $this->config->item('default_img');
		$eduration = (int)$this->config->item("elearning_duration");
		
		if($type == 'INSERT_BASIC'){			
			$this->db->query("INSERT INTO tbl_course (entity_id, name, category_id, image, elearning, eduration, promo_content_type, promo_content, created_by, updated_by, created_date, updated_date, status) VALUES ($this->entity_id, '$name', $category_id, '$image', $elearning, $eduration '$promo_content_type', '$promo_content', $this->user_id, $this->user_id, NOW(), NOW(), 'Saved')");
			$return['status'] = true;
			$return['id'] = $id = $this->db->query("SELECT MAX(id) AS id FROM tbl_course")->row()->id;
			$return['message'] = 'Course created successfully';
		}
		if($type == 'UPDATE_BASIC'){			
			$this->db->query("UPDATE tbl_course SET name = '$name', category_id = $category_id, image = '$image', elearning = '$elearning', eduration = $eduration, promo_content_type = '$promo_content_type', promo_content = '$promo_content', created_by = $this->user_id, updated_by = $this->user_id, created_date = NOW(), updated_date = NOW(), status = 'Saved' WHERE id = $id");			
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Course updated successfully';
		}
		if($type == 'INSERT_BASIC' || $type == 'UPDATE_BASIC'){
			$this->db->query("DELETE FROM tbl_course_trainers WHERE id = $id");
			foreach($trainers as $t){
				$this->db->query("INSERT INTO tbl_course_trainers (course_id, user_id) VALUES ($id, $t)");
			}
		}			
		if($type == 'UPDATE_OVERVIEW'){			
			$this->db->query("UPDATE tbl_course SET overview = '$overview', faq = '$faq', benefits = '$benefits', features = '$features', prerequisite = '$prerequisite', created_by = $this->user_id, updated_by = $this->user_id, created_date = NOW(), updated_date = NOW(), status = 'Saved' WHERE id = $id");			
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Course updated successfully';
		}
		if($type == 'SECTION'){
			$section_id = (int)$this->input->post('section_id');
			$section_name = (string)$this->input->post('section_name');
			$section = $this->db->query("SELECT * FROM tbl_course_sections WHERE id = $section_id")->row();
			if($section){
				$this->db->query("UPDATE tbl_course_sections SET name= '$section_name' WHERE id = $section_id");
				$return['status'] = true;
				$return['id'] = $id;
				$return['message'] = 'Course section updated successfully';
			}else{
				$this->db->query("INSERT INTO tbl_course_sections(name,course_id) VALUES ('$section_name',$id)");
				$return['status'] = true;
				$return['id'] = $id;
				$return['message'] = 'Course section created successfully';
			}
		}
		if($type == 'CHAPTER'){
			$section_id = (int)$this->input->post('section_id');
			$chapter_id = (int)$this->input->post('chapter_id');
			$chapter_name = (string)$this->input->post('chapter_name');
			$content_type = (string)$this->input->post('content_type');
			$content = $this->input->post('content');
			$section = $this->db->query("SELECT * FROM tbl_course_chapters WHERE id = $chapter_id")->row();
			if($section){
				$this->db->query("UPDATE tbl_course_chapters SET name= '$chapter_name',content_type= '$content_type' ,content= '$content' WHERE id = $chapter_id");
				$return['status'] = true;
				$return['id'] = $id;
				$return['message'] = 'Course chapter updated successfully';
			}else{
				$this->db->query("INSERT INTO tbl_course_chapters(name,course_id,section_id,content_type,content) VALUES ('$chapter_name',$id,$section_id,'$content_type','$content')");
				$chapter_id = $this->db->query("SELECT MAX(id) AS id FROM tbl_course_chapters")->row()->id;
				$return['status'] = true;
				$return['id'] = $id;
				$return['message'] = 'Course chapter created successfully';
			}
			$this->db->query("DELETE FROM tbl_course_assessments WHERE course_id = $id AND chapter_id = $chapter_id");
			foreach($assessments as $a){
				$this->db->query("INSERT INTO tbl_course_assessments(course_id,assessment_id,chapter_id) VALUES ($id,$a,$chapter_id)");
			}
		}
		if($type == 'PUBLISH'){
			
			//Basic Details
			$this->db->query("DELETE FROM tbl_course_published WHERE id = $id");
			$this->db->query("INSERT INTO tbl_course_published SELECT * FROM tbl_course WHERE id = $id");	
			
			//Trainers
			$this->db->query("DELETE FROM tbl_course_trainers_published WHERE course_id = $id");
			$this->db->query("INSERT INTO tbl_course_trainers_published SELECT * FROM tbl_course_trainers WHERE course_id = $id");
			
			//Sections
			$this->db->query("DELETE FROM tbl_course_sections_published WHERE course_id = $id");
			$this->db->query("INSERT INTO tbl_course_sections_published SELECT * FROM tbl_course_sections WHERE course_id = $id");
			
			//Chapters
			$this->db->query("DELETE FROM tbl_course_chapters_published WHERE course_id = $id");
			$this->db->query("INSERT INTO tbl_course_chapters_published SELECT * FROM tbl_course_chapters WHERE course_id = $id");			
			
			//Assessments
			$this->db->query("DELETE FROM tbl_course_assessments_published WHERE course_id = $id");
			$this->db->query("INSERT INTO tbl_course_assessments_published SELECT * FROM tbl_course_assessments WHERE course_id = $id");			
			
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Course published successfully';
		}
		if($type == 'SESSION_INSERT'){
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$this->db->query("INSERT INTO tbl_course_sessions (course_id, name, start_date, end_date) VALUES ($id, '$name', '$start_date','$end_date')");
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Course session created successfully';
		}
		if($type == 'SESSION_UPDATE'){
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$this->db->query("UPDATE tbl_course_sessions SET name = '$name', start_date = '$start_date', end_date = '$end_date' WHERE id = $session_id");
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Course session updated successfully';
		}	
		return $return;
	}
		
	function get_assessment($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$id = isset($data['id']) ? (int)$data['id'] : 0;
		$user_id = isset($data['user_id']) ? (int)$data['user_id'] : 0;
		
		if($type == 'S'){
			return $this->db->query("SELECT * FROM tbl_assessment WHERE id = $id")->row();
		}
		if($type == 'L'){
			return $this->db->query("SELECT *,(SELECT COUNT(*) FROM tbl_assessment_questions WHERE assessment_id = a.id) AS questions FROM tbl_assessment a WHERE created_by = $this->user_id")->result();
		}
		if($type == 'QL'){
			return $this->db->query("SELECT * FROM tbl_assessment_questions WHERE assessment_id = $id")->result();
		}
		if($type == 'OL'){
			return $this->db->query("SELECT * FROM tbl_assessment_options WHERE assessment_id = $id")->result();
		}
		if($type == 'STATUS'){
			return $this->db->query("SELECT SUM(s.points) AS marks,(SELECT SUM(marks) marks FROM tbl_assessment_questions WHERE assessment_id = s.assessment_id) AS total_marks FROM tbl_user_assessment_scores s WHERE s.assessment_id = $id AND s.user_id = $user_id")->row();
		}
		if($type == 'RECENT'){
			return $this->db->query("SELECT a.*,IF((SELECT COUNT(*) FROM tbl_user_assessment_scores WHERE assessment_id = ca.assessment_id AND course_id = ca.course_id AND user_id = $this->user_id),'Completed','Not Completed') AS status FROM tbl_assessment a INNER JOIN tbl_course_assessments ca ON ca.assessment_id = a.id INNER JOIN tbl_course_users cu ON ca.course_id = cu.course_id WHERE cu.user_id = $this->user_id LIMIT 5")->result();
		}
		if($type == 'USERALL'){
			return $this->db->query("SELECT a.*,IF((SELECT COUNT(*) FROM tbl_user_assessment_scores WHERE assessment_id = ca.assessment_id AND course_id = ca.course_id AND user_id = $user_id),'Completed','Not Completed') AS status,(SELECT SUM(points) FROM tbl_user_assessment_scores WHERE assessment_id = ca.assessment_id AND course_id = ca.course_id AND user_id = $user_id) AS score,(SELECT SUM(marks) marks FROM tbl_assessment_questions WHERE assessment_id = a.id) AS total_marks FROM tbl_assessment a INNER JOIN tbl_course_assessments ca ON ca.assessment_id = a.id INNER JOIN tbl_course_users cu ON ca.course_id = cu.course_id WHERE cu.user_id = $user_id")->result();
		}	
	}
	function ins_upd_assessment(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = (string)$this->input->post('type');
		$id = (int)$this->input->post('id');
		$name = (string)$this->input->post('name');
		$question_type = (string)$this->input->post('question_type');
		$random = (string)$this->input->post('random');
		$mark_type = (string)$this->input->post('mark_type');
		$mark_per_question = (int)$this->input->post('mark_per_question');
		$questions = json_decode($this->input->post('questions'));
		
		if($type == 'INSERT_BASIC'){			
			$this->db->query("INSERT INTO tbl_assessment (name, question_type, random, mark_type, mark_per_question, created_by, created_date, updated_date, status) VALUES ('$name', '$question_type', '$random', '$mark_type', '$mark_per_question', '$this->user_id', NOW(), NOW(), 'Active')");
			$return['status'] = true;
			$return['id'] = $this->db->query("SELECT MAX(id) AS id FROM tbl_assessment")->row()->id;
			$return['message'] = 'Assessment created successfully';
		}
		if($type == 'UPDATE_BASIC'){			
			$this->db->query("UPDATE tbl_assessment SET name = '$name', question_type = '$question_type', random = '$random', mark_type = '$mark_type', mark_per_question = '$mark_per_question', updated_date = NOW() WHERE id = $id");
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Assessment updated successfully';
		}
		if($type == 'QUESTIONS'){
			$this->db->query("DELETE FROM tbl_assessment_questions WHERE assessment_id = $id");
			$this->db->query("DELETE FROM tbl_assessment_options WHERE assessment_id = $id");
			foreach($questions as $q){
				$marks = (int)$q->marks;
				$this->db->query("INSERT INTO tbl_assessment_questions (assessment_id, question, question_type, marks) VALUES ($id, '$q->name', '$q->qtype', $marks)");
				$qid = $this->db->query("SELECT MAX(id) AS id FROM tbl_assessment_questions")->row()->id;
				foreach($q->options as $o){
					$answer = (int)$o->answer;
					$this->db->query("INSERT INTO tbl_assessment_options (assessment_id, question_id, options, correct) VALUES ($id, $qid, '$o->name', $answer)");
				}
			}
			$return['status'] = true;
			$return['id'] = $id;
			$return['message'] = 'Assessment updated successfully';
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
	function assign_course(){
		$return['status'] = false;$return['message'] = 'Failed';
		$course_id = $this->input->post('course_id');
		$assign_type = $this->input->post('assign_type');
		$course_type = $this->input->post('course_type');
		$group_id = $this->input->post('group_id');
		$designation_id = $this->input->post('designation_id');
		$users = (array)$this->input->post('users');
		$status = 'Not Registered';
		if($course_type == 'Mandatory')
			$status = 'Registered';
		if($assign_type == 'GROUP'){
			$check = $this->db->query("SELECT * FROM tbl_course_groups WHERE course_id = $course_id AND group_id = $group_id")->row();
			if(!$check){
				$this->db->query("INSERT INTO tbl_course_groups(course_id,group_id,added_by) VALUES($course_id,$group_id,$this->user_id)");
			}
			$this->db->query("INSERT INTO tbl_course_users (course_id, user_id, course_type, register_type, group_id, added_by, date_time, status) SELECT $course_id, user_id, '$course_type', 'GROUP',group_id,$this->user_id,NOW(),'$status' FROM  tbl_group_users WHERE group_id = $group_id AND user_id NOT IN (SELECT user_id FROM tbl_course_users WHERE course_id = $course_id)");
				
			$return['status'] = true;
			$return['message'] = 'Course assigned successfully';
		}
		if($assign_type == 'DESIGNATION'){
			$check = $this->db->query("SELECT * FROM tbl_course_designations WHERE course_id = $course_id AND designation_id = $designation_id")->row();
			if(!$check){
				$this->db->query("INSERT INTO tbl_course_designations(course_id,designation_id,added_by) VALUES($course_id,$designation_id,$this->user_id)");
			}
			
			$this->db->query("INSERT INTO tbl_course_users (course_id, user_id, course_type, register_type, designation_id, added_by, date_time, status) SELECT $course_id, id, '$course_type', 'DESIGNATION',designation,$this->user_id,NOW(),'$status' FROM  tbl_user WHERE designation = $designation_id AND id NOT IN (SELECT user_id FROM tbl_course_users WHERE course_id = $course_id)");		
				
			$return['status'] = true;
			$return['message'] = 'Course assigned successfully';
		}
		if($assign_type == 'USER'){
			foreach($users as $user_id){
				$check = $this->db->query("SELECT * FROM tbl_course_users WHERE course_id = $course_id AND user_id = $user_id")->row();
				if(!$check){
					$this->db->query("INSERT INTO tbl_course_users(course_id, user_id, course_type, register_type, added_by, date_time, status) VALUES($course_id, $user_id, '$course_type', 'USER', $this->user_id, NOW(), '$status')");			
				}
			}
			$return['status'] = true;
			$return['message'] = 'Course assigned successfully';
		}
		return $return;
	}
	function submit_assessment(){
		$course_id = (int)$this->input->post("course_id");
		$assessment_id = (int)$this->input->post("assessment_id");
		$answers = $this->input->post("answers");
		
		$qqry = $this->db->query("SELECT o.*,q.marks,q.question_type FROM tbl_assessment_options o INNER JOIN tbl_assessment_questions q ON q.id = o.question_id WHERE q.assessment_id = '$assessment_id'")->result();
		foreach($answers as $a){
			if(isset($a[1])){
				$marks = 0;$temp =0;$atemp =0;$qmarks = 0;$evaluated = 0;$correct=0;
				foreach($qqry as $q){
					if($q->question_id == $a[0]){
						$qmarks = $q->marks;
						if($q->question_type == 'Single Choice'){
							if($q->correct == 1 && $q->id == $a[1]){
								$marks = $q->marks;
								$correct = 1;
							}
							$evaluated = 1;
						}
						else if($q->question_type == 'Multiple Choice'){
							if($q->correct == 1 && in_array($q->id,(array)$a[1]))$atemp++;
							$evaluated = 1;
						}
						if($q->correct == 1)$temp++;
					}
				}
				if($atemp !=0 && $atemp == $temp && $marks == 0){
					$marks = $qmarks;
					$correct = 1;
				}
			
				if(is_array($a[1]))
					$options = json_encode($a[1]);
				else
					$options = $a[1];
				
				$this->db->query("INSERT INTO tbl_user_assessment_scores (assessment_id, user_id, course_id, question_id, user_answer, points,evaluated,status) VALUES ($assessment_id, $this->user_id, $course_id, $a[0], '$options', $marks,$evaluated,$correct)");
			}
		}
		return true; 
	}
	function course_registration(){
		$return['status'] = false;$return['message'] = 'Failed';
		$type = $this->input->post("type");
		$course_id = (int)$this->input->post("course_id");
		$session_id = (int)$this->input->post("session_id");
		$course_type = (string)$this->input->post("course_type");
		$check = $this->db->query("SELECT * FROM tbl_course_users WHERE user_id=$this->user_id AND course_id = $course_id")->row();		
		if($check){
			
			$end_date = date('Y-m-d H:i:s', strtotime("+60 days"));
			if($course_type == 'Elearning'){
				$session_id = -1;
				$days = $this->db->query("SELECT eduration FROM tbl_course_published WHERE id = $course_id")->row()->eduration;
				$end_date = date('Y-m-d', strtotime("+".(int)$days." days"));
			}else{
				$end_date = $this->db->query("SELECT end_date FROM tbl_course_sessions WHERE id = $session_id")->row()->end_date;
			}
			
			$check = $this->db->query("SELECT * FROM tbl_course_session_users WHERE course_id = $course_id AND session_id = $session_id AND course_type = '$course_type' AND user_id = $this->user_id")->row();
			//var_dump($check);exit();
			if(!$check){
				$this->db->query("INSERT INTO tbl_course_session_users (user_id, course_id, session_id, course_type, completed, end_date, date_time, status) VALUES ($this->user_id, $course_id, $session_id, '$course_type', 0, '$end_date', NOW(), 'Registered'); ");
				
				$this->db->query("UPDATE tbl_course_users SET status = 'Registered' WHERE course_id = $course_id AND user_id = $this->user_id");
				
				//Notification
				$ndata['subject'] = 'You have successfully registered for a course';
				$ndata['user_id'] = $this->user_id;
				$this->ins_upd_notification($ndata);
				
				$return['status'] = true;
				$return['message'] = 'Course registered successfully';
			}else{
				$return['status'] = true;
				$return['message'] = 'Course already registered';
			}
		}else{
			$return['message'] = 'You dont have permission to register this course. Contact your manager.';
		}
		return $return;
	}
	function get_dashboard($data){
		$type = isset($data['type']) ? $data['type'] : '';
		$user_id = isset($data['user_id']) ? (int)$data['user_id'] : 0;
		$course_id = isset($data['course_id']) ? (int)$data['course_id'] : 0;
		if($type == 'USER'){
			$return['total'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_course_users WHERE user_id = $this->user_id")->row()->total;
			$return['ongoing'] = $this->db->query("SELECT COUNT(*) AS ongoing FROM tbl_course_session_users WHERE user_id = $this->user_id AND end_date >= NOW()")->row()->ongoing;
			$return['completed'] = $this->db->query("SELECT COUNT(*) AS completed FROM tbl_course_session_users WHERE user_id = $this->user_id AND end_date < NOW()")->row()->completed;
			$return['assessments'] = $this->db->query("SELECT COUNT(*) AS total,(SELECT COUNT(*) FROM tbl_user_assessment_scores uas WHERE uas.course_id = ca.course_id AND uas.user_id = $this->user_id) AS completed FROM tbl_course_assessments_published ca INNER JOIN tbl_course_users cu ON cu.course_id = ca.course_id WHERE cu.user_id = $this->user_id")->row();
			return (object)$return;
		}
		if($type == 'MANAGER'){
			$return['courses'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_course_published")->row()->total;
			$return['groups'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_group WHERE created_by = $this->user_id")->row()->total;
			$return['users'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_user WHERE manager_id = $this->user_id")->row()->total;
			$return['trainers'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_user u INNER JOIN tbl_role r ON r.id = u.role_id WHERE r.name = '".$this->config->item('trainer_role')."'")->row()->total;
			return (object)$return;
		}
		if($type == 'HR'){
			$return['courses'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_course")->row()->total;
			$return['groups'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_group WHERE created_by = $this->user_id")->row()->total;
			$return['users'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_user")->row()->total;
			$return['assessments'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_assessment")->row()->total;
			return (object)$return;
		}
		if($type == 'TRAINER'){
			$return['total'] = $this->db->query("SELECT COUNT(*) AS total FROM tbl_course WHERE created_by = $this->user_id")->row()->total;
			$return['published'] = $this->db->query("SELECT COUNT(*) AS published FROM tbl_course_published WHERE created_by = $this->user_id")->row()->published;
			$return['registered'] = $this->db->query("SELECT COUNT(cu.id) AS registered  FROM tbl_course_users cu INNER JOIN tbl_course_published c ON c.id = cu.course_id WHERE c.created_by = $this->user_id")->row()->registered;
			$return['assessments'] = $this->db->query("SELECT COUNT(*) AS assessments FROM tbl_course_assessments_published ca INNER JOIN  tbl_course_published c ON c.id = ca.course_id WHERE c.created_by = $this->user_id")->row()->assessments;
			return (object)$return;
		}
	}
	function ins_upd_notification($data){
		$type = isset($data['type']) ? $data['type'] : 'INSERT';
		$user_id = isset($data['user_id']) ? (int)$data['user_id'] : 0;
		$subject = isset($data['subject']) ? (string)$data['subject'] : 'No Subject';
		$content = isset($data['content']) ? (string)$data['content'] : '';
		if($type == 'INSERT'){
			$created_by = $this->user_id;
			$image = $this->session->userdata('profile_pic');
			$this->db->query("INSERT INTO tbl_notification (user_id, subject, content, image, module_id, module, created_by,  created_date, status) VALUES ($user_id, '$subject', '$content', '$image', 0, '', '$created_by', NOW(), 'Not read')");
		}
	}
}
?>