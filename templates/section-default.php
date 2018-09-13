<?php
/**
 * Default section template
 *
 * @package     Sections
 * @subpackage  Sections/templates
 * @since       0.1.0
 * @version     1.0
 *
 * Name: Default
 */
?>

<div class="tfr-section" style="background:url(<?php echo esc_url_raw( $section['image_url'] ); ?>)">
	<div class="tfr-section-wrap">
		<h5><?php echo esc_attr( $section['strapline'] ); ?></h5>
		<h3><?php echo esc_attr( $section['heading'] ); ?></h3>
        <?php echo wp_kses_post( do_shortcode( $section['content'] ) ); ?>
	</div>
</div>
