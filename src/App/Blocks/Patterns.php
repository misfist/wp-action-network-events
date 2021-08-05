<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */

declare( strict_types = 1 );

namespace WpActionNetworkEvents\App\Blocks;

use WpActionNetworkEvents\Common\Abstracts\Base;

/**
 * Class Patterns
 *
 * @package WpActionNetworkEvents\App\General
 * @since 1.0.0
 */
class Patterns extends Base {

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
		\add_action( 'init', [ $this, 'register_block_pattern_category' ] );
		\add_action( 'init', [ $this, 'register_block_patterns' ] );
	}

	/**
	 * Register Block Pattern Category
	 * 
	 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-patterns/#register_block_pattern_category
	 *
	 * @return void
	 */
	function register_block_pattern_category() {
		register_block_pattern_category(
			'events',
			[ 
				'label' => __( 'Events', 'wp-action-network-events' ) 
			]
		);
	}
	   
	/**
	 * Register Block Patterns
	 * 
	 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-patterns/
	 *
	 * @return void
	 */
	public function register_block_patterns() {
		// $patterns = [
		// 	[
		// 		$this->plugin_name . '/events-list-detailed',
		// 		array(
		// 			'title'      => _x( 'Events List - Detailed', 'wp-action-network-events' ),
		// 			'blockTypes' => array( 'core/query' ),
		// 			'categories' => array( 'query' ),
		// 			'content'    => '<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"an_event","categoryIds":[],"tagIds":[],"order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"displayLayout":{"type":"flex","columns":3}} -->
		// 							<div class="wp-block-query">
		// 							<!-- wp:post-template -->
		// 							<!-- wp:group {"style":{"spacing":{"padding":{"top":"30px","right":"30px","bottom":"30px","left":"30px"}}},"layout":{"inherit":false}} -->
		// 							<div class="wp-block-group" style="padding-top:30px;padding-right:30px;padding-bottom:30px;padding-left:30px"><!-- wp:post-title {"isLink":true} /-->
		// 							<!-- wp:post-excerpt /-->
		// 							<!-- wp:post-date /--></div>
		// 							<!-- /wp:group -->
		// 							<!-- /wp:post-template -->
		// 							</div>
		// 							<!-- /wp:query -->',
		// 		)
		// 	]
		// ];

		// foreach( $patterns as $name => $details ) {
		// 	\register_block_pattern(
		// 		$name,
		// 		$details
		// 	);
		// }
		\register_block_pattern(
			$this->plugin_name . '/events-list-detailed',
				array(
					'title'      => _x( 'Events List - Detailed', 'wp-action-network-events' ),
					'blockTypes' => array( 'core/query' ),
					'categories' => array( 'query' ),
					'content'    => '<!-- wp:query {"query":{"perPage":3,"pages":1,"offset":0,"postType":"an_event","categoryIds":[],"tagIds":[],"order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"displayLayout":{"type":"flex","columns":3}} -->
									<div class="wp-block-query">
									<!-- wp:post-template -->
									<!-- wp:group {"layout":{"inherit":false}} -->
									<div class="wp-block-group"><!-- wp:post-title {"isLink":true} /-->
									<!-- wp:post-featured-image /-->
									<!-- wp:post-excerpt /--></div>
									<!-- /wp:group -->
									<!-- /wp:post-template -->
									</div>
									<!-- /wp:query -->',
				)
		); 
	}

}
