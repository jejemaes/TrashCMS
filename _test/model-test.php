<?php
/**
 * Maes Jerome
 * index.php, created at Jan 11, 2015
 *
 */

// TODO : module load ; add models loader
/*
 1 - load all model file of the module
 1b - for each, get _name attr,
 1c - then for each _name, get all _inherit, built attributes complete list
 2 - set attributes (complete list) on each model that inherit from _name
 3 - import in order !!!
 4 - set parent_class on each
 */
class Meta{
	public function __call($method, $args){
		// TODO check if method do not belong to ActiveRecordModel with get_class_methods, then ok
		$called_class = get_called_class();
		$parent_class = $called_class::$parent_class; // TODO check if there is a parent, else EXCEption programming
		
		$obj = new $parent_class(get_object_vars($this));
		// TODO : verif if parent has $method, or find 1st parent with method
		$reflectionMethod = new ReflectionMethod($parent_class, $method);
		
		$closure = $reflectionMethod->getClosure($obj); // TODO pass args = attributes to have the same obj

		$fct = Closure::bind($closure, $obj, $parent_class);
		
		$res = $fct();
		
		return $res;
	}
}

class Test extends Meta{
	
	public $nickname;
	
	public function __construct($vars){
		foreach ($vars as $k => $v){
			$this->$k = $v;
		}
	}
	
	public function sayAge() {
		$this->nickname = "set by TEST";
		return 'I am ' . $this->age;
	}
}


class HelloWorld extends Meta{
	
	public $age;
	public $nickname;
	
	static $parent_class = 'Test';
	
	public function __construct($age){
		$this->age = $age;
		$this->nickname = "set by Hello";
	}

	public function sayHelloTo($name) {
		return 'Hello ' . $name;
	}
	
	
	public function sayAge() {
		$str = parent::sayAge();
		return 'CACA' . $str;
	}
	
}


$object = new HelloWorld(12);

echo $object->sayAge();

exit();

$reflectionMethod = new ReflectionMethod('Test', 'sayAge');
$closure = $reflectionMethod->getClosure(new Test());

$fct = Closure::bind($closure, $object, 'Test');
$res = $fct();
var_dump($res);
echo $res;
echo '<br>';
echo $object->nickname;

//echo $reflectionMethod->invoke($object);