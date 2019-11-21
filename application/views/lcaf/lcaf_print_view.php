<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<html>

<head>
	<title>PT. Dasa Windu Agung (DWA)</title>
	
	<base href="<?php echo base_url(); ?>" />
	
	<link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon">
	
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
	<div class="box-body mdl-cell--12-col">
	 
		<h3 class="mdl-cell mdl-cell--12-col"><center>Data Loading Capacity Assurance</center></h3>
		<p><b><center>Vendor Code : <?php echo $data_vendor; ?></center></b></p>
		&nbsp;&nbsp;<a href="<?php echo base_url('lcaf/lcaf_monitoring'); ?>">Back To Menu</a>
	   
		<div class="mdl-cell--12-col panel panel-default ">
			<div class="panel-body">
				<?php
					if (count($data_lcaf) == 0) {
						echo "<center><h3>Tidak Ada Data ... !!!</h3></center>";
					} else {
				?>
					<table width="85%"  class="table table-condensed" >
						<thead> 
							<tr>  
								<th rowspan="2">No.</th>
								<th rowspan="2">Vendor</th>
								<th colspan="2">Period</th>
								<th rowspan="2">Forecast No</th>
								<th rowspan="2">Part Number</th>
								<th rowspan="2">Part Name</th>
								<th rowspan="2">Unit</th>
								<th colspan="4">Qty Order</th>
								<th colspan="4">Qty Capacity</th>
							</tr>   
							<tr>
								<th>Month</th>
								<th>Year</th>
								<th>N</th>
								<th>N+1</th>
								<th>N+2</th>
								<th>N+3</th>
								<th>N</th>
								<th>N+1</th>
								<th>N+2</th>
								<th>N+3</th>
							</tr>
						</thead>
						<tbody> 					
							<?php
								$i = 0;
								if (count($data_lcaf) > 0) {
									foreach ($data_lcaf as $row) {
										$i++;
							?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $row->vendor_code; ?></td>
										<td><?php echo $row->fo_period_month; ?></td>
										<td><?php echo $row->fo_period_year; ?></td>
										<td><?php echo $row->fo_no; ?></td>
										<td><?php echo $row->pn_number; ?></td>
										<td><?php echo $row->pn_name; ?></td>
										<td><?php echo $row->unit; ?></td>									
										<td><?php echo number_format($row->qty_order_n); ?></td>
										<td><?php echo number_format($row->qty_order_n1); ?></td>
										<td><?php echo number_format($row->qty_order_n2); ?></td>
										<td><?php echo number_format($row->qty_order_n3); ?></td>
										<td><?php echo number_format($row->qty_capacity_n); ?></td>
										<td><?php echo number_format($row->qty_capacity_n1); ?></td>
										<td><?php echo number_format($row->qty_capacity_n2); ?></td>
										<td><?php echo number_format($row->qty_capacity_n3); ?></td>
									</tr> 
								<?php } 
							} ?> 
						</tbody>
					</table>
				<?php } ?>
			</div>
		</div>
	</div>  
	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
	
</body>
</html>