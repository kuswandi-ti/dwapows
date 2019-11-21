<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdor_Close extends CI_Controller {
	
	private $order_by = "do_retur_no";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('mdor_model');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_doretur_trx_close');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$mdorclose['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'mdor/mdor_close/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$mdorclose['paginator'] = $this->pagination->create_links();			
		$mdorclose['data'] = $this->mdor_model->get_close($view_name_trx,$this->order_by,$offset,$limit);
		$this->template->display('mdor/mdor_close_view',$mdorclose);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_doretur_trx_close');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');

		if (isset($_POST['btn-search'])) {			
			$sess_search = array(
				'doretur_date_from' => $this->input->post("cbo_doretur_date_from"),
				'doretur_date_to' => $this->input->post("cbo_doretur_date_to"),
				'grreguler_date_from' => $this->input->post("cbo_grreguler_date_from"),
				'grreguler_date_to' => $this->input->post("cbo_grreguler_date_to")
			);
			$this->session->set_userdata($sess_search);
		} else {
		
		}
		
		$doretur_date_from = $this->session->userdata('doretur_date_from');
		$doretur_date_to = $this->session->userdata('doretur_date_to');
		$grreguler_date_from = $this->session->userdata('grreguler_date_from');
		$grreguler_date_to = $this->session->userdata('grreguler_date_to');
	
		$page = $this->uri->segment($uri_segment);
		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;
		
		$where_doretur_date = "(do_retur_date BETWEEN '".$doretur_date_from."' 
		                      AND '".$doretur_date_to."')";
		$where_grreguler_date = "(gr_regular_date BETWEEN '".$grreguler_date_from."' 
		                        AND '".$grreguler_date_to."')";
		
		if (!empty($doretur_date_from) && !empty($doretur_date_to)) {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_doretur_date;
		} else if (!empty($grreguler_date_from) && !empty($grreguler_date_to)) {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_grreguler_date;
		} else {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' 
			       AND ".$where_doretur_date." AND ".$where_grreguler_date;
		}
			
		$mdorclose['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'mdor/mdor_close/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$mdorclose['paginator'] = $this->pagination->create_links();	
		$mdorclose['data'] = $this->mdor_model->search($sql,$this->order_by,$offset,$limit);
		$this->template->display('mdor/mdor_close_view',$mdorclose);
	}
	
}

/* End of file mdor_close.php */
/* Location: ./application/controllers/mdor_close.php */