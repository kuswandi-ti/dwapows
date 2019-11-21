<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_Model extends CI_Model {
	
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
	
	function update_stock($id) {	
		$table_name_trx = $this->config->item('table_name_stock_trx');
		$stock_qty = $this->input->post('stock_qty');
		$min_qty = $this->input->post('min_qty');
		$max_qty = $this->input->post('max_qty');		
		
		date_default_timezone_set('Asia/Jakarta');
		/*$data = array(
		  'stock_qty'=>$stock_qty,
		  'min_qty'=>$min_qty,
		  'max_qty'=>$max_qty,
		  'updated_date'=>date("Y-m-d"),
		  'updated_time'=>date("H:i:s")
		);*/
		$data = array(
		  'stock_qty'=>$stock_qty,
		  'updated_date'=>date("Y-m-d"),
		  'updated_time'=>date("H:i:s")
		);
		$this->db->where('id',$id);
		$this->db->update($table_name_trx,$data);	
	}
	
	function search($sql,$order_by,$offset,$limit){
		$sql = $sql." 
		       ORDER BY ".$order_by." 
			   LIMIT ".$offset.",".$limit;
		$result = $this->db->query($sql);
		return $result;
	}
	
}

/* End of file stock_model.php */
/* Location: ./application/models/stock_model.php */