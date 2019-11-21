<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth {
	var $CI = NULL;
	
	function __construct()
	{
		// get CI's object
		$this->CI =& get_instance();
	}
	
	// untuk validasi login
	function do_login($user_id,$user_password) {
		// cek di database, ada ga?
		$this->CI->db->from('tbl_sys_user');
		$this->CI->db->where('user_id',$user_id);
		$this->CI->db->where('user_password',md5($user_password));
		$result = $this->CI->db->get();
		if($result->num_rows() == 0) {
			// username dan password tsb tidak ada
			return false;
		} else {
			// ada, maka ambil informasi dari database
			$userdata = $result->row();
			$session_data = array(
				'user_id'		=> $userdata->user_id,
				'user_name'	    => $userdata->user_name,
				'vendor_code'	=> $userdata->vendor_code,
				'vendor_name'	=> $userdata->vendor_name
			);
			// buat session
			$this->CI->session->set_userdata($session_data);
			return true;
		}
	}
	
	// untuk mengecek apakah user sudah login/belum
	function is_logged_in() {
		if($this->CI->session->userdata('user_id') == '') {
			return false;
		}
		return true;
	}
	
	// untuk validasi di setiap halaman yang mengharuskan authentikasi
	function restrict() {
		if($this->is_logged_in() == false)
		{
			redirect('');
		}
	}
	
}

/* End of file auth.php */
/* Location: ./application/libraries/auth.php */