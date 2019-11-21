<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fo_Releases extends CI_Controller {
	
	private $order_by = "id DESC";

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('fo_model');
		$this->load->helper('download');
		$this->load->library("PHPExcel");
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
			
			/* Begin Insert Data (header) */
			$query = "DELETE FROM ".$table_name_hst." WHERE id='".$id."'";
			$this->db->query($query);
			$query = "INSERT INTO ".$table_name_hst." (id,fo_no,fo_rev,fo_date,fo_period_month,fo_period_year,fo_note,vendor_id,vendor_code,
						vendor_name,vendor_address,vendor_cp,fo_release_date,fo_status,fo_status_date,fo_status_note,pdf_file,
						pdf_file_viewonly,count_download,last_user,last_update,export_excel_date,import_excel_date) 
					 SELECT id,fo_no,fo_rev,fo_date,fo_period_month,fo_period_year,fo_note,vendor_id,vendor_code,vendor_name,vendor_address,
						vendor_cp,fo_release_date,fo_status,fo_status_date,fo_status_note,pdf_file,pdf_file_viewonly,count_download,
						'".$user_id."','".$date_receive."',export_excel_date,import_excel_date
					 FROM ".$table_name_trx." WHERE id='".$id."'";
			$this->db->query($query);
			/* End Insert Data (header) */
			
			/* Begin Insert Data (detail) */
			$query = "DELETE FROM tbl_loading_capacity_assurance_hst WHERE id_hdr='".$id."'";
			$this->db->query($query);
			$query = "INSERT INTO tbl_loading_capacity_assurance_hst (id,id_hdr,fo_no,pn_number,pn_name,unit,
							qty_order_n,qty_order_n1,qty_order_n2,qty_order_n3,
							qty_capacity_n,qty_capacity_n1,qty_capacity_n2,qty_capacity_n3,
							export_excel_date,import_excel_date) 
					 SELECT id,id_hdr,fo_no,pn_number,pn_name,unit,
							qty_order_n,qty_order_n1,qty_order_n2,qty_order_n3,
							qty_capacity_n,qty_capacity_n1,qty_capacity_n2,qty_capacity_n3,
							export_excel_date,import_excel_date
					 FROM tbl_loading_capacity_assurance_trx 
					 WHERE id_hdr='".$id."'";		
			$this->db->query($query);
			/* End Insert Data (detail) */

			/* Begin Delete Data (header) */
			$query = "DELETE FROM ".$table_name_trx." WHERE id='".$id."'";
			$this->db->query($query);
			/* End Delete Data (header) */

			/* Begin Delete Data (detail) */
			$query = "DELETE FROM tbl_loading_capacity_assurance_trx WHERE id_hdr='".$id."'";
			$this->db->query($query);
			/* End Delete Data (detail) */
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
		$data = file_get_contents('../upload/'.$pdf_file);
		force_download($pdf_file,$data);
	}
	
	/* http://cahbagusnongkrong.blogspot.co.id/2016/07/import-data-excel-ke-mysql-dengan.html */
	public function importdata() {
		date_default_timezone_set('Asia/Jakarta');
		$date_time_import = date("Y-m-d H:i:s");
				
		$fileName = $this->input->post('file', TRUE);

		$config['upload_path'] = './exportimport/'; 
		$config['file_name'] = $fileName;
		$config['allowed_types'] = 'xls';
		$config['max_size'] = 10000;

		$this->load->library('upload', $config);
		$this->upload->initialize($config); 
  
		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg','Ada kesalah dalam upload'); 
			redirect('fo/fo_releases'); 
		} else {
			$media = $this->upload->data();
			$inputFileName = 'exportimport/'.$media['file_name'];
   
			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			for ($row = 2; $row <= $highestRow; $row++) {  
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
				
				$fo_no = $rowData[0][0];
				$pn_number = $rowData[0][5];
				$pn_name = $rowData[0][6];
				$unit = $rowData[0][7];
				$qtycapacityn = $rowData[0][12];
				$qtycapacityn1 = $rowData[0][13];
				$qtycapacityn2 = $rowData[0][14];
				$qtycapacityn3 = $rowData[0][15];
				
				// Cek, jika sudah ada update, jika belum ada insert
				$query = $this->db->get_where(
							'tbl_loading_capacity_assurance_trx',
							array('fo_no' => $fo_no, 
							      'pn_number' => $pn_number)
						 );
				if ($query->num_rows() <= 0) {
					// Insert data (detail)
					$sql = array(
								'fo_no'          	=> $fo_no,
								'pn_number'   		=> $pn_number,
								'pn_name'   		=> $pn_name,
								'unit'   			=> $unit,
								'qty_capacity_n'   	=> $qtycapacityn,
								'qty_capacity_n1'	=> $qtycapacityn1,
								'qty_capacity_n2'	=> $qtycapacityn2,
								'qty_capacity_n3'   => $qtycapacityn3,
								'import_excel_date'	=> $date_time_import
						   );
					$this->db->insert('tbl_loading_capacity_assurance_trx', $sql);
				} else {
					// Insert ke tabel history (detail) sebelum diupdate
					/*$query = "INSERT INTO tbl_loading_capacity_assurance_hst (id,id_hdr,fo_no,pn_number,pn_name,unit,
									qty_order_n,qty_order_n1,qty_order_n2,qty_order_n3,
									qty_capacity_n,qty_capacity_n1,qty_capacity_n2,qty_capacity_n3,
									export_excel_date,import_excel_date) 
							 SELECT id,id_hdr,fo_no,pn_number,pn_name,unit,
									qty_order_n,qty_order_n1,qty_order_n2,qty_order_n3,
									qty_capacity_n,qty_capacity_n1,qty_capacity_n2,qty_capacity_n3,
									export_excel_date,import_excel_date
							 FROM tbl_loading_capacity_assurance_trx 
							 WHERE fo_no='".$fo_no."' AND pn_number='".$pn_number."'";		
					$this->db->query($query);*/
				
					// Update data (detail)				
					$sql = array(
								'qty_capacity_n'   	=> $qtycapacityn,
								'qty_capacity_n1'   => $qtycapacityn1,
								'qty_capacity_n2'   => $qtycapacityn2,
								'qty_capacity_n3'   => $qtycapacityn3,
								'import_excel_date' => $date_time_import
						   );
					$this->db->where(array('fo_no' => $fo_no, 'pn_number' => $pn_number));
					$this->db->update('tbl_loading_capacity_assurance_trx', $sql);
				}
			}
			
			// Update data (header)
			$sql = array('import_excel_date' => $date_time_import);
			$this->db->where(array('vendor_code' => $this->session->userdata('vendor_code'),
								   'fo_no' => $fo_no
								  )
							);
			$this->db->update('tbl_forecastorder_trx', $sql);
			
			unlink('./exportimport/'.$media['file_name']);
			$this->session->set_flashdata('msg','Proses import data berhasil...!!'); 
			redirect('fo/fo_releases');
		}  
	}
	
	public function exportdata() {
		date_default_timezone_set('Asia/Jakarta');
		$date_time_export = date("Y-m-d H:i:s");
		
		$fo_no = $this->input->get('fo_no');
		
		// Membuat object
		$oPHPExcel = new PHPExcel();
		$this->db->select("fo_no AS `FORECAST NO`,vendor_code AS `VENDOR CODE`,vendor_name AS `VENDOR NAME`,
		                  fo_period_month AS `PERIOD MONTH`,fo_period_year AS `PERIOD YEAR`,
						  pn_number AS `PART NUMBER`,`pn_name` AS `PART NAME`,unit AS UNIT,
						  qty_order_n AS `QTY ORDER N`,qty_order_n1 AS `QTY ORDER N+1`,qty_order_n2 AS `QTY ORDER N+2`,qty_order_n3 AS `QTY ORDER N+3`,
						  qty_capacity_n AS `QTY CAPACITY N`,qty_capacity_n1 AS `QTY CAPACITY N+1`,qty_capacity_n2 AS `QTY CAPACITY N+2`,qty_capacity_n3 AS `QTY CAPACITY N+3`");
		$this->db->order_by("pn_number ASC");
		$data = $this->db->get_where('v_loading_capacity_assurance_trx_forexport', 
									 array('vendor_code' => $this->session->userdata('vendor_code'),
									       'fo_no' => $fo_no));
		
		// Nama field baris pertama
		$fields = $data->list_fields();
		$col = 0;
		foreach ($fields as $field) {
			$oPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}
		
		// Mengambil data
		$row = 2; // Index row untuk memulai menulis data
		foreach ($data->result() as $data) {
			$col = 0;			
			foreach ($fields as $field) {
				$oPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
				$col++;
			}
			$row++;
		}
		
		$oPHPExcel->setActiveSheetIndex(0);
		
		// Set Title
		$oPHPExcel->getActiveSheet()->setTitle('Data Forecast');
		
		// Save ke .xls
		// .xlsx = 'Excel2007'
		// .xls = 'Excel5'
		$oWriter = PHPExcel_IOFactory::createWriter($oPHPExcel, 'Excel5');
		
		// Header
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		
		// Nama File
		date_default_timezone_set('Asia/Jakarta');
		$datetime = date("dmYHis");
        $namafile = "forecast_export_".$datetime.".xls";
		header('Content-Disposition: attachment;filename="'.$namafile.'"');
		
		// Update data (header)
		$sql = array('export_excel_date' => $date_time_export);
		$this->db->where(array('vendor_code' => $this->session->userdata('vendor_code'),
							   'fo_no' => $fo_no
							  )
						);
		$this->db->update('tbl_forecastorder_trx', $sql);
		
		// Update data (detail)
		$sql = array('export_excel_date' => $date_time_export);
		$this->db->where(array('fo_no' => $fo_no));
		$this->db->update('tbl_loading_capacity_assurance_trx', $sql);

		// Download
		$oWriter->save("php://output");
	}
	
}

/* End of file fo_releases.php */
/* Location: ./application/controllers/fo_releases.php */