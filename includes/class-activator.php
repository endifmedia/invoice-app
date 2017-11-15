<?php

/**
 * Fired during plugin activation
 *
 * @link       http://endif.media/invoice-app
 * @since      1.0.0
 *
 * @package    Invoice_App
 * @subpackage Invoice_App/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Invoice_App
 * @subpackage Invoice_App/includes
 * @author     Ethan Allen <yourfriendethan@gmail.com>
 */
class Invoice_App_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		if( !wp_next_scheduled( 'invoice_app_overdue_check' ) ){

			wp_schedule_event( time(), 'daily', 'invoice_app_overdue_check' );
		
		}
		if (!get_option('invoice_app_settings')){
			$default_options = array(
				'business_name' => '',
				'business_address' => '',
				'business_phone' => '',
				'business_website' => '',
 				'quote_life' => '30',
				'invoice_offset' => '',
				'invoice_notes' => __('due upon reciept'),
				'invoice_terms' => __('30 days'),
				'tax_rate' => '0',
				'currency_code' => 'USD',
				'individual_client_rate' => ''
			);
			update_option( 'invoice_app_settings', $default_options );
		}

	}

}
