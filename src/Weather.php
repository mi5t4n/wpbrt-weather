<?php
/**
 * Main class.
 */

namespace WPBRT\Weather;

defined( 'ABSPATH' ) || exit;

final class Weather {

	/**
	 * Hold the instance of api class.
	 *
	 * @var WPBRT\Weather\Shortcode
	 */
	public $shortcode;

	/**
	 * Hold the instance of api class.
	 *
	 * @var WPBRT\Weather\Api
	 */
	public $api;

	/**
	 * Hold the instance of settings class.
	 *
	 * @var WPBRT\Weather\Setting
	 */
	public $settings;

	/**
	 * Holds the instance of the class
	 *
	 * @var WPBRT\Weather\Weather
	 */
	private static $instance = null;

	/**
	 * Get instance.
	 *
	 * @return void
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->init();
	}
	/**
	 * Initialize the class.
	 */
	public function init() {
		$this->setting   = new Setting();
		$this->api       = new Api();
		$this->shortcode = new Shortcode();

		$this->api->set_api_key( $this->setting->get_api_key() );
	}
}
