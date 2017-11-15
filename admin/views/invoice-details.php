<?php

/**
 * Provide a view for invoice post type for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://endif.media/invoice-app
 * @since      1.0.0
 *
 * @package    Invoice_App
 * @subpackage Invoice_App/admin/partials
 */

global $post;

$invoice_app_settings = get_option('invoice_app_settings');

?>
<table class="form-table">
	<tbody>
		<tr class="">
			<th><label for="invoice-client">Client</th>
			<td>
			    <select name="invoice-client">
				    <option>--</option>
			    	<?php 
						$clients = invoice_app_get_clients();
						foreach($clients as $client){
							echo '<option value="' . $client->meta_value . '">' .  $client->meta_value . '</option>';
						}

					?>
				</select>
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-project-title">Project Title <span class="description">(project, etc.)</span></label></th>
			<td><input type="text" name="invoice-project-title" id="invoice-project-title" value="" class="regular-text">
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-description">Brief Invoice Description</label></th>
			<td><textarea name="invoice-description" id="invoice-description" value="" rows="4" cols="46" class="large-text"></textarea>
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-issue-date">Invoice Issued</label></th>
			<td><input type="text" name="invoice-issue-date" id="invoice-date" value="" class="date-picker">
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-due-date">Invoice Due</label></th>
			<td><input type="text" name="invoice-due-date" id="invoice-due-date" value="" class="date-picker">
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-status">Invoice Status</label></th>
			<td>
				<select name="invoice-status">
					<option></option>
					<option value="paid">Paid</option>
					<option value="sent">Sent</option>
					<option value="overdue">Overdue</option>
				</select>
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-notes">Notes</label></th>
			<td><textarea name="invoice-notes" id="invoice-notes" rows="4" cols="46" class="large-text"><?php echo esc_attr( $invoice_app_settings['invoice_notes'] ); ?></textarea>
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-terms">Terms</label></th>
			<td><textarea name="invoice-terms" id="invoice-terms" rows="4" cols="46" class="large-text"><?php echo esc_attr( $invoice_app_settings['invoice_terms'] ); ?></textarea>
			</td>
		</tr>
	</tbody>
</table>

<?php if (!empty($this->plugin_settings['individual_client_rate']) && $this->plugin_settings['individual_client_rate'] === 1)  { ?>
<script type="text/javascript">

	function get_client_rate() {
		var client = jQuery('select[name=invoice-client]').val();
		//ajax call
		jQuery.ajax({
			url: ajaxurl,
			type: "POST",
			data: "action=after_change_client_on_invoice&client=" + client,
			success: successFunction
		});
		function successFunction(result) {
			if (result != 0){
				jQuery('.line-item-rate').last().val(parseFloat(result));
			}
		}
	}

	jQuery("body").delegate("select[name=invoice-client]","blur", get_client_rate);

</script>
<?php } ?>