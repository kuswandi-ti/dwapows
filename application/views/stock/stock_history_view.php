<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Stock - History</b></li>
</ul>

<br />

<div id="tab-container">
	<ul id="tab">
		<li><a href="<?= base_url('stock/stock_releases'); ?>">Live</a></li>
		<li><a href="<?= base_url('stock/stock_histories'); ?>" class="active">History</a></li>
		<li><a href="<?= base_url('stock/stock_exportimport'); ?>">Export & Import Data Stock</a></li>
	</ul>
</div>

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('stock/stock_histories/search'); ?>
					<table class="list-table">
						<tr>
							<td>Search (Part Number / Part Name) : <input type="text" id="txt_part_number" name="txt_part_number" /> </td>
							<td>
								<button type="submit" class="css-button" name="btn-search">Search</button>
								<button type="reset" class="css-button" name="btn-reset">Reset</button>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?= base_url('stock/stock_histories'); ?>" class="css-button">Refresh & View All</a>
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
				<td class="not-head">Part Number</td>
				<td class="not-head">Part Name</td>
				<td class="not-head">UOM</td>
				<td class="not-head">Stock Onhand</td>
				<td class="not-head">Min Qty</td>
				<td class="not-head">Max Qty</td>
				<td class="not-head">Status</td>
				<!--<td class="not-head">Jam</td>-->
			</tr>
			<?php	
				$no = $total+1;
				foreach ($data->result_array() as $row) { 					
			?>
			<tr>
				<td align='center'><?= $no; ?></td>
				<td align='center'><?= $row['part_number']; ?></td>
				<td align='left'><?= $row['part_name']; ?></td>
				<td align='center'><?= $row['uom']; ?></td>
				<td align='center' bgcolor='#E65C00'><?= number_format($row['stock_qty'],0); ?></td>
				<td align='center'><?= number_format($row['min_qty'],0); ?></td>
				<td align='center'><?= number_format($row['max_qty'],0); ?></td>
				<td align='center'>Onhand updated <?= convert_date($row['updated_date'],'format_date'); ?> <?= $row['updated_time']; ?></td>
				<!--<td align='center'><?= $row['updated_time']; ?></td>-->
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