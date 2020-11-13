<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Home_Model');
		if($this->session->has_userdata('user')) {
			redirect(base_url());
			exit;
		}
	}
	public function login()
	{
		$this->load->model('Auth_Model');
		$this->lang->load(array('common', 'auth'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'pages' => $this->Home_Model->getPages(),
			'title' => lang('login'),
			'page' => 'login'
		));
		$this->load->view('login', array(
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('footer');
	}
	public function register()
	{
		$this->load->model('Auth_Model');
		$this->lang->load(array('common', 'auth'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'pages' => $this->Home_Model->getPages(),
			'title' => lang('register'),
			'page' => 'register'
		));
		$this->load->view('register', array(
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('footer');
	}
	public function reset_password($key = null)
	{
		$this->load->model('Auth_Model');
		$this->lang->load(array('common', 'auth'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'pages' => $this->Home_Model->getPages(),
			'title' => lang('resetPassword'),
			'page' => 'reset-password'
		));
		$this->load->view('reset-password', array(
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			),
			'key' => $key
		));
		$this->load->view('footer');
	}
	public function validateRecaptcha($r) {
		if($this->config->item("recaptcha_enabled") == "1") {
			return json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$this->config->item('recaptcha_secret_key').'&response='.$r.'&remoteip='.$_SERVER['REMOTE_ADDR']), true)['success'];
		}
		else {
			return true;
		}
	}
	public function login_post() {
		$this->load->model('Auth_Model');
		$this->lang->load(array('common', 'auth'), $this->config->item('site_lang'));

		if(!empty($this->input->post('email')) && !empty($this->input->post('password'))) {
			if($this->validateRecaptcha($this->input->post('g-recaptcha-response'))) {
				$user = $this->Auth_Model->getUser($this->input->post('email'),$this->input->post('password'));
				if(isset($user['id'])) {
					$this->session->set_userdata('user', $user['id']);
					$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('loginSuccess'))));
				}
				else {
					$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('loginFailed'))));
				}
			}
			else {
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('recaptchaFailed'))));
			}
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('loginFailed'))));
		}
	}
	public function register_post() {
		$this->load->model('Auth_Model');
		$this->lang->load(array('common', 'auth'), $this->config->item('site_lang'));

		if(!empty($this->input->post('name')) && !empty($this->input->post('email')) && !empty($this->input->post('password')) && !empty($this->input->post('password_again'))) {
			if($this->validateRecaptcha($this->input->post('g-recaptcha-response'))) {
				if(strlen($this->input->post('password')) > 5) {
					if($this->input->post('password') == $this->input->post('password_again')) {
						if(!isset($this->Auth_Model->getUserByEmail($this->input->post('email'))['id'])) {
							$user_id = $this->Auth_Model->insertUser($this->input->post('name'), $this->input->post('email'), $this->input->post('password'));
							$this->session->set_userdata('user', $user_id);
							$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('registerSuccess'))));	
						}
						else {
							$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emailAlreadyUsing'))));	
						}
					}
					else {
						$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('passwordsNotEqual'))));
					}
				}
				else {
					$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('passwordTooShort'))));
				}
			}
			else {
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('recaptchaFailed'))));
			}
		}
		else {
			$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
		}
	}
	public function reset_password_post($key = null) {
		$this->load->model('Auth_Model');
		$this->lang->load(array('common', 'auth'), $this->config->item('site_lang'));

		if(is_null($key)) {
			if(!empty($this->input->post('email'))) {
				if($this->validateRecaptcha($this->input->post('g-recaptcha-response'))) {
					$user = $this->Auth_Model->getUserByEmail($this->input->post('email'));
					if(isset($user['id'])) {
						$hash = md5($user['email'].$user['password'].date('d-m-Y'));
						$reset_url = base_url('reset-password/'.$hash);
						$email_body = $this->load->view('email/reset_password', array('reset_url' => $reset_url), true);
						$this->load->library('email');
						$this->email->initialize(array(
							'protocol' => 'smtp',
							'smtp_host' => $this->config->item('smtp_host'),
							'smtp_user' => $this->config->item('smtp_user'),
							'smtp_pass' => $this->config->item('smtp_pass'),
							'smtp_port' => $this->config->item('smtp_port'),
							'mailtype' => 'html'
						));
						$this->email->set_newline("\r\n");
						$this->email->from($this->config->item('smtp_user'), $this->config->item('site_name'));
						$this->email->to($user['email']);
						$this->email->subject(lang('resetPassword').' - '.$this->config->item('site_name'));
						$this->email->set_mailtype('html');
						$this->email->message($email_body);
						$this->email->send();
						$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('resetPasswordEmailSent'))));
					}
					else {
						$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emailNotValid'))));
					}
				}
				else {
					$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('recaptchaFailed'))));
				}
			}
			else {
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
			}
		}
		else {
			if(!empty($this->input->post('password'))) {
				if($this->validateRecaptcha($this->input->post('g-recaptcha-response'))) {
					if(strlen($this->input->post('password')) > 5) {
						$this->Auth_Model->resetPassword($key, $this->input->post('password'));
						$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'message' => lang('passwordResetSuccess'))));
					}
					else {
						$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('passwordTooShort'))));
					}	
				}
				else {
					$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('recaptchaFailed'))));
				}
			}
			else {
				$this->output->set_content_type('application/json')->set_output(json_encode(array('success' => false, 'message' => lang('emptyFieldsFound'))));
			}
		}
	}
}
