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

$type = (invoice_app_is_quote($post->ID)) ? 'quote' : 'invoice';
if (! empty($line_items = get_post_meta($post->ID, 'invoice_line_items', true) ) ) { ?>

<table class="widefat invoice-app-item" id="invoice_items">
	<thead>
	    <tr>
	        <th width="16"></th>
			<th><?php _e('Item', 'invoice-app'); ?></th>
			<th width="40" align="right"><?php _e('Qty', 'invoice-app'); ?></th>
			<th width="60"><?php _e('Rate', 'invoice-app'); ?></th>
			<th width="80"><?php _e('Amount', 'invoice-app'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$it = 0;
			foreach ($line_items as $line_item){
				echo '<tr id="clonedInput-' . $it . '" class="clonedInput invoice-line-item">';
				echo '<td><button type="button" class="remove"><span class="dashicons dashicons-minus"></span></button></td>';
				echo '<td><input type="text" name="line-item[' . $it . '][description]" id="line-item-description" class="large-text" value="' . $line_item['description'] . '"></td>';
				echo '<td><input type="text" name="line-item[' . $it . '][qty]" id="line-item-qty" class="large-text numeric line-item-qty" value="' . $line_item['qty'] . '" ></td>';
				echo '<td><input type="text" size="4" name="line-item[' . $it . '][rate]" id="line-item-rate" class="numeric line-item-rate" value="' . $line_item['rate'] . '" ></td>';
				echo '<td><input type="text" size="6" name="line-item[' . $it . '][total]" id="line-item-total" class="price line-item-total" value="' . $line_item['total'] . '"></span></td>';			
				echo '</tr>';
				$it++;
			}
		?>		
	</tbody>


    <?php 
		echo '<tbody>';
		echo '<tr>';
		echo '<td colspan="5"><a id="invoice_add_another" size="6" class="button-secondary clone">Add new item</a></td>';
		echo '</tr>';

		echo '<tr>';

			$subMeta = get_post_meta($post->ID, 'invoice_line_items_subtotal', true);		
			$sub = ( isset( $subMeta ) ) ? $subMeta : '0.00';

		echo '<td colspan="4" style="text-align:right;">' . __('Sub Total: ', 'invoice-app') . '</td><td><input type="text" size="6" class="disabled line-items-sub-total" name="invoice_line_items_subtotal" value="' . $sub . '" /></td>';
		echo '</tr>';
				
				
		echo '<tr>';
			$taxMeta = get_post_meta($post->ID, 'invoice_line_items_tax_total', true);
			$taxtotal = ( isset($taxMeta) ) ? $taxMeta : '0.00';
		
		echo '<td colspan="4" style="text-align:right;">' 
				. __('Tax Total: ', 'invoice-app') . '(<span class="invoice-tax-rate">' . $this->plugin_settings['tax_rate'] . '</span>%)
			 </td>
			 <td><input type="text" size="6" class="disabled line-items-tax-total" name="invoice_line_items_tax_total" value="' . $taxtotal . '" />
			 </td>';
		echo '</tr>';	
			
		echo '<tr>';

		    $totalMeta = get_post_meta($post->ID, 'invoice_line_items_total', true);
		    $total = ( isset( $totalMeta ) ) ? $totalMeta : '0.00';

	    echo '<td colspan="4" style="text-align:right;">' . __('Total: ', 'invoice-app') . '</td>
		      <td><input type="text" size="6" class="disabled line-items-total" name="invoice_line_items_total" value="' . $total . '" /></td>
		      </tr>';
		echo '<tr><td colspan="5" style="text-align:right;padding-top:20px;padding-bottom:20px;"><input type="submit" class="button-primary" value="Update ' . ucwords($type) . '"></td></tr>';
		echo '</tbody>';
	?>
</table>
<?php } else { ?>
<table class="widefat" id="invoice_items">
	<thead>
		<tr>
			<th width="16"></th>
			<th><?php _e('Item', 'invoice-app'); ?></th>
			<th width="40" align="right"><?php _e('Qty', 'invoice-app'); ?></th>
			<th width="60"><?php _e('Rate', 'invoice-app'); ?></th>
			<th width="80"><?php _e('Amount', 'invoice-app'); ?></th>
		</tr>
	</thead>
	<tbody>
		<tr id="clonedInput-0" class="clonedInput invoice-line-item">
	        <td><button type="button" class="remove"><span class="dashicons dashicons-minus"></span></button></td>
	        <td><input type="text" name="line-item[0][description]" id="line-item-description" class="large-text" value=""></td>
			<td><input type="text" name="line-item[0][qty]" id="line-item-qty" class="large-text numeric line-item-qty" value=""></td>
			<td><input type="text" size="4" name="line-item[0][rate]" id="line-item-rate" class="line-item-rate numeric" value=""></td>
			<td><input type="text" size="6" name="line-item[0][total]" id="line-item-total" class="price line-item-total" value=""></td>
		</tr>
	</tbody>
	<tbody>
		<td colspan="5" style="text-align:right;padding-top:20px;padding-bottom:20px;"><a id="invoice_add_another" size="6" class="button-secondary clone">Add new item</a></td>
		<tr>
			<td colspan="4" style="text-align:right;">Sub Total: </td>
			<td><input type="text" size="6" class="disabled line-items-sub-total" name="invoice_line_items_subtotal" value="0.00" ></td>
		</tr>
		<tr>
		    <td colspan="4" style="text-align:right;">
			    <?php _e('Tax Total: ', 'invoice-app'); ?>(<span class="invoice-tax-rate"> <?php echo $this->plugin_settings['tax_rate']; ?></span>%)
			</td>
			<td>
			    <input type="text" size="6" class="disabled line-items-tax-total" name="invoice_line_items_tax_total" value="" />
			</td>
		<tr>
			<td colspan="4" style="text-align:right;"><?php _e('Total: ', 'invoice-app'); ?></td>
		    <td><input type="text" size="6" class="disabled line-items-total" name="invoice_line_items_total" value="" /></td>
		</tr>
		<tr><td colspan="5" style="text-align:right;padding-top:20px;padding-bottom:20px;"><input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Publish"></td></tr>
	</tbody>
</table>
<?php } ?>