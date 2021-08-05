<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */

declare( strict_types = 1 );

namespace WpActionNetworkEvents\App\General\Taxonomies;

use WpActionNetworkEvents\Common\Abstracts\Taxonomy;

/**
 * Class Taxonomies
 *
 * @package WpActionNetworkEvents\App\General
 * @since 0.1.0
 */
class EventType extends Taxonomy {

	/**
	 * Taxonomy data
	 */
	public const TAXONOMY = [
		'id'       		=> 'event_type',
		'archive'  		=> 'types',
		'title'    		=> 'Event Types',
		'singular' 		=> 'Event Type',
		'menu'			=> 'Types',
		'icon'     		=> 'dashicons-calendar-alt',
		'post_types' 	=> [ 'an_event' ],
		'rest'			=> 'event-types'
	];

}
