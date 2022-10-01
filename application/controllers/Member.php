<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . 'libraries/GroceryCrudEnterprise/autoload.php');

use GroceryCrud\Core\GroceryCrud;

class Member extends Admin_Base_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Member';
		//$this->load->model('Member_model');
		$this->setTemplateFile('grocery_view');

	}

	private function _getDbData()
	{
		$db = [];
		include(APPPATH . 'config/database.php');
		return [
			'adapter' => [
				'driver' => 'Pdo_Mysql',
				'host' => $db['default']['hostname'],
				'database' => $db['default']['database'],
				'username' => $db['default']['username'],
				'password' => $db['default']['password'],
				'charset' => 'utf8'
			]
		];
	}

	private function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true)
	{
		$db = $this->_getDbData();
		$config = include(APPPATH . 'config/gcrud-enterprise.php');
		$groceryCrud = new GroceryCrud($config, $db);
		return $groceryCrud;
	}

	public function Member_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('Members');
		$crud->setSubject('Member');
		$crud->unsetJquery();
        $crud->displayAs('name', 'নাম');
		$crud->displayAs('mobile_no', 'মোবাইল');
		$crud->displayAs('email', 'ইমেইল');
        $crud->displayAs('nid', 'জাতীয় পরিপত্র');
        $crud->displayAs('plot_no', 'প্লট নং');
        $crud->displayAs('balance', 'মোট জমা');
        $crud->displayAs('present_address', 'ঠিকানা');

		if (!in_array('viewMember', $this->permission)) {
		$crud->unsetRead();
		$this->toastr->error('You do not have view permission');
		redirect('admin/dashboard', 'refresh');
		}
		if (!in_array('updateMember', $this->permission)) {
		$crud->unsetEdit();
		$this->toastr->error('You do not have edit permission');
		}
		if (!in_array('deleteMember', $this->permission)) {
		$crud->unsetDelete();
		$this->toastr->error('You do not have delete permission');
		}
		if (!in_array('createMember', $this->permission)) {
		$crud->unsetAdd();
		$crud->unsetClone();
		$this->toastr->error('You do not have create permission');
		}

		$stateParameters = (object)[
			'insertId' => '1234',
		];
		
		$crud->callbackAfterInsert(function ($stateParameters) {
    	$this->db->where('id', $stateParameters->insertId);
    	$Member = $this->db->get('Members')->row();

        $this->db->update('Members', array(
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $this->ion_auth->user()->row()->id,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->ion_auth->user()->row()->id,
		));
    	return $stateParameters;
});

		$output = $crud->render();
		$this->_Member_output($output);
	}

	public function dashboard() {
		$this->data['title'] = 'Member Dashboard';
		$this->data['breadcrumbs'] = 'Dashboard';
        $this->data['member_data']  = $this->Member_model->getMemberAllData($this->ion_auth->user()->row()->member_id);
        $this->data['member_balance'] = $this->Member_model->getMemberBalance($this->ion_auth->user()->row()->member_id);
		$this->load->view('members/dashboard_view', $this->data);
	}

	function _Member_output($output = null)
	{
		if (isset($output->isJSONResponse) && $output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
		}

		$this->load->view('member.php', $output);
	}

}
