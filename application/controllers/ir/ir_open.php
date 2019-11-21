<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ir_Open extends CI_Controller {
	
	private $order_by = "tt_no,invoice_no";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('ir_model');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_ir_trx_hdr');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$iropen['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'ir/ir_open/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$iropen['paginator'] = $this->pagination->create_links();			
		$iropen['data'] = $this->ir_model->get_all($view_name_trx,$this->order_by,$offset,$limit);
		$this->template->display('ir/ir_open_view',$iropen);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_ir_trx_hdr');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');

		if (isset($_POST['btn-search'])) {			
			$sess_search = array(
				'tt_date_from' => $this->input->post("cbo_tt_date_from"),
				'tt_date_to' => $this->input->post("cbo_tt_date_to"),
				'invoice_date_from' => $this->input->post("cbo_invoice_date_from"),
				'invoice_date_to' => $this->input->post("cbo_invoice_date_to")
			);
			$this->session->set_userdata($sess_search);
		} else {
		
		}
		
		$tt_date_from = $this->session->userdata('tt_date_from');
		$tt_date_to = $this->session->userdata('tt_date_to');
		$invoice_date_from = $this->session->userdata('invoice_date_from');
		$invoice_date_to = $this->session->userdata('invoice_date_to');
	
		$page = $this->uri->segment($uri_segment);
		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;
		
		$where_tt_date = "(tt_date BETWEEN '".$tt_date_from."' 
		                 AND '".$tt_date_to."')";
		$where_invoice_date = "(invoice_date BETWEEN '".$invoice_date_from."' 
		                      AND '".$invoice_date_to."')";
		
		if (!empty($tt_date_from) && !empty($tt_date_to)) {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_tt_date;
		} else if (!empty($invoice_date_from) && !empty($invoice_date_to)) {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_invoice_date;
		} else {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' 
			       AND ".$where_tt_date." AND ".$where_invoice_date;
		}
			
		$iropen['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'ir/ir_open/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$iropen['paginator'] = $this->pagination->create_links();	
		$iropen['data'] = $this->ir_model->search($sql,$this->order_by,$offset,$limit);
		$this->template->display('ir/ir_open_view',$iropen);
	}
	
	public function detail() {	
		$irdetail['data'] = $this->ir_model->detail_by_id($this->config->item('view_name_ir_trx_dtl'),$_GET['id']);
		$irdetail['vendor_code'] = $_GET['vendor_code'];
		$irdetail['tt_no'] = $_GET['tt_no'];
		$irdetail['inv_no'] = $_GET['inv_no'];
		$irdetail['invoice_status'] = $_GET['invoice_status'];
		$this->load->view('ir/ir_detail_view',$irdetail);
	}
	
}

/* End of file ir_open.php */
/* Location: ./application/controllers/ir_open.php */