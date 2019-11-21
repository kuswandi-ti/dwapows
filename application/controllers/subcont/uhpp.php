<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uhpp extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('uhpp_model');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$uhpp['total'] = $offset;
		$config['base_url'] = base_url().'subcont/uhpp/index/';
		$config['total_rows'] = $this->uhpp_model->get_num_rows_uhpp($vendor_code);
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$uhpp['paginator'] = $this->pagination->create_links();
		$uhpp['data'] = $this->uhpp_model->get_data_uhpp($vendor_code, $offset, $limit);
		$uhpp['get_vpn'] = $this->uhpp_model->get_vpn($vendor_code);
		
		$this->template->display('subcont/uhpp_view', $uhpp);
	}
	
	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');

		if (isset($_POST['btn-search'])) {			
			$sess_search = array(
				'tanggal' => $this->input->post("txtdate_find"),
				'vpn_id' => $this->input->post("cbopn_cari")
			);
			$this->session->set_userdata($sess_search);
		} else {
		
		}
		
		$tanggal = $this->session->userdata('tanggal');
		$vpn_id = $this->session->userdata('vpn_id');
	
		$page = $this->uri->segment($uri_segment);
		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;
		
		$where_tanggal = "tanggal='".$tanggal."'";
		$where_vpn_id = "vpn_id='".$vpn_id."'";
		
		if (empty($tanggal) && empty($vpn_id)) { // tanpa filter
			$sql = "SELECT * FROM tbl_hasil_proses_produksi WHERE vendor_code='".$vendor_code."'";
		} else if (!empty($tanggal) && empty($vpn_id)) { // filter tanggal
			$sql = "SELECT * FROM tbl_hasil_proses_produksi WHERE vendor_code='".$vendor_code."' AND ".$where_tanggal;
		} else if (empty($tanggal) && !empty($vpn_id)) { // filter vpn
			$sql = "SELECT * FROM tbl_hasil_proses_produksi WHERE vendor_code='".$vendor_code."' AND ".$where_vpn_id;
		} else if (!empty($tanggal) && !empty($vpn_id)) { // filter tanggal & vpn
			$sql = "SELECT * FROM tbl_hasil_proses_produksi WHERE vendor_code='".$vendor_code."' AND ".$where_tanggal." AND ".$where_vpn_id;
		}
		
		$uhpp['total'] = $offset;
		$config['base_url'] = base_url().'subcont/uhpp/search/';
		$config['total_rows'] = $this->uhpp_model->get_num_rows_uhpp($vendor_code);
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$uhpp['paginator'] = $this->pagination->create_links();
		$uhpp['data'] = $this->uhpp_model->get_data_uhpp($vendor_code, $offset, $limit);
		$uhpp['get_vpn'] = $this->uhpp_model->get_vpn($vendor_code);
		$this->template->display('subcont/uhpp_view', $uhpp);
	}
	
	function add() {
		return $this->uhpp_model->add();
	}
	
	function edit() {
		$data = $this->uhpp_model->edit();
		echo json_encode($data);
	}
	
	function update() {
		return $this->uhpp_model->update();
	}
	
}

/* End of file uhpp.php */
/* Location: ./application/controllers/uhpp.php */