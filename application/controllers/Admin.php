<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
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
	public function index()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('adminPanel'),
			'page' => 'admin-panel',
			'user' => $this->user
		));
		$this->load->view('admin/panel', array(
			'totalBalance' => $this->Admin_Model->getTotalBalance(),
			'pendingPaymentNotificationsCount' => $this->Admin_Model->getPendingPaymentNotificationsCount(),
			'activeSupportTicketsCount' => $this->Admin_Model->getActiveSupportTicketsCount(),
			'pendingPaymentNotifications' => $this->Admin_Model->getPendingPaymentNotifications(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function categories()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('categories'),
			'page' => 'categories',
			'user' => $this->user
		));
		$this->load->view('admin/categories', array(
			'categories' => $this->Admin_Model->getCategories(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function add_category()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('addCategory'),
			'page' => 'categories',
			'user' => $this->user
		));
		$this->load->view('admin/add_category', array(
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function edit_category($id)
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$category = $this->Admin_Model->getCategory($id);
		if(!isset($category['id'])) {
			redirect(base_url('admin/categories'));
			exit;
		}
		$this->load->view('admin/header', array(
			'title' => lang('editCategory'),
			'page' => 'categories',
			'user' => $this->user
		));
		$this->load->view('admin/edit_category', array(
			'category' => $category,
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function accounts()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('sellingAccounts'),
			'page' => 'accounts',
			'user' => $this->user
		));
		$this->load->view('admin/accounts', array(
			'accounts' => $this->Admin_Model->getAccounts(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function add_account()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('addAccount'),
			'page' => 'accounts',
			'user' => $this->user
		));
		$this->load->view('admin/add_account', array(
			'categories' => $this->Admin_Model->getCategories(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function edit_account($id)
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$account = $this->Admin_Model->getAccount($id);
		if(!isset($account['id'])) {
			redirect(base_url('admin/accounts'));
			exit;
		}
		$this->load->view('admin/header', array(
			'title' => lang('editAccount'),
			'page' => 'accounts',
			'user' => $this->user
		));
		$this->load->view('admin/edit_account', array(
			'categories' => $this->Admin_Model->getCategories(),
			'account' => $account,
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function payments()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('paymentNotifications'),
			'page' => 'payments',
			'user' => $this->user
		));
		$this->load->view('admin/payments', array(
			'bank_accounts' => $this->Admin_Model->getBankAccounts(),
			'payment_notifications' => $this->Admin_Model->getPaymentNotifications(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function users()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('users'),
			'page' => 'users',
			'user' => $this->user
		));
		$this->load->view('admin/users', array(
			'users' => $this->Admin_Model->getUsers(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function edit_user($id)
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$user = $this->Admin_Model->getUserById($id);
		if(!isset($user['id'])) {
			redirect(base_url('admin/users'));
			exit;
		}
		$this->load->view('admin/header', array(
			'title' => lang('editUser'),
			'page' => 'users',
			'user' => $this->user
		));
		$this->load->view('admin/edit_user', array(
			'payments' => $this->Admin_Model->getUserPaymentNotifications($user["id"]),
			'bank_accounts' => $this->Admin_Model->getBankAccounts(),
			'accounts' => $this->Admin_Model->getUserAccounts($user["id"]),
			'user' => $user,
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function tickets()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('supportTickets'),
			'page' => 'tickets',
			'user' => $this->user
		));
		$this->load->view('admin/tickets', array(
			'tickets' => $this->Admin_Model->getTickets(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function ticket($id)
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$ticket = $this->Admin_Model->getSupportTicket($id);
		if(!isset($ticket['title'])) {redirect(base_url('admin/tickets'));}
		$ticket_messages = $this->Admin_Model->getSupportTicketMessages($id);
		$this->load->view('admin/header', array(
			'title' => sprintf(lang('supportTicket'), $ticket['title']),
			'page' => 'tickets',
			'user' => $this->user
		));
		$this->load->view('admin/ticket', array(
			'ticket_user' => $this->Admin_Model->getUserById($ticket['user']),
			'ticket' => $ticket,
			'ticket_messages' => $ticket_messages,
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function pages()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('pages'),
			'page' => 'pages',
			'user' => $this->user
		));
		$this->load->view('admin/pages', array(
			'pages' => $this->Admin_Model->getPages(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function add_page()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('addPage'),
			'page' => 'pages',
			'user' => $this->user
		));
		$this->load->view('admin/add_page', array(
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function edit_page($id)
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$page = $this->Admin_Model->getPage($id);
		if(!isset($page['id'])) {redirect(base_url('admin/pages'));}
		$this->load->view('admin/header', array(
			'title' => lang('editPage'),
			'page' => 'pages',
			'user' => $this->user
		));
		$this->load->view('admin/edit_page', array(
			'page' => $page,
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function banks()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('bankAccounts'),
			'page' => 'banks',
			'user' => $this->user
		));
		$this->load->view('admin/banks', array(
			'banks' => $this->Admin_Model->getBankAccounts(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function add_bank()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$this->load->view('admin/header', array(
			'title' => lang('addBank'),
			'page' => 'pages',
			'user' => $this->user
		));
		$this->load->view('admin/add_bank', array(
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function edit_bank($id)
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$bank = $this->Admin_Model->getBankAccount($id);
		if(!isset($bank['id'])) {redirect(base_url('admin/banks'));}
		$this->load->view('admin/header', array(
			'title' => lang('editBank'),
			'page' => 'banks',
			'user' => $this->user
		));
		$this->load->view('admin/edit_bank', array(
			'bank' => $bank,
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
	public function settings()
	{
		$this->lang->load(array('common', 'admin'), $this->config->item('site_lang'));
		$page = 'general';
		$title = lang('siteSettings');
		switch($this->input->get('page')) {
			case 'recaptcha':
				$page = 'recaptcha';
				$title = lang('recaptchaSettings');
			break;
			case 'smtp':
				$page = 'smtp';
				$title = lang('smtpSettings');
			break;
			case 'payment':
				$page = 'payment';
				$title = lang('paymentSettings');
			break;
			default:
				$page = 'general';
				$title = lang('siteSettings');
			break;
		}
		$this->load->view('admin/header', array(
			'title' => $title,
			'page' => 'settings',
			'user' => $this->user,
			'p' => $page,
		));
		$this->load->view('admin/settings', array(
			'page' => $page,
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('admin/footer');
	}
}
