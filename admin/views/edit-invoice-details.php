<?php

/**
 * Provide Edit invoice view for plugin.
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

?>
<table class="form-table">
	<tbody>
		<tr class="">
			<th><label for="invoice-client">Client</th>
			<td>
			    <select name="invoice-client">
			    	<?php 
						$clients = invoice_app_get_clients();
						foreach($clients as $client){
							echo '<option value="' . $client->meta_value . '"' . selected($client->meta_value, get_post_meta( $post->ID, 'invoice_client', true)) . '>' .  $client->meta_value . '</option>';
						}
					?>
				</select>
				<span class="invoiceapp-invoice-number">Invoice # <?php echo get_post_meta( $post->ID, 'invoice_number', true); ?></span>
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-project-title">Project Title <span class="description">(project, etc.)</span></label></th>
			<td><input type="text" name="invoice-project-title" id="invoice-project-title" value="<?php echo get_post_meta( $post->ID, 'invoice_project_title', true ); ?>" class="regular-text">
			<?php add_thickbox(); ?>
			<a href="<?php echo admin_url('admin-ajax.php'); ?>?action=get_preview&invoiceid=<?php echo intval($post->ID); ?>&TB_iframe=true&width=700&height=550" class="thickbox button button-primary button-large" title="Invoice Preview">Preview Invoice</a>
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-description">Brief Invoice Description</label></th>
			<td><textarea name="invoice-description" id="invoice-description" value="" rows="4" cols="46" class="large-text"><?php echo get_post_meta( $post->ID, 'invoice_description', true ); ?></textarea>
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-issue-date">Invoice Issued</label></th>
			<td><input type="text" name="invoice-issue-date" id="invoice-date" value="<?php echo get_post_meta( $post->ID, 'invoice_issue_date', true ); ?>" class="date-picker">
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-due-date">Invoice Due</label></th>
			<td><input type="text" name="invoice-due-date" id="invoice-due-date" value="<?php echo get_post_meta( $post->ID, 'invoice_due_date', true ); ?>" class="date-picker">
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-status">Invoice Status</label></th>
			<td>
				<select name="invoice-status">
					<?php $status = get_post_meta( $post->ID, 'invoice_status', true );?>
					<option>--</option>
					<option value="paid" <?php selected( $status, 'paid'); ?>>Paid</option>
					<option value="sent" <?php selected( $status, 'sent'); ?>>Sent</option>
					<option value="overdue" <?php selected( $status, 'overdue'); ?>>Overdue</option>
					<option value="unpaid" <?php selected( $status, 'unpaid'); ?>>Unpaid (loss)</option>
				</select>
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-notes">Notes</label></th>
			<td><textarea name="invoice-notes" id="invoice-notes" rows="4" cols="46" class="large-text"><?php echo get_post_meta( $post->ID, 'invoice_notes', true ); ?></textarea>
			</td>
		</tr>
		<tr class="">
			<th><label for="invoice-terms">Terms</label></th>
			<td><textarea name="invoice-terms" id="invoice-terms" rows="4" cols="46" class="large-text"><?php echo get_post_meta( $post->ID, 'invoice_terms', true ); ?></textarea>
			</td>
		</tr>
	</tbody>
</table>
<?php 
/**
* add other items to this list
*/
do_action('other_items'); ?>