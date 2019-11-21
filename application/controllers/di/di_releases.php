<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Di_Releases extends CI_Controller {
	
	private $order_by = "id DESC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('di_model');
		$this->load->helper('download');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_di_trx');
		$limit = $this->config->item('limit');
		$vendor_code = $this->session->userdata('vendor_code');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$direleases['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_trx." WHERE vendor_code='".$vendor_code."'");
		$config['base_url'] = base_url().'di/di_releases/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$direleases['paginator'] = $this->pagination->create_links();			
		$direleases['data'] = $this->di_model->get_all($view_name_trx,$this->order_by,$offset,$limit);
		$direleases['kriteria_reject'] = $this->di_model->get_kriteria_reject();
		$this->template->display('di/di_release_view',$direleases);
	}

	public function search() {	
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = $this->config->item('view_name_di_trx');
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
			
		$direleases['total'] = $offset;
		$total_page = $this->db->query($sql);
		$config['base_url'] = base_url() . 'di/di_releases/search/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$direleases['paginator'] = $this->pagination->create_links();	
		$direleases['data'] = $this->di_model->search($sql,$this->order_by,$offset,$limit);
		$direleases['kriteria_reject'] = $this->di_model->get_kriteria_reject();
		$this->template->display('di/di_release_view',$direleases);
	}
	
	function receive() {
		$table_name_trx = $this->config->item('table_name_di_trx');
		$table_name_hst = $this->config->item('table_name_di_hst');	
		$table_name_rcv_trx = $this->config->item('table_name_rcv_trx');		
		$view_name_trx = $this->config->item('view_name_di_trx');
		$status_received = $this->config->item('status_received');
		$status_full_outstanding = $this->config->item('status_full_outstanding');
		$limit = $this->config->item('limit');
		$user_id = $this->session->userdata('user_id');

		if ($this->input->post('id')) {
			$this->di_model->receive();
			$direleases['data'] = $this->di_model->get_all($view_name_trx,$this->order_by,1,$limit);
			
			/* ------------------------------------------------------------------------------------------------------------ */
			/* 	1. Dapatkan nama file pdf berdasarkan [ID] dari tabel tbl_deliveryinstruction_trx (transaksi DI)
			/* 	http://stackoverflow.com/questions/14286253/pass-a-value-from-controller-json-to-view-ajax-in-codeigniter */
				$id = $this->input->post('id');
				$sql = "SELECT pdf_file FROM ".$table_name_trx." WHERE id='".$id."' LIMIT 1"; 
				$data['res'] = $this->db->query($sql)->row()->pdf_file;			
				echo json_encode($data);
			
			date_default_timezone_set('Asia/Jakarta');
			$date_receive = date("Y-m-d H:i:s"); /* untuk menentukan tanggal di status receive */
				
			/* 	2. Insert ke tabel tbl_deliveryinstruction_hst (receive) */
				$query = "DELETE FROM ".$table_name_hst." WHERE id='".$id."'";
				$this->db->query($query);
				$query = "INSERT INTO ".$table_name_hst." (id,di_no,di_rev,di_date,di_delivery_datetime,di_note,vendor_id,
								vendor_code,vendor_name,vendor_address,vendor_cp,di_release_date,di_status,
								di_status_date,di_status_note,pdf_file,pdf_file_viewonly,count_download,last_user,last_update) 
						 SELECT id,di_no,di_rev,di_date,di_delivery_datetime,di_note,vendor_id,
								vendor_code,vendor_name,vendor_address,vendor_cp,di_release_date,'".$status_received."',
								'".$date_receive."',di_status_note,pdf_file,pdf_file_viewonly,count_download,
								'".$user_id."','".$date_receive."'
						 FROM ".$table_name_trx." WHERE id='".$id."'";		
				$this->db->query($query);
			
			/*	3. Insert ke tabel tbl_receiving_trx (outstanding) */						
				$query = "DELETE FROM ".$table_name_rcv_trx." WHERE id='".$id."'";
				$this->db->query($query);
				$query = "INSERT INTO ".$table_name_rcv_trx." (id,di_no,di_rev,di_date,di_delivery_datetime,di_note,vendor_id,
								vendor_code,vendor_name,vendor_address,vendor_cp,di_release_date,di_status,
								di_status_date,di_status_note,pdf_file,count_download)
						 SELECT id,di_no,di_rev,di_date,di_delivery_datetime,di_note,vendor_id,
								vendor_code,vendor_name,vendor_address,vendor_cp,di_release_date,'".$status_full_outstanding."',
								'".$date_receive."',di_status_note,pdf_file,count_download 
						 FROM ".$table_name_trx." WHERE id='".$id."'";
				$this->db->query($query);
			
			/*	4. Delete DI di tabel tbl_deliveryinstruction_trx (open) */
				$query = "DELETE FROM ".$table_name_trx." WHERE id='".$id."'";
				$this->db->query($query);
		}
	}
	
	function reject() {	
		$view_name_trx = $this->config->item('view_name_di_trx');
		$limit = $this->config->item('limit');

		if ($this->input->post('id')) {
			$this->di_model->reject();
			$direleases['data'] = $this->di_model->get_all($view_name_trx,$this->order_by,1,$limit);
		}
	}

	function download($pdf_file = '') {
		$table_name_trx = $this->config->item('table_name_di_trx');
		
		$sql = "UPDATE ".$table_name_trx." SET count_download=count_download+1 WHERE pdf_file='".$pdf_file."'";
		$this->db->query($sql);	
		
		$data = "Delivery Instruction (DI)";
		$data = file_get_contents('../upload/'.$pdf_file);
//		$data = file_get_contents('\\\\192.168.0.39\htdocs\upload\\'.$pdf_file);
		force_download($pdf_file,$data);
	}
	
	function cancel() {
		$table_name_trx = $this->config->item('table_name_di_trx');
		$table_name_hst = $this->config->item('table_name_di_hst');	
		$table_name_rcv_trx = $this->config->item('table_name_rcv_trx');
		$table_name_rcv_hst = $this->config->item('table_name_rcv_hst');

		if ($this->uri->segment(4)) {	
			$id = $this->uri->segment(4);
			
			/* 	1. Insert ke tabel tbl_deliveryinstruction_hst (receive) */
				$query = "INSERT INTO ".$table_name_hst." (id,di_no,di_rev,di_date,di_delivery_datetime,di_note,vendor_id,
								vendor_code,vendor_name,vendor_address,vendor_cp,di_release_date,di_status,
								di_status_date,di_status_note,pdf_file,count_download,last_user,last_update) 
						 SELECT id,di_no,di_rev,di_date,di_delivery_datetime,di_note,vendor_id,
								vendor_code,vendor_name,vendor_address,vendor_cp,di_release_date,di_status,
								di_status_date,di_status_note,pdf_file,count_download,'".$user_id."',date('Y-m-d H:i:s') 
						 FROM ".$table_name_trx." WHERE id='".$id."'";		
				$this->db->query($query);
			
			/*	2. Delete DI di tabel tbl_deliveryinstruction_trx (open) */
				$query = "DELETE FROM ".$table_name_trx." WHERE id='".$id."'";
				$this->db->query($query);
				
			/*	3. Delete DI di tabel tbl_receiving_trx (outstanding) */
				$query = "DELETE FROM ".$table_name_rcv_trx." WHERE id='".$id."'";
				$this->db->query($query);
				
			/*	4. Delete DI di tabel tbl_receiving_hst (close) */
				$query = "DELETE FROM ".$table_name_rcv_hst." WHERE id='".$id."'";
				$this->db->query($query);
				
			redirect('di/di_releases/', 'refresh');
		}
	}
	
}

/* End of file di_releases.php */
/* Location: ./application/controllers/di_releases.php */