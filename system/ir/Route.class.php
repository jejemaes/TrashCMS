<?php
/**
 * Maes Jerome
 * Route.class.php, created at May 25, 2014
 *
 */

namespace system\ir;

class Route{
	
	public $module;
	public $controller;
	public $action;
	public $name;
	public $path;
	public $params;
	
	
	public function __construct(array $data = array()){
		$this->module = $data['target']['module'];
		$this->controller = $data['target']['controller'];
		$this->action = $data['target']['action'];
		$this->name = $data['name'];
		$this->params = $data['params'];
		//$this->path = $data['path'];
	}

}

/*extends TrashModel{
	
	static $table_name = 'system_route';
	
	static $attr_accessible = array(
			'id',
			'name', 		// string, name of the Route
			'method', 		// string method for the route : GET, POST GET|POST, ...
			'path', 		// url of the route : baseUrl + path = complete url
			'controller',	// name of the controller class
			'action',		// name of the method of the controller
			'system_module'
	);
	
	
	static $belongs_to = array(
			array('system_module', 'class_name' => 'system\ir\Module'),
	);
	
	
	public static function get_active_routes(){
		return static::find_by_sql("SELECT * FROM system_route R, system_module M WHERE R.module_id = M.id AND M.is_installed = '1'");
	}
}
	*/