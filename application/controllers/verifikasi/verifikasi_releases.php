<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifikasi_Releases extends CI_Controller {
	
	private $order_by = "id DESC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('verifikasi_model');
		$this->load->helper('download');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_verifikasi_trx');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$verifikasireleases['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'verifikasi/verifikasi_releases/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$verifikasireleases['paginator'] = $this->pagination->create_links();			
		$verifikasireleases['data'] = $this->verifikasi_model->get_all($view_name_trx,$this->order_by,$offset,$limit);
		$verifikasireleases['kriteria_reject'] = $this->verifikasi_model->get_kriteria_reject();
		$this->template->display('verifikasi/verifikasi_release_view',$verifikasireleases);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_verifikasi_trx');
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
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_verifikasi_period;
		} else {
			$sql = "SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."' AND ".$where_verifikasi_date;
		}
			
		$verifikasireleases['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'verifikasi/verifikasi_releases/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$verifikasireleases['paginator'] = $this->pagination->create_links();	
		$verifikasireleases['data'] = $this->verifikasi_model->search($sql,$this->order_by,$offset,$limit);
		$verifikasireleases['kriteria_reject'] = $this->verifikasi_model->get_kriteria_reject();
		$this->template->display('verifikasi/verifikasi_release_view',$verifikasireleases);
	}
		
	function receive() {
		$table_name_trx = $this->config->item('table_name_verifikasi_trx');
		$table_name_hst = $this->config->item('table_name_verifikasi_hst');
		$view_name_trx = $this->config->item('view_name_verifikasi_trx');
		$limit = $this->config->item('limit');
		$user_id = $this->session->userdata('user_id');

		if ($this->input->post('id')) {
			$this->verifikasi_model->receive();
			$foreleases['data'] = $this->verifikasi_model->get_all($view_name_trx,$this->order_by,1,$limit);
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
			$query = "INSERT INTO ".$table_name_hst." (id,verifikasi_no,verifikasi_rev,verifikasi_date,
						verifikasi_period_month,verifikasi_period_year,verifikasi_note,vendor_id,vendor_code,
						vendor_name,vendor_address,vendor_cp,verifikasi_release_date,
						verifikasi_status,verifikasi_status_date,verifikasi_status_note,pdf_file,
						pdf_file_viewonly,count_download,last_user,last_update) 
					 SELECT id,verifikasi_no,verifikasi_rev,verifikasi_date,verifikasi_period_month,verifikasi_period_year,
						verifikasi_note,vendor_id,vendor_code,vendor_name,vendor_address,vendor_cp,
						verifikasi_release_date,verifikasi_status,verifikasi_status_date,verifikasi_status_note,
						pdf_file,pdf_file_viewonly,count_download,
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
		$view_name_trx = $this->config->item('view_name_verifikasi_trx');
		$limit = $this->config->item('limit');

		if ($this->input->post('id')) {
			$this->verifikasi_model->reject();
			$foreleases['data'] = $this->verifikasi_model->get_all($view_name_trx,$this->order_by,1,$limit);
		}
	}

	function download($pdf_file = '') {
		$table_name_trx = $this->config->item('table_name_verifikasi_trx');
		$table_name_hst = $this->config->item('table_name_verifikasi_hst');

		$sql = "UPDATE ".$table_name_trx." SET count_download=count_download+1 WHERE pdf_file='".$pdf_file."'";
		$this->db->query($sql);				
		
		$data = "Verifikasi Claim Replacement";
		$data = file_get_contents('../upload/'.$pdf_file);
		force_download($pdf_file,$data);
	}
	
}

/* End of file verifikasi_releases.php */
/* Location: ./application/controllers/verifikasi_releases.php */