<?php
/**
 * Class form handling the meta of sections.
 *
 * @since      0.1.0
 * @package    Sections
 * @subpackage Sections/includes
 * @link       https://thefancyrobot.com
 * @author     Matthew Schroeter <matt@thefancyrobot.com>
 */

class Sections_Meta {

	/**
	 * The WordPress post ID
	 *
	 * @since   0.1.0
	 * @access  private
	 * @var     int  WordPress post object
	 */
	private $post_id;

	/**
	 * Sections_Meta constructor.
	 *
	 * Sets the post ID of the post we are dealing with
	 *
	 * @since   0.1.0
	 * @param   int  $post_id   WordPress post ID
	 */
	public function __construct( $post_id ) {
		$this->post_id = $post_id;
	}

	/**
	 * Method to retrieve meta key
	 *
	 * @since   0.1.0
	 * @param   string  $key  Meta key to retrieve
	 *
	 * @return  bool|mixed|string
	 */
	public function get_meta( $key ) {
		$field = get_post_meta( $this->post_id, $key, true );
		if ( ! empty( $field ) ) {
			return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		} else {
			return false;
		}
	}

	/**
	 * Method to update post meta
	 *
	 * @since   0.1.0
	 * @param   string  $key    Meta key to update
	 * @param   string  $value  Value to store
	 * @param   string  $sanitize_callback  Not currently used
	 *
	 * @return  bool|mixed|string
	 */
	public function save_meta( $key, $value, $sanitize_callback ) {
		if ( ! empty( $key ) && ! empty( $value ) ) {
			return update_post_meta( $this->post_id, $key, esc_attr( $value ) );
		} else {
			return false;
		}
	}
}