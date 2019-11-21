<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Invoice Receive - Close</b></li>
</ul>

<br />

<div id="tab-container">
	<ul id="tab">
		<li><a href="<?= base_url('ir/ir_open'); ?>">Open</a></li>
		<li><a href="<?= base_url('ir/ir_close'); ?>" class="active">Close</a></li>
	</ul>
</div>

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('ir/ir_close/search'); ?>
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
				<td class="not-head" rowspan="2">No.</td>
				<td class="not-head" colspan="3">Delivery Instruction (DI)</td>
				<td class="not-head" colspan="2">DI Period</td>
				<!--<td class="not-head" colspan="3">Status</td>-->
			</tr>
			<tr class="table-row-header">
				<td class="not-head">No.</td>
				<td class="not-head">Rev.</td>
				<td class="not-head">Note</td>				
				<td class="not-head">Month</td>
				<td class="not-head">Year</td>
				<td class="not-head">Status</td>
				<td class="not-head">Due Date</td>
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
				<td align='center'><?= $row['di_note']; ?></td>
				<td align='center'><?= bulan_3karakter($row['di_period_month']); ?></td>
				<td align='center'><?= $row['di_period_year']; ?></td>
				<?php
					/*if ($row['di_status']==$this->config->item('status_readytopay')) {
						$di_status = $this->config->item('status_readytopay_info');
					} else if ($row['di_status']==$this->config->item('status_pay')) {
						$di_status = $this->config->item('status_pay_info');
					}*/
				?>
				<td align='center'><?= $di_status; ?></td>
				<td align='center'><?= format_tanggaljam3karakter($row['di_due_date']); ?></td>
				<td align='left'><?= $row['di_status_note']; ?></td>
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
		
		/*$(document).bind("contextmenu",function(e){
			return false;
		});*/
	});
	
	/*$(window).load(function() { 
		$("#loading").fadeOut("slow"); 
	});*/
</script>