<?php

class Expense_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getTotalExpense()
	{
		$sql = "SELECT SUM(amount) as total_expense FROM expenses";
		$query = $this->db->query($sql);
		$row =  $query->row_array();
		return $row['total_expense'];
	}

}
