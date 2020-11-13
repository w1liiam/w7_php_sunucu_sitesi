<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	private $user = array();
	public function __construct() {
		parent::__construct();
		$this->load->model('Home_Model');
		$this->load->model('Panel_Model');
		if($this->session->has_userdata('user')) {
			$this->user = $this->Panel_Model->getUserById($this->session->userdata('user'));
			if(!isset($this->user['id'])) {
				session_destroy();
				redirect(base_url('login'));
				exit;
			}
		}
	}
	public function index()
	{
		$this->lang->load(array('common', 'home'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'pages' => $this->Home_Model->getPages(),
			'title' => lang('home'),
			'page' => 'home',
			'user' => $this->user
		));
		$this->load->view('home', array(
			'categories' => $this->Home_Model->getActiveCategories()
		));
		$this->load->view('footer');
	}
	public function category($id)
	{
        $this->load->library('pagination');
		$category = $this->Panel_Model->getCategory($id);
		if(!isset($category['id'])) redirect(base_url());
		$config = array();
        $config['total_rows'] = $this->Panel_Model->getAccountsCount($id);
		$config['per_page'] = 7;
		$config['base_url'] = current_url();
		$config['page_query_string'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['attributes'] = ['class' => 'page-link'];
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="javascript:;" class="page-link">';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		
        $this->pagination->initialize($config);

		$this->lang->load(array('common', 'panel'), $this->config->item('site_lang'));
		$this->load->view('header', array(
			'pages' => $this->Home_Model->getPages(),
			'title' => $category['name'],
			'page' => 'category',
			'user' => $this->user
		));
		$this->load->view('category', array(
			'category' => $category,
			'results' => $this->Panel_Model->getAccounts($id, $config['per_page'], !empty($this->input->get('per_page')) && $this->input->get('per_page') <= ceil($config['total_rows']) ? $this->input->get('per_page') : 0),
			'links' => $this->pagination->create_links(),
			'csrf' => array(
				'name' => $this->security->get_csrf_token_name(),
				'hash' => $this->security->get_csrf_hash()
			)
		));
		$this->load->view('footer');
	}
	public function page($slug)
	{
		$this->lang->load(array('common', 'home'), $this->config->item('site_lang'));
		$page = $this->Home_Model->getPage($slug);
		if(!isset($page['id'])) {redirect(base_url());exit;}
		$this->load->view('header', array(
			'pages' => $this->Home_Model->getPages(),
			'title' => $page["name"],
			'page' => $slug,
			'user' => $this->user,
			'p' => $page
		));
		$this->load->view('page', array('page' => $page));
		$this->load->view('footer');
	}
	public function page_not_found() {
		$this->lang->load(array('home'), $this->config->item('site_lang'));
		$this->load->view('404');
	}
	public function sitemap() {
		header('Content-Type: text/xml');
		$pages = $this->Home_Model->getPages();
		$categories = $this->Home_Model->getActiveCategories();
		?>
<?php echo '<'; ?>?xml version="1.0" encoding="UTF-8"?>
		<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
			<url>
				<loc><?php echo base_url(); ?></loc>
				<lastmod><?php echo date('c', 1590278400); ?></lastmod>
			</url>
			<url>
				<loc><?php echo base_url('login'); ?></loc>
				<lastmod><?php echo date('c', 1590278400); ?></lastmod>
			</url>
			<url>
				<loc><?php echo base_url('register'); ?></loc>
				<lastmod><?php echo date('c', 1590278400); ?></lastmod>
			</url>
			<?php foreach($pages as $page): ?>
			<url>
				<loc><?php echo base_url($page['slug']); ?></loc>
				<lastmod><?php echo date('c', 1590278400); ?></lastmod>
			</url>
			<?php endforeach; ?>
			<?php foreach($categories as $category): ?>
			<url>
				<loc><?php echo base_url(url_title(convert_accented_characters($category["name"]), "dash", true)."-".strval($category["id"])); ?></loc>
				<lastmod><?php echo date('c', 1590278400); ?></lastmod>
			</url>
			<?php endforeach; ?>
			</urlset>
		<?php
	}
}
