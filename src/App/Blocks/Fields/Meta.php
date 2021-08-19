<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */

declare( strict_types = 1 );

namespace WpActionNetworkEvents\App\Blocks\Fields;

use Carbon_Fields\Block;
use Carbon_Fields\Field;
use WpActionNetworkEvents\Common\Abstracts\Base;

/**
 * Class Meta
 *
 * @package WpActionNetworkEvents\App\General
 * @since 1.0.0
 */
class Meta extends Base {

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
	 * Register Blocks
	 *
	 * @return void
	 */
	public function register() {
		$query_id = \uniqid();

		$template = [
			[ 'core/heading', [
				'level'			=> 2,
				'placeholder'	=> __( 'Add a Section Header...', 'wp-action-network-events' ),
				'className'		=> 'section-heading'
			], [] ],
			[ 'core/paragraph', [
				'placeholder'	=> __( 'Add a section description...', 'wp-action-network-events' ),
				'className'		=> 'section-description'
			], [] ],
			[ 'core/query', [
				'query'			=> [
					'queryId'	=> $query_id,
					'postType'	=> 'an_event',
					'perPage'	=> 3,
					'inherit'	=> false,
					'orderBy'	=> 'meta_value',
					'metaKey'	=> '_start_date'
				],
				'displayLayout'	=> [
					'type'		=> 'flex',
					'columns'	=> 3
				]
			], [
				[ 'core/post-template', [], [
					[ 'core/post-title', [
						'isLink'		=> true,
						'className'		=> 'event-title'
					], [] ],
					[ 'wp-action-network-events/event-date', [ 
						'attributes' => [ 
							'format' => 'F j, Y' 
						] 
					], [] ],
					[ 'wp-action-network-events/event-time', [ 
						'attributes' => [ 
							'format' => 'g:i a' 
						] 
					], [] ],
					[ 'wp-action-network-events/event-location', [], [] ]
				] ]
			] ],
		];

		// {\"query\":{\"perPage\":3,\"pages\":0,\"offset\":0,\"postType\":\"an_event\",\"tagIds\":[],\"order\":\"desc\",\"orderBy\":\"date\",\"inherit\":false},\"displayLayout\":{\"type\":\"flex\",\"columns\":3}}

		Block::make( __( 'Events Query', 'wp-action-network-events' ) )
			->set_category( 'events' )
			->set_icon( 'grid-view' )
			->set_keywords( [ 
				__( 'grid', 'wp-action-network-events' ), 
				__( 'events', 'wp-action-network-events' ), 
				__( 'basic', 'wp-action-network-events' ) 
			] )
			->add_fields( array(
				Field::make( 'association', 'event_tag', __( 'Event Tag', 'wp-action-network-events' ) )
					->set_types( [
						[
							'type'      	=> 'term',
							'taxonomy' 		=> 'event_tag',
						]
					] 
				),
				Field::make( 'text', 'posts_per_page', __( 'Number of Posts', 'wp-action-network-events' ) )
					->set_attribute( 'type', 'number' )
					->set_default_value( 3 )
			) )
			->set_inner_blocks( true )
			->set_inner_blocks_position( 'below' )
			->set_inner_blocks_template( $template )
			->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
				var_dump( $fields, $attributes, $inner_blocks  );
				?>

				<div class="block">
					<div class="block__heading">
						<h1><?php echo esc_html( $fields['heading'] ); ?></h1>
					</div><!-- /.block__heading -->

					<div class="block__image">
						<?php echo wp_get_attachment_image( $fields['image'], 'full' ); ?>
					</div><!-- /.block__image -->

					<div class="block__content">
						<?php echo apply_filters( 'the_content', $fields['content'] ); ?>
					</div><!-- /.block__content -->
				</div><!-- /.block -->

				<?php
			} 
		);

	}

}
