<?php
/**
 * Maes Jerome
 * Request.class.php, created at Oct 30, 2014
 *
 */


namespace system\ir;

use system\ir\TrashView as TrashView;
use system\helpers\TemplateEngineHelper as TemplateEngineHelper;
use system\ir\RequestHeader as RequestHeader;



class Request{
	
	protected $params_get;
	protected $params_post;
	protected $cookies;
	protected $server;
	protected $headers;
	protected $files;
	protected $body;
	

	/**
	 * HTTP 1.1 status messages based on code
	 *
	 * @link http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
	 * @type array
	 */
	protected static $http_messages = array(
			// Informational 1xx
			100 => 'Continue',
			101 => 'Switching Protocols',
			// Successful 2xx
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			// Redirection 3xx
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',
			// Client Error 4xx
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			// Server Error 5xx
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
	);
	
	
	/**
	 * The prefix of HTTP headers normally
	 * stored in the Server data
	 *
	 * @type string
	 */
	protected static $http_header_prefix = 'HTTP_';
	
	/**
	 * The list of HTTP headers that for some
	 * reason aren't prefixed in PHP...
	 *
	 * @type array
	 */
	protected static $http_nonprefixed_headers = array(
			'CONTENT_LENGTH',
			'CONTENT_TYPE',
			'CONTENT_MD5',
	);
	
	
	
	private $_is_website;
	private $_template_engine;
	
	
	public function __construct($is_website = true/*, $template_engine=FALSE*/){
		$this->params_get   = $_GET;
		$this->params_post  = $_POST;
		$this->cookies      = $_COOKIE;
		$this->server       = $_SERVER;
		$this->files		= $_FILES;
		
		$this->headers = $this->getHeaders();
		
		
		
		$this->_is_website = $is_website;
		//$this->_template_engine = new TemplateEngineHelper();
	}
	
	
	/**
	 * render the view with the given values, and return it as a response
	 * @param string $view_name : xml_id of the view, as "module"."view_name".
	 * @param array $values : key-array of values for the view.
	 */
	public function render($view_name, $values=array()){
		global $Logger;
		$Logger->debug("Request render : ".$view_name);
		if($this->_is_website){
			// TODO add website values (menuitems, ...) to values before rendering
		}
		// TODO render values on $views
		
		$view = $this->_template_engine->render($view_name, $values);
		
		$this->make_response($view, 'text/html');
	}
	
	
	/**
	 * make response
	 * @param array $values : key-array
	 * @param string $header : type of the response (text/html, ....)
	 */
	public function make_response($values, $header="text/html"){
		if($header == "text/html"){
			header('Content-type: text/html; charset=utf-8');
			echo $values;
		}
	}
	
	
	
	
	/**
	 * Gets the request body
	 * @return string
	 */
	public function body()
	{
		// Only get it once
		if (null === $this->body) {
			$this->body = @file_get_contents('php://input');
		}
		return $this->body;
	}
	
	/**
	 * Quickly check if a string has a passed prefix
	 * @param string $string    The string to check
	 * @param string $prefix    The prefix to test
	 * @return boolean
	 */
	public static function hasPrefix($string, $prefix){
		if (strpos($string, $prefix) === 0) {
			return true;
		}
		return false;
	}
	
	/**
	 * Get our headers from our server data collection
	 * PHP is weird... it puts all of the HTTP request
	 * headers in the $_SERVER array. This handles that
	 * @return array
	 */
	public function getHeaders(){
		// Define a headers array
		$headers = array();
		foreach ($this->server as $key => $value) {
			// Does our server attribute have our header prefix?
			if (self::hasPrefix($key, self::$http_header_prefix)) {
				// Add our server attribute to our header array
				$headers[substr($key, strlen(self::$http_header_prefix))] = $value;
			} elseif (in_array($key, self::$http_nonprefixed_headers)) {
				// Add our server attribute to our header array
				$headers[$key] = $value;
			}
		}
		return $headers;
	}
	
	
	
	
	
	
	/**
	 * Return a request parameter, or $default if it doesn't exist
	 * @param string $key       The name of the parameter to return
	 * @param mixed $default    The default value of the parameter if it contains no value
	 * @return string
	 */
	public function param($key, $default = null){
		// Get all of our request params
		$params = $this->params();
		return isset($params[$key]) ? $params[$key] : $default;
	}
	
	/**
	 * Is the request secure?
	 * @return boolean
	 */
	public function isSecure(){
		return ($this->server['HTTPS'] == true);
	}
	
	/**
	 * Gets the request IP address
	 * @return string
	 */
	public function ip(){
		return $this->server['REMOTE_ADDR'];
	}
	
	/**
	 * Gets the request user agent
	 * @return string
	 */
	public function userAgent(){
		return $this->headers->get('USER_AGENT');
	}
	
	/**
	 * Gets the request URI
	 * @return string
	 */
	public function uri(){
		return $this->server['REQUEST_URI'] ?: '/';
	}
	
	/**
	 * Get the request's pathname
	 * @return string
	 */
	public function pathname(){
		$uri = $this->uri();
		// Strip the query string from the URI
		$uri = strstr($uri, '?', true) ?: $uri;
		return $uri;
	}
	
	/**
	 * Gets the request method, or checks it against $is
	 *
	 * <code>
	 * // POST request example
	 * $request->method() // returns 'POST'
	 * $request->method('post') // returns true
	 * $request->method('get') // returns false
	 * </code>
	 *
	 * @param string $is				The method to check the current request method against
	 * @param boolean $allow_override	Whether or not to allow HTTP method overriding via header or params
	 * @return string|boolean
	 */
	public function method($is = null, $allow_override = true){
		$method = $this->server['REQUEST_METHOD'] ?: 'GET';
		// Override
		if ($allow_override && $method === 'POST') {
			// For legacy servers, override the HTTP method with the X-HTTP-Method-Override header or _method parameter
			if ($this->server['X_HTTP_METHOD_OVERRIDE']) {
				$method = $this->server['X_HTTP_METHOD_OVERRIDE'] ?: $method;
			} else {
				$method = $this->param('_method', $method);
			}
			$method = strtoupper($method);
		}
		// We're doing a check
		if (null !== $is) {
			return strcasecmp($method, $is) === 0;
		}
		return $method;
	}
	
	/**
	 * Adds to or modifies the current query string
	 *
	 * @param string $key   The name of the query param
	 * @param mixed $value  The value of the query param
	 * @return string
	 */
	public function query($key, $value = null){
		$query = array();
		parse_str(
			$this->server['QUERY_STRING'],
			$query
		);
		if (is_array($key)) {
			$query = array_merge($query, $key);
		} else {
			$query[$key] = $value;
		}
		$request_uri = $this->uri();
		if (strpos($request_uri, '?') !== false) {
			$request_uri = strstr($request_uri, '?', true);
		}
		return $request_uri . (!empty($query) ? '?' . http_build_query($query) : null);
	}
	
}