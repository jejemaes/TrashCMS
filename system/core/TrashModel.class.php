<?php
/**
 * Maes Jerome
 * TrashModel.class.php, created at May 25, 2014
 *
 * This class extends the Active Record Model to allow the user to add, dynamically, methods and attributes
 * to defined model. This is inspired from Open Object Project (Odoo, formerly OpenERP). 
 * All new defined model must be extends like 
 * <code>
 * class Person extends TrashModel{
 *		static $attr_accessible = array( // the attributes
 *			'id', 'name', 'state', 'created_at', 'updated_at'
 *		);
 *		public function sayHello(){ // public methods defined here
 *			echo 'hello';
 *		}
 * }
 * </code>
 * The model Person will be extended like
 * <code>
 *  @TODO
 * </code>
 */


namespace system\core;

class TrashModel extends \ActiveRecord\Model{
		
	public static $pool;
	
	public static function __callStatic($method, $args){
		$class = get_called_class();
		$model_name = static::$pool->convertNameToModel(static::$table_name);
		$parent_class = static::$pool->getParentClass($model_name, get_called_class());
		if($parent_class){
			return call_user_func_array(array($parent_class, $method), $args);
		}
	}
	
	public function __call($method, $args){
		$class = get_called_class();
		$model_name = static::$pool->convertNameToModel(static::$table_name);
		$parent_class = static::$pool->getParentClass($model_name, get_called_class());
		if($parent_class){
			$parent_object = new $parent_class($this->attributes);
			return call_user_func_array(array($parent_object, $method), $args);
		}
	}
	
}


