<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */

declare( strict_types = 1 );

namespace WpActionNetworkEvents\App\General\Taxonomies;

use WpActionNetworkEvents\Common\Abstracts\Base;
use WpActionNetworkEvents\App\General\Taxonomies\EventType;

/**
 * Class Taxonomies
 *
 * @package WpActionNetworkEvents\App\General
 * @since 0.1.0
 */
class Taxonomies extends Base {

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
		new EventType( $this->version, $this->plugin_name );

		new EventTag( $this->version, $this->plugin_name );

	}

}
