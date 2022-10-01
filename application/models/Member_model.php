<?php

class Member_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getMemberAllData($id = null)
	{
		if ($id) {
			$sql = "SELECT * from members WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM members ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

    public function getMemberBalance($id)
    {
        $sql = "SELECT balance FROM members where id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

	public function getTotalMemberBalance()
	{
		$sql = "SELECT SUM(balance) as total FROM members";
		$query = $this->db->query($sql);
		$row =  $query->row_array();
		return $row['total'];
	}

    public function updateMemberBalance($member_id, $amount)
    {
		$current_balance = $this->getMemberBalance($member_id);
		$new_balance = $current_balance['balance']+$amount;
		$data = [
			'balance' => $new_balance
		];
    	$this->db->where('id', $member_id);
    	$update = $this->db->update('members', $data);
    }
}
