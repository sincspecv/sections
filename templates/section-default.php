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

<div class="tfr-section" style="background:url(<?php echo $image_url; ?>)">
	<div class="tfr-section-wrap">
		<h5><?php echo $strapline; ?></h5>
		<h3><?php echo $heading; ?></h3>
        <?php echo $content; ?>
	</div>
</div>