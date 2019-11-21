<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<html>
</head>
	<!-- http://cariprogram.blogspot.com/2012/06/pemrograman-web-otomatis-refresh.html -->
	<meta http-equiv="refresh" content="600" /> <!-- Refresh halaman tiap 30 menit (1 menit 60 detik, 30 menit = 60 x 30 = 1800) -->
	
	<title>PT. Dasa Windu Agung (DWA)</title>
	
	<base href="<?php echo base_url(); ?>" />
	
	<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon">
	
	<link rel="stylesheet" type="text/css" href="assets/css/all.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/crumbs.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/accordion.css" />
	<link rel="stylesheet" type="text/css" href="assets/css/button.css" />
	
	<!--<link rel="stylesheet" type="text/css" href="assets/bootstrap-4.0.0-dist/css/bootstrap.min.css" />-->
	
	<!--Start of Zopim Live Chat Script-->
	<!--<script type="text/javascript">
		window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
		d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
		_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
		$.src='//v2.zopim.com/?2YhNL5mG5EK6hPzXRnbajsrAR7aK2U7k';z.t=+new Date;$.
		type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
	</script>-->
	<!--End of Zopim Live Chat Script-->
</head>

<body>
	<div id="#content-container">
		<div id="header">
			<div id="user">
				<?php 				
					$sess_userid = $this->session->userdata('user_id');
					$sess_username = $this->session->userdata('user_name');
					$curr_date = date("Y-m-d");
					$curr_time = date("H:i");				
					if ($sess_userid=='') {
						echo "<font color=\"FFFFFF\">Welcome, </font><font color=\"E0EB29\"><b> Guest.</b></font><br />";
					} else {
						echo "<font color=\"FFFFFF\">Welcome, </font>
						     <font color=\"E0EB29\"><b>".$sess_userid."</b></font>  |  
							 <a href=".base_url('login/logout')."><font color=\"E0EB29\"><u>Logout</u></a></font>
							 |
							 <a href=".base_url('help')."><font color=\"3BCF1D\"><b>Help</b></font></a> <br />";
					}
				?>
				<font color="FFFFFF"><?= nama_hari($curr_date).', '.convert_date($curr_date,'format_date').' | '; ?>
					<span id="hours"></span>	
					<span id="point">:</span>
					<span id="min"></span>
					<span id="point">:</span>
					<span id="sec"></span>
				</font>
			</div>
			<?= $_header;?>
		</div>	
			
		<div id="content">		
			<?= $_content; ?>
		</div>
			
		<div id="footer">
			<?= $_footer; ?>
		</div>
	</div>
	
	<!--<script type="text/javascript" src="assets/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>-->
	
	<!-- http://www.alessioatzeni.com/blog/css3-digital-clock-with-jquery/ -->
	<script type="text/javascript">
		$(document).ready(function() {
			setInterval( function() {
				// Create a newDate() object and extract the seconds of the current time on the visitor's
				var seconds = new Date().getSeconds();
				// Add a leading zero to seconds value
				$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
				},1000);
				
			setInterval( function() {
				// Create a newDate() object and extract the minutes of the current time on the visitor's
				var minutes = new Date().getMinutes();
				// Add a leading zero to the minutes value
				$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
				},1000);
				
			setInterval( function() {
				// Create a newDate() object and extract the hours of the current time on the visitor's
				var hours = new Date().getHours();
				// Add a leading zero to the hours value
				$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
				}, 1000);

			$(document).bind("contextmenu",function(e){
				return false;
			});
		});
		
		$(window).load(function() { 
			$("#loading").fadeOut("slow"); 
		});
	</script>
</body>
</html>