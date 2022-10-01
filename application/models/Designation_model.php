<?php

class Designation_model extends CI_model
{

	public function __construct()
	{
		parent::__construct();
	}

	function fetch_designation()
	{
		$this->db->order_by("rank", "ASC");
		$query = $this->db->get("designations");
		return $query->result();
	}
}
