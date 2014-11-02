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
 */

namespace system\ir;

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
	
	
	public function match(){
		return $this->router->match();
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
		// match current request
		$match = $this->router->match();
		return $match;
	}
	
	
	public function generate($name){
		return $this->router->generate($name);
	}
	
	public function getRouter(){
		return $this->router;
	}
}