<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Delivery Instruction (DI) - Received</b></li>
</ul>

<br />

<div id="tab-container">
	<ul id="tab">
		<li><a href="<?= base_url('di/di_releases'); ?>">Open</a></li>
		<li><a href="<?= base_url('di/di_histories'); ?>" class="active">Received</a></li>
	</ul>
</div>

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('di/di_histories/search'); ?>
					<table class="list-table">
						<tr>
							<td>DI Delivery Date
								&nbsp;&nbsp;
								<input type="text" id="di_delivery_datetime" name="di_delivery_datetime" /> 
							</td>
							<td>&nbsp;&nbsp;&nbsp;</td>
							<td>DI Release Date From
								&nbsp;&nbsp;
								<input type="text" id="di_date_from" name="di_date_from" /> 
								To 
								<input type="text" id="di_date_to" name="di_date_to" /> 
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<button type="submit" class="css-button" name="btn-search">Search</button>
								<button type="reset" class="css-button" name="btn-reset">Reset</button>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?= base_url('di/di_histories'); ?>" class="css-button">Refresh & View All</a>
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
				<td class="not-head" colspan="5">Delivery Instruction (DI)</td>
				<td class="not-head" colspan="3">DI Status</td>
				<!--<td class="not-head" rowspan="2">View PDF File</td>-->
				<td class="not-head" rowspan="2">Actions</td>
			</tr>
			<tr class="table-row-header">
				<td class="not-head">No.</td>
				<td class="not-head">Rev.</td>
				<td class="not-head">Date</td>
				<td class="not-head">Note</td>
				<td class="not-head">Delivery</td>
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
				<td align='center'><?= $row['di_no']; ?></td>
				<td align='center'><?= $row['di_rev']; ?></td>
				<td align='center'><?= convert_date($row['di_date'],'format_date'); ?></td>
				<td align='left'><?= $row['di_note']; ?></td>
				<td align='center'><?= $row['di_delivery_datetime']; ?></td>
				<?php
					$sess_userid = $this->session->userdata('user_id');
					if ($row['di_status']==$this->config->item('status_released')) {
						$di_status = $this->config->item('status_released_info');
					} else if ($row['di_status']==$this->config->item('status_received')) {
						$di_status = $this->config->item('status_received_info').$sess_userid;
					} else if ($row['di_status']==$this->config->item('status_revisi')) {
						$di_status = $this->config->item('status_revisi_info');
					} else if ($row['di_status']==$this->config->item('status_rejected')) {
						$di_status = $this->config->item('status_rejected_info').$sess_userid;
					} else if ($row['di_status']==$this->config->item('status_canceled')) {
						$di_status = $this->config->item('status_canceled_info');
					}
					
					if ($di_status!=$this->config->item('status_received_info').$sess_userid) { ?>
						<td align='center'><font color='red'><b><blink><?= $di_status; ?></blink></b></font></td>						
					<?php } else { ?>
						<td align='center'><?= $di_status; ?></td>
					<?php }
				?>
				<td align='center'><?= convert_date($row['di_status_date'],'format_datetime'); ?></td>
				<td align='left'><?= $row['di_status_note']; ?></td>	
				<td align='center'>
					<?php
						if ($di_status==$this->config->item('status_rejected_info')) { ?>
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
	
	<div id="form-redownload" title="Re-Download DI">Are you sure to download data ?</div>
</div>

<script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/plugins/zebra-datepicker-master/public/javascript/zebra_datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>

<script>
	$(document).ready(function() {
		$('#di_delivery_datetime').Zebra_DatePicker();
		$('#di_date_from').Zebra_DatePicker();
		$('#di_date_to').Zebra_DatePicker();
		
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
						url: "<?= base_url('di/di_histories/redownload'); ?>",	
						data: form_data,
						dataType: "json",
						async: false,
						success: function(msg) {
							$('#id').val('');
							$(location).attr('href',"di/di_histories/download/"+msg.res);
							alert('Successfully download DI Document !!!');
							$("#form-redownload").dialog("close");
							setTimeout(function() {
								$(location).attr('href',"<?= base_url('di/di_histories'); ?>");
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