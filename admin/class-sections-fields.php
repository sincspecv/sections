<?php
/**
 * Class for handling the section fields in the page editor.
 *
 * @since      0.1.0
 * @package    Sections
 * @subpackage Sections/includes
 * @link       https://thefancyrobot.com
 * @author     Matthew Schroeter <matt@thefancyrobot.com>
 */

//include_once 'class-sections-admin.php';

class Sections_Fields extends Sections_Admin {

	public function __construct( $plugin_name, $version ) {
	    // Call parent constructor
        parent::__construct( $plugin_name, $version );
    }

    public function section_get_meta( $value ) {
		global $post;

		$field = get_post_meta( $post->ID, $value, true );
		if ( ! empty( $field ) ) {
			return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
		} else {
			return false;
		}
	}

	public function add_meta_box() {
		add_meta_box(
			'section-section',
			__( 'Section', 'section' ),
			array( __CLASS__, 'section_html' ),
			'post',
			'advanced',
			'core'
		);
		add_meta_box(
			'section-section',
			__( 'Section', 'section' ),
			array( __CLASS__, 'section_html' ),
			'page',
			'advanced',
			'core'
		);
	}


	public function section_html( $post) {
		wp_nonce_field( '_section_nonce', 'section_nonce' ); ?>

		<p>
			<label for="section_stripline"><?php _e( 'Stripline', 'section' ); ?></label><br>
			<input type="text" name="section_stripline" id="section_stripline" value="<?php echo self::section_get_meta( 'section_stripline' ); ?>">
		</p>	<p>
			<label for="section_heading"><?php _e( 'Heading', 'section' ); ?></label><br>
			<input type="text" name="section_heading" id="section_heading" value="<?php echo self::section_get_meta( 'section_heading' ); ?>">
		</p>	<p>
			<label for="section_content"><?php _e( 'Content', 'section' ); ?></label><br>
			<textarea name="section_content" id="section_content" ><?php echo self::section_get_meta( 'section_content' ); ?></textarea>

		</p>	<p>
		<label for="section_background_image"><?php _e( 'Background Image', 'section' ); ?></label><br>
		<input type="text" name="section_background_image" id="section_background_image" value="<?php echo self::section_get_meta( 'section_background_image' ); ?>">
		</p><?php
	}

	public function save_meta_box( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( ! isset( $_POST['section_nonce'] ) || ! wp_verify_nonce( $_POST['section_nonce'], '_section_nonce' ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;

		if ( isset( $_POST['section_stripline'] ) )
			update_post_meta( $post_id, 'section_stripline', esc_attr( $_POST['section_stripline'] ) );
		if ( isset( $_POST['section_heading'] ) )
			update_post_meta( $post_id, 'section_heading', esc_attr( $_POST['section_heading'] ) );
		if ( isset( $_POST['section_content'] ) )
			update_post_meta( $post_id, 'section_content', esc_attr( $_POST['section_content'] ) );
		if ( isset( $_POST['section_background_image'] ) )
			update_post_meta( $post_id, 'section_background_image', esc_attr( $_POST['section_background_image'] ) );
	}

}

//add_action( 'add_meta_boxes', 'section_add_meta_box' );
//add_action( 'save_post', 'section_save' );

/*
		Usage: section_get_meta( 'section_stripline' )
		Usage: section_get_meta( 'section_heading' )
		Usage: section_get_meta( 'section_content' )
		Usage: section_get_meta( 'section_background_image' )
	*/
