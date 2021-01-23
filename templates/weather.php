<?php
/**
 * Weather shortcode template.
 */

 $a = 1;
?>

<div class="wpbrt-weather">
	<span class="wpbrt-weather-icon">
	<?php
		printf(
			'<img src="http://openweathermap.org/img/wn/%s@2x.png" />',
			$data["weather"]->icon
		);
	?>
	</span>

	<span class="wpbrt-weather-city">
		<?php echo esc_html( $data["name"] ); ?> -
	</span>

	<span class="wpbrt-weather-description">
		<?php echo esc_html( $data["weather"]->main ); ?>,
	</span>

	<span class="wpbrt-weather-description">
		<?php echo esc_html( $data["temp"]->temp ); ?>
	</span>


</div>
