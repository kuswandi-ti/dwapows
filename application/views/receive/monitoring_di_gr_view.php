<link rel="shortcut icon" href="../../assets/favicon.ico" type="image/x-icon">
<?php
	//$url = "http://docs.google.com/gview?url=".$this->config->item('url_gr').$pdf_file;
	if ($count_records<=0) {
		echo "<script type='text/javascript'>alert('Maaf, tidak ada data !!!');</script>";
	} else {
		$url = $this->config->item('url_gr').$pdf_file;
		redirect($url);
	}
?>