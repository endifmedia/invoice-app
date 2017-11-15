<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://endif.media/invoice-app
 * @since             1.0.0
 * @package           Invoice_App
 *
 * @wordpress-plugin
 * Plugin Name:       Invoice App
 * Plugin URI:        http://endif.media
 * Description:       A WordPress invoicing plugin for creating invoices and quotes.
 * Version:           1.0.5
 * Author:            Ethan Allen
 * Author URI:        http://endif.media/invoice-app
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       invoice-app
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'INVOICEAPP_PLUGIN_VERSION', '1.0.5' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-invoice-app-activator.php
 */
function activate_invoice_app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
	Invoice_App_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-invoice-app-deactivator.php
 */
function deactivate_invoice_app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivator.php';
	Invoice_App_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_invoice_app' );
register_deactivation_hook( __FILE__, 'deactivate_invoice_app' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-invoice-app.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_invoice_app() {

	$plugin = new Invoice_App();
	$plugin->run();

}
run_invoice_app();
