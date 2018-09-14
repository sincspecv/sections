<?php
/**
 * AJAX functions used by the Sections plugin
 *
 * @since      0.2.0
 * @package    Sections
 * @subpackage Sections/includes
 * @link       https://thefancyrobot.com
 * @author     Matthew Schroeter <matt@thefancyrobot.com>
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Add sub section to section via AJAX request
 *
 * @return string   Sub Section HTML
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
			wp_die();
		}

		// Add wp_die to end of sub section html to get rid of 0 returned by WordPress
		add_action( 'after_sub_section_html', 'wp_die' );

		// Return sub section markup
		return Sections_Fields::sub_section_html( array(), $request['section_index'], $request['sub_section_index'] );
	}
	add_action( 'wp_ajax_add_sub_section', 'add_sub_section' );
}
