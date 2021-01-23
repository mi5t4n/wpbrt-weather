<?php
/**
 * Shortcode class.
 */

namespace WPBRT\Weather;

defined( 'ABSPATH' ) || exit;

class Shortcode {

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
		add_action( 'init', array( $this, 'register_shortcodes' ) );
	}

	/**
	 * Register shortcode.
	 */
	public function register_shortcodes(){
		add_shortcode('wpbrt-weather', array( $this, 'display_weather_data' ) );
	}

	/**
	 * Display weather data.
	 *
	 * @param array $attrs
	 */
	public function display_weather_data( $attrs ) {
		$city    = isset( $attrs['city'] ) ? trim( $attrs['city'] ) : '';
		$country = isset( $attrs['country'] ) ? trim( $attrs['country'] ) : '';
		$state   = isset( $attrs['state'] ) ? trim( $attrs['state'] ) : '';

		if ( empty( $city ) ) {
			return '<div>' . esc_html__( 'WPBRT Weather: City is required.', 'wpbrt-weather' ) . '</div>';
		}

		$data = WPBRT_WEATHER()->api->fetch( $city, $country, $state );

		if( is_wp_error( $data ) ) {
			return '<div><b>WPBRT Weather:</b>' . $data->get_error_message(). '</div>';
		}

		ob_start();
		require WPBRT_WEATHER_DIR. '/templates/weather.php';
		return ob_get_clean();
	}
}
