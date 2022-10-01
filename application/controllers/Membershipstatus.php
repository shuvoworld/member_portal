<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . 'libraries/GroceryCrudEnterprise/autoload.php');

use GroceryCrud\Core\GroceryCrud;

class Membershipstatus extends Admin_Base_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Membership Status';
		$this->load->model('Membershipstatus_model');
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

	public function membershipstatus_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('membership_status');
		$crud->setSubject('Payscale');
		$crud->unsetBootstrap();
		$crud->unsetJquery();
		$crud->unsetJqueryUi();
		if (!in_array('viewMembershipstatus', $this->permission)) {
		$crud->unsetRead();
		$this->toastr->error('You do not have view permission');
		redirect('admin/dashboard', 'refresh');
		}
		if (!in_array('updateMembershipstatus', $this->permission)) {
		$crud->unsetEdit();
		$this->toastr->error('You do not have edit permission');
		}
		if (!in_array('deleteMembershipstatus', $this->permission)) {
		$crud->unsetDelete();
		$this->toastr->error('You do not have delete permission');
		}
		if (!in_array('createMembershipstatus', $this->permission)) {
		$crud->unsetAdd();
		$crud->unsetClone();
		$this->toastr->error('You do not have create permission');
		}

		$output = $crud->render();
		$this->_membershipstatus_output($output);
	}

	function _membershipstatus_output($output = null)
	{
		if (isset($output->isJSONResponse) && $output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
		}

		$this->load->view('membershipstatus.php', $output);
	}

}
