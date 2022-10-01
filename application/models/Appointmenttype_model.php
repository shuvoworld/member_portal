<?php

class Appointmenttype_model extends CI_model
{

	public function __construct()
	{
		parent::__construct();
	}

	function fetch_appointmenttype()
	{
		$query = $this->db->get("appointmenttypes");
		return $query->result();
	}
}
