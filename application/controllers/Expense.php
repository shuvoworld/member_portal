<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . 'libraries/GroceryCrudEnterprise/autoload.php');

use GroceryCrud\Core\GroceryCrud;

class Expense extends Admin_Base_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Expense';
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

	public function Expense_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('expenses');
		$crud->setSubject('Expense');
		$crud->unsetJquery();
	
		$crud->displayAs('date', 'জমার তারিখ');
		$crud->displayAs('amount', 'পরিমাণ');
		$crud->displayAs('details', 'বিস্তারিত');
		
		if (!in_array('viewExpense', $this->permission)) {
			$crud->unsetRead();
			$this->toastr->error('You do not have view permission');
			redirect('admin/dashboard', 'refresh');
		}
		if (!in_array('updateExpense', $this->permission)) {
			$crud->unsetEdit();
			$this->toastr->error('You do not have edit permission');
		}
		if (!in_array('deleteExpense', $this->permission)) {
			$crud->unsetDelete();
			$this->toastr->error('You do not have delete permission');
		}
		if (!in_array('createExpense', $this->permission)) {
			$crud->unsetAdd();
			$crud->unsetClone();
			$this->toastr->error('You do not have create permission');
		}

		$stateParameters = (object)[
			'insertId' => '1234',
		];
		
		$crud->callbackAfterInsert(function ($stateParameters) {
    	$this->db->where('id', $stateParameters->insertId);
    	$balance = $this->db->get('expenses')->row();

        $this->db->update('expenses', array(
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $this->ion_auth->user()->row()->id,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->ion_auth->user()->row()->id,
		));
    	return $stateParameters;
});
		$output = $crud->render();
		$this->_payment_output($output);
	}

	function _payment_output($output = null)
	{
		if (isset($output->isJSONResponse) && $output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
		}

		$this->load->view('expense.php', $output);
	}
}
