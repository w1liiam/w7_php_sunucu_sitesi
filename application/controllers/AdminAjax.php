<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminAjax extends CI_Controller {
	private $user = array();
	public function __construct() {
		parent::__construct();
		$this->load->model('Admin_Model');
		if($this->session->has_userdata('user')) {
			$this->user = $this->Admin_Model->getUserById($this->session->userdata('user'));
			if(!isset($this->user['id']) || $this->user['role'] != 1) {
				redirect(base_url('panel'));
				exit;
			}
		}
		else {
			redirect(base_url('login'));
			exit;
		}
	}
	public function approve_payment() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			$payment = $this->Admin_Model->getPaymentNotification($this->input->post('id'));
			if(isset($payment['id'])) {
				$this->Admin_Model->approvePaymentNotification($payment['id'], $payment['user'], $payment['amount']);
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('approvePaymentSuccess'))));
			}	
		}
	}
	public function reject_payment() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			$this->Admin_Model->rejectPaymentNotification($this->input->post('id'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('rejectPaymentSuccess'))));
		}
	}
	function add_category() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('name')) && @is_array(getimagesize($_FILES['image']['tmp_name']))) {
			$id = $this->Admin_Model->insertCategory($this->input->post('name'));
			$path = realpath('./assets/uploads').'/category-'.(string)$id.'.jpg';
			if(file_exists($path)) {unlink($path);}
			if(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_GIF) {
				imagejpeg(imagecreatefromgif($_FILES['image']['tmp_name']), $path);
			}
			elseif(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_PNG) {
				imagejpeg(imagecreatefrompng($_FILES['image']['tmp_name']), $path);
			}
			elseif(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_JPEG) {
				move_uploaded_file($_FILES['image']['tmp_name'], $path);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('addCategorySuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function edit_category() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('name'))) {
			$this->Admin_Model->updateCategory($this->input->post('id'), $this->input->post('name'), $this->input->post('active'));
			if(@is_array(getimagesize($_FILES['image']['tmp_name']))) {
				$path = realpath('./assets/uploads').'/category-'.(string)$this->input->post('id').'.jpg';
				if(file_exists($path)) {unlink($path);}
				if(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_GIF) {
					imagejpeg(imagecreatefromgif($_FILES['image']['tmp_name']), $path);
				}
				elseif(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_PNG) {
					imagejpeg(imagecreatefrompng($_FILES['image']['tmp_name']), $path);
				}
				elseif(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_JPEG) {
					move_uploaded_file($_FILES['image']['tmp_name'], $path);
				}	
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('editCategorySuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function delete_category() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			$path = realpath('./assets/uploads').'/category-'.(string)$this->input->post('id').'.jpg';
			if(file_exists($path)) {unlink($path);}
			$this->Admin_Model->deleteCategory($this->input->post('id'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('deleteCategorySuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function add_account() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('category'))) {
			$id = $this->Admin_Model->insertAccount($this->input->post('category'), $this->input->post('date'), $this->input->post('days'), $this->input->post('verified'), $this->input->post('email'), $this->input->post('password'), $this->input->post('price'), $this->input->post('details'));

			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('addAccountSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function edit_account() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('category')) && !empty($this->input->post('id'))) {
			$id = $this->Admin_Model->updateAccount($this->input->post('id'), $this->input->post('category'), $this->input->post('date'), $this->input->post('days'), $this->input->post('verified'), $this->input->post('email'), $this->input->post('password'), $this->input->post('price'), $this->input->post('details'));

			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('editAccountSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function delete_account() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			$this->Admin_Model->deleteAccount($this->input->post('id'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('deleteAccountSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function add_accounts() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('category'))) {
			foreach(explode(PHP_EOL, $this->input->post('data')) as $line) {
				$line = explode(':', $line);
				if(count($line) == 2) {
					$this->Admin_Model->insertAccount($this->input->post('category'), $this->input->post('date'), $this->input->post('days'), $this->input->post('verified'), $line[0], $line[1], $this->input->post('price'), $this->input->post('details'));
				}
			}

			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('addAccountsSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function edit_user() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			$user = $this->Admin_Model->getUserByEmail($this->input->post('email'));
			if(!isset($user['id']) || $user['id'] == $this->input->post('id')) {
				if(empty($this->input->post('password')) || strlen($this->input->post('password')) > 5) {
					$this->Admin_Model->updateUser($this->input->post('id'), $this->input->post('name'), $this->input->post('email'), $this->input->post('password'), $this->input->post('balance'), $this->input->post('role'));
					$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('editUserSuccess'))));		
				}
				else {
					$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('passwordTooShort'))));
				}
			}
			else {
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emailAlreadyUsing'))));
			}
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function delete_user() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			if($this->input->post('id') != $this->user['id']) {
				$this->Admin_Model->deleteUser($this->input->post('id'));
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('deleteUserSuccess'))));	
			}
			else {
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('deleteUserError'))));	
			}
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	public function ticket_reply($id) {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$ticket = $this->Admin_Model->getSupportTicket($id);
		if(isset($ticket['id']) && $ticket['status'] != -1 && !empty($this->input->post('message'))) {
			$this->Admin_Model->insertSupportTicketMessage($id, $this->input->post('message'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('createTicketMessageSuccess'))));
		}
	}
	public function ticket_status() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$ticket = $this->Admin_Model->getSupportTicket($this->input->post('id'));
		if(isset($ticket['id'])) {
			$this->Admin_Model->setSupportTicketStatus($ticket['id'], $this->input->post('status'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('ticketStatusUpdateSuccess'))));
		}
	}
	function add_page() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('name'))) {
			$slug = url_title(convert_accented_characters($this->input->post('name')), 'dash', true);
			$this->Admin_Model->insertPage($this->input->post('name'), $slug, $this->input->post('description'),$this->input->post('tags'),$this->input->post('content'),$this->input->post('menu'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('addPageSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function edit_page() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			$this->Admin_Model->updatePage($this->input->post('id'), $this->input->post('name'), $this->input->post('description'),$this->input->post('tags'),$this->input->post('content'),$this->input->post('menu'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('editPageSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function delete_page() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			$this->Admin_Model->deletePage($this->input->post('id'), $this->input->post('name'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('deletePageSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function add_bank() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('name'))) {
			$id = $this->Admin_Model->insertBankAccount($this->input->post('bank_name'), $this->input->post('name'), $this->input->post('number'));
			$path = realpath('./assets/uploads/banks').'/'.(string)$id.'.png';
			if(file_exists($path)) {unlink($path);}
			if(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_GIF) {
				imagepng(imagecreatefromgif($_FILES['image']['tmp_name']), $path);
			}
			elseif(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_JPEG) {
				imagepng(imagecreatefromjpeg($_FILES['image']['tmp_name']), $path);
			}
			elseif(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_PNG) {
				move_uploaded_file($_FILES['image']['tmp_name'], $path);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('addBankSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function edit_bank() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('name'))) {
			$this->Admin_Model->updateBank($this->input->post('id'), $this->input->post('bank_name'), $this->input->post('name'), $this->input->post('number'));
			if(@is_array(getimagesize($_FILES['image']['tmp_name']))) {
				$path = realpath('./assets/uploads/banks').'/'.(string)$this->input->post('id').'.png';
				if(file_exists($path)) {unlink($path);}
				if(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_GIF) {
					imagepng(imagecreatefromgif($_FILES['image']['tmp_name']), $path);
				}
				elseif(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_JPEG) {
					imagepng(imagecreatefromjpeg($_FILES['image']['tmp_name']), $path);
				}
				elseif(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_PNG) {
					move_uploaded_file($_FILES['image']['tmp_name'], $path);
				}
				}
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('editBankSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function delete_bank() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			$path = realpath('./assets/uploads/banks').'/'.(string)$this->input->post('id').'.png';
			if(file_exists($path)) {unlink($path);}
			$this->Admin_Model->deleteBankAccount($this->input->post('id'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('deleteBankSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	function update_settings() {
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$configs = $this->Admin_Model->getConfigs();
		foreach($_POST as $key=>$value) {
			if(isset($configs[$key]) && $configs[$key] != $value) {
				$this->Admin_Model->updateSetting($key, $value);
			}
		}
		foreach($_FILES as $key=>$file) {
			if(@is_array(getimagesize($_FILES[$key]['tmp_name']))) {
				$path = realpath('./assets/img').'/'.$key.'.png';
				if(file_exists($path)) {unlink($path);}
				if(exif_imagetype($_FILES[$key]['tmp_name']) ==  IMAGETYPE_GIF) {
					imagepng(imagecreatefromgif($_FILES[$key]['tmp_name']), $path);
				}
				elseif(exif_imagetype($_FILES[$key]['tmp_name']) ==  IMAGETYPE_JPEG) {
					imagepng(imagecreatefromjpeg($_FILES[$key]['tmp_name']), $path);
				}
				elseif(exif_imagetype($_FILES[$key]['tmp_name']) ==  IMAGETYPE_PNG) {
					move_uploaded_file($_FILES[$key]['tmp_name'], $path);
				}
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('updateSettingsSuccess'))));
	}
}
