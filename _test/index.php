<?php
/**
 * Maes Jerome
 * index.php, created at Jan 11, 2015
 *
 */
class Meta{
	public function __call($method, $args){
		$called_class = get_called_class();
		$parent_class = $called_class::$parent_class;
		
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