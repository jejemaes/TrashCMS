<?php


include 'config/configuration.php';

date_default_timezone_set(TIMEZONE);
error_reporting(DEBUG_MODE);


//######## define the site path constant ######
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path . '/');

//####### include the system ########
include 'system/init.php';

?>