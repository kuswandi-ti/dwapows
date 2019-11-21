<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Invoice Receive</b></li>
</ul>

<br />

<div id="tab-container">
	<ul id="tab">
		<li><a href="<?= base_url('ir/ir_open'); ?>" class="active">Monitoring</a></li>
	</ul>
</div>

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('ir/ir_open/search'); ?>
					<table class="list-table">
						<tr>
							<td>
								TT Date From
								&nbsp;&nbsp;
								<input type="text" id="cbo_tt_date_from" name="cbo_tt_date_from" /> 
								To 
								<input type="text" id="cbo_tt_date_to" name="cbo_tt_date_to" /> 
							</td>
							<td>&nbsp;&nbsp;&nbsp;</td>
							<td>
								Invoice Date From
								&nbsp;&nbsp;
								<input type="text" id="cbo_invoice_date_from" name="cbo_invoice_date_from" /> 
								To 
								<input type="text" id="cbo_invoice_date_to" name="cbo_invoice_date_to" /> 
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<button type="submit" class="css-button" name="btn-search">Search</button>
								<button type="reset" class="css-button" name="btn-reset">Reset</button>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?= base_url('ir/ir_open'); ?>" class="css-button">Refresh & View All</a>
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
				<td class="not-head">No.</td>
				<td class="not-head">Invoice No.</td>
				<td class="not-head">Invoice Date</td>
				<td class="not-head">Receive Date</td>
				<td class="not-head">Invoice Amount</td>
				<td class="not-head">Invoice Status</td>
				<td class="not-head">TT No.</td>
				<td class="not-head">Invoice Due Date</td>
				<td class="not-head">Action</td>
			</tr>
			<?php	
				$no = $total+1;
				foreach ($data->result_array() as $row) { 					
			?>
			<tr>
				<td align='center'><?= $no; ?></td>
				<td align='center'><?= $row['invoice_no']; ?></td>
				<td align='right'><?= convert_date($row['invoice_date'],'format_date'); ?></td>
				<td align='right'><?= convert_date($row['receive_date'],'format_date'); ?></td>
				<td align='right'><?= number_format($row['invoice_amount'],2); ?></td>
				<?php
					if ($row['invoice_status']==$this->config->item('status_receive_verification')) {
						$invoice_status = $this->config->item('status_receive_verification_info');
					} else if ($row['invoice_status']==$this->config->item('status_process_for_payment')) {
						$invoice_status = $this->config->item('status_process_for_payment_info');
					} else if ($row['invoice_status']==$this->config->item('status_partial_payment')) {
						$invoice_status = $this->config->item('status_partial_payment_info');
					} else if ($row['invoice_status']==$this->config->item('status_full_payment')) {
						$invoice_status = $this->config->item('status_full_payment_info');
					} else {
						$invoice_status='';
					}
				?>
				<td align='center'><?= $invoice_status; ?>
				<td align='center'><?= $row['tt_no']; ?></td>
				<td align='right'><?= convert_date($row['invoice_due_date'],'format_date'); ?></td>
				<td align='center'>
					<a class="show-detail-button" 
					   id="<?= $row['id']; ?>"	
					   vendor_code="<?= $row['vendor_code']; ?>"
					   tt_no="<?= $row['tt_no']; ?>"
					   inv_no="<?= $row['invoice_no']; ?>"
					   invoice_status="<?= $row['invoice_status']; ?>"
				       href="#">
					   Show Detail
					</a>
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
	
	<div id="form-detail" title="Invoice Detail"></div>
	
	<!--<br />
	<br />
	<br />
	<br />
	<center><img src="assets/images/uc.png" alt="Under Construction" style="width:339px;height:258px;"></center>-->
	<!--<center><h1><font color="red">SORRY... UNDER MAINTENANCE</font></h1></center>-->
	
</div>

<script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/plugins/zebra-datepicker-master/public/javascript/zebra_datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>

<script>
	$(document).ready(function() {
		$('#cbo_tt_date_from').Zebra_DatePicker();
		$('#cbo_tt_date_to').Zebra_DatePicker();
		$('#cbo_invoice_date_from').Zebra_DatePicker();	
		$('#cbo_invoice_date_to').Zebra_DatePicker();	
		
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		$(".show-detail-button").click(function() {
			var id = $(this).attr("id");
			$('#id').val(id);
			$.ajax({
				url: "<?= base_url('ir/ir_open/detail'); ?>",
				cache: false,
				type: 'GET',
				data: {
					id: $(this).attr("id"),
					vendor_code: $(this).attr("vendor_code"),
					tt_no: $(this).attr("tt_no"),
					inv_no: $(this).attr("inv_no"),
					invoice_status: $(this).attr("invoice_status"),
				},
				success: function(html) {
					$('#form-detail').html(html);
				}
			});
			$("#form-detail").dialog("open");
			return false;
		});
		
		$( "#form-detail" ).dialog({			
			autoOpen: false,
			height: 600,
			width: 1000,
			modal: true,
			hide: 'Slide',			
			buttons: {	
				"OK": function() {
					$('#id').val(''),
					$(this).dialog( "close" );
				}
			},
			close: function() {
				$('#id').val('');
				$(this).dialog( "close" );
			}
		});	

		$("#accordion > li").click(function(){
			if(false == $(this).next().is(':visible')) {
				$('#accordion > ul').slideUp(300);
			}
			$(this).next().slideToggle(300);
		});
		
		/*$(document).bind("contextmenu",function(e){
			return false;
		});*/
	});
	
	/*$(window).load(function() { 
		$("#loading").fadeOut("slow"); 
	});*/
</script>