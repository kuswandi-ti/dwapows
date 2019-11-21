<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Stock - Export & Import Data Stock</b></li>
</ul>

<br />

<div id="tab-container">	
	<ul id="tab">
		<li><a href="<?= base_url('stock/stock_releases'); ?>">Live</a></li>
		<li><a href="<?= base_url('stock/stock_histories'); ?>">History</a></li>
		<li><a href="<?= base_url('stock/stock_exportimport'); ?>" class="active">Export & Import Data Stock</a></li>
	</ul>
</div>

<div id="content-container">
	<table class="list-table">
		<tr>
			<td><u><a href='<?php echo site_url('stock/stock_exportimport/exportdata')?>'><font color="black"><h3>1. Export Data Stock</h3></font></a></u></td>
		</tr>
		
		<tr>
			<td>
				<form action="<?php echo base_url();?>stock/stock_exportimport/importdata/" 
					  enctype="multipart/form-data" 
					  method="post">
					<h3>2. Import Data Stock</h3>
					Pilih File Excel (.xls)
					<input type="file" 
						   class="form-control" 
						   id="file" 
						   name="file" 
						   required="" 
						   placeholder="Pilih File" 
						   accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
					<br /><br />
					<button type="submit" id="importbtn">Import Data Stock</button>
					<button type="reset" id="resetbtn">Reset</button>
				</form>
				<font color="yellow"><h2><?php echo $this->session->flashdata('msg'); ?></h2></font>
			</td>
		</tr>
	</table>
</div>

<script type="text/javascript" src="assets/plugins/jquery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="assets/plugins/zebra-datepicker-master/public/javascript/zebra_datepicker.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="assets/plugins/jquery-blink/jquery-blink.js"></script>

<script>	
	/*$(window).load(function() { 
		$("#loading").fadeOut("slow"); 
	});*/
	
	/*$(document).ready(function() {	
		$("#formimport").on('submit',function(e) {
			e.preventDefault();    
            $.ajax({
                type:'post',
                dataType:'json',
                url:'<?= base_url('stock/stock_exportimport/importdata'); ?>',
                data:  new FormData(this),
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                beforeSend:function() {
                    $("#responimport").html('<img src="<?=base_url();?>assets/images/ajax-loader.gif"/><span>  harap tunggu...</span>');
                },
                success:function(x) {
                    $("#responimport").html(x);
                    $("#resetbtn").trigger('click');
                    return false;
                },
            });
        });
        
        $("#formexport").on('submit',function(e) {
            e.preventDefault(); 
            $.ajax({
                type:'post',
                dataType:'json',
                url:'<?= base_url('stock/stock_exportimport/exportdata'); ?>',
                data:$(this).serialize(),
                beforeSend:function(){
                    $("#responexport").html('<img src="<?=base_url();?>assets/images/ajax-loader.gif"/><span>  harap tunggu...</span>');
                },
                success:function(x) {
                    $("#responexport").html(x);
                    return false;
                },
            });
        });		
	});*/
</script>