<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Di_Model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}	
	
	function get_kriteria_reject(){
		$sql = "SELECT * 
			   FROM tbl_kriteria_reject 
			   WHERE dokumen = 'DI'";
		$result = $this->db->query($sql);
		return $result;
	}
	
	function get_all($view_name,$order_by,$offset,$limit){
		$vendor_code = $this->session->userdata('vendor_code');
		$sql = "SELECT * 
		        FROM ".$view_name."
				WHERE vendor_code='".$vendor_code."'
				ORDER BY ".$order_by." 
				LIMIT ".$offset.",".$limit;
		$result = $this->db->query($sql);
		return $result;
	}
	
	function search($sql,$order_by,$offset,$limit){
		$sql = $sql." 
		       ORDER BY ".$order_by." 
			   LIMIT ".$offset.",".$limit;
		$result = $this->db->query($sql);
		return $result;
	}
		
	function receive() {	
		$table_name_trx = $this->config->item('table_name_di_trx');
		$id = $this->input->post('id');

		$data = array(
		  'di_status'=>$this->config->item('status_received'),
		  'di_status_date'=>date("Y-m-d H:i:s")
		);
		$this->db->where('id',$id);
		$this->db->update($table_name_trx,$data);	
	}
	
	function reject() {	
		$table_name_trx = $this->config->item('table_name_di_trx');
		$id = $this->input->post('id');
		$kriteria = $this->input->post('kriteria_reject');
		$alasan = $this->input->post('alasan_reject');

		$data = array(
		  'di_status'=>$this->config->item('status_rejected'),
		  'di_status_date'=>date("Y-m-d H:i:s"),
		  'kriteria_reject'=>$kriteria,
		  'di_status_note'=>$alasan
		);
		$this->db->where('id',$id);
		$this->db->update($table_name_trx,$data);
	}
	
}

/* End of file di_model.php */
/* Location: ./application/models/di_model.php */