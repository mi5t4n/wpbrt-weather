<?php
/**
 * Class ApiTest
 *
 * @package Wpbrt_Weather
 */

use WPBRT\Weather\Api;

/**
 * Sample test case.
 */
class ApiTest extends WP_UnitTestCase {
	private $api;

	public function setUp() {
		$this->api = new Api();

		\WP_Mock::setUp();
	}

	public function tearDown() {
		\WP_Mock::tearDown();
	}

	public function test_api_key_is_set() {
		$this->api->set_api_key( 'hello' );
		$this->assertAttributeSame('hello', 'api_key', $this->api);
	}

	public function test_fetch_is_successfull() {
		$data = '{"coord":{"lon":-0.1257,"lat":51.5085},"weather":[{"id":721,"main":"Haze","description":"haze","icon":"50n"}],"base":"stations","main":{"temp":276.59,"feels_like":273.45,"temp_min":274.15,"temp_max":278.15,"pressure":1040,"humidity":75},"visibility":2000,"wind":{"speed":1.54,"deg":230},"clouds":{"all":0},"dt":1614393914,"sys":{"type":1,"id":1414,"country":"GB","sunrise":1614408600,"sunset":1614447406},"timezone":0,"id":2643743,"name":"London","cod":200}';

		\WP_Mock::userFunction( 'wp_remote_get', array(
			'times' => 1,
			'args' => 'https://api.openweathermap.org/data/2.5/weather?q=london,,&appid',
			'return' => $data,
		) );

		\WP_Mock::userFunction( 'wp_remote_retrieve_body', array(
			'times' => 1,
			'args' => $data,
			'return' => $data,
		) );

		\WP_Mock::userFunction( 'wp_remote_retrieve_response_code', array(
			'times' => 1,
			'args' => $data,
			'return' => 200,
		) );

		// Test actions are added.
		$api = $this->getMockBuilder( Api::class )
			->setMethods( ['process_result'] )->getMock();
		$api->method( 'process_result' )->willReturn(true);

		$this->assertTrue( $api->fetch( 'london' ), true );
	}

	public function test_fetch_is_unsucessfull() {
		\WP_Mock::userFunction( 'wp_remote_get', array(
			'times' => 1,
			'args' => 'https://api.openweathermap.org/data/2.5/weather?q=london,,&appid',
			'return' => new \WP_Error( 'fetch_error' ),
		) );

		$result = $this->api->fetch( 'london' );
		$this->assertEquals( $result->get_error_code(), 'fetch_error' );
	}


	public function test_when_fetch_response_is_not_200() {
		$data = '{"coord":{"lon":-0.1257,"lat":51.5085},"weather":[{"id":721,"main":"Haze","description":"haze","icon":"50n"}],"base":"stations","main":{"temp":276.59,"feels_like":273.45,"temp_min":274.15,"temp_max":278.15,"pressure":1040,"humidity":75},"visibility":2000,"wind":{"speed":1.54,"deg":230},"clouds":{"all":0},"dt":1614393914,"sys":{"type":1,"id":1414,"country":"GB","sunrise":1614408600,"sunset":1614447406},"timezone":0,"id":2643743,"name":"London","cod":200}';

		$return = array(
			'cod' => 'fetch_is_not_200',
			'message' => 'fetch error'
		);

		\WP_Mock::userFunction( 'wp_remote_get', array(
			'times' => 1,
			'args' => 'https://api.openweathermap.org/data/2.5/weather?q=london,,&appid',
			'return' => $data,
		) );

		\WP_Mock::userFunction( 'wp_remote_retrieve_body', array(
			'times' => 1,
			'args' => $data,
			'return' => json_encode( $return ),
		) );

		\WP_Mock::userFunction( 'wp_remote_retrieve_response_code', array(
			'times' => 1,
			'args' => $data,
			'return' => 400,
		) );

		$result = $this->api->fetch( 'london' );
		$this->assertEquals( $result->get_error_code(), 'fetch_is_not_200' );
	}

	public function test_process_result() {
		$data = '{"coord":{"lon":-0.1257,"lat":51.5085},"weather":[{"id":721,"main":"Haze","description":"haze","icon":"50n"}],"base":"stations","main":{"temp":276.59,"feels_like":273.45,"temp_min":274.15,"temp_max":278.15,"pressure":1040,"humidity":75},"visibility":2000,"wind":{"speed":1.54,"deg":230},"clouds":{"all":0},"dt":1614393914,"sys":{"type":1,"id":1414,"country":"GB","sunrise":1614408600,"sunset":1614447406},"timezone":0,"id":2643743,"name":"London","cod":200}';

		$api = new Api();

		$reflection = new \ReflectionClass( get_class($api) );
		$method = $reflection->getMethod( 'process_result' );
		$method->setAccessible( true );
		$result = $method->invokeArgs( $api, array( json_decode( $data ) ) );

		$this->assertEquals( $result['name'], 'London' );
	}
}
