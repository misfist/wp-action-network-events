<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */
declare( strict_types = 1 );

namespace WpActionNetworkEvents\App\Integration;

use WpActionNetworkEvents\Common\Abstracts\GetData;

/**
 * Class GetData
 *
 * @package WpActionNetworkEvents\App\General
 * @since 0.1.0
 */
class GetEvents extends GetData {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $endpoint = 'events', $types = [], $args = [] ) {
		$this->endpoint = $endpoint;
		$this->types = [
			$this->endpoint	=> \__( 'Events', 'wp-action-network-events' )
		];
		$this->args = $args;
		parent::__construct( $this->endpoint, $this->types, $this->args );
	}

	/**
	 * Initialize the class.
	 *
	 * @since 0.1.0
	 */
	// public function init() {
	// 	/**
	// 	 * This general class is always being instantiated as requested in the Bootstrap class
	// 	 *
	// 	 * @see Bootstrap::__construct
	// 	 *
	// 	 */

	// }

}
