<?php
/**
 * Maes Jerome
 * Dispatcher.class.php, created at May 25, 2014
 *
 * Dispatcher : it is the object that route the request to the good controller method. It decode
 * 		the url, and find the best match route, and instanciate the controller and call the corresponding
 * 		method.
 * Implementation : depends of the library AltoRouter to find the matching routes, and Module to get the routes 
 * 		of all installed modules.
 * 
 * Route mapping (from http://altorouter.com/usage/mapping-routes.html) : 
 * 		*                    // Match all request URIs
 * 		[i]                  // Match an integer
 *		[i:id]               // Match an integer as 'id'
 *		[a:action]           // Match alphanumeric characters as 'action'
 * 		[h:key]              // Match hexadecimal characters as 'key'
 * 		[:action]            // Match anything up to the next / or end of the URI as 'action'
 * 		[create|edit:action] // Match either 'create' or 'edit' as 'action'
 * 		[*]                  // Catch all (lazy, stops at the next trailing slash)
 *		[*:trailing]         // Catch all as 'trailing' (lazy)
 *		[**:trailing]        // Catch all (possessive - will match the rest of the URI)
 *		.[:format]?          // Match an optional parameter 'format' - a / or . before the block is also optional
 */

namespace system\core;
use system\core\Route as Route;


class Dispatcher{
	
	protected static $_instance;
	private $router;
	
	
	/**
	 * getInstance
	 * @return Dispatcher $instance : the instance of Dispatcher
	 */
	public static function getInstance($baseUrl){
		if (!isset(self::$_instance)) {
			$c = __CLASS__;
			self::$_instance = new $c(str_replace(" ", "%20", $baseUrl));
		}
		return self::$_instance;
	}
	
	
	/**
	 * Constructor : load the AltoRouter lib
	 */
	private function __construct($baseUrl){
		require_once _DIR_LIB . 'AltoRouter/AltoRouter.php';
		
		$this->router = new \AltoRouter();
		$this->router->setBasePath($baseUrl);
	}

	
	
	/**
	 * find the best match Route of the current request
	 * @param array $routes : list of active Routes to compare for matching
	 * @return array 
	 */
	public function route(array $routes = array()){
		foreach ($routes as $r){
			$this->router->map($r->method, $r->path, array('controller' => $r->controller, 'action' => $r->action), $r->name);
		}
		return $this->match();
	}
	
	
	/**
	 * find the match route of the request
	 * @return system\ir\Route object containing the informations of the matched route. NULL otherwise.
	 */
	public function match(){
		// match current request
		$match = $this->router->match();
		if($match){
			return new Route($match);
		}
		return NULL;
	}
	
	/**
	 * add a route to the routing mapping
	 * @param string $method : GET, POST, GET|POST
	 * @param string $path : the path of the query
	 * @param string $controllerMethod : key array where
	 * 				'controller' => complete class name (with namespace)
	 * 				'action' =>  name of the method to call on the controller
	 * @param string $name : the name of the route
	 */
	public function map($method, $path, $controllerMethod, $name){
		global $Logger;
		// TODO : since the modules will be load in a correct order (depending on their dependencies), a controller
		// can override a route, so, here, if a route already exists, jsute override it with the new controller
		$Logger->debug("Add route " . $path . " to routing map :  " . $controllerMethod['controller'] . "->" . $controllerMethod['action']);
		$this->router->map($method, $path, $controllerMethod, $name);
	}
	
	public function dispatch(){
		global $request;
		$route = $this->match();
		if($route){
			$controller_class = sprintf('\module\%s\controller\%s', $route->module,  $route->controller);
			$action = $route->action;
			$controller = new $controller_class($request);
			call_user_func_array(array($controller, $action), $route->params);
		}else{
			$this->_handle_exception();
		}
	}
	
	
	public function generate_route($name){
		return $this->router->generate($name);
	}
	
	public function getRouter(){
		return $this->router;
	}
	
	private function _handle_exception(){
		//TODO
		echo 'ERROR DISPATCHER : route not found or else';
	}
}