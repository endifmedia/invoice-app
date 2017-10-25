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

$invoice_app_settings = get_option('invoice_app_settings');

global $post;
?>

<div class="cmb2-wrap form-table"><div id="cmb2-metabox-_sliced_line_items" class="cmb2-metabox cmb-field-list"><div class="cmb-row cmb-repeat-group-wrap"><div class="cmb-td"><div id="_sliced_items_repeat" class="cmb-nested cmb-field-list cmb-repeatable-group sortable repeatable" style="width:100%;">
		<div class="postbox cmb-row cmb-repeatable-grouping" data-iterator="0"><button type="button" disabled="disabled" data-selector="_sliced_items_repeat" class="dashicons-before dashicons-no-alt cmb-remove-group-row"></button>
			<div class="cmbhandle" title="Click to toggle"><br></div>
			<h3 class="cmb-group-title cmbhandle-title"><span>Item 1</span></h3>

			<div class="inside cmb-td cmb-nested cmb-field-list"><div class="cmb-row cmb-type-text-small cmb2-id--sliced-items-0-qty cmb-repeat-group-field">
<div class="cmb-th">
<label for="_sliced_items_0_qty">Qty</label>
</div>
	<div class="cmb-td">
<input type="text" class="item_qty" name="_sliced_items[0][qty]" id="_sliced_items_0_qty" value="" placeholder="1" maxlength="8" required="required" step="any" min="0">
	</div>
</div><div class="cmb-row cmb-type-text cmb2-id--sliced-items-0-title cmb-repeat-group-field table-layout">
<div class="cmb-th">
<label for="_sliced_items_0_title">Item Title</label>
</div>
	<div class="cmb-td">
<input type="text" class="regular-text" name="_sliced_items[0][title]" id="_sliced_items_0_title" value="">
	</div>
</div><div class="cmb-row cmb-type-text-small cmb2-id--sliced-items-0-tax cmb-repeat-group-field">
<div class="cmb-th">
<label for="_sliced_items_0_tax">Adjust (%)</label>
</div>
	<div class="cmb-td">
<input type="text" class="item_tax" name="_sliced_items[0][tax]" id="_sliced_items_0_tax" value="" placeholder="0" maxlength="5" step="any">
	</div>
</div><div class="cmb-row cmb-type-text-money cmb2-id--sliced-items-0-amount cmb-repeat-group-field">
<div class="cmb-th">
<label for="_sliced_items_0_amount"><span class="pull-left">Rate ($)</span><span class="pull-right">Amount ($)</span></label>
</div>
	<div class="cmb-td">
  <input type="text" class="item_amount" name="_sliced_items[0][amount]" id="_sliced_items_0_amount" value="" placeholder="0.00" maxlength="10" required="required"><span class="line_total_wrap"><span class="line_total">$0.00</span></span>
	</div>
</div><div class="cmb-row cmb-type-textarea-small cmb2-id--sliced-items-0-description cmb-repeat-group-field">
<div class="cmb-th">
<label for="_sliced_items_0_description">Description</label>
</div>
	<div class="cmb-td">
<textarea class="cmb2-textarea-small" name="_sliced_items[0][description]" id="_sliced_items_0_description" cols="140" rows="4" placeholder="Brief description of the work carried out for this line item (optional)"></textarea>
	</div>
</div><select class="pre_defined_products" id="pre_defined_select"><option value="" data-qty="" data-price="" data-title="" data-desc="">Add a pre-defined line item</option><option value="Web Design" data-qty="1" data-price="85" data-title="Web Design" data-desc="Design work on the website">Web Design</option><option value="Web Development" data-qty="1" data-price="95" data-title="Web Development" data-desc="Back end development of website">Web Development</option></select>
					<div class="cmb-row cmb-remove-field-row">
						<div class="cmb-remove-row">
							<a class="button cmb-shift-rows move-up alignleft" href="#"><span class="dashicons dashicons-arrow-up-alt2"></span></a> <a class="button cmb-shift-rows move-down alignleft" href="#"><span class="dashicons dashicons-arrow-down-alt2"></span></a><button type="button" disabled="disabled" data-selector="_sliced_items_repeat" class="button cmb-remove-group-row alignright">Remove Item</button>
						</div>
					</div>
					
			</div>
		</div>
		<div class="cmb-row"><div class="cmb-td"><p class="cmb-add-row"><button type="button" data-selector="_sliced_items_repeat" data-grouptitle="Item {#}" class="cmb-add-group-row button">Add Another Item</button></p></div></div></div></div></div><div class="cmb-row cmb-type-title cmb2-id--sliced-calc-total">

	<div class="cmb-td">
<h5 class="cmb2-metabox-title"></h5><div class="alignright sliced_totals"><h3>Invoice Totals</h3><div class="sub">Sub Total <span class="alignright"><span id="sliced_sub_total">$0.00</span></span></div><div class="tax">Tax <span class="alignright"><span id="sliced_tax">$0.00</span></span></div><div class="total">Total <span class="alignright"><span id="sliced_total">$0.00</span></span></div>
			</div>
	</div>
</div></div></div>