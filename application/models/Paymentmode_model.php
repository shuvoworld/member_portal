<?php

class Paymentmode_model extends CI_model
{

	public function __construct()
	{
		parent::__construct();
	}

	function fetch_paymentmode()
	{
		$this->db->order_by("id", "ASC");
		$query = $this->db->get("Ppaymentmodes");
		return $query->result();
	}
}
