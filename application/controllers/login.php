<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
	}
	
	public function index() {	
		//if ($this->agent->is_browser('Firefox')) {
			$this->template->display('login_view');
		//} /*else {
			//$this->load->view('unsupportedbrowser_view');
		//}
	}
	
	public function login() {		
		if($this->auth->is_logged_in() == false) {
			$this->do_login();
		} else {
			$this->template->display('menu_view');
		}
	}
	
	public function do_login() {
		$this->form_validation->set_rules('user_id', 'User ID','trim|required|xss_clean');
		$this->form_validation->set_rules('user_password', 'Password','trim|required|xss_clean');
		$this->form_validation->set_error_delimiters(' <span style="color:#FF0000">', '</span>');
		
		$user_id = $this->input->post('user_id',true);
		$user_password = $this->input->post('user_password',true);

		if ($this->form_validation->run() == false) {
			$data['login_info'] = "User Id & Password harus diisi !";
			$this->template->display('login_view',$data);
		} else {
			$success = $this->auth->do_login($user_id,$user_password);
			if($success) {
				redirect('menu/index');
			} else {
				$data['login_info'] = "Maaf, user id atau password anda salah!";
				$this->template->display('login_view',$data);
			}
		}
	}
	
	public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */