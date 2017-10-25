<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://endif.media/invoice-app
 * @since      1.0.0
 *
 * @package    Invoice_App
 * @subpackage Invoice_App/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Invoice_App
 * @subpackage Invoice_App/includes
 * @author     Ethan Allen <yourfriendethan@gmail.com>
 */
class Invoice_App_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

  		wp_clear_scheduled_hook( 'invoice_app_overdue_check' );

	}

}
