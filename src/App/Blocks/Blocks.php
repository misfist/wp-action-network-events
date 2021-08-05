<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */

declare( strict_types = 1 );

namespace WpActionNetworkEvents\App\Blocks;

use WpActionNetworkEvents\Common\Abstracts\Base;
use WpActionNetworkEvents\App\Blocks\Patterns;
use WpActionNetworkEvents\App\Blocks\Fields\Fields;

/**
 * Class Blocks
 *
 * @package WpActionNetworkEvents\App\General
 * @since 1.0.0
 */
class Blocks extends Base {

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
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This general class is always being instantiated as requested in the Bootstrap class
		 *
		 * @see Bootstrap::__construct
		 *
		 */
		new Patterns( $this->version, $this->plugin_name );
		new Fields( $this->version, $this->plugin_name );
	}

}
