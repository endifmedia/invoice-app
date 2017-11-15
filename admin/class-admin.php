<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://endif.media/invoice-app
 * @since      1.0.0
 *
 * @package    Invoice_App
 * @subpackage Invoice_App/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Invoice_App
 * @subpackage Invoice_App/admin
 * @author     Ethan Allen <yourfriendethan@gmail.com>
 */
class Invoice_App_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The settings stored for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_settings    The current settings of this plugin.
	 */
	private $plugin_settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       The name of this plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = INVOICEAPP_PLUGIN_VERSION;
		$this->plugin_settings = get_option('invoice_app_settings');
		$this->options = new Invoice_App_Plugin_Options('Invoice App', 'invoice_app_settings', 'invoice_app_settings');

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * Enqueue stuff on the admin side.
		 *
		 * The Invoice_App_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-jquery-ui-datepicker', plugin_dir_url( __FILE__ ) . 'css/jquery.ui.datepicker.css');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Invoice_App_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Invoice_App_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, false, 99 );

	}

	/**
	 * Add a class to the admin body
	 *
	 * @since 	1.0.0
	 */
	public function get_pdf_preview() {
		if (!empty($_REQUEST['invoiceid'])) {
			return invoice_to_pdf( intval( $_REQUEST['invoiceid'] ) );
		} else {
			wp_die('Unable to process your request.', $this->plugin_name);
		}
	}

	/**
	 * Add a class to the admin body
	 *
	 * @since 	1.0.0
	 */
	public function add_admin_body_class( $classes ) {

		global $post;

		$invoiceAppPostTypes = array('invoice_app_clients', 'invoice_app_invoices', 'invoice_app_quotes');
		if ($post && in_array($post->post_type, $invoiceAppPostTypes)) {
			$classes .= ' invoice_app ';
		}
		return $classes;
	
	}

	/**
	 * Register the menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function create_menu(){
		add_menu_page( 'Plugin Settings', 'Invoice App', 'manage_options', 'invoice_app_settings', null, 'dashicons-media-text');//plugins_url('img/invoice.png', __FILE__) );
		add_submenu_page(
					'invoice_app_settings',
					esc_html__( 'Settings', 'invoice-app' ),
					esc_html__( 'Settings', 'invoice-app' ),
					'manage_options',
					'invoice_app_settings',
					array($this, 'options_page') 
		);
	}

	/**
	 * Function that displays the options form.
	 *
	 * @since    1.0.0
	 */
	public function options_page() {

		$options = $this->option_fields();

		if (isset($_GET['tab']) && !is_numeric($_GET['tab'])){
			$active_tab = sanitize_text_field($_GET['tab']);
		} else {
			$active_tab = 'business';
		}

		$this->options->render_form($options, $active_tab);

	}

	/**
	 * Function that builds the options array for Plugin_Settings class.
	 *
	 * @since    1.0.0
	 */
	public function option_fields() {
		$options = array(
			/** Payment Gateways Settings */
			'business' => apply_filters('invoice_app_settings_business',
				array(
					/*'business_logo' => array(
						'id'   => 'business_logo',
						'label' => __( 'Logo', 'invoice-app' ),
						'desc' => __( 'Upload or choose a logo to be displayed at the top of PDF invoices and quotes.', 'invoice-app' ),
						'type' => 'upload',
					),*/
					'business_name' => array(
						'id'   => 'business_name',
						'label' => __( 'Business Name', 'invoice-app' ),
						'type' => 'text',
					),
					'business_address' => array(
						'id'   => 'business_address',
						'label' => __( 'Address', 'invoice-app' ),
						'type' => 'textarea',
					),
					'business_phone' => array(
						'id'   => 'business_phone',
						'label' => __( 'Phone', 'invoice-app' ),
						'desc' => __('xxx-xxx-xxxx', 'invoice-app'),
						'type' => 'phone',
					),
					'business_website' => array(
						'id'   => 'business_website',
						'label' => __( 'Business Website', 'invoice-app' ),
						'type' => 'url',
					),
				)
			),
			/** Payment Gateways Settings */
			'quotes' => apply_filters('invoice_app_settings_quotes',
				array(
					'quote_life' => array(
						'id'   => 'quote_life',
						'label' => __( 'Quote Life', 'invoice-app' ),
						'desc' => __( 'days', 'invoice-app' ),
						'type' => 'number',
						'size' => 'small',
					),			
				)
			),
			'invoices' => apply_filters('invoice_app_settings_invoices',
				array(
					'invoice_offset' => array(
						'id'   => 'invoice_offset',
						'label' => __( 'Invoice Offset', 'invoice-app' ),
						'desc' => __( 'Add a custom starting point for invoice numbering. (Leave this box blank to start from 1.)', 'invoice-app' ),
						'type' => 'number',
						'size' => 'small',
					),
					'invoice_notes' => array(
						'id'   => 'invoice_notes',
						'label' => __( 'Invoice Notes', 'invoice-app' ),
						'type' => 'textarea',
					),
					'invoice_terms' => array(
						'id'   => 'invoice_terms',
						'label' => __( 'Invoice Terms', 'invoice-app' ),
						'type' => 'textarea',
					),
				)
			),
			'payments' => apply_filters('invoice_app_settings_payments',
				array(
					'tax_rate' => array(
						'id'   => 'tax_rate',
						'label' => __( 'Tax Rate', 'invoice-app' ),
						'desc' => __( '%', 'invoice-app' ),
						'type' => 'number',
						'size' => 'small',
					),
					'currency_code' => array(
						'id'      => 'currency_code',
						'label'    => __( 'Currency Code', 'invoice-app' ),
						'desc'    => __( '', 'invoice-app' ),
						'type'    => 'select',
						'options' => array(
							'USD' => 'U.S. Dollar',
							'AUD' => 'Austrailian Dollar',
							'BRL' => 'Brazilian Real',
							'CAD' => 'Canadian Dollar',
							'CZK' => 'Czech Koruna',
							'DKK' => 'Danish Krone',
							'EUR' => 'EURO',
							'HKD' => 'Hong Kong Dollar',
							'HUF' => 'Hungarian Forint',
							'ILS' => 'Israeli New Sheqel',
							'JPY' => 'Japanese Yen',
							'MYR' => 'Malaysian Ringgit',
							'MXN' => 'Mexican Peso',
							'NOK' => 'Norwegian Krone',
							'NZD' => 'New Zealand Dollar',
							'PHP' => 'Philippine Peso',
							'PLN' => 'Polish Zloty',
							'GBP' => 'Pound Sterling',
							'SGD' => 'Singapore Dollar',
							'SEK' => 'Swedish Krona',
							'CHF' => 'Swiss Franc',
							'TWD' => 'Taiwan New Dollar',
							'THB' => 'Thai Baht',
							'TRY' => 'Turkish Lira',
						)
					),
					'individual_client_rate' => array(
							'id'   => 'individual_client_rate',
							'label' => __( 'Individual Rates per Client?', 'invoice-app' ),
							'desc' => __( 'Turn on rate settings for individal clients. If you charge different hourly rates per client. <small><i>Clients > Add New > Hourly Rate</i></small>', 'invoice-app' ),
							'type' => 'checkbox'
					),
				)	
			)

	);
    return apply_filters( 'invoice_app_settings_group', $options );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function dashboard_widget() {
		wp_add_dashboard_widget('dashboard_widget', 'Invoice App', array(&$this, 'display_widget'));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function display_widget(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/invoice-app-admin-dash.php';
	}

	/**
	 * Change the default notification messages for custom post type 'wpiu-invoices'
	 *
	 * @package    Invoice_App
	 */
	function set_post_type_messages($messages){
		
		global $post;

		add_thickbox();
		$link = add_query_arg( array(
			'action' => 'get_preview',
			'invoiceid' => intval($post->ID),
			'TB_iframe' => true,
			'width' => '700',
			'height' => '550'
		), admin_url('admin-ajax.php'));

		$messages['invoice_app_invoices'] = array(
			1 => sprintf( __('Invoice updated. <a id="view_invoice" href="%s" target="_blank">View Invoice</a>', 'invoice-app'), $link ),
		);

		$messages['invoice_app_quotes'] = array(
			1 => sprintf( __('Quote updated. <a id="view_quote" href="%s" target="_blank">View Quote</a>', 'invoice-app'), $link ),
		);

		$messages['invoice_app_clients'] = array(
			1 => __('Client updated.', 'invoice-app'),
		);

		return $messages;
	}

	/**
	 * Setup post types for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function setup_postypes() {
		//invoices
		$labels = array(
		    'name'                  => _x( 'Invoices', 'invoice-app' ),
			'singular_name'         => _x( 'Invoice', 'invoice-app' ),
			'menu_name'             => __( 'Invoices', 'invoice-app' ),
			'name_admin_bar'        => __( 'Invoice', 'invoice-app' ),
			'all_items'             => __( 'All Invoices', 'invoice-app' ),
			'add_new_item'          => __( 'Add New Invoice', 'invoice-app' ),
			'new_item'              => __( 'New Invoice', 'invoice-app' ),
			'edit_item'             => __( 'Edit Invoice', 'invoice-app' ),
			'update_item'           => __( 'Update Invoice', 'invoice-app' ),
			'view_item'             => __( 'View Invoice', 'invoice-app' ),
			'search_items'          => __( 'Search Invoices', 'invoice-app' ),
			'not_found'             => __( 'No Invoices found', 'invoice-app' ),
			'not_found_in_trash'    => __( 'No Invoices found in the Trash', 'invoice-app' ),
		    'insert_into_item'      => __( 'Insert into Invoice', 'invoice-app' ),
		    'uploaded_to_this_item' => __( 'Uploaded to this Invoice', 'invoice-app' ),
			'items_list'            => __( 'Invoices list', 'invoice-app' ),
			'items_list_navigation' => __( 'Invoices list navigation', 'invoice-app' ),
		);
		$args = array(
			'label'                 => __( 'Invoice', 'invoice-app' ),
			'description'           => __( 'Invoice App invoices', 'invoice-app' ),
			'labels'                => $labels,
			'supports'              => false,
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => 'invoice_app_settings',
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'menu_icon'			    => 'dashicons-media-spreadsheet',
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
		);
		register_post_type( 'invoice_app_invoices', $args );

		//quotes
		$labels = array(
			'name'                  => _x( 'Quotes', 'invoice-app' ),
			'singular_name'         => _x( 'Quote', 'invoice-app' ),
			'menu_name'             => __( 'Quotes', 'invoice-app' ),
			'name_admin_bar'        => __( 'Quote', 'invoice-app' ),
			'all_items'             => __( 'All Quotes', 'invoice-app' ),
			'add_new_item'          => __( 'Add New Quote', 'invoice-app' ),
			'new_item'              => __( 'New Quote', 'invoice-app' ),
			'edit_item'             => __( 'Edit Quote', 'invoice-app' ),
			'update_item'           => __( 'Update Quote', 'invoice-app' ),
			'view_item'             => __( 'View Quote', 'invoice-app' ),
			'search_items'          => __( 'Search Quotes', 'invoice-app' ),
			'not_found'             => __( 'No Quotes found', 'invoice-app' ),
			'not_found_in_trash'    => __( 'No Quotes found in the Trash', 'invoice-app' ),
			'insert_into_item'      => __( 'Insert into Quote', 'invoice-app' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Quote', 'invoice-app' ),
			'items_list'            => __( 'Quotes list', 'invoice-app' ),
			'items_list_navigation' => __( 'Quotes list navigation', 'invoice-app' ),
		);
		$args = array(
			'label'                 => __( 'Quote', 'invoice-app' ),
			'description'           => __( 'Invoice App quotes', 'invoice-app' ),
			'labels'                => $labels,
			'supports'              => false,
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => 'invoice_app_settings',
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'menu_icon'			    => 'dashicons-media-text',
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
		);
		register_post_type( 'invoice_app_quotes', $args );

		//clients
		$labels = array(
			'name'                  => _x( 'Clients', 'invoice-app' ),
			'singular_name'         => _x( 'Client', 'invoice-app' ),
			'menu_name'             => __( 'Clients', 'invoice-app' ),
			'name_admin_bar'        => __( 'Client', 'invoice-app' ),
			'all_items'             => __( 'All Clients', 'invoice-app' ),
			'add_new_item'          => __( 'Add New Client', 'invoice-app' ),
			'new_item'              => __( 'New Client', 'invoice-app' ),
			'edit_item'             => __( 'Edit Client', 'invoice-app' ),
			'update_item'           => __( 'Update Client', 'invoice-app' ),
			'view_item'             => __( 'View Client', 'invoice-app' ),
			'search_items'          => __( 'Search Clients', 'invoice-app' ),
			'not_found'             => __( 'No Clients found', 'invoice-app' ),
			'not_found_in_trash'    => __( 'No Clients found in the Trash', 'invoice-app' ),
			'insert_into_item'      => __( 'Insert into Client', 'invoice-app' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Client', 'invoice-app' ),
			'items_list'            => __( 'Clients list', 'invoice-app' ),
			'items_list_navigation' => __( 'Clients list navigation', 'invoice-app' ),
		);
		$args = array(
			'label'                 => __( 'Client', 'invoice-app' ),
			'description'           => __( 'Invoice App clients', 'invoice-app' ),
			'labels'                => $labels,
			'supports'              => false,
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => 'invoice_app_settings',
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'menu_icon'			    => 'dashicons-businessman',
			'exclude_from_search'   => true,
			'publicly_queryable'    => false,
		);
		register_post_type( 'invoice_app_clients', $args );

	}

	/**
	 * Add client metaboxes.
	 *
	 * @since    1.0.0
	 */
	public function setup_client_metaboxes() {
  		add_meta_box('invoiceapp_client_info', 'Client Details', array(&$this, 'client_details'), 'invoice_app_clients', 'normal');
	}

	/**
	 * Add qoute metaboxes.
	 *
	 * @since    1.0.0
	 */
	public function setup_quote_metaboxes() {
  		add_meta_box('invoiceapp_quote_info', 'Quote Details', array(&$this, 'quote_details'), 'invoice_app_quotes', 'normal');
		add_meta_box('invoiceapp_product_info', 'Quote Items', array(&$this, 'item_details'), array('invoice_app_invoices', 'invoice_app_quotes'), 'normal');
	}

	/**
	 * Add invoice metaboxes.
	 *
	 * @since    1.0.0
	 */
	public function setup_invoice_metaboxes() {
  		add_meta_box('invoiceapp_invoice_info', 'Invoice Details', array(&$this, 'invoice_details'), 'invoice_app_invoices', 'normal');
		add_meta_box('invoiceapp_product_info', 'Invoice Items', array(&$this, 'item_details'), array('invoice_app_invoices', 'invoice_app_quotes'), 'normal');
	}

	/**
	 * Do client metabox.
	 *
	 * @since    1.0.0
	 */
	public function client_details(){
		if(isset($_GET['action']) && $_GET['action'] == 'edit' ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/edit-client-details.php';
		} else {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/client-details.php';
		}
	}

	/**
	 * Do client metabox.
	 *
	 * @since    1.0.0
	 */
	public function quote_details(){
		if(isset($_GET['action']) && $_GET['action'] == 'edit' ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/edit-quote-details.php';
		} else {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/quote-details.php';
		}	
	}

	/**
	 * Do client metabox.
	 *
	 * @since    1.0.0
	 */
	public function invoice_details(){
		if(isset($_GET['action']) && $_GET['action'] == 'edit' ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/edit-invoice-details.php';
		} else {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/invoice-details.php';
		}
	}

	/**
	 * Do product metabox.
	 *
	 * @since    1.0.0
	 */
	public function item_details(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/item-details.php';
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param $post_id
	 * @param $post
	 */
	public function save_invoice_app_meta($post_id, $post) {

		/**
		 * Check cap.
		 */
		if ( !current_user_can('edit_plugins') ){
			return;
		}

		//update meta based on post_type
		switch ($post->post_type) {
        	case 'invoice_app_clients':
        	    //company name
        		if ( isset( $_REQUEST['client-company'] ) ) {
			        update_post_meta( $post_id, 'client_company', sanitize_text_field( $_REQUEST['client-company'] ) );
			    }
        		//contact name
        		if ( isset( $_REQUEST['client-contact-name'] ) ) {
			        update_post_meta( $post_id, 'client_contact_name', sanitize_text_field( $_REQUEST['client-contact-name'] ) );
			    }
        		//email
        		if ( isset( $_REQUEST['client-email'] ) ) {
			        update_post_meta( $post_id, 'client_email', sanitize_email( $_REQUEST['client-email'] ) );
			    }
        		//address
        	    if ( isset( $_REQUEST['client-address'] ) ) {

			        update_post_meta( $post_id, 'client_address', sanitize_text_field( $_REQUEST['client-address'] ) );
			    }
			    //city
        	    if ( isset( $_REQUEST['client-city'] ) ) {
			        update_post_meta( $post_id, 'client_city', sanitize_text_field( $_REQUEST['client-city'] ) );
			    }
			    //state
        	    if ( isset( $_REQUEST['client-state'] ) ) {
			        update_post_meta( $post_id, 'client_state', sanitize_text_field( $_REQUEST['client-state'] ) );
			    }
			    //zip
        	    if ( isset( $_REQUEST['client-zip'] ) ) {
			        update_post_meta( $post_id, 'client_zip', sanitize_text_field( $_REQUEST['client-zip'] ) );
			    }
			    //fax
        	    if ( isset( $_REQUEST['client-fax'] ) ) {
			        update_post_meta( $post_id, 'client_fax', sanitize_text_field( $_REQUEST['client-fax'] ) );
			    }
			    //phone
        	    if ( isset( $_REQUEST['client-phone'] ) ) {
			        update_post_meta( $post_id, 'client_phone', sanitize_text_field( $_REQUEST['client-phone'] ) );
			    }
			    //cell
        	    if ( isset( $_REQUEST['client-cell'] ) ) {
			        update_post_meta( $post_id, 'client_cell', sanitize_text_field( $_REQUEST['client-cell'] ) );
			    }
			    //website
        	    if ( isset( $_REQUEST['client-website'] ) ) {
			        update_post_meta( $post_id, 'client_website', sanitize_text_field( $_REQUEST['client-website'] ) );
			    }
		        if ( isset( $_REQUEST['client-website'] ) ) {
			        $rate = money_format('%i', $_REQUEST['client-hourly-rate']);
			        update_post_meta( $post_id, 'client_hourly_rate', sanitize_text_field($rate) );
		        }

        		break;

        	case 'invoice_app_quotes':
        	    //client
        		if ( isset( $_REQUEST['quote-client'] ) ) {
			        update_post_meta( $post_id, 'quote_client', sanitize_text_field( $_REQUEST['quote-client'] ) );
			    }
        		//project title
        		if ( isset( $_REQUEST['quote-project-title'] ) ) {
			        update_post_meta( $post_id, 'quote_project_title', sanitize_text_field( $_REQUEST['quote-project-title'] ) );
			    }
			    //description
			    if ( isset( $_REQUEST['quote-description'] ) ) {
			        update_post_meta( $post_id, 'quote_description', sanitize_text_field( $_REQUEST['quote-description'] ) );
			    }
			    //issue date
			    if ( isset( $_REQUEST['quote-issue-date'] ) ) {
			        update_post_meta( $post_id, 'quote_issue_date', sanitize_text_field( $_REQUEST['quote-issue-date'] ) );
			    }	

			    //invoice items
		        if ( isset( $_REQUEST['line-item'] ) ) {
			        $info = $_REQUEST['line-item'];
			        update_post_meta( $post_id, 'invoice_line_items', $info );
		        }

		        //invoice data
		        if ( isset( $_REQUEST['invoice_line_items_subtotal'] ) ) {
		        	update_post_meta( $post_id, 'invoice_line_items_subtotal', sanitize_text_field($_REQUEST['invoice_line_items_subtotal']) );
		        }
		        if ( isset( $_REQUEST['invoice_line_items_tax_total'] ) ) {
		        	update_post_meta( $post_id, 'invoice_line_items_tax_total', sanitize_text_field($_REQUEST['invoice_line_items_tax_total']) );
		        }
		        if ( isset( $_REQUEST['invoice_line_items_total'] ) ) {
		        	update_post_meta( $post_id, 'invoice_line_items_total', sanitize_text_field($_REQUEST['invoice_line_items_total']) );
		        }
        		break;

        	case 'invoice_app_invoices':
        		//get last invoice
        		$lastInvoice = invoice_app_get_previous_invoice();

        		if ( empty(get_post_meta( $post->ID, 'invoice_number', true )) && !wp_is_post_autosave( $post_id ) ){//if there is no # attached current invoice

	        		if( $lastInvoice->previous_invoice_number ){//get most recent invoice #

	        			//increment invoice
	        			$newestInvoiceNumber = $lastInvoice->previous_invoice_number+1;

	        			//if there is a number number in settings and its greater than current use that one
	        			if ( isset($this->plugin_settings['most_recent_invoice_number']) && $this->plugin_settings['most_recent_invoice_number'] > $newestInvoiceNumber ) {	        				
	        				//increment invoice # in settings
	        				$newestInvoiceNumber = $this->plugin_settings['most_recent_invoice_number']+1;
		        			//update invoice meta
		        			update_post_meta( $post_id, 'invoice_number', intval( $newestInvoiceNumber ) );		        			
		        			//build settings with lastest invoice number
		        			$this->plugin_settings['most_recent_invoice_number'] = $newestInvoiceNumber;
	        			} else {
		        			update_post_meta( $post_id, 'invoice_number', intval( $newestInvoiceNumber ) );
		        			//build settings with lastest invoice number
		        			$this->plugin_settings['most_recent_invoice_number'] = $newestInvoiceNumber;
		        		}

	        		} else {
	        			if($this->plugin_settings['invoice_offset']){//try using offset
	        				update_post_meta( $post_id, 'invoice_number', intval( $this->plugin_settings['invoice_offset'] ) );
	        			} else {//has to be the first invoice
	        				update_post_meta( $post_id, 'invoice_number', intval( '1' ) );
	        			}
	        		}

	        	}
        	    if ( isset( $_REQUEST['invoice-client'] ) ) {
			        update_post_meta( $post_id, 'invoice_client', sanitize_text_field( $_REQUEST['invoice-client'] ) );
			    }
			    if ( isset( $_REQUEST['invoice-project-title'] ) ) {
			        update_post_meta( $post_id, 'invoice_project_title', sanitize_text_field( $_REQUEST['invoice-project-title'] ) );
			    }
			    if ( isset( $_REQUEST['invoice-description'] ) ) {
			        update_post_meta( $post_id, 'invoice_description', sanitize_text_field( $_REQUEST['invoice-description'] ) );
			    }
			    if ( isset( $_REQUEST['invoice-issue-date'] ) ) {
			        update_post_meta( $post_id, 'invoice_issue_date', sanitize_text_field( $_REQUEST['invoice-issue-date'] ) );
			    }
			    if ( isset( $_REQUEST['invoice-due-date'] ) ) {
			        update_post_meta( $post_id, 'invoice_due_date', sanitize_text_field( $_REQUEST['invoice-due-date'] ) );
			    }
			    if ( isset( $_REQUEST['invoice-status'] ) ) {
			        update_post_meta( $post_id, 'invoice_status', sanitize_text_field( $_REQUEST['invoice-status'] ) );
			    }
			    if ( isset( $_REQUEST['invoice-notes'] ) ) {
			        update_post_meta( $post_id, 'invoice_notes', sanitize_text_field( $_REQUEST['invoice-notes'] ) );
			    }
			    if ( isset( $_REQUEST['invoice-terms'] ) ) {
			        update_post_meta( $post_id, 'invoice_terms', sanitize_text_field( $_REQUEST['invoice-terms'] ) );
			    }

		        //invoice items
		        if ( isset( $_REQUEST['line-item'] ) ) {
			        $info = $_REQUEST['line-item'];
			        update_post_meta( $post_id, 'invoice_line_items', $info );
		        }

		        //invoice data
		        if ( isset( $_REQUEST['invoice_line_items_subtotal'] ) ) {
		        	update_post_meta( $post_id, 'invoice_line_items_subtotal', sanitize_text_field($_REQUEST['invoice_line_items_subtotal']) );
		        }
		        if ( isset( $_REQUEST['invoice_line_items_tax_total'] ) ) {
		        	update_post_meta( $post_id, 'invoice_line_items_tax_total', sanitize_text_field($_REQUEST['invoice_line_items_tax_total']) );
		        }
		        if ( isset( $_REQUEST['invoice_line_items_total'] ) ) {
		        	update_post_meta( $post_id, 'invoice_line_items_total', sanitize_text_field($_REQUEST['invoice_line_items_total']) );
		        }
        		break;
        	
        	default:
        		return;
        		break;
        }

    }

	/**
	 * Check which subsubsub link was clicked.
	 *
	 * @since    1.0.0
	 */
	public function capture_subsubsub_click($query){
		
		# Not admin, bail out
		if ( !is_admin() ) return;

		$screenID = get_current_screen()->id;

		$pages = array('edit-invoice_app_invoices', 'edit-invoice_app_quotes');

	    if ( !is_admin() || !in_array($screenID, $pages) ){
	        return;
	    }

		switch ($screenID) {
			case 'edit-invoice_app_invoices':
				if( isset( $_GET['invoice_status'] ) ){
					$query->set('meta_key', 'invoice_status');
					$query->set('meta_value', $_GET['invoice_status']);
	        	}
				break;

			case 'edit-invoice_app_quotes':
				if( isset( $_GET['quote_status'] ) ){
					$query->set('meta_key', 'quote_status');
					$query->set('meta_value', $_GET['quote_status']);
	        	}
				break;
			
			default:
				break;
		}

	}

	/**
	 * Edit plugin post type subsubsub links.
	 *
	 * @since    1.0.0
	 */
	public function edit_subsubsub_links($views) {
		unset($views['publish']);
		$type = $this->invoice_app_get_the_type();

		if ($type === 'quote'){
			return $views;
		}

		//get statuses
        $statuses = $this->invoice_app_get_statuses($type);
        $active = '';

		if ($statuses) {
			foreach ( $statuses as $status ) {

				if ( $status->count != 0 ) {

					$class                    = ( ! empty( $_GET[ $type . '_status' ] ) ) ? $this->is_current_link( $_GET[ $type . '_status' ], $status->status ) : '';
					$views[ $status->status ] = '<a href="' . esc_url( add_query_arg( $type . '_status', $status->status, admin_url() . 'edit.php?post_type=invoice_app_invoices' ) ) . '"'
					                            . $class
					                            . '>'
					                            . esc_html( ucfirst( $status->status ) )
					                            . ' <span class="count">(' . esc_html( $status->count )
					                            . ')</span></a>';
				}
			}
		}
    	return $views;
	}

	/**
	 * Check if clicked subsubsub is the active link.
	 *
	 * @since 1.0.0
	 * @param $first
	 * @param $second
	 *
	 * @return string
	 */
	public function is_current_link($first, $second){

		if ($first == $second)
			return ' class="current"';

	}

	/**
	 * Count posts by meta_key and meta_value.
	 *
	 * @since    1.0.0
	 * @param $key
	 * @param $value
	 *
	 * @return null|string
	 */
	public function invoice_app_get_count( $key, $value ){

		global $wpdb;

		$sql = "SELECT COUNT( * ) 
				FROM $wpdb->postmeta 
				LEFT JOIN $wpdb->posts ON $wpdb->posts.ID = $wpdb->postmeta.post_id 
				WHERE meta_key = %s AND meta_value = %s AND wp_posts.post_status = 'publish'";
		$results = $wpdb->get_var($wpdb->prepare($sql, $key, $value));
		return $results;

	}

	/**
	 * Get invoice app post type by id.
	 *
	 * @since    1.0.0
	 * @param int $id
	 *
	 * @return string
	 */
	public function invoice_app_get_the_type( $id = 0 ) {

		if ( ! $id ) {
			$id = get_the_id();
		}
		$type = rtrim(str_replace( 'invoice_app_', '', get_post_type($id) ), 's' );
		return $type;

	}

	/**
	 * Get available statuses by post type.
	 *
	 * @since    1.0.0
	 * @param $type
	 *
	 * @return array
	 */
	public function invoice_app_get_statuses($type) {

		$values = array();

		if ($type == 'quote')
		    $values = array('sent', 'overdue');

		if ($type == 'invoice')
			 $values = array('paid', 'sent', 'overdue', 'unpaid');

		if (empty($values))
			return false;

		$i = 0;

		foreach ($values as $value){
			$count[$i] = new StdClass;
		    $count[$i]->status = $value;
		    $count[$i]->count = $this->invoice_app_get_count($type . '_status', $value);
		    $i++;
		}
		return $count;

	}

	/**
	 * Edit Client post type list table.
	 *
	 * @since    1.0.0
	 * @param $defaults
	 *
	 * @return mixed
	 */
	public function edit_client_post_list($defaults) {

		//remove these..
		unset($defaults['title']);
		unset($defaults['date']);
		unset($defaults['categories']);
		unset($defaults['tags']);
		unset($defaults['post_views']);

		//add new ones
		$defaults['invoiceapp_client_company'] = __('Company');
		$defaults['invoiceapp_client_contact_name'] = __('Contact');
		$defaults['invoiceapp_client_email'] = __('Email');
    	return $defaults;

	}

	/**
	 * Populate invoice post type list table.
	 *
	 * @since    1.0.0
	 * @param $column_name
	 * @param $post_ID
	 */
	public function add_client_details_to_post_list($column_name, $post_ID) {

		if ($column_name == 'invoiceapp_client_company') {
	        $clientCompany = get_post_meta( $post_ID, 'client_company', true );
	        if ($clientCompany) {
	            echo $clientCompany;
	        }
	    }

	    if ($column_name == 'invoiceapp_client_contact_name') {
	        $clientContactName = get_post_meta( $post_ID, 'client_contact_name', true );
	        if ($clientContactName) {
	            echo $clientContactName;
	        }
	    }
	    
	    if ($column_name == 'invoiceapp_client_email') {
	        $clientEmail = get_post_meta( $post_ID, 'client_email', true );
	        if ($clientEmail) {
	            echo $clientEmail;
	        }
	    }

	}

	/**
	 * Edit invoice post type list table.
	 *
	 * @since    1.0.0
	 * @param $defaults
	 *
	 * @return mixed
	 */
	public function edit_quote_post_list($defaults) {

		//remove these..
		unset($defaults['title']);
		unset($defaults['date']);
		unset($defaults['categories']);
		unset($defaults['tags']);
		unset($defaults['post_views']);

		//add new ones
		$defaults['invoiceapp_quote_project_title'] = __('Project Title');
		$defaults['invoiceapp_quote_client_name'] = __('Client');
		$defaults['invoiceapp_quote_total'] = __('Total');
    	return $defaults;

	}

	/**
	 * Poplate invoice post type list table.
	 *
	 * @since    1.0.0
	 * @param $column_name
	 * @param $post_ID
	 */
	public function add_quote_details_to_post_list($column_name, $post_ID) {

		if ($column_name == 'invoiceapp_quote_project_title') {
	        $quoteProjectTitle = get_post_meta( $post_ID, 'quote_project_title', true );
	        if ($quoteProjectTitle) {
	            echo $quoteProjectTitle;
	        }
	    }

	    if ($column_name == 'invoiceapp_quote_client_name') {
	        $quoteClientName = get_post_meta( $post_ID, 'quote_client', true );
	        if ($quoteClientName) {
	            echo $quoteClientName;
	        }
	    }

	    if ($column_name == 'invoiceapp_quote_total') {
	        $quoteStatus = get_post_meta( $post_ID, 'invoice_line_items_total', true );
	        if ($quoteStatus) {
	            echo $this->plugin_settings['currency_code'] .  ' ' . $quoteStatus;
	        }
	    }
	}

	/**
	 * Edit invoice post type list table.
	 *
	 * @since    1.0.0
	 * @param $defaults
	 *
	 * @return mixed
	 */
	public function edit_invoice_post_list($defaults) {

		//remove these..
		unset($defaults['title']);
		unset($defaults['date']);
		unset($defaults['categories']);
		unset($defaults['tags']);
		unset($defaults['post_views']);
		//var_dump($defaults);

		//add new ones
		$defaults['invoiceapp_invoice_number'] = __('Invoice #');
		$defaults['invoiceapp_invoice_due_date'] = __('Due');
		$defaults['invoiceapp_invoice_project_title'] = __('Project Title');
		$defaults['invoiceapp_invoice_client_name'] = __('Client');
		$defaults['invoiceapp_invoice_status'] = __('Status');
		$defaults['invoiceapp_invoice_total'] = __('Total');
    	return $defaults;
	}

	/**
	 * Poplate invoice post type list table.
	 *
	 * @since    1.0.0
	 * @param $column_name
	 * @param $post_ID
	 */
	public function add_invoice_details_to_post_list($column_name, $post_ID) {

		if ($column_name == 'invoiceapp_invoice_number') {
	        $invoiceProjectTitle = get_post_meta( $post_ID, 'invoice_number', true );
	        if ($invoiceProjectTitle) {
	            echo $invoiceProjectTitle;
	        }
	    }

	    if ($column_name == 'invoiceapp_invoice_due_date') {
	        $invoiceDueDate = get_post_meta( $post_ID, 'invoice_due_date', true );
	        if ($invoiceDueDate) {
	            echo $invoiceDueDate;
	        }
	    }

	    if ($column_name == 'invoiceapp_invoice_project_title') {
	        $invoiceProjectTitle = get_post_meta( $post_ID, 'invoice_project_title', true );
	        if ($invoiceProjectTitle) {
	            echo $invoiceProjectTitle;
	        }
	    }

	    if ($column_name == 'invoiceapp_invoice_client_name') {
	        $invoiceClientName = get_post_meta( $post_ID, 'invoice_client', true );
	        if ($invoiceClientName) {
	            echo $invoiceClientName;
	        }
	    }

	    if ($column_name == 'invoiceapp_invoice_status') {
	        $invoiceStatus = get_post_meta( $post_ID, 'invoice_status', true );
	        if ($invoiceStatus) {
	            echo $invoiceStatus;
	        }
	    }

	    if ($column_name == 'invoiceapp_invoice_total') {
	        $invoiceStatus = get_post_meta( $post_ID, 'invoice_line_items_total', true );
	        if ($invoiceStatus) {
	            echo $this->plugin_settings['currency_code']  .  ' ' .  $invoiceStatus;
	        }
	    }

	}

	/**
	 * Check for overdue.
	 *
	 * @since    1.0.0
	 */
	public function check_for_overdue() {
		global $wpdb;

	    $sql = "SELECT ID AS post_id, 
				pinvoicedate.meta_value AS due_date, 
				pinvoicestatus.meta_value AS status 
				FROM {$wpdb->prefix}posts 
				LEFT JOIN {$wpdb->prefix}postmeta pinvoicedate 
				ON pinvoicedate.post_id = ID AND pinvoicedate.meta_key = 'invoice_due_date' 
				RIGHT JOIN {$wpdb->prefix}postmeta pinvoicestatus 
				ON pinvoicestatus.post_id = ID AND pinvoicestatus.meta_key = 'invoice_status' 
				WHERE post_type = 'invoice_app_invoices' AND post_status = 'publish'";
	 
	    $results = $wpdb->get_results($sql);    

	    foreach($results as $invoice) {
	        if($invoice->due_date != '' && strtotime(date('m/d/Y')) >= strtotime($invoice->due_date) && $invoice->status != 'paid'){
	            update_post_meta( $invoice->post_id, 'invoice_status', 'overdue' );
	        }
	    }
	}

	/**
	 *
	 */
	public function lookup_client_rate() {
		$client = sanitize_text_field($_REQUEST['client']);
		$result = invoice_app_get_client_details_by_name($client);
		echo $result['client_hourly_rate'][0];
		exit;
	}

}
