<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Di_Histories extends CI_Controller {
	
	private $order_by = "di_status_date DESC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('di_model');
		$this->load->helper('download');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_hst = $this->config->item('view_name_di_hst');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$dihistories['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'di/di_histories/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$dihistories['paginator'] = $this->pagination->create_links();			
		$dihistories['data'] = $this->di_model->get_all($view_name_hst,$this->order_by,$offset,$limit);
		$this->template->display('di/di_history_view',$dihistories);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_hst = $this->config->item('view_name_di_hst');
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
			
		$direleases['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'di/di_releases/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$direleases['paginator'] = $this->pagination->create_links();	
		$direleases['data'] = $this->di_model->search($sql,$this->order_by,$offset,$limit);
		$this->template->display('di/di_history_view',$direleases);
	}
	
	function redownload() {
		$table_name_hst = $this->config->item('table_name_di_hst');

		if ($this->input->post('id')) {
			/* ------------------------------------------------------------------------------------------------------------ */
			/* http://stackoverflow.com/questions/14286253/pass-a-value-from-controller-json-to-view-ajax-in-codeigniter */
			$id = $this->input->post('id');
			$sql = "SELECT pdf_file FROM ".$table_name_hst." WHERE id='".$id."' LIMIT 1"; 
  			$data['res'] = $this->db->query($sql)->row()->pdf_file;
            echo json_encode($data);
            /* ------------------------------------------------------------------------------------------------------------ */					
		}
	}

	function download($pdf_file = '') {
		$table_name_hst = $this->config->item('table_name_di_hst');

		$sql = "UPDATE ".$table_name_hst." SET count_download=count_download+1 WHERE pdf_file='".$pdf_file."'";
		$this->db->query($sql);	
		
		$data = "Delivery Instruction (DI)";
		$data = file_get_contents('../upload/'.$pdf_file);
//		$data = file_get_contents('\\\\192.168.0.39\htdocs\upload\\'.$pdf_file);
		force_download($pdf_file,$data);
	}
	
}

/* End of file di_histories.php */
/* Location: ./application/controllers/di_histories.php */