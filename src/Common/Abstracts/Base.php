<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */
namespace WpActionNetworkEvents\Common\Abstracts;

/**
 * The Base class which can be extended by other classes to load in default methods
 *
 * @package WpActionNetworkEvents\Common\Abstracts
 * @since 1.0.0
 */
abstract class Base {

	/**
	 * Singleton trait
	 */
	// use Singleton;

	// private static $instance;

	/**
	 * @var array : will be filled with data from the plugin config class
	 * @see Plugin
	 */
	protected $plugin = [];

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Base constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version = '1.0.0', $plugin_name ) {
		$this->version = $version;
		$this->plugin_name = $plugin_name;
		// $this->init();
		// self::instantiate();
	}

	/**
	 * @return self
	 * @since 0.1.0
	 */
	final public static function instantiate(): self {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function init() {}
}
