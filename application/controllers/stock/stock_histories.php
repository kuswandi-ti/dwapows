<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_Histories extends CI_Controller {
	
	private $order_by = "part_number ASC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('stock_model');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_stock_hst');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$stockreleases['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'stock/stock_histories/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$stockreleases['paginator'] = $this->pagination->create_links();			
		$stockreleases['data'] = $this->stock_model->get_all($view_name_trx,$this->order_by,$offset,$limit);
		$this->template->display('stock/stock_history_view',$stockreleases);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_stock_hst');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');

		if (isset($_POST['btn-search'])) {			
			$sess_search = array(
				'sess_part_number' => $this->input->post("txt_part_number")
			);
			$this->session->set_userdata($sess_search);
		} else {
		
		}
		
		$var_part_number = $this->session->userdata('sess_part_number');
	
		$page = $this->uri->segment($uri_segment);
		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;
		
		$where_search = "part_number LIKE '%".$var_part_number."%' OR part_name LIKE '%".$var_part_number."%'";
		
		$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_search;
			
		$stockreleases['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'stock/stock_histories/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$stockreleases['paginator'] = $this->pagination->create_links();	
		$stockreleases['data'] = $this->stock_model->search($sql,$this->order_by,$offset,$limit);
		$this->template->display('stock/stock_history_view',$stockreleases);
	}
	
}

/* End of file stock_releases.php */
/* Location: ./application/controllers/stock_releases.php */