<?php

/**
 * Provide a view for dashboard widget.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://endif.media/invoice-app
 * @since      1.0.0
 *
 * @package    Invoice_App
 * @subpackage Invoice_App/admin/views
 */
?>
<div class="" style="width:50%">
	<h4>Last Thirty Days</h4>
	<hr>
	<ul style="font-size: 14px;">
	    <li>Paid: <span style="float: right;">$<?php paid_invoices() ?></span></li>
	    <li>Active: <span style="float: right;">$<?php live_invoices(); ?></span></li>
	    <li>Overdue: <span style="float: right;">$<?php overdue_invoices(); ?></span></li>
	</ul>
</div>