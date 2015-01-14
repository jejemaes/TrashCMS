<?php

/**
 * Autoloader for interfaces
 * It will automatically load the interface php file when an unknown interface is implemented
 * @param string $iname : the name of the called interface
 * @return boolean
 */
function interfaceLoader($iname){
	$filename = $iname . 'class.php';
	$file = _DIR_INTERFACE . $filename;
	if (!file_exists($file)){
		global $Logger;
		//$Logger->debug("Interface " . $iname . " not loaded !");
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
		global $Logger;
		//$Logger->debug("Helper " . $name . " not loaded !");
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
		global $Logger;
		//$Logger->debug("Exception " . $name . " not loaded !");
		return false;
	}
	include $file;
}

/**
 * Autoloader for internal libraries (sys lib)
 * It will automatically load the class php file when an unknown class is used
 * @param string $name : the name of the called class
 * @return boolean
 */
function systemLoader($class_name){
	$directories = explode("\\", $class_name);
	$root = implode($directories, DIRECTORY_SEPARATOR);
	$file = __SITE_PATH . $root . '.class.php';
	global $Logger;
	if (!file_exists($file)){
		//$Logger->debug("Filesys " . $file . " not found !");
		return false;
	}
	include $file;
}
