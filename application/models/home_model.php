<?php
	
class Home_model extends CI_Model{
		
	public function __construct(){
		parent::__construct();
		$this->db->query("SET SESSION time_zone = '+05:30'");
	}
	
	function login($email,$password){
		$data['status'] = false;$data['message'] = 'Login authentication failed';
		$user = $this->db->query("SELECT * FROM tbl_user WHERE email = '$email'")->row();
		if($user){
			if($user->password == $password){
				
				$role = $this->db->query("SELECT * FROM tbl_role WHERE id = ".$user->role_id)->row();
				if(!$role){
					$data['message'] = 'User is not mapped with any role. Please contact admin.';
					return $data;
				}
				$login = array(
					'logged_in' => true,
					'user_id' => $user->id,
					'user_name' => $user->first_name.' '.$user->last_name,
					'email' => $user->email,
					'entity_id' => $user->entity_id,
					'role_id' => $user->role_id,
					'role_name' => $role->name
				);
				$this->session->set_userdata($login);
				$data['status'] = true;
				$data['message'] = 'Logged in successfully';
			}else{
				$data['message'] = 'Invalid email or password';
			}
		}else{
			$data['message'] = 'Invalid email or username';
		}
		return $data;
	}
	
}
?>