<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Plan Order (PLO) - Received</b></li>
</ul>

<br />

<div id="tab-container">
	<ul id="tab">
		<li><a href="<?= base_url('plo/plo_releases'); ?>">Open</a></li>
		<li><a href="<?= base_url('plo/plo_histories'); ?>" class="active">Received</a></li>
	</ul>
</div>

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('plo/plo_histories/search'); ?>
					<table class="list-table">
						<tr>
							<td>PLO Period :</td>
							<td>
								<select name="cbo_plo_period_month">
									<?php
										$now_month = date('m');
										$bulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
										for ($x=1;$x<=12;$x++) {
											if($x == $now_month) {
												echo "<option value='".$x."' selected='selected'>".$bulan[$x]."</option>";
											} else {
												echo "<option value='".$x."'>".$bulan[$x]."</option>";
											}
										}
									?>
								</select>
							</td>
							<td>
								<select name="cbo_plo_period_year">
									<?php
										$now_year = date('Y');
										for ($x=2012;$x<=2017;$x++) {
											if($x == $now_year) {
												echo "<option value='".$x."' selected='selected'>".$x."</option>";
											} else {
												echo "<option value='".$x."'>".$x."</option>";
											}
										}
									?>
								</select>
							</td>
							<td>&nbsp;&nbsp;&nbsp;</td>
							<td>PLO Release Date From
								&nbsp;&nbsp;
								<input type="text" id="plo_date_from" name="plo_date_from" /> 
								To 
								<input type="text" id="plo_date_to" name="plo_date_to" /> 
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<button type="submit" class="css-button" name="btn-search">Search</button>
								<button type="reset" class="css-button" name="btn-reset">Reset</button>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?= base_url('plo/plo_histories'); ?>" class="css-button">Refresh & View All</a>
							</td>
						</tr>
					</table>
				<?= form_close(); ?>
			</li>
		</ul>
	</ul>

	<br />
	
	<div id="show">
		<input type="hidden" value='' id="id" name="id">
        <table border="0" class="list-table custom-table">
			<tr class="table-row-header">
				<td class="not-head" rowspan="2">No.</td>
				<td class="not-head" colspan="4">Plan Order (PLO)</td>
				<td class="not-head" colspan="2">PLO Period</td>
				<td class="not-head" colspan="3">PLO Status</td>
				<!--<td class="not-head" rowspan="2">View PDF File</td>-->
				<td class="not-head" rowspan="2">Actions</td>
			</tr>
			<tr class="table-row-header">
				<td class="not-head">No.</td>
				<td class="not-head">Rev.</td>
				<td class="not-head">Date</td>
				<td class="not-head">Note</td>
				<td class="not-head">Month</td>
				<td class="not-head">Year</td>
				<td class="not-head">Status</td>
				<td class="not-head">Date</td>
				<td class="not-head">Note</td>
			</tr>
			<?php	
				$no = $total+1;
				foreach ($data->result_array() as $row) { 
			?>
			<tr>
				<td align='center'><?= $no; ?></td>
				<td align='center'><?= $row['plo_no']; ?></td>
				<td align='center'><?= $row['plo_rev']; ?></td>
				<td align='center'><?= convert_date($row['plo_date'],'format_date'); ?></td>
				<td align='left'><?= $row['plo_note']; ?></td>
				<td align='center'><?= month_3_char($row['plo_period_month']); ?></td>
				<td align='center'><?= $row['plo_period_year']; ?></td>
				<?php
					$sess_userid = $this->session->userdata('user_id');
					if ($row['plo_status']==$this->config->item('status_released')) {
						$plo_status = $this->config->item('status_released_info');
					} else if ($row['plo_status']==$this->config->item('status_received')) {
						$plo_status = $this->config->item('status_received_info').$sess_userid;
					} else if ($row['plo_status']==$this->config->item('status_revisi')) {
						$plo_status = $this->config->item('status_revisi_info');
					} else if ($row['plo_status']==$this->config->item('status_rejected')) {
						$plo_status = $this->config->item('status_rejected_info').$sess_userid;
					}
					
					if ($plo_status!=$this->config->item('status_received_info').$sess_userid) { ?>
						<td align='center'><font color='red'><b><blink><?= $plo_status; ?></blink></b></font></td>						
					<?php } else { ?>
						<td align='center'><?= $plo_status; ?></td>
					<?php }
				?>
				<td align='center'><?= convert_date($row['plo_status_date'],'format_datetime'); ?></td>
				<td align='left'><?= $row['plo_status_note']; ?></td>	
				<!--<td align='left'>
					<a 	class="pdf-file" 
						id="<?= $row['pdf_file']; ?>" 
						href="http://docs.google.com/gview?url=<?= $this->config->item('url_upload').$row['pdf_file']; ?>&embedded=true"
						style="width:600px; height:500px;" 
						frameborder="0" 						
						target="_blank"><img src="assets/images/forms/view_pdf.png" alt="View PDF" title="View PDF">&nbsp;<?= $row['pdf_file']; ?>
					</a>
				</td>-->
				<td align='center'>
					<?php
						if ($plo_status==$this->config->item('status_rejected_info')) { ?>
							No Action
						<?php } else { ?>
							<a class="redownload-button" 
								id="<?= $row['id']; ?>"
								href="#">
								<img src="assets/images/forms/pdf_download.png" alt="Re-Download" title="Re-Download">(<?= $row['count_download']; ?>)
							</a>
						<?php } ?>
				</td>
			</tr>
			<?php
					$no++;
				}
			?>
		</table>
    </div>
	
	<div class="pagination">
		<?= $paginator; ?>
	</div>
	
	<div id="form-redownload" title="Re-Download PLO">Are you sure to download data ?</div>
</div>

<script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/plugins/zebra-datepicker-master/public/javascript/zebra_datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>

<script>
	$(document).ready(function() {
		$('#plo_date_from').Zebra_DatePicker();
		$('#plo_date_to').Zebra_DatePicker();
		
		$("#accordion > li").click(function(){
			if(false == $(this).next().is(':visible')) {
				$('#accordion > ul').slideUp(300);
			}
			$(this).next().slideToggle(300);
		});
		
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
				
		$(".redownload-button").click(function() {
			var id = $(this).attr("id"); $('#id').val(id);	
			$("#form-redownload").dialog("open");
			return false;
		});
		
		$( "#form-redownload" ).dialog({						
			autoOpen: false,
			modal: true,
			hide: 'Slide',			
			buttons: {				
				"Yes": function() {	
					var form_data = {
						id: $('#id').val()
				  	};
					$.ajax({
						type: 'POST',
						url: "<?= base_url('plo/plo_histories/redownload'); ?>",	
						data: form_data,
						dataType: "json",
						async: false,
						success: function(msg) {
							$('#id').val('');
							$(location).attr('href',"plo/plo_histories/download/"+msg.res);	
							alert('Successfully download PLO Document !!!');
							$("#form-redownload").dialog("close");
							setTimeout(function() {
								$(location).attr('href',"<?= base_url('plo/plo_histories'); ?>");
							}, 5000);							
						}
					});
					return false;
				},
				Cancel: function() {
					$('#id').val(''),
					$(this).dialog( "close" );
				}
			},
			close: function() {
				$('#id').val('');
				$(this).dialog( "close" );
			}
		});
		
		/*$(document).bind("contextmenu",function(e){
			return false;
		});*/
	});
	
	/*$(window).load(function() { 
		$("#loading").fadeOut("slow"); 
	});*/
</script>