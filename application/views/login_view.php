<link rel="stylesheet" type="text/css" href="assets/css/login.css" />
<link rel="stylesheet" type="text/css" id="camera-css" media="all" href="assets/plugins/camera/css/camera.css" /> 	
	
<div id="leftside">
	<div class="camera_wrap camera_azure_skin" id="camera_wrap_1">
		<div data-thumb="assets/plugins/camera/images/slides/thumbs/dwa1.jpg" data-src="assets/plugins/camera/images/slides/dwa1.jpg">
			
		</div>
		<div data-thumb="assets/plugins/camera/images/slides/thumbs/dwa2.jpg" data-src="assets/plugins/camera/images/slides/dwa2.jpg">
			
		</div>
	</div>
</div>

<div id="rightside">
	<div>
		<img src="assets/images/forms/logo-dwa.png" /><br /><br />
	</div>
	<div id="login-box">
		<form name="form-login" action="<?= base_url('login/do_login'); ?>" method="post">
			<?php
				// hanya untuk menampilkan informasi saja
				if(isset($login_info)) {
					echo "<span style='background-color:red;padding:3px;'>";
					echo $login_info;
					echo '</span>';
				}
			?>

			<h1>Login</h1>
			<p>Welcome. Please fill your user id and password</p>
			<div id="login-box-name" style="margin-top:20px;">User Id:</div>
			<div id="login-box-field" style="margin-top:20px;">
				<input id="user_id" name="user_id" class="form-login" title="User Id" value="" size="30" />
			</div>
			<div id="login-box-name">Password:</div>
			<div id="login-box-field">
				<input id="user_password" name="user_password" type="password" class="form-login" title="Password" value="" size="30" />
			</div>
			<input type="submit" value="Login" class="form-submit-button" style="float:left;">
		</form>
	</div>
</div>

<script type="text/javascript" src="assets/plugins/jquery/jquery-1.6.4.min.js"></script>

<script type="text/javascript" src="assets/plugins/camera/scripts/jquery.mobile.customized.min.js"></script>
<script type="text/javascript" src="assets/plugins/camera/scripts/jquery.easing.1.3.js"></script> 
<script type="text/javascript" src="assets/plugins/camera/scripts/camera.min.js"></script>

<script>
	jQuery(function(){			
		jQuery('#camera_wrap_1').camera({
			thumbnails: true
		});
		
		jQuery(document).bind("contextmenu",function(e){
			return false;
		});
	});
</script>