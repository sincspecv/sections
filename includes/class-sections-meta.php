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
	 * The WordPress post object
	 *
	 * @since   0.1.0
	 * @access   private
	 * @var     object  WordPress post object
	 */
	private $post;

	/**
	 * Sections_Meta constructor.
	 *
	 * Sets the post object we are dealing with
	 *
	 * @since   0.1.0
	 * @param   object  $post   WordPress post object
	 */
	public function __construct( $post ) {
		$this->post = $post;
	}

	/**
	 * Method to retrieve meta key
	 *
	 * @since   0.1.0
	 * @param   string    $key    Meta key to retrieve
	 *
	 * @return  bool|mixed|string
	 */
	public function get_meta( $key ) {
		$field = get_post_meta( $this->post->ID, $key, true );
		if ( ! empty( $field ) ) {
			return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		} else {
			return false;
		}
	}
}