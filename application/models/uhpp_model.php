<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uhpp_Model extends CI_Model {
	
	private $db2;
	
	function __construct() {
		parent::__construct();
		$this->db2 = $this->load->database('db_dwasys', TRUE);
	}
	
	function get_num_rows_uhpp($vendor_code) {
		return $this->db->query("
					SELECT
						*
					FROM
						tbl_hasil_proses_produksi
				")->num_rows();
	}
	
	function get_data_uhpp($vendor_code, $offset, $limit) {
		return $this->db->query("
					SELECT
						* 
					FROM
						tbl_hasil_proses_produksi
					WHERE
						vendor_code = '".$vendor_code."'
					ORDER BY
						tanggal 
					LIMIT
						".$offset.", ".$limit);
	}
	
	function get_vpn($vendor_code) {
		return $this->db2->query("
					SELECT
						a.SysId AS VPN_Id,
						a.VPN_Number,
						a.VPN_Name,
						a.IsActive,
						b.Vendor_Code
					FROM
						TMst_Pur_ProductVPNPN a
						LEFT OUTER JOIN TMst_Pur_Vendor b ON a.Vendor_Id = b.SysId
					WHERE
						a.IsActive = 1
						AND b.Vendor_Code = '".$vendor_code."'
					ORDER BY
						a.VPN_Number
				");
	}
	
	function add() {
		$data = array(
		  'tanggal' => date('Y-m-d', strtotime($this->input->post('tanggal'))),
		  'vendor_code' => $this->session->userdata('vendor_code'),
		  'vpn_id' => $this->input->post('vpn_id'),
		  'vpn_number' => $this->input->post('vpn_number'),
		  'vpn_name' => $this->input->post('vpn_name'),
		  'qty_process' => $this->input->post('qty_process'),
		  'qty_ok' => $this->input->post('qty_ok'),
		  'qty_ng' => $this->input->post('qty_ng'),
		  'persen_ok' => $this->input->post('persen_ok'),
		  'persen_ng' => $this->input->post('persen_ng'),
		  'detail_ng_defect' => $this->input->post('detail_ng_defect'),
		  'created_by' => $this->session->userdata('user_id'),
		  'created_date' => date("Y-m-d H:i:s"),
		  'modified_by' => $this->session->userdata('user_id'),
		  'modified_date' => date("Y-m-d H:i:s")
		);
		$this->db->insert('tbl_hasil_proses_produksi', $data);
	}
	
	function edit() {
		$id = $this->input->post('id');
		
		$this->db->from('tbl_hasil_proses_produksi');
        $this->db->where('sysid', $id);
        $query = $this->db->get();
 
        return $query->row();
	}
	
	function update() {
		$id = $this->input->post('id');
		
		$data = array(		  
		  'tanggal' => date('Y-m-d', strtotime($this->input->post('tanggal'))),
		  'vendor_code' => $this->session->userdata('vendor_code'),
		  'vpn_id' => $this->input->post('vpn_id'),
		  'vpn_number' => $this->input->post('vpn_number'),
		  'vpn_name' => $this->input->post('vpn_name'),
		  'qty_process' => $this->input->post('qty_process'),
		  'qty_ok' => $this->input->post('qty_ok'),
		  'qty_ng' => $this->input->post('qty_ng'),
		  'persen_ok' => $this->input->post('persen_ok'),
		  'persen_ng' => $this->input->post('persen_ng'),
		  'detail_ng_defect' => $this->input->post('detail_ng_defect'),
		  'modified_by' => $this->session->userdata('user_id'),
		  'modified_date' => date("Y-m-d H:i:s")
		);
		$this->db->where('sysid', $id);
		$this->db->update('tbl_hasil_proses_produksi', $data);
	}
	
}

/* End of file uhpp_model.php */
/* Location: ./application/models/uhpp_model.php */