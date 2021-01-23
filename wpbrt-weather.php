<?php
/**
 * Plugin Name:     WPBRT Weather
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     WordPress weather plugin.
 * Author:          WPBRT
 * Author URI:      YOUR SITE HERE
 * Text Domain:     wpbrt-weather
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         WPBRT\Weather
 */

use WPBRT\Weather\Weather;

defined( 'ABSPATH' ) || exit;

define( 'WPBRT_WEATHER_FILE', __FILE__ );
define( 'WPBRT_WEATHER_DIR', dirname( __FILE__ ) );
define( 'WPBRT_WEATHER_VERSION', '0.1.0' );

require_once dirname( __FILE__ ) . '/vendor/autoload.php';

function WPBRT_WEATHER() {
	return Weather::instance();
}

WPBRT_WEATHER();

