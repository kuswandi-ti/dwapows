<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Delivery Instruction (DI) - Open</b></li>
</ul>

<br />

<div id="tab-container">
	<ul id="tab">
		<li><a href="<?= base_url('di/di_releases'); ?>" class="active">Open</a></li>
		<li><a href="<?= base_url('di/di_histories'); ?>">Received</a></li>
	</ul>
</div>

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('di/di_releases/search'); ?>
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
								<a href="<?= base_url('di/di_releases'); ?>" class="css-button">Refresh & View All</a>
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
				<td class="not-head" rowspan="2">View PDF File</td>
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
					if ($row['selisih_tanggal'] > 3) {
						echo "<tr class=\"record\">";
					} else {
						echo "<tr>";
					}
			?>
				<td align='center'><?= $no; ?></td>
				<td align='center'><?= $row['di_no']; ?></td>
				<td align='center'><?= $row['di_rev']; ?></td>
				<td align='center'><?= convert_date($row['di_date'],'format_date'); ?></td>
				<td align='left'><?= $row['di_note']; ?></td>
				<td align='center'><?= convert_date($row['di_delivery_datetime'],'format_datetime'); ?></td>
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
					
					if ($di_status!=$this->config->item('status_released_info')) { ?>
						<td align='center' class="reject">
							<font color='red'>
								<b><?= $di_status; ?></b>
							</font>
						</td>						
					<?php } else { ?>
						<td align='center'><?= $di_status; ?></td>
					<?php }
				?>
				<td align='center'><?= convert_date($row['di_status_date'],'format_datetime'); ?></td>
				<td align='left'><?= $row['di_status_note']; ?></td>
				<td align='left'>
					<a 	class="pdf-file" 
						id="<?= $row['pdf_file_viewonly']; ?>" 
						href="<?= $this->config->item('url_upload').$row['pdf_file_viewonly']; ?>"
						style="width:600px; height:500px;" 
						frameborder="0" 						
						target="_blank"><img src="assets/images/forms/view_pdf.png" alt="View PDF" title="View PDF">&nbsp;<?= $row['pdf_file_viewonly']; ?>
					</a>
				</td>
				<td align='center'>
					<?php
						if ($di_status==$this->config->item('status_rejected_info').$sess_userid) { 
					?>
							No Action
					<?php 
						} else if ($di_status==$this->config->item('status_canceled_info')) {
					?>
							<a href="<?php echo base_url() ?>di/di_releases/cancel/<?php echo $row['id'] ?>">Confirm</a>
					<?php
						} else { 
					?>
							<a 	class="receive-button" 
								id="<?= $row['id']; ?>" 
								href="#">Receive
							</a>
							|
							<a 	class="reject-button" 
								id="<?= $row['id']; ?>" 
								href="#">Reject
							</a>
					<?php 
						} 
					?>
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
	
	<div id="form-receive" title="Receive DI">Are you sure to receive data ?</div>
	<div id="form-reject" title="Reject DI">
		Are you sure to reject data ? 
		<br /><br />
		<b>Kriteria Reject :</b>
		<br />
		<select id="kriteria_reject" name="kriteria_reject">
			<?php
				foreach ($kriteria_reject->result_array() as $row) {
					echo "<option value=$row[id]>$row[nama_kriteria]</option>";
				}
			?>
		</select>
		<br />
		<br />
		<b>Alasan Reject :</b>
		<br />
		<textarea rows="7" cols="80" name="alasan_reject" id="alasan_reject" size="160" class="required"></textarea>
	</div>
</div>

<script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/plugins/zebra-datepicker-master/public/javascript/zebra_datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-blink/jquery-blink.js"></script>

<script>
	$(document).ready(function() {
		$('#di_delivery_datetime').Zebra_DatePicker();
		$('#di_date_from').Zebra_DatePicker();
		$('#di_date_to').Zebra_DatePicker();
		
		$('.reject').blink({delay:500});
		
		$("#accordion > li").click(function(){
			if(false == $(this).next().is(':visible')) {
				$('#accordion > ul').slideUp(300);
			}
			$(this).next().slideToggle(300);
		});
		
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
				
		$(".receive-button").click(function() {
			var id = $(this).attr("id"); $('#id').val(id);	
			$("#form-receive").dialog("open");
			return false;
		});
		
		$( "#form-receive" ).dialog({						
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
						url: "<?= base_url('di/di_releases/receive'); ?>",	
						data: form_data,
						dataType: "json",
						async: false,
						success: function(msg) {
							$('#id').val('');
							$(location).attr('href',"di/di_releases/download/"+msg.res);	
							alert('Successfully receive DI Document !!!. Please download & Print PDF document.');
							$("#form-receive").dialog("close");
							setTimeout(function() {
								$(location).attr('href',"<?= base_url('di/di_releases'); ?>");
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

		$(".reject-button").click(function() {			
			var id = $(this).attr("id"); $('#id').val(id);
			$("#form-reject").dialog("open");
			return false;
		});

		$( "#form-reject" ).dialog({						
			autoOpen: false,
			modal: true,
			height: 290,
			width: 620,
			hide: 'Slide',			
			buttons: {				
				"Yes": function() {	
					/* http://stackoverflow.com/questions/1044105/string-length-and-jquery */
					if ($('#alasan_reject').val().length==0) {
						alert("Alasan reject harus diisi !!!");
						return false;
					}
					var form_data = {
						id: $('#id').val(),
						kriteria_reject: $('#kriteria_reject option:selected').val(),
						alasan_reject: $('#alasan_reject').val()
				  	};
					$.ajax({						
						type: 'POST',
						async: false,
						url: "<?= base_url('di/di_releases/reject'); ?>",	
						data : form_data,
						success: function(msg) {
							$('#id').val('');
							$('#kriteria_reject').val('');
							$('#alasan_reject').val('');			
							$(location).attr('href',"<?= base_url('di/di_releases'); ?>");
						}
					});
				},
				Cancel: function() {
					$('#id').val(''),
					$('#kriteria_reject').val(''),
					$('#alasan_reject').val(''),
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