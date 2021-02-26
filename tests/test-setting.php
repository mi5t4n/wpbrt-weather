<?php
/**
 * Class SettingTest
 *
 * @package Wpbrt_Weather
 */

use WPBRT\Weather\Setting;

/**
 * Sample test case.
 */
class SettingTest extends WP_UnitTestCase {
	private $setting;

	public function setUp() {
		$this->setting = new Setting();

		\WP_Mock::setUp();
	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	/**
	 * A single example test.
	 */
	public function test_admin_hook_is_added() {
		$has_added = is_int( has_action( 'admin_menu', array( $this->setting, 'add_admin_menu' ) ) );
		$this->assertTrue( $has_added );
	}

	public function test_admin_menu_is_added() {
		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		$user = wp_set_current_user( $user_id );
		$has_added = is_string( $this->setting->add_admin_menu() );
		$this->assertTrue( $has_added );
	}

	public function test_api_key() {
		\WP_Mock::userFunction( 'get_option', array(
			'times' => 1,
			'args' => array( 'wpbrt_weather_api_key', '' ),
			'return' => 'hello',
		) );

		$this->assertEquals( $this->setting->get_api_key(), 'hello' );
	}
}
