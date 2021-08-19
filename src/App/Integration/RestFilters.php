<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */

declare( strict_types = 1 );

namespace WpActionNetworkEvents\App\Integration;

use WpActionNetworkEvents\Common\Abstracts\Base;
use WpActionNetworkEvents\App\General\PostTypes;

/**
 * Class RestFilters
 *
 * @package WpActionNetworkEvents\App\Integration
 * @since 1.0.0
 */
class RestFilters extends Base {

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
		 * Add plugin code here
		 */

		\add_filter( 'rest_query_vars', 											[ $this, 'rest_query_vars' ] );
		\add_filter( 'rest_' . PostTypes::POST_TYPE['id'] . '_query', 				[ $this, 'rest_query' ], 10, 2 );
		\add_filter( 'rest_' . PostTypes::POST_TYPE['id'] . '_collection_params', 	[ $this, 'rest_collection_params' ], 10, 2 );

	}

	/**
	 * Add rest query variables
	 *
	 * @param array $current_vars
	 * @return array
	 */
	function rest_query_vars( $current_vars ) {
		$current_vars = array_merge( $current_vars, array( 'meta_key', 'meta_value' ) );
		return $current_vars;
	}

	/**
	 * Modify query
	 * 
	 * @see https://developer.wordpress.org/reference/hooks/rest_this-post_type_query/
	 *
	 * @param array $params
	 * @param obj $request
	 * @return array $params
	 */
	function rest_query( $params, $request ) {
		if ( isset( $request['meta_key'] ) && !empty( $request['meta_key'] ) ) {
			$params['meta_key'] = $request['meta_key'];
		}
		return $params;
	}

	/**
	 * Register collection parameters
	 * 
	 * 
	 * @see https://developer.wordpress.org/reference/hooks/rest_this-post_type_collection_params/
	 *
	 * @param array $params
	 * @param string $post_type
	 * @return void
	 */
	function rest_collection_params( $params, $post_type ) {
		array_push( $params['orderby']['enum'], 'meta_value' );
		return $params;
	}
}
