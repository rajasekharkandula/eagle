<?php
	
class Manager_model extends CI_Model{
		
	public function __construct(){
		parent::__construct();
		$this->db->query("SET SESSION time_zone = '+05:30'");
		$this->user_id = $this->session->userdata("user_id");
		$this->entity_id = $this->session->userdata("entity_id");
	}
	
	
}
?>