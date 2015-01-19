<?php
/**
 * Maes Jerome
 * Module.class.php, created at May 25, 2014
 *
 */
namespace system\core;

use system\core\TrashModel as TrashModel;


class Module extends TrashModel{
	
	static $table_name = 'system_module';
	
	static $attr_accessible = array(
			'id',
			'name', 		// string, name of the module
			'display_name', // string, displayed name of the module for the UI
			'location', 	// string, dir path of the module
			'is_installed',	// boolean
			'menu_items', 	// json
			'dependencies', // json
	);
		
	
	/**
	 * get the list of all the modules
	 * @return Ambigous <\ActiveRecord\mixed, NULL, unknown, \ActiveRecord\Model, multitype:>
	 */
	public static function findAll(){
		return Module::find('all', array('order' => 'sequence desc'));
	}
	
	/**
	 * get the list of installed modules
	 * @return Ambigous <\ActiveRecord\mixed, NULL, unknown, \ActiveRecord\Model, multitype:>
	 */
	public static function findInstalled(){
		return Module::find(
				'all',
				array('order' => 'sequence desc'),
				array('conditions' => array('is_installed = ?', '1'))
		);
	}
	
	
	public function test(){
		return "###" . $this->name . ' CACA';
	}
}