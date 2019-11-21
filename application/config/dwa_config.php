<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* ============================================================================== */
/* Table & View Name */
/* ============================================================================== */
/* User Login */
$config['table_name_userlogin']					= 'tbl_sys_user';
$config['view_name_user_menu_access']			= 'v_sys_menu_access';
/* End User Login */

/* Forecast Order */
$config['table_name_fo_trx']					= 'tbl_forecastorder_trx';
$config['table_name_fo_hst']					= 'tbl_forecastorder_hst';
$config['view_name_fo_trx']						= 'v_forecastorder_trx';
$config['view_name_fo_hst']						= 'v_forecastorder_hst';
/* End Forecast Order */

/* Plan Order */
$config['table_name_plo_trx']					= 'tbl_planorder_trx';
$config['table_name_plo_hst']					= 'tbl_planorder_hst';
$config['view_name_plo_trx']					= 'v_planorder_trx';
$config['view_name_plo_hst']					= 'v_planorder_hst';
/* End Plan Order */

/* Delivery Instruction */
$config['table_name_di_trx']					= 'tbl_deliveryinstruction_trx';
$config['table_name_di_hst']					= 'tbl_deliveryinstruction_hst';
$config['view_name_di_trx']						= 'v_deliveryinstruction_trx';
$config['view_name_di_hst']						= 'v_deliveryinstruction_hst';
/* End Delivery Instruction */

/* Receiving */
$config['table_name_rcv_trx']					= 'tbl_receiving_trx';
$config['table_name_rcv_hst']					= 'tbl_receiving_hst';
$config['view_name_rcv_trx']					= 'v_receiving_trx';
$config['view_name_rcv_hst']					= 'v_receiving_hst';
/* End Receiving */

/* Invoice Receive */
$config['table_name_ir_trx']					= 'tbl_invoice_trx';
$config['table_name_ir_hst']					= 'tbl_invoice_hst';
$config['view_name_ir_trx']						= 'v_invoice_trx';
$config['view_name_ir_hst']						= 'v_invoice_hst';
$config['view_name_ir_trx_hdr']					= 'v_invoice_trx_hdr';
$config['view_name_ir_trx_dtl']					= 'v_invoice_trx_dtl';
$config['view_name_ir_hst_hdr']					= 'v_invoice_hst_hdr';
$config['view_name_ir_hst_dtl']					= 'v_invoice_hst_dtl';
/* End Invoice Receive */

/* Outstanding GR */
$config['table_name_outstanding_gr']			= 'tbl_outstanding';
/* End Outstanding GR */

/* Stock */
$config['table_name_stock_trx']					= 'tbl_stock_trx';
$config['table_name_stock_hst']					= 'tbl_stock_hst';
$config['view_name_stock_trx']					= 'v_stock_trx';
$config['view_name_stock_hst']					= 'v_stock_hst';
/* End Stock */

/* Verifikasi */
$config['table_name_verifikasi_trx']			= 'tbl_verifikasi_trx';
$config['table_name_verifikasi_hst']			= 'tbl_verifikasi_hst';
$config['view_name_verifikasi_trx']				= 'v_verifikasi_trx';
$config['view_name_verifikasi_hst']				= 'v_verifikasi_hst';
/* End Verifikasi */

/* Monitoring DO Retur */
$config['table_name_doretur_trx']			    = 'tbl_doretur_trx';
$config['view_name_doretur_trx_open']			= 'v_doretur_trx_open';
$config['view_name_doretur_trx_close']			= 'v_doretur_trx_close';
/* End Monitoring DO Retur*/

/* Environment Setting */
$config['status_released']						= 0;
$config['status_received']						= 1;
$config['status_revisi']						= 2;
$config['status_rejected']						= 3;
$config['status_full_outstanding']				= 41;
$config['status_partial_outstanding']			= 42;
$config['status_full_receive']					= 5;
$config['status_outstanding']					= 6;
$config['status_unpaid']						= 7;
$config['status_paid']							= 8;
$config['status_canceled']						= 9;
$config['status_receive_verification']			= 10;
$config['status_process_for_payment']			= 11;
$config['status_partial_payment']				= 12;
$config['status_full_payment']					= 13;

$config['status_released_info']					= 'RELEASED BY DWA';
$config['status_received_info']					= 'RECEIVED BY ';
$config['status_revisi_info']					= 'REVISI BY DWA';
$config['status_rejected_info']					= 'REJECTED BY ';
$config['status_full_outstanding_info']			= 'FULL OUTSTANDING';
$config['status_partial_outstanding_info']		= 'PARTIAL OUTSTANDING';
$config['status_full_receive_info']				= 'FULL RECEIVED';
$config['status_outstanding_info']				= 'OUTSTANDING';
$config['status_unpaid_info']					= 'UNPAID';
$config['status_paid_info']						= 'PAID';
$config['status_canceled_info']					= 'CANCELED BY DWA';
$config['status_receive_verification_info']		= 'VERIFICATION';
$config['status_process_for_payment_info']		= 'PROCESS FOR PAYMENT';
$config['status_partial_payment_info']			= 'PARTIAL PAYMENT';
$config['status_full_payment_info']				= 'FULL PAYMENT';

$config['uri_segment']							= 4;
$config['limit']								= 12;
$config['url_upload']							= 'http://pows.dwa.co.id/viewerjs/#../upload/';
//$config['url_upload']							= 'http://pows.dwa.co.id/upload/';
//$config['url_gr']								= 'http://pows.dwa.co.id/outstanding/';
$config['url_gr']								= 'http://pows.dwa.co.id/viewerjs/#../outstanding/';
/* End Environment Setting */

/* ============================================================================== */
/* End Table & View Name */
/* ============================================================================== */