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

		Block::make( __( 'My Shiny Gutenberg Block', 'wp-action-network-events' ) )
			->set_category( 'common' )
			->set_icon( 'grid-view' )
			->set_keywords( [ 
				__( 'grid', 'wp-action-network-events' ), 
				__( 'events', 'wp-action-network-events' ), 
				__( 'basic', 'wp-action-network-events' ) 
			] )
			->set_parent( 'core/query' )
			->add_fields( array(
				Field::make( 'text', 'heading', __( 'Block Heading', 'wp-action-network-events' ) ),
				Field::make( 'image', 'image', __( 'Block Image', 'wp-action-network-events' ) ),
				Field::make( 'rich_text', 'content', __( 'Block Content', 'wp-action-network-events' ) ),
			) )
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
