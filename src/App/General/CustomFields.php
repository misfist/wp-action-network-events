<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */

declare( strict_types = 1 );

namespace WpActionNetworkEvents\App\General;

use WpActionNetworkEvents\Common\Abstracts\Base;
use WpActionNetworkEvents\App\General\Taxonomies;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Class CustomFields
 *
 * @package WpActionNetworkEvents\App\General
 * @since 0.1.0
 */
class CustomFields extends Base {

	/**
	 * Taxonomy data
	 */
	public const POST_TYPE = [
		'id'       		=> 'event',
		'archive'  		=> 'events',
		'menu'    		=> 'Action Network',
		'title'    		=> 'Events',
		'singular' 		=> 'Event',
		'icon'     		=> 'dashicons-calendar-alt',
		'taxonomies'	=> [ 'event_type' ],
	];

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
		add_action( 'plugins_loaded', 					[ $this, 'load' ] );
		add_action( 'carbon_fields_register_fields', 	[ $this, 'register' ] );
	}

	/**
	 * Load Fields Library
	 *
	 * @return void
	 */
	public function load() {
		\Carbon_Fields\Carbon_Fields::boot();
	}

	/**
	 * Register fields
	 *
	 * @since 0.1.0
	 */
	public function register() {

		$fields = [
			Field::make( 'text', 'name', __( 'Name', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'textarea', 'instructions', __( 'Instructions', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'date_time', 'start_date', __( 'Start', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_classes( 'hidden' ),

			Field::make( 'separator', 'separator', __( 'Location', 'wp-action-network-events' ) ),
			Field::make( 'text', 'location_venue', __( 'Venue', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'text', 'location_address', __( 'Address', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'text', 'location_postal_code', __( 'Postal Code', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'text', 'location_region', __( 'Region', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'text', 'location_country', __( 'Country', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'text', 'location_longitude', __( 'Longitude', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'text', 'location_latitude', __( 'Latitude', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'text', 'location_accuracy', __( 'Accuracy', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'text', 'browser_url', __( 'URL', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true )
				->set_attribute( 'type', 'url' ),

			Field::make( 'text', 'ap_id', __( 'ID', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'date_time', 'modified_date', __( 'Modified Date', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_classes( 'hidden' ),
			Field::make( 'text', 'status', __( 'Status', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
			Field::make( 'text', 'visibility', __( 'Visibility', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', true ),
		];


		Container::make( 'post_meta', __( 'Event Details', 'wp-action-network-events' ) )
			->where( 'post_type', '=', 'event' )
			->set_context( 'advanced' )
			->add_fields( $fields );
	}
}
