<?php
/**
 * WP Action Network Events
 *
 * @package   WP_Action_Network_Events
 */
namespace WpActionNetworkEvents\Common\Abstracts;

use WpActionNetworkEvents\App\Admin\Options;

/**
 * The Data class which can be extended by other classes to load in default methods
 *
 * @package WpActionNetworkEvents\Common\Abstracts
 * @since 1.0.0
 */
abstract class Data {

	/**
	 * Base URL
	 *
	 * @var string
	 */
	private $base_url;

	/**
	 * API Key.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string   $api_key
	 */
	protected $api_key;

	/**
	 * Endpoint.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string   $endpoint
	 */
	protected $endpoint;

	/**
	 * Array of data types.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array   $types
	 */
	protected $types;

	/**
	 * Array of args.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array   $args
	 */
	protected $args;

	/**
	 * Array of data.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array   $data
	 */
	protected $data;

	/**
	 * Data constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( string $endpoint, array $types, array $args = [] ) {
		$this->endpoint = $endpoint;
		$this->types = $types;
		$this->args = $args;
		$options = Options::getOptions();
		$this->api_key = $options['api_key'];
		$this->base_url = $options['base_url'];
	}

	/**
	 * Kick it off
	 *
	 * @return void
	 */
	public function init() {
		$this->registerEventTypeOptions();
	}

	/**
	 * Get Data
	 * 
	 * @see https://developer.wordpress.org/reference/functions/wp_remote_get/
	 *
	 * @param string $endpoint
	 * @param array $args
	 * @return mixed (array|WP_Error) The response or WP_Error on failure.
	 */
	public function fetchData( array $args = [] ) {

		$endpoint = \esc_url( $this->base_url . $this->endpoint );

		$options = [
			'headers' => [
				'Content-Type' 			=> 'application/json',
				'OSDI-API-Token' 		=> $this->api_key,
			],
			'timeout'     => 100,
			'redirection' => 5,
		];

		$options = wp_parse_args( $args, $options );

		$response = wp_remote_get( $endpoint, $options );

		// $ch = curl_init();
		// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		// curl_setopt( $ch, CURLOPT_TIMEOUT, 100 );
		// if ( $method == "POST" ) {
		// 	curl_setopt( $ch, CURLOPT_POST, 1 );
		// 	if ( $object ) {
		// 		$json = json_encode( $object );
		// 		curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
		// 		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 
		// 			'OSDI-API-Token: '.$this->api_key,
		// 			'Content-Type: application/json',
		// 			'Content-Length: ' . strlen( $json ) )
		// 		 );
		// 	}
		// } else {
		// 	curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'OSDI-API-Token:' . $this->api_key ) );
		// }
		// curl_setopt( $ch, CURLOPT_URL, $full_endpoint );

		// $response = curl_exec( $ch );

		// curl_close( $ch );

		$results = json_decode( $response );

		var_dump( $results );
	}

	/**
	 * Get the data at a given endpoint
	 *
	 * @param string $endpoint
	 * @return mixed (array|WP_Error) The response or WP_Error on failure.
	 */
	public static function getData() {
		var_dump( $this->data );
		// return $this->data;
	}

	/**
	 * Error Message
	 * @temp
	 *
	 * @param string $error
	 * @return void
	 */
	public function errorMessage( $error ) {
		var_dump( $error );
	}

	public function setQuery() {}

	/**
	 * Register Resource Type
	 * Will be added to the list of types available on Options page
	 *
	 * @return void
	 */
	public function registerEventTypeOptions() {
		$new_types = $this->args['types'];
		$current_types = Options::getEventTypeOptions();
		if( !array_key_exists( $this->endpoint, $current_types ) ) {
			Options::registerEventTypeOptions( $this->types );
		}
	}
}
