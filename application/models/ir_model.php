<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ir_Model extends CI_Model {
	
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
	
	function detail_by_id($view_name,$id){
		$sql = "SELECT * 
		       FROM ".$view_name." 
			   WHERE id_hdr='".$id."'";
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

/* End of file ir_model.php */
/* Location: ./application/models/ir_model.php */