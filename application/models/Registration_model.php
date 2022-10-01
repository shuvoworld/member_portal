<?php
class Registration_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function create($data) {
		if ($data) {
			$insert = $this->db->insert('event_registration', $data);
			return ($insert == true) ? true : false;
		}
	}
}