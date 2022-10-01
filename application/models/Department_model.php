<?php

class Department_model extends CI_model
{

	public function __construct()
	{
		parent::__construct();
	}

	function fetch_department()
	{
		$this->db->order_by("id", "ASC");
		$query = $this->db->get("departments");
		return $query->result();
	}

	function fetch_department_for_select($ministry_id)
	{
		$this->db->where('ministry_id', $ministry_id);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get('departments');
		$output = '<option value="">নির্বাচন করুন</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="' . $row->id . '">' . $row->name_BN . '</option>';
		}
		return $output;
	}

}
