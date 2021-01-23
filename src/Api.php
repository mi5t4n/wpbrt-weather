<?php
/**
 * Api class.
 */

namespace WPBRT\Weather;

defined( 'ABSPATH' ) || exit;

class Api {

	/**
	 * API base url.
	 */
	private $base_url = 'https://api.openweathermap.org/data/2.5/weather';

	/**
	 * API Key.
	 *
	 * @var string
	 */
	private $api_key = '';

	/**
	 * Set api_key.
	 *
	 * @param string $api_key
	 */
	public function set_api_key( $api_key = '' ) {
		$this->api_key = trim( $api_key );
		return $this;
	}

	/**
	 * Fetch the weather.
	 *
	 * @param string $city    City.
	 * @param string $country Country.
	 * @param string $state   State
	 *
	 */
	public function fetch( $city, $country = '', $state = '' ) {
		$url = add_query_arg( array(
			'q'     => "{$city},{$state},{$country}",
			'appid' => $this->api_key
		), $this->base_url );

		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$data = wp_remote_retrieve_body( $response );
		$data = \json_decode( $data );

		if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return new \WP_Error( $data->cod, $data->message );
		}

		return $this->process_result( $data );
	}

	/**
	 * Process the result and extract only the relevant fields.
	 *
	 * @param array $data
	 * @return array
	 */
	protected function process_result( $data ) {
		return array(
			'weather' => $data->weather[0],
			'temp' => $data->main,
			'name' => $data->name,
			'code' => $data->cod
		);
	}
}
