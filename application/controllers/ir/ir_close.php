<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ir_Close extends CI_Controller {
	
	private $order_by = "di_release_date DESC,di_no ASC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('ir_model');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_hst = $this->config->item('view_name_ir_hst');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$irclose['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'ir/ir_close/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$irclose['paginator'] = $this->pagination->create_links();			
		$irclose['data'] = $this->ir_model->get_all($view_name_hst,$this->order_by,$offset,$limit);
		$this->template->display('ir/ir_close_view',$irclose);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_hst = $this->config->item('view_name_ir_hst');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');

		if (isset($_POST['btn-search'])) {			
			$sess_search = array(
				'di_delivery_datetime' => $this->input->post("cbo_di_delivery_datetime"),
				'di_date_from' => $this->input->post("di_date_from"),
				'di_date_to' => $this->input->post("di_date_to")
			);
			$this->session->set_userdata($sess_search);
		} else {
		
		}
		
		$di_delivery_datetime = $this->session->userdata('di_delivery_datetime');
		$di_date_from = $this->session->userdata('di_date_from');
		$di_date_to = $this->session->userdata('di_date_to');
	
		$page = $this->uri->segment($uri_segment);
		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;
		
		$where_di_delivery_datetime = "di_delivery_datetime='".$di_delivery_datetime."'";
		$where_di_date = "(di_date BETWEEN '".$di_date_from."' 
		                 AND '".$di_date_to."')";
		
		if (empty($di_date_from) or empty($di_date_to)) {
			$sql = "SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."' AND ".$where_di_delivery_datetime;
		} else {
			$sql = "SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."' AND ".$where_di_date;
		}
			
		$irclose['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'ir/ir_close/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$irclose['paginator'] = $this->pagination->create_links();	
		$irclose['data'] = $this->ir_model->search($sql,$this->order_by,$offset,$limit);
		$this->template->display('ir/ir_close_view',$irclose);
	}
	
}

/* End of file ir_close.php */
/* Location: ./application/controllers/ir_close.php */