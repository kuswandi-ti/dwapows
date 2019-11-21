		<!--<table class="list-table">
			<tr>
				<td><u>TT No.</u></td><td>&nbsp;&nbsp;&nbsp;</td>
				<td><u>Invoice No.</u></td><td>&nbsp;&nbsp;&nbsp;</td>
			<tr>
			<tr>
				<td><b><?= $tt_no; ?></b></td><td>&nbsp;&nbsp;&nbsp;</td>
				<td><b><?= $inv_no; ?></b></td><td>&nbsp;&nbsp;&nbsp;</td>
			<tr>
		</table>
		
		<br />-->
		
		<?php
			/* Verification */
			if ($invoice_status==10)  {
		?>
				<br />
				
				<table border="0" class="list-table custom-table">
					<tr class="table-row-header">
						<td class="not-head">No.</td>
						<td class="not-head">No. RI</td>
						<td class="not-head">Tgl. RI</td>
						<td class="not-head">No. Invoice</td>
						<td class="not-head">Note</td>
					</tr>
					<?php	
						$no = 1;
						foreach ($data->result_array() as $row) {
					?>
							<tr>
								<td align="center"><?= $no; ?></td>
								<td align="center"><?= $row['verification_no_ri']; ?></td>
								<td align="center"><?= convert_date($row['verification_date_ri'],'format_date'); ?></td>
								<td align="center"><?= $row['verification_no_inv']; ?></td>
								<td align="left"><?= $row['verification_remark']; ?></td>
							</tr>
					<?php
							$no++;
						}
					?>
				</table>
		<?php 
			/* Process for Payment */
			} else if ($invoice_status==11) { 
		?>
				<table class="list-table">
					<tr>
						<td><u>TT No.</u></td><td>&nbsp;&nbsp;&nbsp;</td>
						<td><u>Invoice No.</u></td><td>&nbsp;&nbsp;&nbsp;</td>
					<tr>
					<tr>
						<td><b><?= $tt_no; ?></b></td><td>&nbsp;&nbsp;&nbsp;</td>
						<td><b><?= $inv_no; ?></b></td><td>&nbsp;&nbsp;&nbsp;</td>
					<tr>
				</table>
				
				<br />
				
				<table border="0" class="list-table custom-table">
					<tr class="table-row-header">
						<td class="not-head">No.</td>
						<td class="not-head">DI No.</td>
						<td class="not-head">DI Rev.</td>
						<td class="not-head">DI Date</td>
						<td class="not-head">Period Month</td>
						<td class="not-head">Period Year</td>
						<td class="not-head">Note</td>
					</tr>
					<?php	
						$no = 1;
						foreach ($data->result_array() as $row) {
					?>
							<tr>
								<td align="center"><?= $no; ?></td>
								<td align="center"><?= $row['di_no']; ?></td>
								<td align="center"><?= $row['di_rev']; ?></td>
								<td align="center"><?= convert_date($row['di_date'],'format_date'); ?></td>
								<td align="center"><?= month_3_char($row['di_period_month']); ?></td>
								<td align="center"><?= $row['di_period_year']; ?></td>
								<td align="center"><?= $row['di_note']; ?></td>
							</tr>
					<?php
							$no++;
						}
					?>
				</table>
		<?php
			/* Partial / Full Payment */
			} else if ($invoice_status==12 or $invoice_status==13) {
		?>
				<br />
				
				<table border="0" class="list-table custom-table">
					<tr class="table-row-header">
						<td class="not-head">No.</td>
						<td class="not-head">No. BK</td>
						<td class="not-head">Tgl. BK</td>
						<td class="not-head">No. Invoice</td>
						<td class="not-head">Amount Invoice</td>
						<td class="not-head">Amount Payment</td>
						<td class="not-head">Note</td>
					</tr>
					<?php	
						$no = 1;
						foreach ($data->result_array() as $row) {
					?>
							<tr>
								<td align="center"><?= $no; ?></td>
								<td align="center"><?= $row['payment_nobk']; ?></td>
								<td align="center"><?= convert_date($row['payment_tglbk'],'format_date'); ?></td>
								<td align="center"><?= $row['invoice_no']; ?></td>
								<td align="center"><?= number_format($row['payment_amount'],2); ?></td>
								<td align="center"><?= number_format($row['payment_pay'],2); ?></td>
								<td align="center"><?= $row['di_note']; ?></td>
							</tr>
					<?php
							$no++;
						}
					?>
				</table>
		<?php
			}
		?>