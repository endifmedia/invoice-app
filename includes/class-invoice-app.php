<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://endif.media/invoice-app
 * @since      1.0.0
 *
 * @package    Invoice_App
 * @subpackage Invoice_App/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Invoice_App
 * @subpackage Invoice_App/includes
 * @author     Ethan Allen <yourfriendethan@gmail.com>
 */
class Invoice_App {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Invoice_App_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'invoice-app';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Invoice_App_Loader. Orchestrates the hooks of the plugin.
	 * - Invoice_App_i18n. Defines internationalization functionality.
	 * - Invoice_App_Admin. Defines all hooks for the admin area.
	 * - Invoice_App_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-i18n.php';

		/**
		 * Plugin functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-admin.php';

		/**
		 * The class responsible for displaying and saving plugin settings in the admin-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'lib/plugin-options.php';

		$this->loader = new Invoice_App_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Invoice_App_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Invoice_App_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Invoice_App_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'setup_postypes' );
		$this->loader->add_filter( 'post_updated_messages', $plugin_admin, 'set_post_type_messages' );//custom messages for post type
		//$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'dashboard_widget' );
		$this->loader->add_action( 'add_meta_boxes_invoice_app_clients', $plugin_admin, 'setup_client_metaboxes' );
		$this->loader->add_action( 'add_meta_boxes_invoice_app_quotes', $plugin_admin, 'setup_quote_metaboxes' );
		$this->loader->add_action( 'add_meta_boxes_invoice_app_invoices', $plugin_admin, 'setup_invoice_metaboxes' );
		$this->loader->add_action( 'post_updated', $plugin_admin, 'save_invoice_app_meta', 10, 2);
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_menu' );
		$this->loader->add_filter( 'admin_body_class', $plugin_admin, 'add_admin_body_class' );
		# Called only in /wp-admin/edit.php* pages
		$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'capture_subsubsub_click' );
		$this->loader->add_action( 'views_edit-invoice_app_invoices', $plugin_admin, 'edit_subsubsub_links' );
		$this->loader->add_action( 'views_edit-invoice_app_quotes', $plugin_admin, 'edit_subsubsub_links' );
		$this->loader->add_action( 'wp_ajax_get_preview', $plugin_admin, 'get_pdf_preview' );
		$this->loader->add_action( 'wp_ajax_after_change_client_on_invoice', $plugin_admin, 'lookup_client_rate' );

		$this->loader->add_filter( 'manage_invoice_app_clients_posts_columns', $plugin_admin, 'edit_client_post_list' );
		$this->loader->add_action( 'manage_invoice_app_clients_posts_custom_column', $plugin_admin, 'add_client_details_to_post_list', 10, 2 );
		$this->loader->add_filter( 'manage_invoice_app_quotes_posts_columns', $plugin_admin, 'edit_quote_post_list' );
		$this->loader->add_action( 'manage_invoice_app_quotes_posts_custom_column', $plugin_admin, 'add_quote_details_to_post_list', 10, 2 );
		$this->loader->add_filter( 'manage_invoice_app_invoices_posts_columns', $plugin_admin, 'edit_invoice_post_list' );
		$this->loader->add_action( 'manage_invoice_app_invoices_posts_custom_column', $plugin_admin, 'add_invoice_details_to_post_list', 10, 2 );
		//$this->loader->add_action( 'delete_post', $plugin_admin, 'delete_invoiceapp_meta', 10, 2 ); 
		$this->loader->add_action( 'invoice_app_overdue_check', $plugin_admin, 'check_for_overdue' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Invoice_App_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
