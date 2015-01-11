<?php

include 'config/configuration.php';

date_default_timezone_set(TIMEZONE);
error_reporting(DEBUG_MODE);

//libxml_use_internal_errors(false);

//######## define the site path and the base url constant ######
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path . '/');

define('__BASE_PATH_URL', isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : dirname(getenv('SCRIPT_NAME')));

$baseUrl = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://'; // checking if the https is enabled
$baseUrl .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST'); // checking adding the host name to the website address
$baseUrl .= isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : dirname(getenv('SCRIPT_NAME')); // adding the directory name to the created url and then returning it.
define('__BASE_URL', $baseUrl . '/');


//####### include the system ########
include 'system/init.php';

?>