<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
	 
	function __construct() {
		parent::__construct();
		$this->auth->restrict();
	}
	
	public function index() {
		$vendor_code = $this->session->userdata('vendor_code');
		
		$this->db->where('vendor_code',$vendor_code);		
		$data['fo'] = $this->db->count_all_results($this->config->item('view_name_fo_trx'));

		$this->db->where('vendor_code',$vendor_code);
		$data['plo'] = $this->db->count_all_results($this->config->item('view_name_plo_trx'));
		
		$this->db->where('vendor_code',$vendor_code);
		$data['di'] = $this->db->count_all_results($this->config->item('view_name_di_trx'));
		
		$this->db->where('vendor_code',$vendor_code);
		$data['grd'] = $this->db->count_all_results($this->config->item('view_name_rcv_trx'));
		
		$this->db->where('vendor_code',$vendor_code);
		$data['ir'] = $this->db->count_all_results($this->config->item('view_name_ir_trx'));
		
		$this->db->where('vendor_code',$vendor_code);
		$data['stock'] = $this->db->count_all_results($this->config->item('view_name_stock_trx'));
		
		$this->db->where('vendor_code',$vendor_code);
		$data['verifikasi'] = $this->db->count_all_results($this->config->item('view_name_verifikasi_trx'));

		$this->db->where('vendor_code',$vendor_code);
		$data['mdor'] = $this->db->count_all_results($this->config->item('view_name_doretur_trx_open'));
		
		$this->template->display('menu_view',$data);
	}
}

/* End of file menu.php */
/* Location: ./application/controllers/menu.php */