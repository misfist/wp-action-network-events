<?php

/**
 * The plugin options.
 *
 * @link       https://debtcollective.org
 * @since      1.0.0
 *
 * @package    Wp_Action_Network_Events
 * @subpackage Wp_Action_Network_Events/admin
 */
declare(strict_types=1);

namespace WpActionNetworkEvents\App\Admin;

use WpActionNetworkEvents\Common\Abstracts\Base;

/**
 * Plugin Options
 *
 *
 * @package    Wp_Action_Network_Events
 * @subpackage Wp_Action_Network_Events/admin
 * @author     Debt Collective <pea@misfist.com>
 */
class Options extends Base {

	/**
	 * Name of options field
	 * 
	 * @var string
	 */
	const OPTIONS_NAME = 'wp_action_network_events_options';

	/**
	 * ID of Options page
	 *
	 * @var string
	 */
	protected $options_page_name = 'options-wp-action-network-events';

	/**
	 * Plugin Options
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * Available Event Types
	 *
	 * @var array
	 */
	protected $eventTypeOptions = [];

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version, $plugin_name ) {
		parent::__construct( $version, $plugin_name );
		$this->init();
	}

	/**
	 * Initialize the class.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		/**
		 * This general class is always being instantiated as requested in the Bootstrap class
		 *
		 * @see Bootstrap::__construct
		 *
		 */
		$this->setOptions();
		\add_action( 'admin_menu', 			array( $this, 'addAdminMenu' ) );
		\add_action( 'admin_notices', 		array( $this, 'renderAdminNotices' ) );
		\add_action( 'admin_init', 			array( $this, 'initSettings'  ) );
		\add_filter( 'plugin_action_links_' . WPANE_PLUGIN_BASENAME, array( $this, 'addSettingsLink' ), 10, 5 );

		$this->eventTypeOptions = apply_filters( 
			__NAMESPACE__ . '\Options\eventTypeOptions',
			[
				'events'			=> \esc_attr__( 'Events', 'wp-action-network-events' ),
			]
		);
	}

	/**
	 * Add Admin Menu
	 *
	 * @return void
	 */
	public function addAdminMenu() {

		\add_options_page(
			\esc_html__( 'Action Network Events Settings', 'wp-action-network-events' ),
			\esc_html__( 'Action Network Events', 'wp-action-network-events' ),
			'activate_plugins',
			$this->options_page_name,
			array( $this, 'renderPage' )
		);

		add_submenu_page( 
			'edit.php?post_type=event', 
			\esc_html__( 'Action Network Events Settings', 'wp-action-network-events' ),
			\esc_html__( 'Settings', 'wp-action-network-events' ),
			'activate_plugins',
			$this->options_page_name,
			array( $this, 'renderPage' )
		);

	}

	/**
	 * Add Settings Link to Plugins Page
	 * 
	 * @see https://developer.wordpress.org/reference/hooks/plugin_action_links_plugin_file/
	 *
	 * @param array $actions
	 * @param string $plugin_file
	 * @return array $actions
	 */
	function addSettingsLink( array $actions ) : array {
		$link = array( 
			'settings' => sprintf( 
				'<a href="%s">%s</a>',
				esc_url( "options-general.php?page={$this->options_page_name}" ),
				esc_attr__( 'Settings', 'wp-action-network-events' )
			),
		);
			
		return array_merge( $link, $actions );
	}

	/**
	 * Render Notices on Options page
	 *
	 * @return void
	 */
	public function renderAdminNotices() {
		$screen = get_current_screen();
		// Only render this notice in the post editor.
		if ( ! $screen || "settings_page_{$this->options_page_name}" !== $screen->base ) {
			return;
		}

		?>
		<div class="notice notice-info is-dismissible">
			<p><?php _e( 'Manual Sync Button Coming Soon!', 'wp-action-network-events' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Register Settings & Fields
	 *
	 * @return void
	 */
	public function initSettings() {

		\register_setting(
			'wp_action_network_events_options',
			'wp_action_network_events_options'
		);

		\add_settings_section(
			'wp_action_network_events_options_section',
			'',
			false,
			'wp_action_network_events_options'
		);

		\add_settings_field(
			'base_url',
			\__( 'Action Network Base URL', 'wp-action-network-events' ),
			array( $this, 'renderBaseUrlField' ),
			'wp_action_network_events_options',
			'wp_action_network_events_options_section'
		);
		\add_settings_field(
			'api_key',
			\__( 'Action Network API Key', 'wp-action-network-events' ),
			array( $this, 'renderApiKeyField' ),
			'wp_action_network_events_options',
			'wp_action_network_events_options_section'
		);
		\add_settings_field(
			'event_types',
			\__( 'Event Types', 'wp-action-network-events' ),
			array( $this, 'renderEventTypesField' ),
			'wp_action_network_events_options',
			'wp_action_network_events_options_section'
		);
		\add_settings_field(
			'sync_frequency',
			\__( 'Frequency', 'wp-action-network-events' ),
			array( $this, 'renderFrequencyField' ),
			'wp_action_network_events_options',
			'wp_action_network_events_options_section'
		);

	}

	/**
	 * Render Settings Page
	 *
	 * @return void
	 */
	public function renderPage() {

		// Check required user capability
		if ( !current_user_can( 'activate_plugins' ) )  {
			\wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'wp-action-network-events' ) );
		}

		echo '<div class="wrap">' . "\n";
		echo '	<h1>' . \get_admin_page_title() . '</h1>' . "\n";
		echo '	<form action="options.php" method="post">' . "\n";

		\settings_fields( 'wp_action_network_events_options' );
		\do_settings_sections( 'wp_action_network_events_options' );
		\submit_button();

		echo '	</form>' . "\n";
		echo '</div>' . "\n";

	}

	/**
	 * Render Field
	 *
	 * @return void
	 */
	function renderBaseUrlField() {

		$value = isset( $this->options['base_url'] ) ? $this->options['base_url'] : esc_url( 'https://actionnetwork.org/api/v2/' );

		echo '<input type="url" name="wp_action_network_events_options[base_url]" class="regular-text base_url_field" placeholder="' . esc_attr__( '', 'wp-action-network-events' ) . '" value="' . esc_attr( $value ) . '">';

	}

	/**
	 * Render Field
	 *
	 * @return void
	 */
	function renderApiKeyField() {

		// $options = \get_option( 'wp_action_network_events_options' );

		$value = isset( $this->options['api_key'] ) ? $this->options['api_key'] : '';

		echo '<input type="text" name="wp_action_network_events_options[api_key]" class="regular-text api_key_field" placeholder="' . esc_attr__( '', 'wp-action-network-events' ) . '" value="' . esc_attr( $value ) . '">';

	}

	/**
	 * Render Field
	 *
	 * @return void
	 */
	function renderEventTypesField() {

		// $options = \get_option( 'wp_action_network_events_options' );

		$event_types = isset( $this->options['event_types'] ) ? $this->options['event_types'] : '';

		echo '<select name="wp_action_network_events_options[event_types][]" class="event_types_field" multiple=multiple>';
		echo '	<option value="">' . __( 'Select Event Types', 'wp-action-network-events' ) . '</option>';

		foreach( $this->eventTypeOptions as $key => $value ) {
			printf(
				'<option value="%s" %s>%s</option>',
				esc_attr( $key ),
				selected( true, in_array( $key, $event_types ), false ), 
				esc_attr( $value )
			);
		}

		echo '</select>';
		echo '<p class="description">' . __( 'Select the type of events to sync and display.', 'wp-action-network-events' ) . '</p>';

	}

	/**
	 * Render Field
	 *
	 * @return void
	 */
	function renderFrequencyField() {

		// $options = \get_option( 'wp_action_network_events_options' );

		$value = isset( $this->options['sync_frequency'] ) ? $this->options['sync_frequency'] : (int) 24;

		printf( 
			'<input type="number" name="wp_action_network_events_options[sync_frequency]" class="regular-text sync_frequency_field" placeholder="%s" value="%s"> %s',
			esc_attr__( '', 'wp-action-network-events' ),
			esc_attr( $value ),
			esc_attr__( 'hours', 'wp-action-network-events' ),
		);
		echo '<p class="description">' . __( 'Select the frequency with which to sync events.', 'wp-action-network-events' ) . '</p>';

	}

	/**
	 * Set Event Types
	 * Event Type options that will be displayed on the options page
	 *
	 * @param array $types
	 * @return void
	 */
	public function setEventTypeOptions( array ...$types ) : array {
		// $this->types = $types;
		$this->eventTypeOptions = array_push( $types );
	}

	/**
	 * Get Event Types
	 *
	 * @return void
	 */
	public static function getEventTypeOptions() : array {
		return $this->eventTypeOptions;
	}

	/**
	 * Add Event Types
	 * Add Event Types to options
	 *
	 * @param array $types
	 * @return array $types
	 */
	public static function registerEventTypeOptions( array $types ) : array {
		$this->setEventTypeOptions( $types );
	}

	/**
	 * Get Options
	 * 
	 * @see https://developer.wordpress.org/reference/functions/get_option/
	 *
	 * @return mixed array || false
	 */
	static function getOptions() {
		return \get_option( self::OPTIONS_NAME );
	}

	/**
	 * Set options
	 *
	 * @return void
	 */
	function setOptions() {
		$this->options = self::getOptions();
	}
}
