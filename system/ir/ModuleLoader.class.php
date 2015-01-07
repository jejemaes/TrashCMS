<?php
/**
 * Maes Jerome
 * ModuleLoader.class.php, created at Jan 7, 2015
 *
 */

namespace system\ir;

class ModuleLoader{
		
	private static function importModule($module){
		if(file_exists(_DIR_MODULE . $module->location . 'controller/init.php')){
			include _DIR_MODULE . $module->location . 'controller/init.php';
		}
	}
	
	public static function loadModules($list){
		foreach ($list as $module){
			self::importModule($module);
		}
	}
	
}