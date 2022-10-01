<?php

class Ministry_model extends CI_model
{

	public function __construct()
	{
		parent::__construct();
	}

	function fetch_ministry()
	{
		$this->db->order_by("id", "ASC");
		$query = $this->db->get("ministries");
		return $query->result();
	}
}
