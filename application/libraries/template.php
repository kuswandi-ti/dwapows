<?php
	class Template {
		protected $_ci;
		
		function __construct() {
			$this->_ci =&get_instance();
		}
		
		function display($content,$data=null) {
			$data['_header'] = $this->_ci->load->view('template/header',$data,true);
			$data['_content'] = $this->_ci->load->view($content,$data,true);		
			$data['_footer'] = $this->_ci->load->view('template/footer',$data,true);
			$this->_ci->load->view('template/template.php',$data);
		}
	}