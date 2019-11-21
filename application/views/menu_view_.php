<style>

</style>

<link rel="stylesheet" type="text/css" href="assets/css/menu.css" />
<link rel="stylesheet" type="text/css" href="assets/css/notification.css" />

<div id="mainwrapper">
	<?php 
		$user_id = $this->session->userdata('user_id');
		$sql = "SELECT * 
		        FROM v_sys_menu_access
				WHERE user_id='".$user_id."'
				ORDER BY menu_sort";
		$result = $this->db->query($sql);
		foreach ($result->result_array() as $row) {
	?>
			<a href="<?= base_url($row['menu_base_url']); ?>">
				<div id="box-2" class="box">
					<?php if ($row['menu_name']!=='receive' and $row['menu_name']!=='ir' and $row['menu_name']!=='stock') { ?>
						<section class='notification'>
							<?php
								if ($row['menu_name']=='fo') { $data_count=$fo; }
								if ($row['menu_name']=='plo') { $data_count=$plo; }
								if ($row['menu_name']=='di') { $data_count=$di; }
								if ($row['menu_name']=='verifikasi') { $data_count=$verifikasi; }
							?>
							<li class='message' data-count='<?= $data_count; ?> *'></li>
						</section>
					<?php } ?>					
					<img id="<?= $row['menu_img_id']; ?>" src="<?= $row['menu_img_src']; ?>"/>
					<span class="caption full-caption">
						<h3><?= $row['menu_caption']; ?></h3>
						<p><?= $row['menu_description']; ?></p>
					</span>			
				</div>
			</a>
	<?php
		}
	?>
	
	<!--<a href="<?= base_url('help'); ?>">
		<div id="box-2" class="box">
			<img id="help" src="assets/images/menu/help.jpg"/>
			<span class="caption full-caption">
				<h3>Help</h3>
				<p>Petunjuk dari aplikasi</p>
			</span>
		</div>
	</a>-->
	
	<div style="color:red;padding:15px;font-size:medium;" id="_blink"><b>* Waiting to Action</b></div>
	
</div>

<script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-blink/jquery-blink.js"></script>

<script>
	$(document).ready(function() {
		$('#_blink').blink({delay:500});
	});
	
	$(window).load(function() { 
		$("#loading").fadeOut("slow"); 
		
		$(document).bind("contextmenu",function(e){
			return false;
		});
	});
</script>