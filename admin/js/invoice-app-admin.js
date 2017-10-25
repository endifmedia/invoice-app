(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 */
    $('.date-picker').datepicker();

    var last_css_id_array = $(".clonedInput").last().attr('id').slice('-');
    var row_key = last_css_id_array[last_css_id_array.length - 1];

    function clone(){

        row_key++;

        var header_row_template =
        '<tr id="clonedInput-' + row_key + '" class="clonedInput invoice-line-item">' +
	    '<td><button type="button" class="remove"><i class="fa fa-minus-circle"></i></button></td>' +		
	    '<td><input type="text" name="line-item[' + row_key + '][description]" id="line-item-description" class="large-text" value=""></td>' +
		'<td><input type="text" name="line-item[' + row_key + '][qty]" id="line-item-qty" class="large-text numeric line-item-qty" value=""></td>' +
		'<td><input type="text" size="4" name="line-item[' + row_key + '][rate]" id="line-item-rate" class="line-item-rate numeric" value=""></td>' +
		'<td><input type="text" size="6" name="line-item[' + row_key + '][total]" id="line-item-total" class="price line-item-total" value=""></td>' +
		'</tr>';

        $('.clonedInput').last().after(header_row_template);

    }

    function remove(){
        var cloneCount = $(".clonedInput").length;
        if(cloneCount > 1) {
            $(this).parents(".clonedInput").remove();
        }

		//update totals
		update_total();
    }

    $("body").delegate(".clone","click", clone);
    $("body").delegate("button.remove","click", remove);

	function roundNumber(number,decimals) {
		var newString;// The new rounded number
		decimals = Number(decimals);
		if (decimals < 1) {
			newString = (Math.round(number)).toString();
		} else {
			var numString = number.toString();
			if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
				numString += ".";// give it one at the end
			}
			var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
			var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
			var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
			if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
				if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
					while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
						if (d1 != ".") {
							cutoff -= 1;
							d1 = Number(numString.substring(cutoff,cutoff+1));
						} else {
							cutoff -= 1;
						}
					}
				}
				d1 += 1;
			}
			if (d1 == 10) {
				numString = numString.substring(0, numString.lastIndexOf("."));
				var roundedNum = Number(numString) + 1;
				newString = roundedNum.toString() + '.';
			} else {
				newString = numString.substring(0,cutoff) + d1.toString();
			}
		}
		if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
			newString += ".";
		}
		var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
		for(var i=0;i<decimals-decs;i++) newString += "0";
		//var newNumber = Number(newString);// make it a number if you like
		return newString; // Output the result to the form field (change for your purposes)
	}


	function calculate_tax() {
		//get tax rate (.12)
		var taxRate = parseFloat( $('.invoice-tax-rate').text() ) / 100;

		//tax total (sub total box * user set tax [converted to decimal])
		var taxTotal = parseFloat( $('.line-items-sub-total').val() ) * taxRate;

		//update tax total box
		$('.line-items-tax-total').val(taxTotal.toFixed(2));

		//update invoice total
 		var invoiceTotal = parseFloat( $('.line-items-sub-total').val() ) + parseFloat( $('.line-items-tax-total').val() );

 		$('.line-items-total').val(invoiceTotal.toFixed(2));

	}

	function update_total() {

		var sum = 0.00;
		$('.price').each(function() {
			if ( $(this).val() != ''){
			   sum += parseFloat($(this).val());
			}
		});

		$('.line-items-sub-total').val(sum.toFixed(2));

		calculate_tax();

	}

	function update_price() {
        //get main block from clicked item
		var row = $(this).parents('.clonedInput');
        var price = row.find('.line-item-qty').val() * row.find('.line-item-rate').val();

		//price = price, 2;
		row.find('input.price').val(price.toFixed(2));

		update_total();
	}

	$("body").delegate(".line-item-rate","blur", update_price);
	$("body").delegate(".line-item-qty","blur", update_price);


})( jQuery );