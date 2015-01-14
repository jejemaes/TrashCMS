<?php

/*
 * SYSTEM
 */

/**
 * import a file, from an init file
 * @param string $filename : relative path to the caller file (init.php)
 */
function import($filename){
	global $Logger;
	$trace = debug_backtrace();
	$caller_init = $trace[0]['file'];
	$path = realpath(dirname($caller_init));
	$file_to_include = $path . '/' . $filename;
	if(file_exists($file_to_include)){
		$Logger->info("Import : " . $file_to_include);
		require_once $file_to_include;
	}else{
		$Logger->warn("Failed Import : " . $file_to_include);
	}
}