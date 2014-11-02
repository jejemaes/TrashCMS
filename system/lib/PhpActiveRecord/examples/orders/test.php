<?php

date_default_timezone_set('Europe/Brussels');



require_once dirname(__FILE__) . '/../../ActiveRecord.php';
require_once 'system/TrashModel.class.php';


require_once 'models/Person.php';
require_once 'models/Order.php';
require_once 'models/Payment.php';


// initialize ActiveRecord
ActiveRecord\Config::initialize(function($cfg)
{
    $cfg->set_model_directory(dirname(__FILE__) . '/models');
    $cfg->set_connections(array('development' => 'mysql://activerecord:activerecord@127.0.0.1/activerecord'));

	// you can change the default connection with the below
    //$cfg->set_default_connection('production');
});


echo "<br>-------------------------------------------------------- GETTERS <br>";
var_dump(Person::$getters);

echo "<br>-------------------------------------------------------- SETTERS <br>";
var_dump(Person::$setters);

echo "<br>-------------------------------------------------------- DELEGATE <br>";
var_dump(Person::$delegate);

/*
class Person22 extends Person {

	// explicit table name since our table is not "books"
	static $table_name = 'people';


    public function hello(){
    	return "<br>" . $this->name . " says TEST ----- <br><br>";
    }
 }
 */


/*
Person::_extends(array(
	"name" => "caca",
	"coucou" => function(){ echo "hello!";},
 	"fct2" => function(){ echo "hello" . $this->name;}
));
*/

 // Add method
        

       Person::extend_methods(array(
        	'coucou' => function(){
				return "COUCOU " . $this->name;
        	}, 

        ));
        //Person::extend_methods($meths);

        Person::$has_many[] = array('payments');

echo "========================<br>";

print_r(get_declared_classes());

foreach (Person::all() as $person)
{	
	echo "<br><br>########################################################<br>";
	var_dump($person);
	//echo $person->getAttr() . "<br>";
	echo $person->coucou();
	echo "<br>CACA : $person->caca <br>";
	echo "ORDER : " . count($person->orders) . "<br>\n";
	echo "PAY : " . count($person->payments) . "<br>\n";
}