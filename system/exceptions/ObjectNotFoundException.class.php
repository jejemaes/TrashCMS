<?php
/**
 * Maes Jerome
 * ObjectNotFound.class.php, created at Jan 10, 2015
 *
 */
namespace system\exceptions;

class ObjectNotFoundException extends Exception{
	
	public function __construct($model, $id, $message){
		$this->model = $model;
		$this->id = $id;
		parent::__construct($message);
	}
	
	public function  __toString(){
		$str = "The object " + $this->model + " with the id " + $this->id + " was not found.";
		$str += parent::__toString();
		return $str;
	}
}