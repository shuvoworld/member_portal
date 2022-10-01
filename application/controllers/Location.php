<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . 'libraries/GroceryCrudEnterprise/autoload.php');

use GroceryCrud\Core\GroceryCrud;

class Location extends Admin_Base_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Location';
		$this->load->model('Location_model');
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

	public function divisions_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('divisions');
		$crud->setSubject('Division');
		$crud->unsetBootstrap();
		$crud->unsetJquery();
		$crud->unsetJqueryUi();

		$output = $crud->render();
		$this->_division_output($output);
	}

	function _division_output($output = null)
	{
		if (isset($output->isJSONResponse) && $output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
		}


		$this->load->view('division.php', $output);
	}

	public function districts_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('districts');
		$crud->setSubject('District');
		$crud->unsetBootstrap();
		$crud->unsetJquery();
		$crud->unsetJqueryUi();

		$output = $crud->render();
		$this->_district_output($output);
	}

	function _district_output($output = null)
	{
		if ($output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
		}

		$this->load->view('district.php', $output);
	}

	public function upazilas_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('upazilas');
		$crud->setSubject('Upazila');
		$crud->unsetBootstrap();
		$crud->unsetJquery();
		$crud->unsetJqueryUi();

		$output = $crud->render();
		$this->_upazila_output($output);
	}

	function _upazila_output($output = null)
	{
		if ($output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
		}

		$this->load->view('upazila.php', $output);
	}

	function fetch_district()
	{
		if ($this->input->post('division_id')) {
			echo $this->Location_model->fetch_district($this->input->post('division_id'));
		}
	}

	function fetch_upazila()
	{
		if ($this->input->post('district_id')) {
			echo $this->Location_model->fetch_upazila($this->input->post('district_id'));
		}
	}

}
