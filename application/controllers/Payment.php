<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . 'libraries/GroceryCrudEnterprise/autoload.php');

use GroceryCrud\Core\GroceryCrud;
use GroceryCrud\Core\Model;

class Payment extends Admin_Base_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Payment';
		$this->setTemplateFile('grocery_view');
		$this->load->model('Member_model');
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

	public function payment_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('payments');
		$crud->setSubject('Payment');
		$crud->unsetJquery();
		$crud->setRelation('member_id', 'members', 'name');
		$crud->setRelation('mode_id', 'paymentmodes', 'name_BN');
		$crud->setRelation('purpose_id', 'paymentpurposes', 'name_BN');
	
		$crud->displayAs('member_id', 'মেম্বার');
		$crud->displayAs('purpose_id', 'জমা কারণ');
		$crud->displayAs('mode_id', 'জমার উপায়');
		$crud->displayAs('date', 'জমার তারিখ');
		$crud->displayAs('amount', 'পরিমাণ');
		$crud->displayAs('details', 'বিস্তারিত');
		
		if (!in_array('viewPayment', $this->permission)) {
			$crud->unsetRead();
			$this->toastr->error('You do not have view permission');
			redirect('admin/dashboard', 'refresh');
		}
		if (!in_array('updatePayment', $this->permission)) {
			$crud->unsetEdit();
			$this->toastr->error('You do not have edit permission');
		}
		if (!in_array('deletePayment', $this->permission)) {
			$crud->unsetDelete();
			$this->toastr->error('You do not have delete permission');
		}
		if (!in_array('createPayment', $this->permission)) {
			$crud->unsetAdd();
			$crud->unsetClone();
			$this->toastr->error('You do not have create permission');
		}


		$stateParameters = (object)[
			'insertId' => '1234',
		];
		
		$crud->callbackAfterInsert(function ($stateParameters) {
    	$this->db->where('id', $stateParameters->insertId);
    	$payment = $this->db->get('payments')->row();    
        $this->db->update('payments', array(
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $this->ion_auth->user()->row()->id,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->ion_auth->user()->row()->id,
		));
		$this->Member_model->updateMemberBalance($payment->member_id, $payment->amount);
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

		$this->load->view('payment.php', $output);
	}
}
