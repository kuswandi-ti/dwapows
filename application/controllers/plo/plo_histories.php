<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plo_Histories extends CI_Controller {
	
	private $order_by = "plo_status_date DESC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('plo_model');
		$this->load->helper('download');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_hst = $this->config->item('view_name_plo_hst');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$plohistories['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'plo/plo_histories/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$plohistories['paginator'] = $this->pagination->create_links();			
		$plohistories['data'] = $this->plo_model->get_all($view_name_hst,$this->order_by,$offset,$limit);
		$this->template->display('plo/plo_history_view',$plohistories);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_hst = $this->config->item('view_name_plo_hst');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');

		if (isset($_POST['btn-search'])) {			
			$sess_search = array(
				'plo_period_month' => $this->input->post("cbo_plo_period_month"),
				'plo_period_year' => $this->input->post("cbo_plo_period_year"),
				'plo_date_from' => $this->input->post("plo_date_from"),
				'plo_date_to' => $this->input->post("plo_date_to")
			);
			$this->session->set_userdata($sess_search);
		} else {
		
		}
		
		$plo_period_month = $this->session->userdata('plo_period_month');
		$plo_period_year = $this->session->userdata('plo_period_year');
		$plo_date_from = $this->session->userdata('plo_date_from');
		$plo_date_to = $this->session->userdata('plo_date_to');
	
		$page = $this->uri->segment($uri_segment);
		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;
		
		$where_plo_period = "plo_period_month='".$plo_period_month."' 
		                    AND plo_period_year='".$plo_period_year."'";
		$where_plo_date = "(plo_date BETWEEN '".$plo_date_from."' 
		                  AND '".$plo_date_to."')";
		
		if (empty($plo_date_from) or empty($plo_date_to)) {
			$sql = "SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."' AND ".$where_plo_period;
		} else {
			$sql = "SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."' AND ".$where_plo_date;
		}
			
		$plohistories['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'plo/plo_histories/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$plohistories['paginator'] = $this->pagination->create_links();	
		$plohistories['data'] = $this->plo_model->search($sql,$this->order_by,$offset,$limit);
		$this->template->display('plo/plo_history_view',$plohistories);
	}
	
	function redownload() {
		$table_name_hst = $this->config->item('table_name_plo_hst');

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
		$table_name_hst = $this->config->item('table_name_plo_hst');

		$sql = "UPDATE ".$table_name_hst." SET count_download=count_download+1 WHERE pdf_file='".$pdf_file."'";
		$this->db->query($sql);	
		
		$data = "Plan Order (FO)";
		$data = file_get_contents('../upload/'.$pdf_file);
//		$data = file_get_contents('\\\\192.168.0.39\htdocs\upload\\'.$pdf_file);
		force_download($pdf_file,$data);
	}
	
}

/* End of file plo_histories.php */
/* Location: ./application/controllers/plo_histories.php */