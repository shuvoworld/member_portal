<?php

class Customer_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getCustomerData($id = null)
	{
		if ($id) {
			$sql = "SELECT * FROM customers where customerNumber = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM customers ORDER BY customerNumber DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if ($data) {
			$insert = $this->db->insert('customers', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function edit($data = array(), $id = null)
	{
		$this->db->where('customerNumber', $id);
		$update = $this->db->update('customers', $data);

		return ($update == true) ? true : false;
	}


	public function delete($id)
	{
		$result = $this->db->delete('customers', array('customerNumber' => $id));
		return $result;
	}
}
