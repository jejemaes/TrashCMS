<?php
/**
 * Maes Jerome
 * TrashController.class.php, created at Oct 27, 2014
 *
 */


namespace system\ir;

abstract class TrashController{
	
	/**
	 * catch the static call for undefined method
	 * @param string $name : the method name
	 * @param array $arguments : the list of args
	 */
	public static function __callStatic($name, $arguments){
		global $Logger;
		$Logger->error("Programming Error : Undeclared method " . $name . " called with " . implode(', ', $arguments));
	}
	
}