<?php

class Payments_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPaymentData($id = null)
    {
        if ($id) {
            $sql = "SELECT m.forum_membership_no as forum_membership_no, m.name_BN as name_BN, m.mobile_no as mobile_no, p.amount as amount, p.tran_date as tran_date, p.tran_id as tran_id, paymentpurposes.name_BN as purpose, as p.status as status FROM payment as p left join members as m ON p.member_id = m.id LEFT JOIN paymentpurposes as paymentpurposes ON paymentpurposes.id = p.purpose_id where p.id = ?";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        $sql = "SELECT m.forum_membership_no as forum_membership_no, m.name_BN as name_BN, m.mobile_no as mobile_no, p.amount as amount, p.tran_date as tran_date, p.tran_id as tran_id, paymentpurposes.name_BN as purpose, p.status as status FROM payment as p left join members as m ON p.member_id = m.id LEFT JOIN paymentpurposes as paymentpurposes ON paymentpurposes.id = p.purpose_id ORDER BY p.id DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getMemberPaymentData($member_id = null)
    {
        if ($member_id) {
            $sql = "SELECT m.forum_membership_no as forum_membership_no, m.name_BN as name_BN, m.mobile_no as mobile_no, p.amount as amount, p.tran_date as tran_date, p.tran_id as tran_id, paymentpurposes.name_BN as purpose, p.status as status FROM payment as p left join members as m ON p.member_id = m.id LEFT JOIN paymentpurposes as paymentpurposes ON paymentpurposes.id = p.purpose_id where m.id = ?";
            $query = $this->db->query($sql, array($member_id));
            return $query->result_array();
        }
    }

}
