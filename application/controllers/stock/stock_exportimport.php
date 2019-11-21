<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_ExportImport extends CI_Controller {	

	function __construct() {
		parent::__construct();
		$this->auth->restrict();
		$this->load->library("PHPExcel");
	}
	
	public function index() {
		$this->template->display('stock/stock_exportimport_view');
	}
	
	/* http://cahbagusnongkrong.blogspot.co.id/2016/07/import-data-excel-ke-mysql-dengan.html */
	public function importdata() {
		date_default_timezone_set('Asia/Jakarta');
		$date_upload = date("Y-m-d");
		$time_upload = date("H:i:s");
				
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
			redirect('stock/stock_exportimport'); 
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
			
			// Insert ke tabel tbl_stock_hst
			$table_name_trx = $this->config->item('table_name_stock_trx');
			$table_name_hst = $this->config->item('table_name_stock_hst');
			$query = "INSERT INTO ".$table_name_hst." (id,vendor_code,part_number,part_name,uom,
							stock_qty,min_qty,max_qty,updated_date,updated_time,aktif) 
					 SELECT id,vendor_code,part_number,part_name,uom,
							stock_qty,min_qty,max_qty,updated_date,updated_time,aktif
					 FROM ".$table_name_trx." 
					 WHERE vendor_code='".$this->session->userdata('vendor_code')."'";		
			$this->db->query($query);

			for ($row = 2; $row <= $highestRow; $row++) {  
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);
				
				$part_id = $rowData[0][0];
				$vendor_code = $rowData[0][1];
				$part_number = $rowData[0][2];
				$part_name = $rowData[0][3];
				$uom = $rowData[0][4];
				$stock_qty = $rowData[0][5];
				
				// Cek, jika sudah ada update, jika belum ada insert
				$query = $this->db->get_where(
							'tbl_stock_trx',
							array('part_number' => $part_number, 'vendor_code' => $vendor_code)
						 );
				if ($query->num_rows() <= 0) {
					// Insert data
					$sql = array(
								'sysid'          	=> $part_id,
								'vendor_code'   	=> $vendor_code,
								'part_number'   	=> $part_number,
								'part_name'   		=> $part_name,
								'uom'   			=> $uom,
								'stock_qty'   		=> $stock_qty,
								'min_qty'			=> 0,
								'max_qty'			=> 0,
								'updated_date'   	=> $date_upload,
								'updated_time'   	=> $time_upload,
								'aktif'				=> 1
						   );
					$this->db->insert('tbl_stock_trx', $sql);
				} else {
					// Update data					
					$sql = array(
								'stock_qty'   		=> $stock_qty,
								'updated_date'   	=> $date_upload,
								'updated_time'   	=> $time_upload
						   );
					$this->db->where(array('part_number' => $part_number, 'vendor_code' => $vendor_code));
					$this->db->update('tbl_stock_trx', $sql);
				}
			} 
			
			unlink('./exportimport/'.$media['file_name']);
			$this->session->set_flashdata('msg','Berhasil import data stock ...!!'); 
			redirect('stock/stock_exportimport');
		}  
	}
	
	public function exportdata() {
		// Membuat object
		$oPHPExcel = new PHPExcel();
		$this->db->select("sysid,vendor_code,part_number,part_name,uom,stock_qty");
		$this->db->order_by("updated_date DESC, updated_time DESC, part_number ASC");
		$data = $this->db->get_where('v_stock_trx_forexport', array('vendor_code' => $this->session->userdata('vendor_code')));
		
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
		$oPHPExcel->getActiveSheet()->setTitle('Data Stock POWS');
		
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
        $namafile = "pows_stock_export_".$datetime.".xls";
		header('Content-Disposition: attachment;filename="'.$namafile.'"');

		// Download
		$oWriter->save("php://output");
	}
	
}

/* End of file stock_exportimport.php */
/* Location: ./application/controllers/stock_exportimport.php */