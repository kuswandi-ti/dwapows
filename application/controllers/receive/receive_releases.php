<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receive_Releases extends CI_Controller {
	
	//private $order_by = "di_release_date DESC,di_no ASC";
	private $order_by = "di_delivery_datetime ASC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('receive_model');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_rcv_trx');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$receivereleases['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'receive/receive_releases/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$receivereleases['paginator'] = $this->pagination->create_links();			
		$receivereleases['data'] = $this->receive_model->get_all($view_name_trx,$this->order_by,$offset,$limit);
		$receivereleases['file_name'] = $this->receive_model->get_file_name($this->session->userdata('user_id')); 
		$this->template->display('receive/receive_release_view',$receivereleases);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_rcv_trx');
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
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_di_delivery_datetime;
		} else {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_di_date;
		}
			
		$receivereleases['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'receive/receive_releases/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$receivereleases['paginator'] = $this->pagination->create_links();	
		$receivereleases['data'] = $this->receive_model->search($sql,$this->order_by,$offset,$limit);
		$receivereleases['file_name'] = $this->receive_model->get_file_name($this->session->userdata('user_id'));
		$this->template->display('receive/receive_release_view',$receivereleases);
	}
	
	function preview_outstanding() {
		$table_name = $this->config->item('table_name_outstanding_gr');
		$sql = "SELECT file_name FROM ".$table_name." WHERE vendor_code='".$this->session->userdata('vendor_code')."'"; 
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$data['count_records'] = $query->num_rows();
			foreach ($query->result() as $row) {
				$data['pdf_file'] = $row->file_name;
			}
		} else {
			$data['count_records'] = 0;
		}		
		$this->load->view('receive/monitoring_di_gr_view', $data);
	}
	
}

/* End of file receive_releases.php */
/* Location: ./application/controllers/receive_releases.php */