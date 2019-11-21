<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Stock - Live</b></li>
</ul>

<br />

<div id="tab-container">	
	<ul id="tab">
		<li><a href="<?= base_url('stock/stock_releases'); ?>" class="active">Live</a></li>
		<li><a href="<?= base_url('stock/stock_histories'); ?>">History</a></li>
		<li><a href="<?= base_url('stock/stock_exportimport'); ?>">Export & Import Data Stock</a></li>
	</ul>
</div>

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('stock/stock_releases/search'); ?>
					<table class="list-table">
						<tr>
							<td>Search (Part Number / Part Name) : <input type="text" id="txt_part_number" name="txt_part_number" /> </td>
							<td>
								<button type="submit" class="css-button" name="btn-search">Search</button>
								<button type="reset" class="css-button" name="btn-reset">Reset</button>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?= base_url('stock/stock_releases'); ?>" class="css-button">Refresh & View All</a>
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
				<td class="not-head">Action</td>
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
				<td align='center'>Onhand updated<br/><?= convert_date($row['updated_date'],'format_date'); ?> <?= convert_date($row['updated_time'],'format_time'); ?></td>
				<!--<td align='center'><?= convert_date($row['updated_time'],'format_time'); ?></td>-->
				<td align="center">
					<a 	class="update_button" 
						id="<?= $row['id']; ?>" 
						part_number="<?= $row['part_number']; ?>"
						part_name="<?= $row['part_name']; ?>"
						uom="<?= $row['uom']; ?>"
						stock_qty="<?= $row['stock_qty']; ?>"
						min_qty="<?= $row['min_qty']; ?>"
						max_qty="<?= $row['max_qty']; ?>"
						href="#">Update Stock
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
	
	<div id="update_dialog" title="Update Stock">
		<div>
			<fieldset>
				<form action="" method="post">
					Part Number : <br /><input type="text" id="part_number" name="part_number" disabled /><br /><br />
					Part Name : <br /><textarea rows="3" cols="75" name="part_name" id="part_name" size="160" disabled></textarea><br /><br />
					UOM : <br /><input type="text" id="uom" name="uom" size="20" disabled /><br /><br />
					Onhand Qty : <br /><input type="text" id="stock_qty" name="stock_qty" class="required" onkeypress="return isNumberKey(event)" /><br /><br />
					Min Qty : <br /><input type="text" id="min_qty" name="min_qty" class="required" onkeypress="return isNumberKey(event)" disabled /><br /><br />
					Max Qty : <br /><input type="text" id="max_qty" name="max_qty" class="required" onkeypress="return isNumberKey(event)" disabled /><br /><br />
					<input type="hidden" id="ids" name="ids" />
				</form>
			</fieldset>			
		</div>
	</div>
</div>

<script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/plugins/zebra-datepicker-master/public/javascript/zebra_datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-blink/jquery-blink.js"></script>

<script>
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		} else {
			return true;
		}      
	}

	$(document).ready(function() {
		$("#accordion > li").click(function(){
			if(false == $(this).next().is(':visible')) {
				$('#accordion > ul').slideUp(300);
			}
			$(this).next().slideToggle(300);
		});
		
		$("#dialog:ui-dialog").dialog("destroy");
		
		$(".update_button").click(function() {			
			var id =''; id = $(this).attr("id"); $('#ids').val(id);
			var part_number = ''; part_number = $(this).attr("part_number"); $('#part_number').val(part_number);
			var part_name = ''; part_name = $(this).attr("part_name"); $('#part_name').val(part_name);
			var uom = ''; uom = $(this).attr("uom"); $('#uom').val(uom);
			var stock_qty = 0; stock_qty = $(this).attr("stock_qty"); $('#stock_qty').val(stock_qty);
			var min_qty = 0; min_qty = $(this).attr("min_qty"); $('#min_qty').val(min_qty);
			var max_qty = 0; max_qty = $(this).attr("max_qty"); $('#max_qty').val(max_qty);
			$("#update_dialog").dialog("open");
			return false;
		});
		
		$( "#update_dialog" ).dialog({						
			autoOpen: false,
			modal: true,
			height: 520,
			width: 630,
			hide: 'Slide',			
			buttons: {				
				"Yes": function() {	
					var form_data = {
						id: $('#ids').val(),
						stock_qty: $('#stock_qty').val(),
						min_qty: $('#min_qty').val(),
						max_qty: $('#max_qty').val()
				  	};
					$.ajax({						
						type: 'POST',
						url: "<?= base_url('stock/stock_releases/update_stock'); ?>",	
						data : form_data,					
						success: function(msg) {
							$('#ids').val('');
							$('#stock_qty').val('');
							$('#min_qty').val('');	
							$('#max_qty').val('');
							$(location).attr('href',"<?= base_url('stock/stock_releases'); ?>");							
						}
					});
				},
				Cancel: function() {
					$('#ids').val(''),
					$('#stock_qty').val(''),
					$('#min_qty').val(''),
					$('#max_qty').val(''),
					$(this).dialog( "close" );
				}
			},
			close: function() {
				$('#ids').val('');
				$('#stock_qty').val('');
				$('#min_qty').val('');	
				$('#max_qty').val('');
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