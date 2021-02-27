<?php
/**
 * Class SettingTest
 *
 * @package Wpbrt_Weather
 */

use WPBRT\Weather\Setting;

/**
 * Setting test case.
 */
class SettingTest extends WP_UnitTestCase {
	public function test_admin_menu_hook_is_added() {
		$setting = new Setting();
		$has_action = has_action( 'admin_menu', array( $setting, 'add_admin_menu' ) ) !== false;
		$this->assertTrue( $has_action, true );
	}

	public function test_admin_init_hook_is_added() {
		$setting = new Setting();
		$has_action = has_action( 'admin_init', array( $setting, 'register_setting' ) ) !== false;
		$this->assertTrue( $has_action, true );
	}

	public function test_whether_admin_menu_is_registered() {
		$setting = new Setting();

		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		$user = wp_set_current_user( $user_id );

		$has_added = $setting->add_admin_menu();

		$this->assertEquals( $has_added, 'admin_page_wpbrt-weather' );
	}

	public function test_api_key_is_empty() {
		$setting = new Setting();

		\WP_Mock::userFunction( 'get_option', array(
			'args' => array( 'wpbrt_weather_api_key', '' ),
			'times' => 1,
			'return' => 'hello'
		) );

		$this->assertEquals( $setting->get_api_key(), 'hello' );
	}
}
