<?php
/**
 * Maes Jerome
 * Registry.class.php, created at Jan 14, 2015
 *
 */
namespace system\ir;

class Registry implements \arrayaccess{
	
	
	private $pool = array();
	protected static $_instance;
	
	
	public static function getInstance(){
		if (!isset(self::$_instance)) {
			$c = __CLASS__;
			self::$_instance = new $c;
			self::$_instance->__construct();
		}
		return self::$_instance;
	}
	
	private function __construct() {
		$this->pool = array();
	}
	
	public function getParentClass($model, $class){
		$index = $this->findClassIndex($model, $class);
		if($index){
			if($index+1 < count($this->pool[$model])){
				return $this->pool[$model][$index+1];
			}
		}
		return null;
	}
	
	public function loadClass(array $classes){
		foreach ($classes as $class){
			// add the class at the list of model classes
			if(isset($class::$_model)){
				$model = $class::$_model;
				$this->add_class($model, $class);
			}
			// set the registry on the class
			$class::$pool = $this;
		}
	}
	
	private function add_class($model, $class){
		if(!isset($this->pool[$model])){
			$this->pool[$model] = array();
		}
		$this->pool[$model][] = $class;
	}
	
	private function findClassIndex($model, $class){
		if(in_array($class, $this->pool[$model])){
			for ($i = 0; $i < count($this->pool[$model]); $i++) {
				$current = $this->pool[$model][$i];
				if(strcmp($current, $class) == 0){
					return $i;
				}
			}
		}
		return false;		
	}
	
	public function offsetSet($offset, $value) {
		if(!is_array($value)){
			$value = array($value);
		}
		if (is_null($offset)) {
			$this->pool[] = $value;
		} else {
			$this->pool[$offset] = $value;
		}
	}
	
	public function offsetExists($offset) {
		return isset($this->pool[$offset]);
	}
	
	public function offsetUnset($offset) {
		unset($this->pool[$offset]);
	}
	
	public function offsetGet($offset) {
		if(isset($this->pool[$offset])){
			return end($this->pool[$offset]);
		}
		return null;
	}
}