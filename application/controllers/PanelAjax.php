<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PanelAjax extends CI_Controller {
	private $user = array();
	public function __construct() {
		parent::__construct();
		$this->load->model('Panel_Model');
		if($this->session->has_userdata('user')) {
			$this->user = $this->Panel_Model->getUserById($this->session->userdata('user'));
			if(!isset($this->user['id'])) {
				session_destroy();
				redirect(base_url('login'));
				exit;
			}
		}
		else {
			redirect(base_url('login'));
			exit;
		}
	}
	public function buy_account() {
		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		if(!empty($this->input->post('id'))) {
			$account = $this->Panel_Model->getAccount($this->input->post('id'));
			if($this->user['balance'] >= $account['price'] && $account['user'] == 0) {
				$this->Panel_Model->buyAccount((int)$this->input->post('id'), $this->session->userdata('user'), $account['price']);
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('buySuccess'))));
			}	
			else {
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('balanceNotEnough'))));
			}
		}
	}
	public function bulk_download() {
		$this->lang->load(array('panel'), $this->config->item('site_lang'));
		if(!empty($this->input->post('category')) && !empty($this->input->post('filter'))) {
			$accounts = $this->Panel_Model->getUserAccountsCategory($this->session->userdata('user'),$this->input->post('category'), $this->input->post('filter'));
			$res = "";
			if(is_array($accounts)) {
			$res .= lang("bulkDownloadText")."<br/><br/>";
			foreach($accounts as $account) {
				$res .= $account["email"].":".$account["password"]."<br/>";
			}
			}
			$this->output->set_content_type('text/html', 'UTF-8')->set_output($res);
		}
	}
	public function create_ticket() {
		$this->lang->load(array('panel'), $this->config->item('site_lang'));
		if(!empty($this->input->post('title')) && !empty($this->input->post('message'))) {
			$ticket_id = $this->Panel_Model->insertSupportTicket($this->session->userdata('user'),$this->input->post('title'), $this->input->post('message'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('createTicketSuccess'), 'redirect' => './support/'.strval($ticket_id))));
		}
	}
	public function ticket_reply($id) {
		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		$ticket = $this->Panel_Model->getSupportTicket($this->session->userdata('user'), $id);
		if(isset($ticket['id']) && $ticket['status'] != -1 && !empty($this->input->post('message'))) {
			$this->Panel_Model->insertSupportTicketMessage($this->session->userdata('user'), $id, $this->input->post('message'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('createTicketMessageSuccess'))));
		}
	}
	public function payment_notification() {
		$this->lang->load(array('panel'), $this->config->item('site_lang'));
		if(!empty($this->input->post('bank')) && !empty($this->input->post('name')) && !empty($this->input->post('amount'))) {
			$this->Panel_Model->insertPaymentNotification($this->session->userdata('user'),$this->input->post('bank'), $this->input->post('name'), $this->input->post('amount'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('createPaymentNotificationSuccess'))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	public function profile_update() {
		$this->lang->load(array('panel'), $this->config->item('site_lang'));
		if(!empty($this->input->post('name'))) {
			if(empty($this->input->post('password')) || strlen($this->input->post('password')) > 5) {
			$this->Panel_Model->updateProfile($this->user['id'], $this->input->post('name'), $this->input->post('password'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('profileUpdateSuccess'))));
			}
			else {
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('passwordTooShort'))));
			}
		}
	}
	public function bulk_buy_price() {
		$this->lang->load(array('panel'), $this->config->item('site_lang'));
		$acc_count = $this->Panel_Model->getAccountsCount((int)$this->input->post('category'));
		if($acc_count >= (int)$this->input->post('piece')) {
			$price = $this->Panel_Model->getAccountsTotalPrice((int)$this->input->post('category'), (int)$this->input->post('piece'));
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => sprintf(lang('stockText'), (int)$this->input->post('piece'), $price, $this->config->item('site_money_sign')))));
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => sprintf(lang('stockErrorText'), $acc_count))));
		}
	}
	public function bulk_buy() {
		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		if(!empty($this->input->post('category')) && !empty($this->input->post('piece'))) {
			$price = $this->Panel_Model->getAccountsTotalPrice((int)$this->input->post('category'), (int)$this->input->post('piece'));
			if($this->user['balance'] >= $price) {
				$this->Panel_Model->buyBulkAccounts($this->session->userdata('user'), (int)$this->input->post('category'), (int)$this->input->post('piece'), $price);
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('bulkBuySuccess'))));
			}	
			else {
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('balanceNotEnough'))));
			}
		}
	}
}
