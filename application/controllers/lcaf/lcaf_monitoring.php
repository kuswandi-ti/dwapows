<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lcaf_Monitoring extends CI_Controller {
	
	private $order_by = "vendor_code ASC,fo_period_month ASC, fo_period_year ASC,fo_no ASC,pn_number ASC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->library('m_pdf');
		$this->load->model('lcaf_model');
	}
	
	public function index() {		
		$uri_segment = $this->config->item('uri_segment');
		$view_name_trx = 'v_loading_capacity_assurance_trx_forexport';
		$limit = $this->config->item('limit');
		$page = $this->uri->segment($uri_segment);

		if(!$page):
			$offset = 0;
		else:
			$offset = $page;
		endif;			
		$lcafmonitoring['total'] = $offset;
		$total_page = $this->db->query("SELECT * FROM ".$view_name_trx." WHERE vendor_pic='".$this->session->userdata('user_id')."'");
		$config['base_url'] = base_url().'lcaf/lcaf_monitoring/index/';
		$config['total_rows'] = $total_page->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$lcafmonitoring['paginator'] = $this->pagination->create_links();			
		$lcafmonitoring['data'] = $this->lcaf_model->get_all($view_name_trx,$this->order_by,$offset,$limit);
		$lcafmonitoring['user_vendor'] = $this->lcaf_model->user_vendor();
		$this->template->display('lcaf/lcaf_monitoring_view',$lcafmonitoring);
	}

	public function search() {
		/* Button Search */
		if (isset($_POST['btn-search'])) {
			$uri_segment = $this->config->item('uri_segment');
			$view_name_trx = 'v_loading_capacity_assurance_trx_forexport';
			$limit = $this->config->item('limit');

			if (isset($_POST['btn-search'])) {			
				$sess_search = array(
					'src_vendor_code' => $this->input->post("txt_vendor_code"),
					'src_period_month' => $this->input->post("txt_period_month"),
					'src_period_year' => $this->input->post("txt_period_year"),
					'src_fo_no' => $this->input->post("txt_fo_no"),
					'src_pn_number' => $this->input->post("txt_pn_number")
				);
				$this->session->set_userdata($sess_search);
			} else {
			
			}
			
			$sess_vendor_code = $this->session->userdata('src_vendor_code');
			$sess_period_month = $this->session->userdata('src_period_month');
			$sess_period_year = $this->session->userdata('src_period_year');
			$sess_fo_no = $this->session->userdata('src_fo_no');
			$sess_pn_number = $this->session->userdata('src_pn_number');
		
			$page = $this->uri->segment($uri_segment);
			if(!$page):
				$offset = 0;
			else:
				$offset = $page;
			endif;
			
			$where_vendor_pic = " AND vendor_pic='".$this->session->userdata('user_id')."'";
			
			$where_vendor_code = " WHERE vendor_code='".$sess_vendor_code."'";
			$where_period_month = " WHERE (vendor_code = '".$sess_vendor_code."' 
								   AND fo_period_month = '".$sess_period_month."')";
			$where_period_year = " WHERE (vendor_code = '".$sess_vendor_code."' 
								   AND fo_period_month = '".$sess_period_month."'
								   AND fo_period_year = '".$sess_period_year."')";
			$where_fo_no = " WHERE (vendor_code = '".$sess_vendor_code."' 
							AND fo_period_month = '".$sess_period_month."'
							AND fo_period_year = '".$sess_period_year."'
							AND fo_no = '".$sess_fo_no."')";
			$where_pn_number = " WHERE (vendor_code = '".$sess_vendor_code."' 
								AND fo_period_month = '".$sess_period_month."'
								AND fo_period_year = '".$sess_period_year."'
								AND fo_no = '".$sess_fo_no."'
								AND pn_number = '".$sess_pn_number."')";
			
			if (empty($sess_vendor_code) and 
				empty($sess_period_month) and 
				empty($sess_period_year) and 
				empty($sess_fo_no) and 
				empty($sess_pn_number)) {
				$sql = "SELECT * FROM ".$view_name_trx;
			} elseif (!empty($sess_vendor_code) and 
					  empty($sess_period_month) and 
					  empty($sess_period_year) and 
					  empty($sess_fo_no) and 
					  empty($sess_pn_number)) {
				$sql = "SELECT * FROM ".$view_name_trx.$where_vendor_code;
			} elseif (!empty($sess_vendor_code) and 
					  !empty($sess_period_month) and 
					  empty($sess_period_year) and 
					  empty($sess_fo_no) and 
					  empty($sess_pn_number)) {
				$sql = "SELECT * FROM ".$view_name_trx.$where_period_month;
			} elseif (!empty($sess_vendor_code) and 
					  !empty($sess_period_month) and 
					  !empty($sess_period_year) and 
					  empty($sess_fo_no) and 
					  empty($sess_pn_number)) {
				$sql = "SELECT * FROM ".$view_name_trx.$where_period_year;
			} elseif (!empty($sess_vendor_code) and 
					  !empty($sess_period_month) and 
					  !empty($sess_period_year) and 
					  !empty($sess_fo_no) and 
					  empty($sess_pn_number)) {
				$sql = "SELECT * FROM ".$view_name_trx.$where_fo_no;
			} elseif (!empty($sess_vendor_code) and 
					  !empty($sess_period_month) and 
					  !empty($sess_period_year) and 
					  !empty($sess_fo_no) and 
					  !empty($sess_pn_number)) {
				$sql = "SELECT * FROM ".$view_name_trx.$where_pn_number;
			} else {
				$sql = "SELECT * FROM ".$view_name_trx;
			}
			
			$sql = $sql.$where_vendor_pic;
				
			$lcafmonitoring['total'] = $offset;
			$total_page = $this->db->query($sql);
			$config['base_url'] = base_url() . 'lcaf/lcaf_monitoring/search/';
			$config['total_rows'] = $total_page->num_rows();
			$config['per_page'] = $limit;
			$config['uri_segment'] = $uri_segment;
			$this->pagination->initialize($config);
			$lcafmonitoring['paginator'] = $this->pagination->create_links();	
			$lcafmonitoring['data'] = $this->lcaf_model->search($sql,$this->order_by,$offset,$limit);
			$lcafmonitoring['user_vendor'] = $this->lcaf_model->user_vendor();
			$this->template->display('lcaf/lcaf_monitoring_view',$lcafmonitoring);
		}
		
		/* Button Print */
		if (isset($_POST['btn-show-print'])) {
			$vendor_code = $this->input->post('cbo_vendor');
			$data['data_lcaf'] = $this->lcaf_model->show_print($vendor_code, $this->order_by);
			$data['data_vendor'] = $vendor_code;
			$this->load->view('lcaf/lcaf_print_view', $data);
		}
		
		if (isset($_POST['btn-show-pdf'])) {
			$vendor_code = $this->input->post('cbo_vendor');
			$data['data_lcaf'] = $this->lcaf_model->show_print($vendor_code, $this->order_by);
			$data['data_vendor'] = $vendor_code;
			$this->load->view('lcaf/lcaf_print_view', $data);
			
			// pdf
			ini_set('memory_limit', '-1');
			$sumber = $this->load->view('lcaf/lcaf_print_view', $data, TRUE);
			$html = $sumber;			
			$pdfFilePath = 'report_lcaf.pdf';	
			$stylesheet = file_get_contents('assets/bootstrap/css/bootstrap.min.css');
			$pdf = $this->m_pdf->load();
			$pdf->setFooter('Page {PAGENO} of {nb}');
			$pdf->AddPage('L');
			$pdf->WriteHTML($html);
			$pdf->Output($pdfFilePath, "D");
			exit();
		}
	}
	
}

/* End of file lcaf_monitoring.php */
/* Location: ./application/controllers/lcaf_monitoring.php */