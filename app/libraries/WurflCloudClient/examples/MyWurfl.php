<?php
use ScientiaMobile\WurflCloud\Config;
use ScientiaMobile\WurflCloud\Cache\Null;
use ScientiaMobile\WurflCloud\Cache\Cookie;
use ScientiaMobile\WurflCloud\Client;
/**
 * WURFL Cloud Singleton
 * 
 * @package WurflCloud_Client
 * @subpackage Examples
 */
/**
 * WURFL Cloud Singleton
 * 
 * An example of using a single class to easily get WURFL Capabilities.  
 * Make sure you edit the $api_key in this file.
 * 
 * You can use this class in your scripts like this:
 * <code>
 * // Include the MyWurfl.php file
 * require_once './MyWurfl.php';
 * // Get the is_wireless_device capability from the visiting device
 * $wireless = MyWurfl::get('is_wireless_device');
 * </code>
 * 
 * @package WurflCloud_Client
 * @subpackage Example
 */
class MyWurfl {
	/**
	 * Enter your API Key here
	 * @var string
	 */
	private static $api_key = '123456:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
	/**
	 * Initialize static instance
	 */
	private static function init() {
		require_once __DIR__.'/../src/autoload.php';
		// Additional configuration options can be used here
		$config = new Config();
		$config->api_key = self::$api_key;
		
		// To disable caching for testing, you can use the Null cache provider:
		// $cache = new Null();
		$cache = new Cookie();
		
		// These two lines setup the WurflCloud_Client and do the device detection
		self::$instance = new Client($config, $cache);
		self::$instance->detectDevice();
	}
	/**
	 * Returns the value of the requested capability
	 * @param string $capability_name
	 * @return mixed Value of the requested capability
	 */
	public static function get($capability_name) {
		if (self::$instance === null) self::init();
		return self::$instance->getDeviceCapability($capability_name);
	}
	public static function getInstance() {
		return self::$instance;
	}
	/**
	 * @var WurflCloud_Client_Client
	 */
	private static $instance;	
}