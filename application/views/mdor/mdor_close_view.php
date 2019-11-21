<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Monitoring DO Retur - Close</b></li>
</ul>

<br />

<div id="tab-container">	
	<ul id="tab">
		<li><a href="<?= base_url('mdor/mdor_open'); ?>">Open</a></li>
		<li><a href="<?= base_url('mdor/mdor_close'); ?>" class="active">Close</a></li>
	</ul>
</div>

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('mdor/mdor_close/search'); ?>
					<table class="list-table">
						<tr>
							<td>
								DO Date From
								&nbsp;&nbsp;
								<input type="text" id="cbo_doretur_date_from" name="cbo_doretur_date_from" /> 
								To 
								<input type="text" id="cbo_doretur_date_to" name="cbo_doretur_date_to" /> 
							</td>
							<td>&nbsp;&nbsp;&nbsp;</td>
							<td>
								GR Date From
								&nbsp;&nbsp;
								<input type="text" id="cbo_grreguler_date_from" name="cbo_grreguler_date_from" /> 
								To 
								<input type="text" id="cbo_grreguler_date_to" name="cbo_grreguler_date_to" /> 
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<button type="submit" class="css-button" name="btn-search">Search</button>
								<button type="reset" class="css-button" name="btn-reset">Reset</button>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?= base_url('mdor/mdor_close'); ?>" class="css-button">Refresh & View All</a>
							</td>
						</tr>
					</table>
				<?= form_close(); ?>
			</li>
		</ul>
	</ul>

	<br />
	
	<div id="show">
        <table border="0" class="list-table custom-table">
			<tr class="table-row-header">
				<td class="not-head">No.</td>
				<td class="not-head">DO Retur No.</td>
				<td class="not-head">DO Retur Date</td>
				<td class="not-head">DI No.</td>
				<td class="not-head">SJ No.</td>
				<td class="not-head">SJ Date</td>
				<td class="not-head">Part Number</td>
				<td class="not-head">Part Name</td>
				<td class="not-head">Qty Retur</td>
				<td class="not-head">Qty GR</td>
				<td class="not-head">Qty OS</td>
			</tr>
			<?php	
				$no = $total+1;
				foreach ($data->result_array() as $row) { 					
			?>
			<tr>
				<td align='center'><?= $no; ?></td>
				<td align='center'><?= $row['do_retur_no']; ?></td>
				<td align='right'><?= convert_date($row['do_retur_date'],'format_date'); ?></td>
				<td align='center'><?= $row['di_no']; ?></td>
				<td align='center'><?= $row['sj_supplier_no']; ?></td>
				<td align='right'><?= convert_date($row['sj_supplier_date'],'format_date'); ?></td>
				<td align='center'><?= $row['vpn_number']; ?></td>
				<td align='left'><?= $row['vpn_name']; ?></td>
				<td align='right'><?= number_format($row['qty_do_retur'],0); ?></td>
				<td align='right'><?= number_format($row['qty_gr_retur'],0); ?></td>
				<td align='right'><?= number_format($row['qty_os'],0); ?></td>
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
<script type="text/javascript" src="assets/plugins/jquery-blink/jquery-blink.js"></script>

<script>
	$(document).ready(function() {
		$('#cbo_doretur_date_from').Zebra_DatePicker();
		$('#cbo_doretur_date_to').Zebra_DatePicker();
		$('#cbo_grreguler_date_from').Zebra_DatePicker();	
		$('#cbo_grreguler_date_to').Zebra_DatePicker();

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