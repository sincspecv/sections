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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

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
	 */
	public static function section_html( $post ) {
	    $meta = new Sections_Meta( $post->ID );
		wp_nonce_field( '_section_nonce', 'section_nonce' );

		$sections = ! empty( $meta->get_meta( '_sections' ) ) ? $meta->get_meta( '_sections', FALSE ) : array( '_sections' );
		$count = count( $sections );

		// Build out the meta boxes
		for ( $i = 0; $i < $count; $i++ ) :

            $section = $sections[$i];

		    // Escape meta data
            $strapline  = isset( $section['strapline'] ) ? $section['strapline'] : '';
            $heading    = isset( $section['heading'] ) ? $section['heading'] : '' ;
            $content    = isset( $section['content'] ) ? $section['content'] : '';
            $image_url  = isset( $section['image_url'] ) ? $section['image_url'] : '';

            ?>

            <p>
                <label for="section_strapline"><?php _e( 'Strapline', 'sections' ); ?></label><br>
                <input class="full-width" type="text" name="_sections[<?php echo absint( $i ); ?>][strapline]" id="section_strapline_<?php echo absint( $i); ?>" value="<?php echo esc_attr( $strapline ); ?>">
            </p>
            <p>
                <label for="section_heading"><?php _e( 'Heading', 'sections' ); ?></label><br>
                <input class="full-width" type="text" name="_sections[<?php echo absint( $i ); ?>][heading]" id="section_heading_<?php echo absint( $i ); ?>" value="<?php echo esc_attr( $heading ); ?>">
            </p>
            <p>
                <label for="section_content"><?php _e( 'Content', 'sections' ); ?></label><br>

                <?php
                // WYSIWYG editor for content
                $content = do_shortcode( $content );
                $content = wp_kses_post( $content );
                wp_editor( htmlspecialchars_decode( $content ), 'section_content', array('textarea_name' => "_sections[{$i}][content]") );
                ?>

            </p>
            <div style="text-align:right;width:100%;display:inline-block;">
            <?php
                // Determine if there is an image selected
                $button_text        = ! empty( $image_url ) ? 'Replace Section Image' : 'Add Section Image';
                $show_remove_button = ! empty( $image_url ) ? 'inline-block' : 'none';

            ?>
                <div id="section_image_<?php echo absint( $i ); ?>" style="display:inline-block;float:left;max-width:50%;">
                    <img src="<?php echo esc_url_raw( $image_url ) ?>" style="max-width: 100%;">
                </div>
                <input type="hidden" name="_sections[<?php echo absint( $i ); ?>][image_url]" id="section_image_src_<?php echo absint( $i ); ?>" value="<?php echo esc_url_raw( $image_url ); ?>">
                <a href="javascript:void(0)" class="button button-primary button-large image_button" id="image_button_<?php echo absint( $i );?>" data-index="<?php echo absint( $i ); ?>"><?php esc_attr_e( $button_text, 'sections' ); ?></a><br />
                <a href="javascript:void(0)" class="button button-secondary button-large remove-image-button" id="remove_image_button_<?php echo absint( $i ); ?>" data-index="<?php echo absint( $i ); ?>" style="display:<?php echo esc_attr( $show_remove_button ); ?>;margin-top: 0.75rem;"><?php _e( 'Remove Image', 'sections' ); ?></a>
            </div>

            <?php

            // Print sub section boxes
			$sub_sections = isset( $section['sub_sections'] ) ? $section['sub_sections'] : array();
			$sub_section_count = count( $sub_sections );

			for ( $x = 0; $x < $sub_section_count; $x++ ) {
			    self::sub_section_html( $sub_sections[$x], $i, $x );
            }
        endfor;

	}

	/**
	 * Markup for the sub section fields
	 *
	 * @since 0.2.0
	 * @param $post
     *
     * @return mixed
	 */
	public static function sub_section_html( $section, $section_index, $sub_section_index ) {
		// Make sure there are sub sections before printing
//        if( ! isset( $section['sub_sections'] ) || count( $section['sub_sections'] ) <= 0 ) {
//            return null;
//        }
//
//		$sub_sections = $section['sub_sections'];
//		$count = count( $sub_sections );
//
//		// Build out the meta boxes
//		for ( $i = 0; $i < $count; $i++ ) :

			// Escape meta data
			$strapline  = isset( $section['strapline'] ) ? $section['strapline'] : '';
			$heading    = isset( $section['heading'] ) ? $section['heading'] : '' ;
			$content    = isset( $section['content'] ) ? $section['content'] : '';
			$image_url  = isset( $section['image_url'] ) ? $section['image_url'] : '';

			?>

            <p>
                <label for="section_strapline"><?php _e( 'Strapline', 'sections' ); ?></label><br>
                <input class="full-width" type="text" name="_sections[<?php echo absint( $section_index ); ?>][sub_sections][<?php echo absint( $sub_section_index ); ?>][strapline]" id="sub_section_strapline_<?=$i?>" value="<?php echo esc_attr( $strapline ); ?>">
            </p>

            <p>
                <label for="section_heading"><?php _e( 'Heading', 'sections' ); ?></label><br>
                <input class="full-width" type="text" name="_sections[<?php echo absint( $section_index ); ?>][sub_sections][<?php echo absint( $sub_section_index ); ?>][heading]" id="sub_section_heading_<?=$i?>" value="<?php echo esc_attr( $heading ); ?>">
            </p>

            <p>
                <label for="section_content"><?php _e( 'Content', 'sections' ); ?></label><br>

                <?php
                // WYSIWYG editor for content
                $content = do_shortcode( $content );
                $content = wp_kses_post( $content );
                wp_editor( htmlspecialchars_decode( $content ), 'section_content', array('textarea_name' => "_sections[{$section_index}][sub_sections][{$sub_section_index}][content]") );
                ?>

            </p>
            <div style="text-align:right;width:100%;display:inline-block;">
				<?php
				// Determine if there is an image selected
				$button_text        = ! empty( $image_url ) ? 'Replace Section Image' : 'Add Section Image';
				$show_remove_button = ! empty( $image_url ) ? 'inline-block' : 'none';

				?>
                <div id="sub_section_image" style="display:inline-block;float:left;max-width:50%;">
                    <img src="<?php echo esc_url_raw( $image_url ) ?>" style="max-width: 100%;">
                </div>
                <input type="hidden" name="_sections[<?php echo absint( $section_index ); ?>][sub_sections][<?php echo absint( $sub_section_index ); ?>][image_url]" id="sub_section_image_src" data-index="<?php echo absint( $sub_section_index ); ?>" value="<?php echo esc_url_raw( $image_url ); ?>">
                <a href="" class="button button-primary button-large bg-image-button"><?php esc_attr_e( $button_text, 'sections' ); ?></a><br />
                <a href="" class="button button-secondary button-large remove-image-button" style="display:<?php echo esc_attr( $show_remove_button ); ?>;margin-top: 0.75rem;"><?php _e( 'Remove Image', 'sections' ); ?></a>
            </div>

		<?php
//		endfor;

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

		if( isset( $_POST['_sections'] ) )
		    $meta->save_meta( '_sections', $_POST['_sections'], 'stripslashes_deep' );
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

