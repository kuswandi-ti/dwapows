<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifikasi_Histories extends CI_Controller {
	
	private $order_by = "verifikasi_status_date DESC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('verifikasi_model');
		$this->load->helper('download');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_hst = $this->config->item('view_name_verifikasi_hst');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$verifikasihistories['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'verifikasi/verifikasi_histories/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$verifikasihistories['paginator'] = $this->pagination->create_links();			
		$verifikasihistories['data'] = $this->verifikasi_model->get_all($view_name_hst,$this->order_by,$offset,$limit);
		$this->template->display('verifikasi/verifikasi_history_view',$verifikasihistories);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_hst = $this->config->item('view_name_verifikasi_hst');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');

		if (isset($_POST['btn-search'])) {			
			$sess_search = array(
				'verifikasi_period_month' => $this->input->post("cbo_verifikasi_period_month"),
				'verifikasi_period_year' => $this->input->post("cbo_verifikasi_period_year"),
				'verifikasi_date_from' => $this->input->post("verifikasi_date_from"),
				'verifikasi_date_to' => $this->input->post("verifikasi_date_to")
			);
			$this->session->set_userdata($sess_search);
		} else {
		
		}
		
		$verifikasi_period_month = $this->session->userdata('verifikasi_period_month');
		$verifikasi_period_year = $this->session->userdata('verifikasi_period_year');
		$verifikasi_date_from = $this->session->userdata('verifikasi_date_from');
		$verifikasi_date_to = $this->session->userdata('verifikasi_date_to');
	
		$page = $this->uri->segment($uri_segment);
		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;
		
		$where_verifikasi_period = "verifikasi_period_month='".$verifikasi_period_month."' 
		                           AND verifikasi_period_year='".$verifikasi_period_year."'";
		$where_verifikasi_date = "(verifikasi_date BETWEEN '".$verifikasi_date_from."' 
		                         AND '".$verifikasi_date_to."')";
		
		if (empty($verifikasi_date_from) or empty($verifikasi_date_to)) {
			$sql = "SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."' AND ".$where_verifikasi_period;
		} else {
			$sql = "SELECT * FROM ".$view_name_hst." WHERE vendor_code='".$vendor_code."' AND ".$where_verifikasi_date;
		}
			
		$verifikasihistories['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'verifikasi/verifikasi_histories/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$verifikasihistories['paginator'] = $this->pagination->create_links();	
		$verifikasihistories['data'] = $this->verifikasi_model->search($sql,$this->order_by,$offset,$limit);
		$this->template->display('verifikasi/verifikasi_history_view',$verifikasihistories);
	}
	
	function redownload() {
		$table_name_hst = $this->config->item('table_name_verifikasi_hst');

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
		$table_name_hst = $this->config->item('table_name_verifikasi_hst');

		$sql = "UPDATE ".$table_name_hst." SET count_download=count_download+1 WHERE pdf_file='".$pdf_file."'";
		$this->db->query($sql);	
		
		$data = "Verifikasi Claim Replacement";
		$data = file_get_contents('../upload/'.$pdf_file);
		force_download($pdf_file,$data);
	}
	
}

/* End of file verifikasi_histories.php */
/* Location: ./application/controllers/verifikasi_histories.php */