<?php

class CustomerDegree_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function customerdegree_list($customer_id)
	{
		$this->db->select('*');
		$this->db->from('customer_degrees');
		$this->db->where('customer_id', $customer_id);
		$query = $this->db->get();
		return $query->result();
	}

	function save_customerdegree()
	{
		$data = array(
			'customer_id' => $this->input->post('customer_id'),
			'degree' => $this->input->post('degree'),
		);
		$result = $this->db->insert('customer_degrees', $data);
		return $result;
	}

	function update_customerdegree()
	{
		$customer_id = $this->input->post('customer_id');
		$degree = $this->input->post('degree');

		$this->db->set('customer_id', $customer_id);
		$this->db->set('degree', $degree);
		$result = $this->db->update('customer_degrees');
		return $result;
	}

	function delete_customerdegree()
	{
		$id = $this->input->post('id');
		$this->db->where('id', $id);
		$result = $this->db->delete('customer_degrees');
		return $result;
	}
}
