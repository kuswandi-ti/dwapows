<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fo_Releases extends CI_Controller {
	
	private $order_by = "id DESC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('fo_model');
		$this->load->helper('download');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_fo_trx');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$foreleases['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'fo/fo_releases/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$foreleases['paginator'] = $this->pagination->create_links();			
		$foreleases['data'] = $this->fo_model->get_all($view_name_trx,$this->order_by,$offset,$limit);
		$foreleases['kriteria_reject'] = $this->fo_model->get_kriteria_reject();
		$this->template->display('fo/fo_release_view',$foreleases);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_fo_trx');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');

		if (isset($_POST['btn-search'])) {			
			$sess_search = array(
				'fo_period_month' => $this->input->post("cbo_fo_period_month"),
				'fo_period_year' => $this->input->post("cbo_fo_period_year"),
				'fo_date_from' => $this->input->post("fo_date_from"),
				'fo_date_to' => $this->input->post("fo_date_to")
			);
			$this->session->set_userdata($sess_search);
		} else {
		
		}
		
		$fo_period_month = $this->session->userdata('fo_period_month');
		$fo_period_year = $this->session->userdata('fo_period_year');
		$fo_date_from = $this->session->userdata('fo_date_from');
		$fo_date_to = $this->session->userdata('fo_date_to');
	
		$page = $this->uri->segment($uri_segment);
		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;
		
		$where_fo_period = "fo_period_month='".$fo_period_month."' 
		                   AND fo_period_year='".$fo_period_year."'";
		$where_fo_date = "(fo_date BETWEEN '".$fo_date_from."' 
		                 AND '".$fo_date_to."')";
		
		if (empty($fo_date_from) or empty($fo_date_to)) {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_fo_period;
		} else {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_fo_date;
		}
			
		$foreleases['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'fo/fo_releases/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$foreleases['paginator'] = $this->pagination->create_links();	
		$foreleases['data'] = $this->fo_model->search($sql,$this->order_by,$offset,$limit);
		$foreleases['kriteria_reject'] = $this->fo_model->get_kriteria_reject();
		$this->template->display('fo/fo_release_view',$foreleases);
	}
		
	function receive() {
		$table_name_trx = $this->config->item('table_name_fo_trx');
		$table_name_hst = $this->config->item('table_name_fo_hst');
		$view_name_trx = $this->config->item('view_name_fo_trx');
		$limit = $this->config->item('limit');
		$user_id = $this->session->userdata('user_id');

		if ($this->input->post('id')) {
			$this->fo_model->receive();
			$foreleases['data'] = $this->fo_model->get_all($view_name_trx,$this->order_by,1,$limit);
			/* ------------------------------------------------------------------------------------------------------------ */
			/* http://stackoverflow.com/questions/14286253/pass-a-value-from-controller-json-to-view-ajax-in-codeigniter */
			$id = $this->input->post('id');
			$sql = "SELECT pdf_file FROM ".$table_name_trx." WHERE id='".$id."' LIMIT 1"; 
  			$data['res'] = $this->db->query($sql)->row()->pdf_file;
            echo json_encode($data);
            /* ------------------------------------------------------------------------------------------------------------ */	
			
			date_default_timezone_set('Asia/Jakarta');
			$date_receive = date("Y-m-d H:i:s"); /* untuk menentukan tanggal di status receive */
			
			/* Begin Insert Data */
			$query = "DELETE FROM ".$table_name_hst." WHERE id='".$id."'";
			$this->db->query($query);
			$query = "INSERT INTO ".$table_name_hst." (id,fo_no,fo_rev,fo_date,fo_period_month,fo_period_year,fo_note,vendor_id,vendor_code,
						vendor_name,vendor_address,vendor_cp,fo_release_date,fo_status,fo_status_date,fo_status_note,pdf_file,
						pdf_file_viewonly,count_download,last_user,last_update) 
					 SELECT id,fo_no,fo_rev,fo_date,fo_period_month,fo_period_year,fo_note,vendor_id,vendor_code,vendor_name,vendor_address,
						vendor_cp,fo_release_date,fo_status,fo_status_date,fo_status_note,pdf_file,pdf_file_viewonly,count_download,
						'".$user_id."','".$date_receive."'
					 FROM ".$table_name_trx." WHERE id='".$id."'";
			$this->db->query($query);
			/* End Insert Data */

			/* Begin Delete Data */
			$query = "DELETE FROM ".$table_name_trx." WHERE id='".$id."'";
			$this->db->query($query);
			/* End Delete Data */			
		}
	}
	
	function reject() {	
		$view_name_trx = $this->config->item('view_name_fo_trx');
		$limit = $this->config->item('limit');

		if ($this->input->post('id')) {
			$this->fo_model->reject();
			$foreleases['data'] = $this->fo_model->get_all($view_name_trx,$this->order_by,1,$limit);
		}
	}

	function download($pdf_file = '') {
		$table_name_trx = $this->config->item('table_name_fo_trx');
		$table_name_hst = $this->config->item('table_name_fo_hst');

		$sql = "UPDATE ".$table_name_trx." SET count_download=count_download+1 WHERE pdf_file='".$pdf_file."'";
		$this->db->query($sql);				
		
		$data = "Forecast Order (FO)";
//		$data = file_get_contents('../upload/'.$pdf_file);
		$data = file_get_contents('\\\\192.168.0.39\htdocs\upload\\'.$pdf_file);
		force_download($pdf_file,$data);
	}
	
}

/* End of file fo_releases.php */
/* Location: ./application/controllers/fo_releases.php */