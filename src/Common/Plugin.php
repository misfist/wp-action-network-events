<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://debtcollective.org
 * @since      1.0.0
 *
 * @package    Wp_Action_Network_Events
 * @subpackage Wp_Action_Network_Events/src
 */
namespace WpActionNetworkEvents\Common;

use WpActionNetworkEvents\App\Admin\Admin;
use WpActionNetworkEvents\App\Frontend\Frontend;
use WpActionNetworkEvents\Common\Loader;
use WpActionNetworkEvents\Common\I18n;
use WpActionNetworkEvents\App\General\PostTypes;
use WpActionNetworkEvents\App\General\ContentFilters;
use WpActionNetworkEvents\App\General\Taxonomies\Taxonomies;
use WpActionNetworkEvents\App\General\CustomFields;
use WpActionNetworkEvents\App\Integration\RestFilters;
use WpActionNetworkEvents\App\Blocks\Blocks;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Action_Network_Events
 * @subpackage Wp_Action_Network_Events/src
 * @author     Debt Collective <pea@misfist.com>
 */
class Plugin {

	private static $instance;

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
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WpActionNetworkEvents\Common\Loader   $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Construct
	 *
	 * @param string $version
	 * @param string $plugin_name
	 */
	public function __construct( $version, $plugin_name ) {
		$this->version = $version;
		$this->plugin_name = $plugin_name;
		// $this::instantiate();
		$this->init();
	}

	/**
	 * @return self
	 * @since 0.1.0
	 */
	public static function instantiate(): self {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Initialize
	 *
	 * @param string $version
	 * @param string $plugin_name
	 * @return void
	 */
	public function init() {
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WpActionNetworkEvents\Common\Loader. Orchestrates the hooks of the plugin.
	 * - WpActionNetworkEvents\Common\I18n. Defines internationalization functionality.
	 * - WpActionNetworkEvents\App\Admin\Admin. Defines all hooks for the admin area.
	 * - WpActionNetworkEvents\App\Frontend\Frontend. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'src/Common/Loader.php';

		// /**
		//  * The class responsible for defining internationalization functionality
		//  * of the plugin.
		//  */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'src/Common/I18n.php';

		// /**
		//  * The class responsible for defining all actions that occur in the admin area.
		//  */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'src/App/Admin/Admin.php';

		// /**
		//  * The class responsible for defining all actions that occur in the public-facing
		//  * side of the site.
		//  */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'src/App/Frontend/Frontend.php';

		$this->loader = new Loader();

		new PostTypes( $this->version, $this->plugin_name );

		new Taxonomies( $this->version, $this->plugin_name );

		new ContentFilters( $this->version, $this->plugin_name );

		new CustomFields( $this->version, $this->plugin_name );

		new RestFilters( $this->version, $this->plugin_name );

		new Blocks( $this->version, $this->plugin_name );


		// $events = new GetEvents();
		// $events->fetchData();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin( $this->version, $this->plugin_name );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Frontend( $this->version, $this->plugin_name );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WpActionNetworkEvents\Common\Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
