<?php
/**
 * AJAX functions used by the Sections plugin
 *
 * @since 0.2.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Add sub section to section via ajax call
 *
 * @since 0.2.0
 */
if ( ! function_exists( 'add_sub_section' ) ) {
	function add_sub_section() {
		// Sanitize $_POST data
		$filters = array(
			'section_index' => FILTER_SANITIZE_NUMBER_INT,
			'sub_section_index' => FILTER_SANITIZE_NUMBER_INT,
		);

		$request = filter_input_array( INPUT_POST, $filters );

		//Make sure we have data
		if ( empty( $request ) ) {
			echo null;
			wp_die();
		}

		// Return sub section markup
		echo Sections_Fields::sub_section_html( array(), $request['section_index'], $request['sub_section_index'] );
		wp_die();
	}
	add_action( 'wp_ajax_add_sub_section', 'add_sub_section' );
}
