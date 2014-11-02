<?php
 
class AnObj
{
  protected $methods = array();
	protected $properties = array();
 
	public function __construct(array $options)
	{
		
		foreach($options as $key => $opt) {
			//integer, string, float, boolean, array
			if(is_array($opt) || is_scalar($opt)) {
				$this->{$key} = $opt;
				unset($options[$key]);
			}
		}
 
		$this->methods = $options;
		 foreach($this->properties as $k => $value)
      		$this->{$k} = $value;
	}
 
	public function __call($name, $arguments)
	{
		$callable = null;
		if (array_key_exists($name, $this->methods))
			$callable = $this->methods[$name];
		elseif(isset($this->$name))
			$callable = $this->$name;
 
		if (!is_callable($callable))
			throw new BadMethodCallException("Method {$name} does not exists");
 
		return call_user_func_array($callable, $arguments);
	}
}
 
$person = new AnObj(array(
  "name" => "nick",
	"age" => 23,
	"friends" => ["frank", "sally", "aaron"],
    "sayHi" => function() {return "Hello there";},
	"sayHi2" => function() {return "Hello " . $this->name;}
));
 
echo $person->name . ' - ';
echo '<hr>';
echo $person->age . ' - ';
echo '<hr>';
print_r($person->friends) . ' - ';
echo '<hr>';
echo $person->sayHi();
echo '<hr>';
echo $person->sayHi2(); 
 
?>