<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility extends CI_Controller {
	 
	function __construct() {
		parent::__construct();
		$this->auth->restrict();
	}
	
	public function view_pdf() {	
		$data['pdf_file'] = $this->input->get('pdf_file');
		$this->load->view('pdf_view',$data);
	}
	
}

/* End of file utility.php */
/* Location: ./application/controllers/utility.php */