<?php
/**
 * Test function file
 *
 * @package Invoice_App
 */

class Plugin_Functions_VerifyTest extends WP_UnitTestCase {

	function test_invoice_app_quote_expires_on() {
		$test = invoice_app_quote_expires_on(1);
		$this->assertFalse($test);
	}

	function test_invoice_app_get_client_details_by_name() {
		$test = invoice_app_get_client_details_by_name('Plow Digital');
		$this->assertFalse($test);
	}

	function test_invoice_app_get_clients() {
		$test = invoice_app_get_clients();
		$this->assertNotNull($test);
	}

	function test_invoice_app_is_quote() {
		$test = invoice_app_is_quote('795');
		$this->assertFalse($test);
	}

}
