<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lcaf_Model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}	
	
	function get_all($view_name,$order_by,$offset,$limit){
		$sql = "SELECT * 
		        FROM ".$view_name."
				WHERE vendor_pic='".$this->session->userdata('user_id')."'
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
	
	function user_vendor() {
		$vendor_pic = $this->session->userdata('user_id');
		$query = $this->db
						->select('vendor_code')
						->where('vendor_pic',$vendor_pic)
						->group_by('vendor_code')
						->order_by('vendor_code')
						->get('qview_pic_vendor');
		return $query->result();
	}
	
	function show_print($vendor_code, $order_by) {
		if ($vendor_code == "*ALL*") {
			$query = $this->db
							->order_by($order_by)
							->get('v_loading_capacity_assurance_trx_forexport');
		} else {
			$query = $this->db
							->where('vendor_code',$vendor_code)
							->order_by($order_by)
							->get('v_loading_capacity_assurance_trx_forexport');
		}
		return $query->result();
	}
	
}

/* End of file lcaf_model.php */
/* Location: ./application/models/lcaf_model.php */