<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://endif.media/invoice-app
 * @since      1.0.0
 *
 * @package    Invoice_App
 * @subpackage Invoice_App/admin/partials
 */
?>
<table class="form-table">
	<tbody>
		<tr class="">
			<th><label for="quote-client"><?php _e('Client', 'invoice-app'); ?></th>
			<td>
                <select name="quote-client">
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
			<th><label for="qoute-project-title"><?php _e('Project Title', 'invoice-app'); ?><span class="description">(project, etc.)</span></label></th>
			<td><input type="text" name="quote-project-title" id="quote-project-title" value="" class="regular-text">
			</td>
		</tr>
		<tr class="">
			<th><label for="quote-description"><?php _e('Brief Description', 'invoice-app'); ?></label></th>
			<td><textarea name="quote-description" id="quote-description" value="" class="" rows="4" cols="46" class="large-text code"></textarea>
			</td>
		</tr>
		<tr class="">
			<th><label for="quote-issue-date"><?php _e('Quote Issued', 'invoice-app'); ?></label></th>
			<td><input name="quote-issue-date" id="quote-issue-date" value="" class="date-picker">
			</td>
		</tr>
		<tr class="">
			<th><label for=""><?php _e('Quote Good Until', 'invoice-app'); ?></label></th>
			<td><strong><?php echo esc_attr($this->plugin_settings['quote_life']); ?> days</strong><br>
			<small><em><?php _e('determined in Settings > Quotes > Quote Life', 'invoice-app'); ?></em></small>
			</td>
		</tr>
	</tbody>
</table>
