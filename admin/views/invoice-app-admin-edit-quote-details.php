<?php
/**
 * Provide a view for quote post type for the plugin.
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
$quoteDate = get_post_meta( $post->ID, 'quote_issue_date', true );
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
							echo '<option value="' . esc_attr($client->meta_value) . '"' . selected($client->meta_value, get_post_meta( $post->ID, 'quote_client', true)) . '>' .  $client->meta_value . '</option>';
						}
					?>
	            </select> 
			</td>
		</tr>
		<tr class="">
			<th><label for="quote-project-title"><?php _e('Project Title', 'invoice-app'); ?><span class="description">(project, etc.)</span></label></th>
			<td><input type="text" name="quote-project-title" id="quote-project-title" value="<?php echo get_post_meta( $post->ID, 'quote_project_title', true ); ?>" class="regular-text">
            <?php add_thickbox(); ?>
            <a href="<?php echo admin_url('admin-ajax.php'); ?>?action=get_preview&invoiceid=<?php echo intval($post->ID); ?>&TB_iframe=true&width=700&height=550" class="thickbox button button-primary button-large" title="Quote Preview"><?php _e('Preview Quote', 'invoice-app'); ?></a>
            </td>
		</tr>
		<tr class="">
			<th><label for="quote-description"><?php _e('Brief Description', 'invoice-app'); ?></label></th>
			<td><textarea name="quote-description" id="quote-description" class="large-text" rows="4" cols="46" class="large-text code"><?php echo get_post_meta( $post->ID, 'quote_description', true ); ?></textarea>
			</td>
		</tr>
		<tr class="">
			<th><label for="quote-issue-date"><?php _e('Quote Issued', 'invoice-app'); ?></label></th>
			<td><input name="quote-issue-date" id="quote-issue-date" value="<?php echo esc_attr($quoteDate); ?>" class="date-picker">
			</td>
		</tr>
		<tr class="">
			<th><label for=""><?php _e('Quote Good Until', 'invoice-app'); ?></label></th>
			<td><strong><?php echo $this->plugin_settings['quote_life']; ?> <?php _e('days', 'invoice-app'); ?></strong> <?php if ($futureDate = invoice_app_quote_expires_on($post->ID))  echo '(' . $futureDate . ')'; ?><br>
			<small><em><?php _e('determined in Settings > Quotes > Quote Life', 'invoice-app'); ?></em></small>
			</td>
		</tr>
	</tbody>
</table>