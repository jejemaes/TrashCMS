<?php
class TrashModel extends stdClass
{
	public function _extend(array $options = array()){
		foreach($options as $key => $opt) {
			if(is_array($opt) || is_scalar($opt)) {
				$this->$key = $opt;
			}else{
				echo '<b>'.$key.'</b><br>';
				if(in_array($key, get_class_methods($this))){
					echo '<br>unset '.$key;
					unset($this->{$key});
				}
				$this->{$key} = $opt;
			}
		}
	}
	
	public function __call($closure, $args)
	{
		echo "__call ".$closure."<br>";
		return call_user_func_array($this->{$closure}->bindTo($this),$args);
	}

	public function __toString()
	{
		return call_user_func($this->{"__toString"}->bindTo($this));
	}
}


class objTest extends TrashModel{
	
	public function coucou(){
		return "coucou ";
	}
	
	public function coucou2($p){
		return "coucou ".$p;
	}
	
}


$b=new objTest();
echo $b->coucou();
echo '<hr>';
$b->_extend(array(
	"name" => "caca",
	"coucou" => function(){ echo "hello!";},
 	"fct2" => function(){ echo "hello" . $this->name;}
));
$b->fct();
echo '<hr>';
$b->fct2();
echo '<hr>';
echo $b->coucou2(" hihi");
echo '<hr>';
echo '<hr>';
$a=new objTest();
$a->color="red";
$a->sayhello=function(){ echo "hello!";};
$a->printmycolor=function(){ echo $this->color;};
$a->sayhello();//output: "hello!"
$a->printmycolor();//output: "red"