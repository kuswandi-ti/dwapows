<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Loading Capacity Assurance</b></li>
</ul>

<br />

<div id="tab-container">
	<ul id="tab">
		<li><a href="<?= base_url('lcaf/lcaf_monitoring'); ?>" class="active">Monitoring</a></li>
	</ul>
</div>

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('lcaf/lcaf_monitoring/search'); ?>
					<table class="list-table">
						<tr>
							<td>Vendor Code
								&nbsp;&nbsp;
								<input type="text" id="txt_vendor_code" name="txt_vendor_code" style="width:75px;" />
								Period Month
								<input type="text" id="txt_period_month" name="txt_period_month" style="width:75px;" />
								Period Year
								<input type="text" id="txt_period_year" name="txt_period_year" style="width:75px;" />								
								<!--Forecast No
								<input type="text" id="txt_fo_no" name="txt_fo_no" style="width:100px;" />
								Part Number
								<input type="text" id="txt_pn_number" name="txt_pn_number" style="width:125px;" />-->
							</td>
							<td>
								<button type="submit" class="css-button" name="btn-search">Search</button>
								<button type="reset" class="css-button" name="btn-reset">Reset</button>
								<a href="<?= base_url('lcaf/lcaf_monitoring'); ?>" class="css-button">Refresh & View All</a>
								&nbsp;&nbsp;&nbsp;
								Vendor
								<select id="cbo_vendor" name="cbo_vendor">
									<?php
										echo "<option value='*ALL*'>*ALL*</option>";
										foreach ($user_vendor as $row) {
											echo "<option value=$row->vendor_code>$row->vendor_code</option>";
										}
									?>
								</select>
								<button type="submit" class="css-button" name="btn-show-print">Preview</button>
								<button type="submit" class="css-button" name="btn-show-pdf">Export to PDF</button>
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
				<td class="not-head" rowspan="2">Vendor</td>
				<td class="not-head" colspan="2">Period</td>
				<td class="not-head" rowspan="2">Forecast No</td>
				<td class="not-head" rowspan="2">Part Number</td>
				<td class="not-head" rowspan="2">Part Name</td>
				<td class="not-head" rowspan="2">Unit</td>
				<td class="not-head" colspan="4">Qty Order</td>
				<td class="not-head" colspan="4">Qty Capacity</td>
			</tr>
			<tr class="table-row-header">
				<td class="not-head">Month</td>
				<td class="not-head">Year</td>
				<td class="not-head">N</td>
				<td class="not-head">N+1</td>
				<td class="not-head">N+2</td>
				<td class="not-head">N+3</td>
				<td class="not-head">N</td>
				<td class="not-head">N+1</td>
				<td class="not-head">N+2</td>
				<td class="not-head">N+3</td>
			</tr>
			<?php	
				$no = $total+1;
				foreach ($data->result_array() as $row) { 					
			?>
			<tr>
				<td align='center'><?= $no; ?></td>
				<td align='center'><?= $row['vendor_code']; ?></td>
				<td align='center'><?= $row['fo_period_month']; ?></td>
				<td align='center'><?= $row['fo_period_year']; ?></td>
				<td align='center'><?= $row['fo_no']; ?></td>
				<td align='center'><?= $row['pn_number']; ?></td>
				<td align='left'><?= $row['pn_name']; ?></td>
				<td align='center'><?= $row['unit']; ?></td>
				
				<?php
					if ($row['qty_order_n'] > $row['qty_capacity_n']) {
						echo "<td align='center' bgcolor='red'>".number_format($row['qty_order_n'])."</td>";
					} else {
						echo "<td align='center'>".number_format($row['qty_order_n'])."</td>";
					}
					
					if ($row['qty_order_n1'] > $row['qty_capacity_n1']) {
						echo "<td align='center' bgcolor='red'>".number_format($row['qty_order_n1'])."</td>";
					} else {
						echo "<td align='center'>".number_format($row['qty_order_n1'])."</td>";
					}
					
					if ($row['qty_order_n2'] > $row['qty_capacity_n2']) {
						echo "<td align='center' bgcolor='red'>".number_format($row['qty_order_n2'])."</td>";
					} else {
						echo "<td align='center'>".number_format($row['qty_order_n2'])."</td>";
					}
					
					if ($row['qty_order_n3'] > $row['qty_capacity_n3']) {
						echo "<td align='center' bgcolor='red'>".number_format($row['qty_order_n3'])."</td>";
					} else {
						echo "<td align='center'>".number_format($row['qty_order_n3'])."</td>";
					}
				?>
				
				<!--<td align='center'><?= number_format($row['qty_order_n']); ?></td>-->
				<!--<td align='center'><?= number_format($row['qty_order_n1']); ?></td>-->
				<!--<td align='center'><?= number_format($row['qty_order_n2']); ?></td>-->
				<!--<td align='center'><?= number_format($row['qty_order_n3']); ?></td>-->
				<td align='center'><?= number_format($row['qty_capacity_n']); ?></td>
				<td align='center'><?= number_format($row['qty_capacity_n1']); ?></td>
				<td align='center'><?= number_format($row['qty_capacity_n2']); ?></td>
				<td align='center'><?= number_format($row['qty_capacity_n3']); ?></td>
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