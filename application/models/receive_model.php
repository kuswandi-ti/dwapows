<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receive_Model extends CI_Model {
	
	function __construct() {
		parent::__construct();
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
	
	function get_file_name($vendor_code) { 
		$this->db->from('tbl_outstanding'); 
		$this->db->where('vendor_code', $vendor_code); 
		$query = $this->db->get(); 
		if($query->num_rows()>0) { 
			$data = $query->row_array(); 
			$value = $data['file_name']; 
			return $value; 
		} else { 
			return false; 
		}
	}
	
}

/* End of file receive_model.php */
/* Location: ./application/models/receive_model.php */