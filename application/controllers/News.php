<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'libraries/GroceryCrudEnterprise/autoload.php';

use GroceryCrud\Core\GroceryCrud;

class News extends Admin_Base_Controller {
	function __construct() {
		parent::__construct();
		$this->data['page_title'] = 'News';
		$this->load->model('News_model');
		$this->setTemplateFile('grocery_view');

	}

	private function _getDbData() {
		$db = [];
		include APPPATH . 'config/database.php';
		return [
			'adapter' => [
				'driver' => 'Pdo_Mysql',
				'host' => $db['default']['hostname'],
				'database' => $db['default']['database'],
				'username' => $db['default']['username'],
				'password' => $db['default']['password'],
				'charset' => 'utf8',
			],
		];
	}

	private function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true) {
		$db = $this->_getDbData();
		$config = include APPPATH . 'config/gcrud-enterprise.php';
		$groceryCrud = new GroceryCrud($config, $db);
		return $groceryCrud;
	}

	public function news_management() {
		$crud = $this->_getGroceryCrudEnterprise();
		$crud->setTable('website_news');
		$crud->setSubject('News');
		$crud->unsetJquery();
		$crud->fields(['name', 'file', 'detail', 'date', 'is_published']);
		$crud->columns(['name', 'date', 'is_published', 'archive_date']);
		$crud->displayAs('name', 'টাইটেল');
		$crud->displayAs('file', 'ফাইল আপলোড');
		$crud->displayAs('date', 'প্রকাশের তারিখ');
		$crud->displayAs('archive_date', 'আর্কাইভের তারিখ');
		$crud->displayAs('detail', 'বিস্তারিত');
		$crud->displayAs('is_published', 'প্রকাশিত?');
		$crud->setFieldUpload('file', 'assets/uploads/notices', base_url() . 'assets/uploads/notices');

		if (!in_array('viewNews', $this->permission)) {
			$crud->unsetRead();
			$this->toastr->error('You do not have view permission');
			redirect('admin/dashboard', 'refresh');
		}
		if (!in_array('updateNews', $this->permission)) {
			$crud->unsetEdit();
			$this->toastr->error('You do not have edit permission');
		}
		if (!in_array('deleteNews', $this->permission)) {
			$crud->unsetDelete();
			$this->toastr->error('You do not have delete permission');
		}
		if (!in_array('createNews', $this->permission)) {
			$crud->unsetAdd();
			$crud->unsetClone();
			$this->toastr->error('You do not have create permission');
		}

		$stateParameters = (object) [
			'insertId' => '1234',
		];

		$crud->callbackAfterInsert(function ($stateParameters) {
			$this->db->where('id', $stateParameters->insertId);
			$recommender = $this->db->get('website_news')->row();

			//print_r($recommender); die();
			$this->db->update('website_news', array(
				'updated_at' => date('Y-m-d H:i:s'),
				'updated_by' => $this->ion_auth->user()->row()->id,
			));
			return $stateParameters;
		});

		$output = $crud->render();
		$this->_notice_output($output);
	}

	function _notice_output($output = null) {
		if (isset($output->isJSONResponse) && $output->isJSONResponse) {
			header('Content-Type: application/json; charset=utf-8');
			echo $output->output;
			exit;
		}

		$this->load->view('news.php', $output);
	}

}
