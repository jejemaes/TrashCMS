<?php
/**
 * Maes Jerome
 * ModuleLoader.class.php, created at Jan 7, 2015
 *
 */

namespace system\core;
use system\core\Registry as Registry;
use system\exceptions\ProgrammingException as ProgrammingException;

class ModuleLoader{
	
	
	/**
	 * Extract dependencies per module
	 * @param array<system\ir\Module> $modules : the list of Module objects to json_decode dependencies
	 * @return key-array where
	 * 					- key : string, the name the Module
	 * 					- value : array<string>, list of the name of the dependencies
	 */
	public static function extract_dependencies($modules){
		$result = array();
		foreach ($modules as $module){
			$result[$module->name] = json_decode($module->dependencies);
		}
		return $result;
	}
	
	/**
	 * Private recursive function to compute the loading order of modules
	 * @param array<stdClass> $list : list of pseudo module object
	 * @param stdClass $module : current pseudo module
	 * @param array<string> $loaded : module name already loaded
	 * @param number $limit
	 */
	private static function _computeLoadingOrder($list, $module, &$loaded, $limit=0){
		if($limit > 1000) return ''; // Make sure not to have an endless recursion --> not sure
		$module_name = $module->name;
		if(!$list[$module_name]->is_loaded){
			$dependencies = $list[$module_name]->dependencies;
			foreach ($dependencies as $dep_name){
				static::_computeLoadingOrder($list, $list[$dep_name], $loaded, $limit++);
			}
			$list[$module_name]->is_loaded = true;
			$loaded[] = $module_name;
		}
	}
	
	/**
	 * Compute the loading order (according to dependencies) of the given modules
	 * @param array<system\ir\Module> $modules : the list of Module objects
	 * @return array<string> : list of module name, in the correct loading order
	 */
	public static function computeLoadingOrder($modules){
		// build a list of module pseudo object to set flags
		$module_list = array();
		foreach ($modules as $module){
			$mod = new \stdClass();
			$mod->name = $module->name;
			$mod->is_loaded = false;
			$mod->dependencies = json_decode($module->dependencies ?: "[]");
			$module_list[$module->name] = $mod;
		}
		// compute the loading order
		// NOTE : can be optimized by sorting with # of dependencies
		$module_loaded = array();
		foreach ($module_list as $module){
			static::_computeLoadingOrder($module_list, $module, $module_loaded);
		}
		return $module_loaded;
	}
	
	
	
	public static function loadModules($modules){
		// compute loading order
		$loading_order = static::computeLoadingOrder($modules);
		
		// index the module by name
		$indexed_modules = array();
		foreach ($modules as $m){
			$indexed_modules[$m->name] = $m;
		}
		
		
		$models = array();
		$registry = Registry::getInstance();
		// import the module in order : import their controllers, and set up their models
		foreach ($loading_order as $module_name){
			$module = $indexed_modules[$module_name];
			$module_location = static::findModuleLocation($module);
			// import controller
			$controller_init = $module_location . 'controller/init.php';
			if(file_exists($controller_init)){
				require_once $controller_init;
			}
			// import models
			$class_before = get_declared_classes();
			$model_init = $module_location . 'model/init.php';
			if(file_exists($model_init)){
				require_once $model_init;
			}
			$class_after = get_declared_classes();
			// extract the new imported classes (namespaced)
			
			$module_model_classes = array_diff($class_after, $class_before);
			$registry->loadClass($module_model_classes);
		}
		// now, $models contains for each model, the ordered list of the class that implement the model.
		// the hierachy of TrashModel can be create by setting static $_parent_model, and static $attributes.
		//print_r($models);
		
	}
	
	
	/**
	 * return the root path to the given module
	 * @param Module $module
	 */
	private static function findModuleLocation($module){
		if(is_dir(_DIR_MODULE . $module->location)){
			return _DIR_MODULE . $module->location;
		}
		if(is_dir(_DIR_MODULE_SYSTEM . $module->location)){
			return _DIR_MODULE_SYSTEM . $module->location;
		}
		throw new ProgrammingException('Unknown module location : ' . $module->location);
	}
	

}