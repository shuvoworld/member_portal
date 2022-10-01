<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . 'libraries/GroceryCrudEnterprise/autoload.php');

use GroceryCrud\Core\GroceryCrud;

class Department extends Admin_Base_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'অধিদপ্তর/দপ্তর';
		$this->load->model('Department_model');
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

	public function department_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('departments');
		$crud->setRelation('ministry_id', 'ministries', 'name_BN');
		$crud->displayAs('name', 'নাম (ইংরেজি)');
		$crud->displayAs('name_BN', 'নাম (বাংলা)');
		$crud->displayAs('ministry_id', 'মন্ত্রণালয়');
		$crud->displayAs('code', 'কোড');

		$crud->setSubject('Department');
		$crud->unsetBootstrap();
		$crud->unsetJquery();
		$crud->unsetJqueryUi();
		if (!in_array('viewDepartment', $this->permission)) {
		$crud->unsetRead();
		$this->toastr->error('You do not have view permission');
		redirect('admin/dashboard', 'refresh');
		}
		if (!in_array('updateDepartment', $this->permission)) {
		$crud->unsetEdit();
		$this->toastr->error('You do not have edit permission');
		}
		if (!in_array('deleteDepartment', $this->permission)) {
		$crud->unsetDelete();
		$this->toastr->error('You do not have delete permission');
		}
		if (!in_array('createDepartment', $this->permission)) {
		$crud->unsetAdd();
		$crud->unsetClone();
		$this->toastr->error('You do not have create permission');
		}

		$output = $crud->render();
		$this->_department_output($output);
	}

	function _department_output($output = null)
	{
		if (isset($output->isJSONResponse) && $output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
		}

		$this->load->view('department.php', $output);
	}

	function fetch_department()
	{
    if ($this->input->post('ministry_id')) {
        echo $this->Department_model->fetch_department_for_select($this->input->post('ministry_id'));
    }
}


}
