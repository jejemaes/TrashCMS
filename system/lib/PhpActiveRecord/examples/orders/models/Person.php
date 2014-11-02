<?php

use System\Model;

class Person extends System\Model\TrashModel
{

	static $attr_accessible = array(
		'id', 'name', 'state', 'created_at', 'updated_at'
	);
	// a person can have many orders and payments
	static $has_many = array(
		array('orders'),
		//array('payments')
	);

	// must have a name and a state
	static $validates_presence_of = array(
		array('name'), array('state'));


	public function bite(){
		return $this->name . " scraems BITE !"; 
	}
}

