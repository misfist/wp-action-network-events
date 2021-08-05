<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also src all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://debtcollective.org
 * @since             1.0.0
 * @package           Wp_Action_Network_Events
 *
 * @wordpress-plugin
 * Plugin Name:       WP Action Network Events
 * Plugin URI:        https://github.com/misfist/wp-action-network-events
 * Description:       Sync and display events from Action Network.
 * Version:           1.0.0
 * Author:            Debt Collective
 * Author URI:        https://debtcollective.org
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/lgpl-3.0.txt
 * Text Domain:       wp-action-network-events
 * Domain Path:       /languages
 */
namespace WpActionNetworkEvents;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once( 'vendor/autoload.php' );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
const WPANE_PLUGIN_NAME = 'wp-action-network-events';
const WPANE_PLUGIN_VERSION = '1.0.0';
define( 'WPANE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in src/activator.php
 */
function activate_wp_action_network_events() {
	require_once plugin_dir_path( __FILE__ ) . 'Activator.php';
	__NAMESPACE__ . \Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in src/deactivator.php
 */
function deactivate_wp_action_network_events() {
	require_once plugin_dir_path( __FILE__ ) . 'Deactivator.php';
	__NAMESPACE__ . \Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_action_network_events' );
register_deactivation_hook( __FILE__, 'deactivate_wp_action_network_events' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
// require plugin_dir_path( __FILE__ ) . 'src/Plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function init() {
	$plugin = new \WpActionNetworkEvents\Common\Plugin( WPANE_PLUGIN_VERSION, WPANE_PLUGIN_NAME );
	return $plugin;
}
init();
