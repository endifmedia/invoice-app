<?php

/**
 * Provide a edit view for client post type for the plugin.
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
<table class="invoice-app-table form-table">
	<tbody>
		<tr class="">
			<th><label for="client-company">Company <span class="description">(required)</span></label></th>
			<td><input type="text" name="client-company" id="client-company" value="<?php echo get_post_meta( $post->ID, 'client_company', true ); ?>" class="regular-text ltr">
			</td>
		</tr>
		<tr class="">
			<th><label for="client-contact-name">Contact <span class="description">(required)</span></label></th>
			<td><input type="text" name="client-contact-name" id="client-contact-name" value="<?php echo get_post_meta( $post->ID, 'client_contact_name', true ); ?>" class="regular-text ltr">
			</td>
		</tr>
		<tr class="">
			<th><label for="client-email">Email <span class="description">(required)</span></label></th>
			<td><input type="email" name="client-email" id="client-email" value="<?php echo get_post_meta( $post->ID, 'client_email', true ); ?>" class="regular-text ltr">
			</td>
		</tr>
		<tr class="">
			<th><label for="client-address">Address</label></th>
			<td><input type="text" name="client-address" id="client-address" value="<?php echo get_post_meta( $post->ID, 'client_address', true ); ?>" class="regular-text ltr"></td>
		</tr>
		<tr class="">
			<th><label for="client-city">City</label></th>
			<td><input type="text" name="client-city" id="client-city" value="<?php echo get_post_meta( $post->ID, 'client_city', true ); ?>" class="regular-text ltr"></td>
		</tr>
		<tr class="">
			<th><label for="client-state">State</label></th>
			<td>
				<select name="client-state">
					<option value="AL" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'AL');?>>AL</option>
					<option value="AK" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'AK');?>>AK</option>
					<option value="AZ" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'AZ');?>>AZ</option>
					<option value="AR" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'AR');?>>AR</option>
					<option value="CA" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'CA');?>>CA</option>
					<option value="CO" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'CO');?>>CO</option>
					<option value="CT" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'CT');?>>CT</option>
					<option value="DE" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'DE');?>>DE</option>
					<option value="DC" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'DC');?>>DC</option>
					<option value="FL" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'FL');?>>FL</option>
					<option value="GA" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'GA');?>>GA</option>
					<option value="HI" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'HI');?>>HI</option>
					<option value="ID" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'ID');?>>ID</option>
					<option value="IL" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'IL');?>>IL</option>
					<option value="IN" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'IN');?>>IN</option>
					<option value="IA" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'IA');?>>IA</option>
					<option value="KS" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'KS');?>>KS</option>
					<option value="KY" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'KY');?>>KY</option>
					<option value="LA" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'LA');?>>LA</option>
					<option value="ME" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'ME');?>>ME</option>
					<option value="MD" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'MD');?>>MD</option>
					<option value="MA" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'MA');?>>MA</option>
					<option value="MI" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'MI');?>>MI</option>
					<option value="MN" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'MN');?>>MN</option>
					<option value="MS" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'MS');?>>MS</option>
					<option value="MO" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'MO');?>>MO</option>
					<option value="MT" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'MT');?>>MT</option>
					<option value="NE" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'NE');?>>NE</option>
					<option value="NV" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'NV');?>>NV</option>
					<option value="NH" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'NH');?>>NH</option>
					<option value="NJ" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'NJ');?>>NJ</option>
					<option value="NM" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'NM');?>>NM</option>
					<option value="NY" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'NY');?>>NY</option>
					<option value="NC" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'NC');?>>NC</option>
					<option value="ND" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'ND');?>>ND</option>
					<option value="OH" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'OH');?>>OH</option>
					<option value="OK" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'OK');?>>OK</option>
					<option value="OR" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'OR');?>>OR</option>
					<option value="PA" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'PA');?>>PA</option>
					<option value="RI" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'RI');?>>RI</option>
					<option value="SC" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'SC');?>>SC</option>
					<option value="SD" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'SD');?>>SD</option>
					<option value="TN" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'TN');?>>TN</option>
					<option value="TX" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'TX');?>>TX</option>
					<option value="UT" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'UT');?>>UT</option>
					<option value="VT" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'VT');?>>VT</option>
					<option value="VA" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'VA');?>>VA</option>
					<option value="WA" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'WA');?>>WA</option>
					<option value="WV" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'WV');?>>WV</option>
					<option value="WI" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'WI');?>>WI</option>
					<option value="WY" <?php selected(get_post_meta( $post->ID, 'client_state', true ), 'WY');?>>WY</option>
				</select>
			</td>
		</tr>
		<tr class="">
			<th><label for="client-zip">Zip</label></th>
			<td><input type="text" name="client-zip" id="client-zip" value="<?php echo get_post_meta( $post->ID, 'client_zip', true ); ?>" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-fax">Fax</label></th>
			<td><input type="" name="client-fax" id="client-fax" value="<?php echo get_post_meta( $post->ID, 'client_fax', true ); ?>" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-phone">Phone</label></th>
			<td><input type="text" name="client-phone" id="client-phone" value="<?php echo get_post_meta( $post->ID, 'client_phone', true ); ?>" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-cell">Cell</label></th>
			<td><input type="text" name="client-cell" id="client-cell" value="<?php echo get_post_meta( $post->ID, 'client_cell', true ); ?>" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-website">Website</label></th>
			<td><input type="url" name="client-website" id="client-website" value="<?php echo get_post_meta( $post->ID, 'client_website', true ); ?>" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-hourly-rate"><?php _e('Hourly Rate', 'invoice-app'); ?></label></th>
			<td><input type="number" name="client-hourly-rate" id="client-hourly-rate" min="0" max="9999" step="0.01" size="4" value="<?php echo get_post_meta( $post->ID, 'client_hourly_rate', true ); ?>" class="small-text"></td>
		</tr>
	</tbody>
</table>