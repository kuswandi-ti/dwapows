<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Update Hasil Proses Produksi</b></li>
</ul>

<br />

<div id="content-container">
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('subcont/uhpp/search'); ?>
					<table class="list-table">
						<tr>
							<td>Date
								&nbsp;&nbsp;
								<input type="text" id="txtdate_find" name="txtdate_find" /> 
							</td>
							<td>&nbsp;&nbsp;&nbsp;</td>
							<td>VPN Code
								&nbsp
								<select name="cbopn_cari" id="cbopn_cari" style="width: 80%;">
									<option value="0">--Pilih Item--</option>
									<?php
										foreach ($get_vpn->result() as $r) {
											echo "<option value='".$r->VPN_Id."'
														  vpn_number='".$r->VPN_Number."'
														  vpn_name='".$r->VPN_Name."'>".$r->VPN_Number." - ".$r->VPN_Name."</option>";
										}
									?>
								</select>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<button type="submit" class="css-button" name="btn-search">Search</button>
								<button type="reset" class="css-button" name="btn-reset">Reset</button>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a href="<?= base_url('subcont/uhpp'); ?>" class="css-button">Refresh & View All</a>
							</td>
						</tr>
					</table>
				<?= form_close(); ?>
			</li>
		</ul>
	</ul>

	<br />
	
	<div id="show">
		<button class="css-button add-button" name="add-button">Add</button>
        <table border="0" class="list-table custom-table">
			<tr class="table-row-header">
				<td class="not-head">No.</td>
				<td class="not-head" style="display: none;">ID</td>
				<td class="not-head">Tanggal</td>
				<td class="not-head" style="display: none;">VPN ID</td>
				<td class="not-head">VPN Code</td>
				<td class="not-head">VPN Name</td>
				<td class="not-head">Qty Process</td>
				<td class="not-head">Qty OK</td>
				<td class="not-head">Qty NG</td>
				<td class="not-head">% OK</td>
				<td class="not-head">% NG</td>
				<td class="not-head">Detail NG Defect</td>
				<td class="not-head">Actions</td>
			</tr>
			<?php	
				$no = $total + 1;
				foreach ($data->result_array() as $row) { 	
			?>
				<td align='center'><?= $no; ?></td>
				<td align='center' style='display: none'><?= $row['sysid']; ?></td>
				<td align='center'><?= convert_date($row['tanggal'],'format_date'); ?></td>
				<td align='center' style='display: none'><?= $row['vpn_id']; ?></td>
				<td align='center'><?= $row['vpn_number']; ?></td>
				<td><?= $row['vpn_name']; ?></td>
				<td align='center'><?= number_format($row['qty_process']); ?></td>
				<td align='center'><?= number_format($row['qty_ok']); ?></td>
				<td align='center'><?= number_format($row['qty_ng']); ?></td>
				<td align='center'><?= number_format($row['persen_ok'], 1); ?></td>
				<td align='center'><?= number_format($row['persen_ng'], 1); ?></td>
				<td align='left'><?= $row['detail_ng_defect']; ?></td>
				<td align='center'>
							<a 	class="update-button" 
								id="<?= $row['sysid']; ?>" 
								href="#">Update
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
	
	<div id="form-add" title="Add Data">
		<b>Tanggal :</b><br />
		<input type="text" id="txttanggal_add" name="txttanggal_add" /><br /><br />
		
		<b>Part Number :</b><br />
		<select name="cbopn_add" id="cbopn_add" style="width: 100%;">
			<option value="0">--Pilih Item--</option>
			<?php
				foreach ($get_vpn->result() as $r) {
					echo "<option value='".$r->VPN_Id."'
					              vpn_number='".$r->VPN_Number."'
								  vpn_name='".$r->VPN_Name."'>".$r->VPN_Number." - ".$r->VPN_Name."</option>";
				}
			?>
		</select><br /><br />
		
		<b>Qty Process :</b><br />
		<input type="text" id="txtqtyprocess_add" name="txtqtyprocess_add" value="0" style="text-align: right" onkeypress="return isNumberKey(event)" /><br /><br />
		
		<b>Qty OK :</b><br />
		<input type="text" id="txtqtyok_add" name="txtqtyok_add" value="0" style="text-align: right" onkeypress="return isNumberKey(event)" /><br /><br />
		
		<b>Qty NG :</b><br />
		<input type="text" id="txtqtyng_add" name="txtqtyng_add" value="0" style="text-align: right" onkeypress="return isNumberKey(event)" /><br /><br />
		
		<b>% OK :</b><br />
		<input type="text" id="txtpersenok_add" name="txtpersenok_add" value="0" style="text-align: right" readonly /><br /><br />
		
		<b>% NG :</b><br />
		<input type="text" id="txtpersenng_add" name="txtpersenng_add" value="0" style="text-align: right" readonly /><br /><br />
		
		<b>Detail NG Defect :</b>
		<br />
		<textarea rows="7" cols="80" style="width: 100%;" name="txtdetailng_add" id="txtdetailng_add" size="160" class="required"></textarea>
	</div>
	
	<div id="form-update" title="Update Data">
		<input type="text" id="txtid_edit" /><br /><br />
	
		<b>Tanggal :</b><br />
		<input type="text" id="txttanggal_edit" name="txttanggal_edit" /><br /><br />
		
		<b>Part Number :</b><br />
		<select name="cbopn_edit" id="cbopn_edit" style="width: 100%;">
			<option value="0">--Pilih Item--</option>
			<?php
				foreach ($get_vpn->result() as $r) {
					echo "<option value='".$r->VPN_Id."'
					              vpn_number='".$r->VPN_Number."'
								  vpn_name='".$r->VPN_Name."'>".$r->VPN_Number." - ".$r->VPN_Name."</option>";
				}
			?>
		</select><br /><br />
		
		<b>Qty Process :</b><br />
		<input type="text" id="txtqtyprocess_edit" name="txtqtyprocess_edit" value="0" style="text-align: right" onkeypress="return isNumberKey(event)" /><br /><br />
		
		<b>Qty OK :</b><br />
		<input type="text" id="txtqtyok_edit" name="txtqtyok_edit" value="0" style="text-align: right" onkeypress="return isNumberKey(event)" /><br /><br />
		
		<b>Qty NG :</b><br />
		<input type="text" id="txtqtyng_edit" name="txtqtyng_edit" value="0" style="text-align: right" onkeypress="return isNumberKey(event)" /><br /><br />
		
		<b>% OK :</b><br />
		<input type="text" id="txtpersenok_edit" name="txtpersenok_edit" value="0" style="text-align: right" readonly /><br /><br />
		
		<b>% NG :</b><br />
		<input type="text" id="txtpersenng_edit" name="txtpersenng_edit" value="0" style="text-align: right" readonly /><br /><br />
		
		<b>Detail NG Defect :</b>
		<br />
		<textarea rows="7" cols="80" style="width: 100%;" name="txtdetailng_edit" id="txtdetailng_edit" size="160" class="required"></textarea>
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
		$( "#txtdate_find" ).datepicker({ dateFormat: 'dd-mm-yy' });
		$( "#txttanggal_add" ).datepicker({ dateFormat: 'dd-mm-yy' });
		$( "#txttanggal_edit" ).datepicker({ dateFormat: 'dd-mm-yy' });
		
		$("#accordion > li").click(function(){
			if(false == $(this).next().is(':visible')) {
				$('#accordion > ul').slideUp(300);
			}
			$(this).next().slideToggle(300);
		});
		
		$( "#dialog:ui-dialog" ).dialog( "destroy" );

		$(".update-button").click(function() {			
			var id = $(this).attr("id"); $('#txtid_edit').val(id);
			
			$.ajax({
				type: 'post',
				url: '<?= base_url('subcont/uhpp/edit'); ?>',
				data: {
					id: id
				},
				dataType: "JSON",
				success: function(data) {
					var d = new Date(data.tanggal);
					var month = d.getMonth()+1;
					var day = d.getDate();
					var output = ((''+day).length<2 ? '0' : '') + day + '-' +
								((''+month).length<2 ? '0' : '') + month + '-' +
								d.getFullYear();
					$('#txttanggal_edit').val(output);
					$("#cbopn_edit").val(data.vpn_id);
					$('#txtqtyprocess_edit').val(data.qty_process);
					$('#txtqtyok_edit').val(data.qty_ok);
					$('#txtqtyng_edit').val(data.qty_ng);
					$('#txtpersenok_edit').val(data.persen_ok);
					$('#txtpersenng_edit').val(data.persen_ng);
					$('#txtdetailng_edit').val(data.detail_ng_defect);
				}
			});
			
			$("#form-update").dialog("open");
			return false;
		});

		$( "#form-update" ).dialog({
			autoOpen: false,
			modal: true,
			height: 550,
			width: 620,
			hide: 'Slide',
			buttons: {				
				"Yes": function() {	
					// http://stackoverflow.com/questions/1044105/string-length-and-jquery
					if ($('#txtdetailng_edit').val().length==0) {
						alert("Detail NG harus diisi !!!");
						return false;
					}
					var form_data = {
						id: $('#txtid_edit').val(),
						tanggal: $('#txttanggal_edit').val(),
						vpn_id: $('#cbopn_edit option:selected').val(),
						vpn_number: $('#cbopn_edit option:selected').attr('vpn_number'),
						vpn_name: $('#cbopn_edit option:selected').attr('vpn_name'),
						qty_process: $('#txtqtyprocess_edit').val(),
						qty_ok: $('#txtqtyok_edit').val(),
						qty_ng: $('#txtqtyng_edit').val(),
						persen_ok: $('#txtpersenok_edit').val(),
						persen_ng: $('#txtpersenng_edit').val(),
						detail_ng_defect: $('#txtdetailng_edit').val()
				  	};
					$.ajax({						
						type: 'POST',
						url: "<?= base_url('subcont/uhpp/update'); ?>",	
						data : form_data,
						success: function(msg) {
							$('#txtid_edit').val('');
							$('#txttanggal_edit').val('');
							$('#txtqtyprocess_edit').val('0');
							$('#txtqtyok_edit').val('0');
							$('#txtqtyng_edit').val('0');
							$('#txtpersenok_edit').val('0');
							$('#txtpersenng_edit').val('0')
							$('#txtdetailng_edit').val('');			
							$(location).attr('href',"<?= base_url('subcont/uhpp'); ?>");
						}
					});
				},
				Cancel: function() {
					$('#txtid_edit').val('');
					$('#txttanggal_edit').val('');
					$('#txtqtyprocess_edit').val('0');
					$('#txtqtyok_edit').val('0');
					$('#txtqtyng_edit').val('0');
					$('#txtpersenok_edit').val('0');
					$('#txtpersenng_edit').val('0')
					$('#txtdetailng_edit').val('');
					$(this).dialog( "close" );
				}
			},
			close: function() {
				$('#id').val('');
				$(this).dialog( "close" );
			}
		});
		
		$(".add-button").click(function() {
			$('#txtid_edit').val('');
			$('#txttanggal_add').val('');
			$('#txtqtyprocess_add').val('0');
			$('#txtqtyok_add').val('0');
			$('#txtqtyng_add').val('0');
			$('#txtpersenok_add').val('0');
			$('#txtpersenng_add').val('0');
			$('#txtdetailng_add').val('');
			$("#form-add").dialog("open");
			return false;
		});
		
		$( "#form-add" ).dialog({						
			autoOpen: false,
			modal: true,
			height: 550,
			width: 620,
			hide: 'Slide',
			buttons: {				
				"Yes": function() {	
					// http://stackoverflow.com/questions/1044105/string-length-and-jquery
					if ($('#txtdetailng_add').val().length==0) {
						alert("Detail NG harus diisi !!!");
						return false;
					}
					var form_data = {
						tanggal: $('#txttanggal_add').val(),
						vpn_id: $('#cbopn_add option:selected').val(),
						vpn_number: $('#cbopn_add option:selected').attr('vpn_number'),
						vpn_name: $('#cbopn_add option:selected').attr('vpn_name'),
						qty_process: $('#txtqtyprocess_add').val(),
						qty_ok: $('#txtqtyok_add').val(),
						qty_ng: $('#txtqtyng_add').val(),
						persen_ok: $('#txtpersenok_add').val(),
						persen_ng: $('#txtpersenng_add').val(),
						detail_ng_defect: $('#txtdetailng_add').val()
				  	};
					$.ajax({
						type: 'POST',
						url: "<?= base_url('subcont/uhpp/add'); ?>",	
						data : form_data,
						success: function(msg) {
							$('#txtid_edit').val('');
							$('#txttanggal_add').val('');
							$('#txtqtyprocess_add').val('0');
							$('#txtqtyok_add').val('0');
							$('#txtqtyng_add').val('0');
							$('#txtpersenok_add').val('0');
							$('#txtpersenng_add').val('0');
							$('#txtdetailng_add').val('');
							$(location).attr('href',"<?= base_url('subcont/uhpp'); ?>");
						}
					});
				},
				Cancel: function() {
					$('#txtid_edit').val('');
					$('#txttanggal_add').val('');
					$('#txtqtyprocess_add').val('0');
					$('#txtqtyok_add').val('0');
					$('#txtqtyng_add').val('0');
					$('#txtpersenok_add').val('0');
					$('#txtpersenng_add').val('0');
					$('#txtdetailng_add').val('');
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
		
		$( "#txtqtyprocess_add, #txtqtyok_add, #txtqtyng_add" ).change(function() {
			var qtyprocess_add = $('#txtqtyprocess_add').val();
			var qtyok_add = $('#txtqtyok_add').val();
			var qtyng_add = $('#txtqtyng_add').val();
			
			var persen_ok = 0;
			var persen_ng = 0;
			
			if (qtyok_add != 0) {
				persen_ok = ((parseFloat(qtyok_add) / parseFloat(qtyprocess_add)) * 100).toFixed(1);
			}
			
			if (qtyng_add != 0) {
				persen_ng = ((parseFloat(qtyng_add) / parseFloat(qtyprocess_add)) * 100).toFixed(1);
			}
			
			$('#txtpersenok_add').val(persen_ok);
			$('#txtpersenng_add').val(persen_ng);
		});

		$( "#txtqtyprocess_edit, #txtqtyok_edit, #txtqtyng_edit" ).change(function() {
			var qtyprocess_edit = $('#txtqtyprocess_edit').val();
			var qtyok_edit = $('#txtqtyok_edit').val();
			var qtyng_edit = $('#txtqtyng_edit').val();
			
			var persen_ok = 0;
			var persen_ng = 0;
			
			if (qtyok_edit != 0) {
				persen_ok = ((parseFloat(qtyok_edit) / parseFloat(qtyprocess_edit)) * 100).toFixed(1);
			}
			
			if (qtyng_edit != 0) {
				persen_ng = ((parseFloat(qtyng_edit) / parseFloat(qtyprocess_edit)) * 100).toFixed(1);
			}
			
			$('#txtpersenok_edit').val(persen_ok);
			$('#txtpersenng_edit').val(persen_ng);
		});	
	});
	
	/*$(window).load(function() { 
		$("#loading").fadeOut("slow"); 
	});*/
</script>