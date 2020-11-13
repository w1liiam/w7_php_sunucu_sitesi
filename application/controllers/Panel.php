<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {
	private $user = array();
	private $pagination_config = array(
		'per_page' => 7,
		'page_query_string' => TRUE,
		'full_tag_open' => '<ul class="pagination">',
		'full_tag_close' => '</ul>',
		'attributes' => array('class' => 'page-link'),
		'first_link' => false,
		'last_link' => false,
		'first_tag_open' => '<li class="page-item">',
		'first_tag_close' => '</li>',
		'prev_link' => '&laquo',
		'prev_tag_open' => '<li class="page-item">',
		'prev_tag_close' => '</li>',
		'next_link' => '&raquo',
		'next_tag_open' => '<li class="page-item">',
		'next_tag_close' => '</li>',
		'last_tag_open' => '<li class="page-item">',
		'last_tag_close' => '</li>',
		'cur_tag_open' => '<li class="page-item active"><a href="javascript:;" class="page-link">',
		'cur_tag_close' => '<span class="sr-only">(current)</span></a></li>',
		'num_tag_open' => '<li class="page-item">',
		'num_tag_close' => '</li>'
	);
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
	public function index()
	{
		$this->load->model('Home_Model');
		$this->lang->load(array('common', 'panel', 'home'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'title' => lang('userPanel'),
			'page' => 'panel',
			'user' => $this->user
		));
		$this->load->view('panel', array(
			'categories' => $this->Home_Model->getActiveCategories(),
			'account_count' => $this->Panel_Model->getUserAccountCount($this->user['id']),
			'spended_amount' => $this->Panel_Model->getUserAccountSum($this->user['id'])
		));
		$this->load->view('footer');
	}
	public function my_accounts()
	{
		$this->load->library('pagination');
		$this->load->model('Home_Model');
		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'title' => lang('userPanel'),
			'page' => 'my-accounts',
			'user' => $this->user
		));
		$filter = 'month';
		if(!empty($this->input->get('filter'))) {
			switch($this->input->get('filter')) {
				case 'day':
					$filter = 'day';
				break;
				case 'week':
					$filter  = 'week';
				break;
				case 'all':
					$filter = 'all';
				break;
				default:
					$filter = 'month';
			}
		}
		$config = $this->pagination_config;
		$config['base_url'] = current_url();
		$config['total_rows'] = $this->Panel_Model->getUserAccountsCount($this->session->userdata('user'), $filter);

        $this->pagination->initialize($config);

		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		$this->load->view('my-accounts', array(
			'results' => $this->Panel_Model->getUserAccounts($this->session->userdata('user'), $config['per_page'], !empty($this->input->get('per_page')) && $this->input->get('per_page') <= ceil($config['total_rows']) ? $this->input->get('per_page') : 0, $filter),
			'links' => $this->pagination->create_links(),
			'filter' => $filter,
			'categories' => $this->Panel_Model->getActiveCategories(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('footer');
	}
	public function support_tickets()
	{
		$this->load->library('pagination');
		$config = $this->pagination_config;
		$config['base_url'] = current_url();
        $config['total_rows'] = $this->Panel_Model->getSupportTicketsCount($this->user['id']);
		
        $this->pagination->initialize($config);

		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'title' => lang('supportTickets'),
			'page' => 'support',
			'user' => $this->user
		));
		$this->load->view('support-tickets', array(
			'results' => $this->Panel_Model->getSupportTickets($this->user['id'], $config['per_page'], !empty($this->input->get('per_page')) && $this->input->get('per_page') <= ceil($config['total_rows']) ? $this->input->get('per_page') : 0),
			'links' => $this->pagination->create_links(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('footer');
	}
	public function support_ticket($id)
	{
		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		$ticket = $this->Panel_Model->getSupportTicket($this->session->userdata('user'), $id);
		if(!isset($ticket['title'])) {redirect('./support');}
		$ticket_messages = $this->Panel_Model->getSupportTicketMessages($this->session->userdata('user'), $id);
		$this->load->view('header', array(
			'title' => sprintf(lang('supportTicket'), $ticket['title']),
			'page' => 'support',
			'user' => $this->user
		));
		$this->load->view('support-ticket', array(
			'ticket' => $ticket,
			'ticket_messages' => $ticket_messages,
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('footer');
	}
	public function add_balance()
	{
		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'title' => lang('addBalance'),
			'page' => 'add-balance',
			'user' => $this->user
		));
		$this->load->view('add-balance', array(
			'bank_accounts' => $this->Panel_Model->getBankAccounts(),
			'status' => $this->input->get('status'),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('footer');
	}
	public function profile()
	{
		$this->load->library('pagination');
		$config = $this->pagination_config;
		$config['base_url'] = current_url();
        $config['total_rows'] = $this->Panel_Model->getPaymentNotificationsCount($this->user['id']);
		$config['per_page'] = 5;

        $this->pagination->initialize($config);

		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'title' => lang('myProfile'),
			'page' => 'profile',
			'user' => $this->user
		));
		$this->load->view('profile', array(
			'bank_accounts' => $this->Panel_Model->getBankAccounts(),
			'results' => $this->Panel_Model->getPaymentNotifications($this->user['id'], $config['per_page'], !empty($this->input->get('per_page')) && $this->input->get('per_page') <= ceil($config['total_rows']) ? $this->input->get('per_page') : 0),
			'links' => $this->pagination->create_links(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('footer');
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
