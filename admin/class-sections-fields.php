<?php
/**
 * Class for handling the section fields in the page editor.
 *
 * @since      0.1.0
 * @package    Sections
 * @subpackage Sections/admin
 * @link       https://thefancyrobot.com
 * @author     Matthew Schroeter <matt@thefancyrobot.com>
 */

class Sections_Fields extends Sections_Admin {

	public function __construct( $plugin_name, $version ) {
	    // Call parent constructor
        parent::__construct( $plugin_name, $version );
    }

	/**
	 * Add section meta box to pages and posts
     *
     * @since 0.1.0
	 */
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

	/**
     * Markup for the meta fields
     *
     * @since 0.1.0
	 * @param $post
     *
     * TODO: Show background image when selected
     * TODO: Allow removal of background image
	 */
	public function section_html( $post ) {
	    $meta = new Sections_Meta( $post->ID );
		wp_nonce_field( '_section_nonce', 'section_nonce' );

		$sections = !empty( $meta->get_meta( '_sections' ) ) ? $meta->get_meta( '_sections' ) : array( '_sections' );
		$count = count( $sections );
		for ( $i = 0; $i < $count; $i++ ) :

        $strapline  = isset( $sections[$i]['strapline'] ) ? $sections[$i]['strapline'] : '';
		$heading    = isset( $sections[$i]['heading'] ) ? $sections[$i]['heading'] : '' ;

        ?>

		<p>
			<label for="section_strapline"><?php _e( 'Strapline', 'sections' ); ?></label><br>
			<input class="full-width" type="text" name="_sections[<?=$i?>][strapline]" id="section_strapline" value="<?php echo esc_attr( $strapline ); ?>">
		</p>	<p>
			<label for="section_heading"><?php _e( 'Heading', 'sections' ); ?></label><br>
			<input class="full-width" type="text" name="_sections[<?=$i?>][heading]" id="section_heading" value="<?php echo esc_attr( $heading ); ?>">
		</p>	<p>
			<label for="section_content"><?php _e( 'Content', 'sections' ); ?></label><br>

            <?php
            // WYSIWYG editor for content
            $section_content = $meta->get_meta( '_section_content' );
            wp_editor( htmlspecialchars_decode( $section_content ), 'section_content', $settings = array('textarea_name'=>'_section_content') );
            ?>

		</p>
        <p style="text-align:right;width:100%;">
        <?php
            // Determine if there is an image selected
            $image_url = ! empty( $meta->get_meta( '_section_background_image' ) ) ? esc_url_raw( $meta->get_meta( '_section_background_image' ) ) : '';
            $button_text = ! empty( $image_url ) ? 'Replace Background Image' : 'Add Background Image';
        ?>
            <input type="hidden" name="_section_background_image" id="section_background_image" value="<?php echo $image_url; ?>">
            <a href="" class="button button-primary button-large bg-image-button"><?php _e( $button_text, 'sections' ); ?></a>
        </p>

        <?php
        endfor;

	}

	/**
     * Save the meta data
     *
     * @since 0.1.0
	 * @param $post_id
	 */
	public function save_meta_box( $post_id ) {
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		if ( ! isset( $_POST['section_nonce'] ) || ! wp_verify_nonce( $_POST['section_nonce'], '_section_nonce' ) ) return;
		if ( ! current_user_can( 'edit_post', $post_id ) ) return;

		$meta = new Sections_Meta( $post_id );

//		var_dump($_POST);

		if( isset( $_POST['_sections'] ) )
		    $meta->save_meta( '_sections', $_POST['_sections'] );
		if ( isset( $_POST['_section_strapline'] ) )
		    $meta->save_meta( '_section_strapline', $_POST['_section_strapline'] );
		if ( isset( $_POST['_section_heading'] ) )
		    $meta->save_meta( '_section_heading', $_POST['_section_heading'] );
		if ( isset( $_POST['_section_content'] ) )
		    $meta->save_meta( '_section_content', $_POST['_section_content'] );
		if ( isset( $_POST['_section_background_image'] ) )
		    $meta->save_meta( '_section_background_image', $_POST['_section_background_image'] );
	}

}

