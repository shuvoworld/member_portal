<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(APPPATH . 'libraries/GroceryCrudEnterprise/autoload.php');

use GroceryCrud\Core\GroceryCrud;

class Committee extends Admin_Base_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Committee';
		$this->load->model('Committee_model');
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

	public function committee_management()
	{
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('committees');
		$crud->setSubject('Committee');
		$crud->setRelation('member_id', 'members', '{name_BN} - {mobile_no} - {forum_membership_no}');
		$crud->setRelation('committee_id', 'committee_names', '{name}');
		$crud->setRelation('committee_designation_id', 'committee_designations', '{name}');
		$crud->setRelation('start_year_id', 'committee_years', '{name}');
		$crud->setRelation('end_year_id', 'committee_years', '{name}');
		$crud->fields(['member_id', 'committee_id', 'committee_designation_id', 'start_year_id', 'end_year_id', 'current']);
		$crud->unsetJquery();
		$crud->displayAs('member_id', 'মেম্বার');
		$crud->displayAs('committee_id', 'কমিটি');
		$crud->displayAs('committee_designation_id', 'কমিটিতে পদ');
		$crud->displayAs('start_year_id', 'শুরু');
		$crud->displayAs('end_year_id', 'শেষ');
		$crud->displayAs('current', 'বর্তমান?');

		if (!in_array('viewCommittee', $this->permission)) {
		$crud->unsetRead();
		$this->toastr->error('You do not have view permission');
		redirect('admin/dashboard', 'refresh');
		}
		if (!in_array('updateCommittee', $this->permission)) {
		$crud->unsetEdit();
		$this->toastr->error('You do not have edit permission');
		}
		if (!in_array('deleteCommittee', $this->permission)) {
		$crud->unsetDelete();
		$this->toastr->error('You do not have delete permission');
		}
		if (!in_array('createCommittee', $this->permission)) {
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
        $this->db->update('committees', array(
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
