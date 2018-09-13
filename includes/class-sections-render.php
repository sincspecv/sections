<?php
/**
 * Class that handles printing sections on front end.
 *
 * @since      0.1.0
 * @package    Sections
 * @subpackage Sections/includes
 * @link       https://thefancyrobot.com
 * @author     Matthew Schroeter <matt@thefancyrobot.com>
 */

class Sections_Render {

	/**
	 * The WordPress post ID
	 *
	 * @since   0.1.0
	 * @access  private
	 * @var     int  WordPress post object
	 */
	private $post_id;

	/**
	 * Sections_Render constructor.
	 *
	 * Sets the post ID of the post we are dealing with
	 *
	 * @since   0.1.0
	 */
	public function __construct() {
		global $post;

		if( ! empty( $post ) )
			$this->post_id = is_array( $post ) ? $post['ID'] : $post->ID;
	}

	/**
	 * Gets the meta data for the section and returns in an array
	 *
	 * @since   0.1.0
	 * @param   int $post_id    Post ID
	 *
	 * @return  array
	 */
	public function get_section_meta( $post_id ) {
		$meta = new Sections_Meta( $post_id );

		$section_meta = ! empty( $meta->get_meta( '_sections' ) ) ? $meta->get_meta( '_sections', FALSE ) : array();

		$section_data = apply_filters( 'section_data', $section_meta );

		return $section_data;
	}

	/**
	 * Get the template for the section
	 *
	 * @since   0.1.0
	 * @param   string  $template   Name of template to use
	 *
	 * @return  string
	 *
	 * TODO: Check theme directories for template files
	 */
	public function get_template( $template = 'default' ) {
		$template_file = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/section-' . $template . '.php';

		return $template_file;
	}

	/**
	 * Render the section and add to content
	 *
	 * @since   0.1.0
	 * @param   string  $content    Post content
	 *
	 * @return  string
	 */
	public function section_content( $content ) {
		global $post;

		// The section meta to pass to the section template
		$sections = $this->get_section_meta( $post->ID );

		foreach ( $sections as $section ) {
			// Get the template to use
			$section_template = ! empty( $section['template'] ) ? esc_attr( $section['template'] ) : 'default';
			$template = $this->get_template( $section_template );

			// Create empty markup variable in case there is no section data
			$markup = '';

			// Make sure there is section data
			if( ! $section['strapline'] && ! $section['heading'] && ! $section['content'] && ! $section['background_image'] ) {

				//DO NOTHING

			} else {

				// Render the template with the section meta
				ob_start();

				include $template;
				$markup .= ob_get_contents();

				ob_end_clean();

				// Append sections to content and make images responsive
				$content .= wp_make_content_images_responsive( $markup );

			}
		}

		add_action( 'section_content' );

		return $content;
	}
}