<link rel="stylesheet" type="text/css" href="assets/plugins/zebra-datepicker-master/public/css/metallic.css" />
<link rel="stylesheet" type="text/css" href="assets/plugins/jquery-ui-1.10.4.custom/css/smoothness/jquery-ui-1.10.4.custom.min.css" />

<div id="loading"></div>

<br />

<ul id="crumbs">
	<li><a href="<?= base_url('menu'); ?>">Menu</a></li>
	<li><b>Goods Receive Delivery - Outstanding</b></li>
</ul>

<br />

<div id="tab-container">
	<ul id="tab">
		<li><a href="<?= base_url('receive/receive_releases'); ?>" class="active">Outstanding</a></li>
		<li><a href="<?= base_url('receive/receive_histories'); ?>">Close</a></li>
	</ul>
</div>

<div id="content-container">
	<div align="right">
		<!--<a href="http://docs.google.com/gview?url=<?= $this->config->item('url_gr').$this->session->userdata('user_id'); ?>.pdf" 
		   class="css-button" 
		   frameborder="0" 						
		   target="_blank">Preview & Print Outstanding Detail
		</a>-->
		<!--<a href="http://docs.google.com/gview?url=<?= $this->config->item('url_gr').$file_name; ?>" 
		   class="css-button" 
		   frameborder="0" 						
		   target="_blank">Preview & Print Outstanding Detail
		</a>-->
		<a href="<?= base_url('receive/receive_releases/preview_outstanding'); ?>"
			class="css-button" target="_blank">Preview & Print Outstanding Detail
		</a>
	</div>
	
	<ul id="accordion">
		<li>Filter Record</li>
		<ul>
			<li>
				<?= form_open('receive/receive_releases/search'); ?>
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
								<a href="<?= base_url('receive/receive_releases'); ?>" class="css-button">Refresh & View All</a>
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
				<td class="not-head" rowspan="2">Status</td>
				<td class="not-head" rowspan="2">Aging (Day)</td>
			</tr>
			<tr class="table-row-header">
				<td class="not-head">No.</td>
				<td class="not-head">Rev.</td>
				<td class="not-head">Date</td>				
				<td class="not-head">Note</td>
				<td class="not-head">Delivery Date</td>
			</tr>
			<?php	
				$no = $total+1;
				foreach ($data->result_array() as $row) { 					
			?>
			<tr class="record">
				<td align='center'><?= $no; ?></td>
				<td align='center'><?= $row['di_no']; ?></td>
				<td align='center'><?= $row['di_rev']; ?></td>
				<td align='center'><?= convert_date($row['di_date'],'format_date'); ?></td>
				<td align='left'><?= $row['di_note']; ?></td>
				<td align='center'><?= convert_date($row['di_delivery_datetime'],'format_datetime'); ?></td>
				<?php
					if ($row['di_status']==$this->config->item('status_full_outstanding')) {
						$di_status = $this->config->item('status_full_outstanding_info');
					} else if ($row['di_status']==$this->config->item('status_partial_outstanding')) {
						$di_status = $this->config->item('status_partial_outstanding_info');
					} else if ($row['di_status']==$this->config->item('status_full_receive')) {
						$di_status = $this->config->item('status_full_receive_info');
					} else if ($row['di_status']==$this->config->item('status_outstanding')) {
						$di_status = $this->config->item('status_outstanding_info');
					}
				?>
				<td align='center'><?= $di_status; ?></td>				
				<?php
					// http://www.phpbook.net/how-to-calculate-the-difference-between-two-dates-in-php.html
					$difference_unixtime = abs(strtotime($row['di_delivery_datetime']) - strtotime(date("Y-m-d")));
					if (strtotime($row['di_delivery_datetime'])<=strtotime(date("Y-m-d"))) {
						$difference_year = floor($difference_unixtime/(60*60*24*365));
						$difference_month = floor($difference_unixtime/(60*60*24*30));
						$difference_day = floor($difference_unixtime/(60*60*24))+1;
					} else {
						$difference_day=0;
					}					
				?>
				<td align='center'><?= $difference_day; ?></td>
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