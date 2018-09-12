<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://thefancyrobot.com
 * @since             0.1.0
 * @package           Sections
 *
 * @wordpress-plugin
 * Plugin Name:       Sections
 * Plugin URI:        https://thefancyrobot.com
 * Description:       Allows you to build pages in a modular way, without the overhead of a typical page builder plugin
 * Version:           0.1.0
 * Author:            Matthew Schroeter
 * Author URI:        https://thefancyrobot.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sections
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TFR_SECTIONS_VERSION', '0.1.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sections-activator.php
 */
function activate_sections() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sections-activator.php';
	Sections_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sections-deactivator.php
 */
function deactivate_sections() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sections-deactivator.php';
	Sections_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sections' );
register_deactivation_hook( __FILE__, 'deactivate_sections' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sections.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_sections() {

	$plugin = new Sections();
	$plugin->run();

}
run_sections();
