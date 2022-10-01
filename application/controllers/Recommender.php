<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . 'libraries/GroceryCrudEnterprise/autoload.php');

use GroceryCrud\Core\GroceryCrud;

class Recommender extends Admin_Base_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Recommender';
		$this->load->model('Paymentmode_model');
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

	public function recommender_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('recommenders');
		$crud->setSubject('Recommender');
		$crud->setRelation('member_id', 'members', '{name_BN} - {mobile_no} - {forum_membership_no}');
		$crud->fields(['member_id', 'start_date', 'end_date', 'is_active']);
		$crud->unsetJquery();
		$crud->displayAs('member_id', 'মেম্বার');
		$crud->displayAs('start_date', 'শুরু');
		$crud->displayAs('end_date', 'শেষ');
		$crud->displayAs('is_active', 'এক্টিভ');

		if (!in_array('viewRecommender', $this->permission)) {
		$crud->unsetRead();
		$this->toastr->error('You do not have view permission');
		redirect('admin/dashboard', 'refresh');
		}
		if (!in_array('updateRecommender', $this->permission)) {
		$crud->unsetEdit();
		$this->toastr->error('You do not have edit permission');
		}
		if (!in_array('deleteRecommender', $this->permission)) {
		$crud->unsetDelete();
		$this->toastr->error('You do not have delete permission');
		}
		if (!in_array('createRecommender', $this->permission)) {
		$crud->unsetAdd();
		$crud->unsetClone();
		$this->toastr->error('You do not have create permission');
		}

		$stateParameters = (object)[
			'insertId' => '1234',
		];
		
		$crud->callbackAfterInsert(function ($stateParameters) {
    	$this->db->where('id', $stateParameters->insertId);
    	$recommender = $this->db->get('recommenders')->row();

		//print_r($recommender); die();
        $this->db->update('recommenders', array(
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $this->ion_auth->user()->row()->id,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->ion_auth->user()->row()->id,
		));
    	return $stateParameters;
});

		$output = $crud->render();
		$this->_recommender_output($output);
	}

	function _recommender_output($output = null)
	{
		if (isset($output->isJSONResponse) && $output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
		}

		$this->load->view('recommender.php', $output);
	}

}
