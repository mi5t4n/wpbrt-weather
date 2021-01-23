<?php
/**
 * Setting page.
 *
 * @package    WPBRT\Weather
 * @subpackage WPBRT\Weather\Templates
 */
?>

<div class="wrap">
	<h2><?php esc_html_e( 'WPBRT Weather', 'wpbrt-weather' ); ?></h2>

	<form method="post" action="options.php">
	<?php
		/**
		 * Nonces, actions and referrers.
		 */
		settings_fields( 'wpbrt-weather' );
	?>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label>
						<?php esc_html_e( 'Usage:', 'wpbrt-weather' ); ?>
					</label>
				</th>
				<td>
				<?php
					printf(
						esc_html__( 'Use the following shortcode: %s[wpbrt-weather city="london" country="uk" state=""]%s', 'wpbrt-weather' ),
						'<code>',
						'</code>'
					);
				?>
				</td>
			</tr>

			<!-- Weather API Key -->
			<tr>
				<th scope="row">
					<label for="wpbrt_weather_api_key">
						<?php esc_html_e( 'API Key', 'wp-currency-exchange-rate' ); ?>
					</label>
				</th>
				<td>
					<input type="text"
						name="wpbrt_weather_api_key"
						value="<?php echo esc_attr( $api_key ); ?>" />
					<span class="description">
					<?php
						printf(
							'Get your API key %shere%s.',
							'<a href="https://home.openweathermap.org/users/sign_up" target="_blank">',
							'</a>'
						);
					?>
					</span>
				</td>
			</tr>
			<!-- ./ Weather API Key -->
		</tbody>
	</table>

	<?php
		submit_button();
	?>
	</form>
</div>
<?php
