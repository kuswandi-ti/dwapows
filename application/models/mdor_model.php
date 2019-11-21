<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdor_Model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}	
	
	function get_open($view_name,$order_by,$offset,$limit){
		$vendor_code = $this->session->userdata('vendor_code');
		$sql = "SELECT * 
		        FROM ".$view_name."
				WHERE vendor_code='".$vendor_code."'
				AND qty_os > 0
				ORDER BY ".$order_by." 
				LIMIT ".$offset.",".$limit;
		$result = $this->db->query($sql);
		return $result;
	}

	function get_close($view_name,$order_by,$offset,$limit){
		$vendor_code = $this->session->userdata('vendor_code');
		$sql = "SELECT * 
		        FROM ".$view_name."
				WHERE vendor_code='".$vendor_code."'
				AND qty_os <= 0
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
	
}

/* End of file mdor_model.php */
/* Location: ./application/models/mdor_model.php */