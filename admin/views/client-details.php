<?php

/**
 * Provide a client post type view for the plugin.
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
<table class="invoice-app-table form-table">
	<tbody>
		<tr class="">
			<th><label for="client-company">Company <span class="description">(required)</span></label></th>
			<td><input type="text" name="client-company" id="client-company" value="" class="regular-text ltr">
			</td>
		</tr>
		<tr class="">
			<th><label for="client-contact-name">Contact <span class="description">(required)</span></label></th>
			<td><input type="text" name="client-contact-name" id="client-contact-name" value="" class="regular-text ltr">
			</td>
		</tr>
		<tr class="">
			<th><label for="client-email">Email <span class="description">(required)</span></label></th>
			<td><input type="email" name="client-email" id="client-email" value="" class="regular-text ltr">
			</td>
		</tr>
		<tr class="">
			<th><label for="client-address">Address</label></th>
			<td><input type="text" name="client-address" id="client-address" value="" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-city">City</label></th>
			<td><input type="text" name="client-city" id="client-city" value="" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-state">State</label></th>
			<td>
				<select name="client-state">
					<option value="AL">AL</option>
					<option value="AK">AK</option>
					<option value="AZ">AZ</option>
					<option value="AR">AR</option>
					<option value="CA">CA</option>
					<option value="CO">CO</option>
					<option value="CT">CT</option>
					<option value="DE">DE</option>
					<option value="DC">DC</option>
					<option value="FL">FL</option>
					<option value="GA">GA</option>
					<option value="HI">HI</option>
					<option value="ID">ID</option>
					<option value="IL">IL</option>
					<option value="IN">IN</option>
					<option value="IA">IA</option>
					<option value="KS">KS</option>
					<option value="KY">KY</option>
					<option value="LA">LA</option>
					<option value="ME">ME</option>
					<option value="MD">MD</option>
					<option value="MA">MA</option>
					<option value="MI">MI</option>
					<option value="MN">MN</option>
					<option value="MS">MS</option>
					<option value="MO">MO</option>
					<option value="MT">MT</option>
					<option value="NE">NE</option>
					<option value="NV">NV</option>
					<option value="NH">NH</option>
					<option value="NJ">NJ</option>
					<option value="NM">NM</option>
					<option value="NY">NY</option>
					<option value="NC">NC</option>
					<option value="ND">ND</option>
					<option value="OH">OH</option>
					<option value="OK">OK</option>
					<option value="OR">OR</option>
					<option value="PA">PA</option>
					<option value="RI">RI</option>
					<option value="SC">SC</option>
					<option value="SD">SD</option>
					<option value="TN">TN</option>
					<option value="TX">TX</option>
					<option value="UT">UT</option>
					<option value="VT">VT</option>
					<option value="VA">VA</option>
					<option value="WA">WA</option>
					<option value="WV">WV</option>
					<option value="WI">WI</option>
					<option value="WY">WY</option>
				</select>
			</td>
		</tr>
		<tr class="">
			<th><label for="client-zip">Zip</label></th>
			<td><input type="text" name="client-zip" id="client-zip" value="" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-fax">Fax</label></th>
			<td><input type="" name="client-fax" id="client-fax" value="" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-phone">Phone</label></th>
			<td><input type="text" name="client-phone" id="client-phone" value="" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-cell">Cell</label></th>
			<td><input type="text" name="client-cell" id="client-cell" value="" class="regular-text"></td>
		</tr>
		<tr class="">
			<th><label for="client-website">Website</label></th>
			<td><input type="url" name="client-website" id="client-website" value="" class="regular-text"></td>
		</tr>
	</tbody>
</table>