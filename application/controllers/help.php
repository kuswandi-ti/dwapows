<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {
	 
	function __construct() {
		parent::__construct();
		$this->auth->restrict();
	}
	
	public function index() {		
		$this->template->display('help_view');
	}
	
}

/* End of file help.php */
/* Location: ./application/controllers/help.php */