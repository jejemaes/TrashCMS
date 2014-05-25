<?php

// define system directory constants
define('_DIR_EXCEPTION', __SITE_PATH . 'system/exceptions/');
define('_DIR_LIB_EXT', __SITE_PATH . 'system/lib/external/');
define('_DIR_LIB_SYS', __SITE_PATH . 'system/lib/system/');
define('_DIR_INTERFACE', __SITE_PATH . 'system/interfaces/');
define('_DIR_HELPER', __SITE_PATH . 'system/helpers/');
define('_DIR_INCLUDE', __SITE_PATH . 'system/includes/');
define('_DIR_MODULE', __SITE_PATH . 'module/');
define('_DIR_MEDIA', __SITE_PATH . 'media/');

// include files utils
include _DIR_INCLUDE . 'autoload.inc.php';
include _DIR_INCLUDE . 'functions.inc.php';

// autoload for interfaces, helpers, exceptions and system lib (external lib are loaded by the helpers using them)
spl_autoload_register('interfaceLoader');
spl_autoload_register('helperLoader');
spl_autoload_register('exceptionLoader');
spl_autoload_register('systemLoader');

