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
	 * @param   string  $key                Meta key to retrieve
	 * @param   mixed   $sanitize_callback  Function to sanitize data. Set to FALSE to not sanitize data
	 * @param   bool    $single             Is meta key unique
	 *
	 * @return  bool|mixed|string
	 */
	public function get_meta( $key, $sanitize_callback = 'esc_attr', $single = TRUE ) {
		$value = get_post_meta( $this->post_id, $key, $single );
		if ( ! empty( $value ) ) {
			if ( FALSE !== $sanitize_callback ) {
				return is_array( $value ) ? map_deep( $value, $sanitize_callback ) : call_user_func( $sanitize_callback, $value );
			} else {
				return $value;
			}
		} else {
			return false;
		}
	}

	/**
	 * Method to update post meta
	 *
	 * @since   0.1.0
	 * @param   string  $key                Meta key to update
	 * @param   string  $value              Value to store
	 * @param   mixed   $sanitize_callback  Function to sanitize data
	 *
	 * @return  bool|mixed|string
	 */
	public function save_meta( $key, $value, $sanitize_callback = null ) {
		if ( ! empty( $key ) && ! empty( $value ) ) {

			// Sanitize data per user defined function
			if ( ! empty( $sanitize_callback )  && FALSE !== $sanitize_callback ) {
				$value = is_array( $value ) ? map_deep( $value, $sanitize_callback ) : call_user_func( $sanitize_callback, $value );
			}
			return update_post_meta( $this->post_id, $key, $value );
		} else {
			return false;
		}
	}
}