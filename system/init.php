<?php

// define system directory constants
define('_DIR_SYS', __SITE_PATH . 'system/core/');
define('_DIR_EXCEPTION', __SITE_PATH . 'system/exceptions/');
define('_DIR_LIB', __SITE_PATH . 'system/lib/');
define('_DIR_INTERFACE', __SITE_PATH . 'system/interfaces/');
define('_DIR_HELPER', __SITE_PATH . 'system/helpers/');
define('_DIR_INCLUDE', __SITE_PATH . 'system/includes/');
define('_DIR_MODULE', __SITE_PATH . 'module/');
define('_DIR_MODULE_SYSTEM', __SITE_PATH . 'system/module/');
define('_DIR_MEDIA', __SITE_PATH . 'media/');

// include files utils
include _DIR_INCLUDE . 'autoload.inc.php';
include _DIR_INCLUDE . 'functions.inc.php';
include _DIR_INCLUDE . 'underscore.php';

// autoload for interfaces, helpers, exceptions and system lib 
// (external lib are loaded by the helpers using them)
spl_autoload_register('interfaceLoader');
spl_autoload_register('helperLoader');
spl_autoload_register('exceptionLoader');
spl_autoload_register('systemLoader');

// instanciate the Logger
include _DIR_SYS . 'Logger.class.php' ;
global $Logger;
$Logger = system\core\Logger::getInstance(system\core\Logger::LOG_DEBUG);

// initialize ActiveRecord
require_once _DIR_LIB . 'PhpActiveRecord/ActiveRecord.php';
ActiveRecord\Config::initialize(function($cfg){
	//$cfg->set_model_directory(dirname(__FILE__) . '/models');
	$cfg->set_connections(array('production' => 'mysql://'.DB_LOGIN.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME . '?charset=utf8'));
	// you can change the default connection with the below
	$cfg->set_default_connection('production');
	$cfg->set_model_directory(_DIR_LIB);
});
$Logger->info("ActiveRecord Loaded and configurated !");


$Logger->debug("Start the Routing =============================================");

use system\core\Route as Route;
use system\core\Dispatcher as Dispatcher;
use system\core\Request as Request;
use system\core\Module as Module;
use system\core\ModuleLoader as ModuleLoader;
use system\core\Registry;


global $match;
global $request;
global $dispatcher;
global $registry;

$registry = Registry::getInstance();
$dispatcher = Dispatcher::getInstance(__BASE_PATH_URL);

// load all installed modules
$modules_list = Module::findInstalled();
ModuleLoader::loadModules($modules_list);

var_dump($registry);

$request = new Request();
$user = $registry['res.user']::first();
//var_dump($user->test());

$dispatcher->dispatch();


$Logger->debug("End the Routing =============================================");

