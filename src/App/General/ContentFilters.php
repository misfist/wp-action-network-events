<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */

declare( strict_types = 1 );

namespace WpActionNetworkEvents\App\General;

use WpActionNetworkEvents\Common\Abstracts\Base;
use WpActionNetworkEvents\App\General\PostTypes;

/**
 * Class ContentFilters
 *
 * @package WpActionNetworkEvents\App\General
 * @since 0.1.0
 */
class ContentFilters extends Base {


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
		if( !class_exists( '\CWS_PageLinksTo' ) ) {
			add_filter( 'post_link', 		[ $this, 'modifyEventUrl' ], 10, 2 );
			add_filter( 'post_type_link', 	[ $this, 'modifyEventUrl' ], 10, 2 );
		}

	}

	/**
	 * Change Event URL to Action Network URL
	 * Modify link to Action Network URL; 
	 * Let Page Links To <https://wordpress.org/plugins/page-links-to/> handle this, if it is available
	 *
	 * @param string $url
	 * @param obj $post
	 * @return string $url
	 */
	public function modifyEventUrl( $url, $post ) {
		if( 
			( PostTypes::POST_TYPE['id'] === get_post_type( $post->ID ) ) &&
			( $external_url = get_post_meta( $post->ID, '_browser_url', 'true' ) ) 
		) {
			$url = esc_url( $external_url );
		}
		return $url;
	}


}
