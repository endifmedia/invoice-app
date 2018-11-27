<?php

/**
 * Test admin class
 *
 * @package Invoice_App
 */

class Invoice_App_Admin_VerifyTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();
		$this->class_instance = new Invoice_App_Admin('invoice-app', '1.0.0');
	}

	public function test_is_current_link() {
		$link = $this->class_instance->is_current_link('endif.media', 'endif.media');
		$expected = ' class="current"';

		$this->assertEquals($expected, $link);
	}

	public function test_lookup_client_rate() {
		$test = invoice_app_get_client_details_by_name('Plow');
		$this->assertArrayHasKey('client_hourly_rate', $test);
	}

}
