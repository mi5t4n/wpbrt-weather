<?php
/**
 * Setting class.
 */

namespace WPBRT\Weather;

defined( 'ABSPATH' ) || exit;

class Setting {

	/**
	 * Constructor.
	 */
	public function  __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @return void
	 */
	private function init_hooks() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_setting' ) );
	}

	/**
	 * Add sub menu to the settings menu.
	 *
	 * @return void
	 */
	public function add_admin_menu() {
		return add_options_page(
			esc_html__( 'WPBRT Weather', 'wpbrt-weather' ),
			esc_html__( 'WPBRT Weather', 'wpbrt-weather' ),
			'manage_options',
			'wpbrt-weather',
			array( $this, 'display_setting_page' )
		);
	}

	/**
	 * Display settingpage.
	 *
	 * @return void
	 */
	public function display_setting_page() {
		$api_key = $this->get_api_key();
		require_once WPBRT_WEATHER_DIR . '/templates/setting.php';
	}

	/**
	 * Register setting.
	 *
	 * @since 1.0.0
	 */
	public function register_setting() {
		register_setting( 'wpbrt-weather', 'wpbrt_weather_api_key', function( $api_key ) {
			return trim( $api_key );
		} );
	}

	/**
	 * Get api key.
	 */
	public function get_api_key() {
		return get_option( 'wpbrt_weather_api_key', '' );
	}
}
