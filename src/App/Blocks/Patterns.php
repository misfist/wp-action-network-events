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
		\add_action( 'init', [ $this, 'register_block_patterns' ] );
		\add_action( 'init', [ $this, 'register_block_pattern_category' ] );
	}

	/**
	 * Register Block Pattern Category
	 * 
	 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-patterns/#register_block_pattern_category
	 *
	 * @return void
	 */
	function register_block_pattern_category() {
		\register_block_pattern_category(
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

		$query_id = uniqid();

		$content = '<!-- wp:group {"className":"events"} -->
		<div class="wp-block-group events"><!-- wp:heading {"placeholder":"Add a Section Heading...","className":"events__heading"} -->
		<h2 class="events__heading"></h2>
		<!-- /wp:heading -->
		
		<!-- wp:paragraph {"placeholder":"Add a short description...","className":"events__description"} -->
		<p class="events__description"></p>
		<!-- /wp:paragraph -->
		
		<!-- wp:query {"queryId":3,"query":{"perPage":3,"pages":0,"offset":0,"postType":"an_event","tagIds":[],"order":"desc","orderBy":"date","inherit":false},"displayLayout":{"type":"flex","columns":3},"className":"events events__detailed"} -->
		<div class="wp-block-query events events__detailed"><!-- wp:post-template {"className":"event"} -->
		<!-- wp:post-title {"isLink":true,"className":"event__title"} /-->
		
		<!-- wp:wp-action-network-events/event-date {"format":"F j, Y","className":"event__date"} /-->
		
		<!-- wp:wp-action-network-events/event-time {"format":"g:i a","className":"event__time"} /-->
		
		<!-- wp:wp-action-network-events/event-location {"className":"event__location"} /-->
		<!-- /wp:post-template --></div>
		<!-- /wp:query --></div>
		<!-- /wp:group -->';

		\register_block_pattern(
			$this->plugin_name . '/events-list-detailed',
				[
					'title'      	=> \_x( 'Events List', 'wp-action-network-events' ),
					'blockTypes' 	=> [ 'core/query', 'core/post-template', 'core/post-title' ],
					'categories' 	=> [ 'query', 'events' ],
					'keywords'		=> [ 'action network', 'events' ],
					'content'    	=> $content,
				]
		); 
	}

}
