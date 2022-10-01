<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Base_Controller {

	function __construct() {
		parent::__construct();
		$this->data['page_title'] = 'Dashboard';
		$this->load->model('Member_model');
		$this->load->model('Expense_model');
	}

	public function index() {
		if (!$this->ion_auth->is_admin()) {
			$this->toastr->error('You do not have permission to see administrator dashboard');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$this->data['members'] = $this->Member_model->getMemberAllData();
		$this->data['total_deposit'] = $this->Member_model->getTotalMemberBalance();
		$this->data['total_expense'] = $this->Expense_model->getTotalExpense();
		$this->data['title'] = 'Dashboard';
		$this->data['breadcrumbs'] = 'Dashboard';
		$this->load->view('admin/dashboard_view', $this->data);

	}

}