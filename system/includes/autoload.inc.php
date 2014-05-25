<?php

/**
 * Autoloader for interfaces
 * It will automatically load the interface php file when an unknown interface is implemented
 * @param string $iname : the name of the called interface
 * @return boolean
 */
function interfaceLoader($iname){
	$filename = $iname . '.php';
	$file = _DIR_INTERFACE . $filename;
	if (!file_exists($file)){
		return false;
	}
	include $file;
}

/**
 * Autoloader for helpers
 * It will automatically load the helpers php file when an unknown class is used
 * @param string $iname : the name of the called class
 * @return boolean
 */
function helperLoader($name){
	$filename = $name . '.class.php';
	$file = _DIR_HELPER . $filename;
	if (!file_exists($file)){
		return false;
	}
	include $file;
}


/**
 * Autoloader for Exception classes
 * It will automatically load the exception php file when an unknown class is used
 * @param string $iname : the name of the called class
 * @return boolean
 */
function exceptionLoader($name){
	$filename = $name . '.class.php';
	$file = _DIR_EXCEPTION . $filename;
	if (!file_exists($file)){
		return false;
	}
	include $file;
}

/**
 * Autoloader for internal libraries (sys lib)
 * It will automatically load the class php file when an unknown class is used
 * @param string $iname : the name of the called class
 * @return boolean
 */
function systemLoader($name){
	$filename = $name . '.class.php';
	$file = _DIR_LIB_SYS . $filename;
	if (!file_exists($file)){
		return false;
	}
	include $file;
}
