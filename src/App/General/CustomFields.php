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
use WpActionNetworkEvents\App\General\PostTypes;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Helper\Helper;

/**
 * Class CustomFields
 *
 * @package WpActionNetworkEvents\App\General
 * @since 0.1.0
 */
class CustomFields extends Base {

	/**
	 * Metabox Container ID
	 * 
	 * @since 1.0.0
	 */
	public const CONTAINER_ID = 'wp_action_network_fields';

	public const FIELDS = [
		[
			'name'		=> '',
			'label'		=> '',
			'type'		=> '',
			'text_type'	=> null,
			'api_prop'	=> ''
		],
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

		$is_read_only = true;

		$fields = [
			Field::make( 'text', 'name', __( 'Name', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'rich_text', 'instructions', __( 'Instructions', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'browser_url', __( 'URL', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only )
				->set_attribute( 'type', 'url' ),
			Field::make( 'text', 'start_date', __( 'Start', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only )
				->set_classes( 'read-only' ),
			Field::make( 'text', 'accepted', __( 'RSVPd', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'type', 'number' )
				->set_attribute( 'readOnly', $is_read_only ),

			Field::make( 'text', 'total_events', __( 'Total Events', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only )
				->set_attribute( 'type', 'number' ),
			Field::make( 'text', 'total_rsvps', __( 'Total RSVPs', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only )
				->set_attribute( 'type', 'number' ),
			
			Field::make( 'separator', 'separator_host', __( 'Host Details', 'wp-action-network-events' ) ),
			Field::make( 'rich_text', 'host_pitch', __( 'Host Pitch', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'rich_text', 'host_instructions', __( 'Host Instructions', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'host_url', __( 'Host URL', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only )
				->set_attribute( 'type', 'url' ),

			Field::make( 'separator', 'separator_location', __( 'Location Detail', 'wp-action-network-events' ) ),
			Field::make( 'text', 'location_venue', __( 'Venue', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'location_locality', __( 'Locality', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'location_address', __( 'Address', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'location_postal_code', __( 'Postal Code', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'location_region', __( 'Region', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'location_country', __( 'Country', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'location_longitude', __( 'Longitude', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'location_latitude', __( 'Latitude', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'location_accuracy', __( 'Accuracy', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			
			Field::make( 'separator', 'separator_campaign', __( 'Campaign Details', 'wp-action-network-events' ) ),
			Field::make( 'text', 'an_campaign_id', __( 'Campaign ID', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'campaign_events', __( 'Events', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'type', 'url' ),
			Field::make( 'text', 'campaign_type', __( 'Campaign Type', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'total_outreaches', __( 'Total Outreaches', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only )
				->set_attribute( 'type', 'number' ),

			Field::make( 'separator', 'separator_misc', __( 'Misc Details', 'wp-action-network-events' ) ),
			Field::make( 'text', 'an_id', __( 'ID', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'modified_date', __( 'Modified Date', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only )
				->set_classes( 'read-only' ),
			Field::make( 'text', 'status', __( 'Status', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
			Field::make( 'text', 'visibility', __( 'Visibility', 'wp-action-network-events' ) )
				->set_visible_in_rest_api( $visible = true )
				->set_attribute( 'readOnly', $is_read_only ),
		];

		Container::make( 
			'post_meta',
			self::CONTAINER_ID,
			__( 'Event Details', 'wp-action-network-events' ) 
		)
			->where( 'post_type', '=', PostTypes::POST_TYPE['id'] )
			->set_context( 'advanced' )
			->add_fields( $fields );
	}

	public function makeFields() {
		$fields = [];
		foreach( self::FIELDS as $field ) {
			switch( $field) {
				case $field['text_type'] :
					$fields[] = Field::make( $field['type'], $field['name'], __( $field['label'], 'wp-action-network-events' ) )
						->set_visible_in_rest_api( $visible = true )
						->set_attribute( 'readOnly', $is_read_only )
						->set_attribute( 'type', $field['text_type'] );
					break;
				case 'separator' === $field['type'] :
					$fields[] = Field::make( $field['type'], $field['name'], __( $field['label'], 'wp-action-network-events' ) );
					break;
				default :
					$fields[] = Field::make( $field['type'], $field['name'], __( $field['label'], 'wp-action-network-events' ) )
						->set_visible_in_rest_api( $visible = true )
						->set_attribute( 'readOnly', $is_read_only );
					break;
			}
		}
		return $fields;

	}

	public static function getFields() {}
}
