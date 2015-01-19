<?php
/**
 * Maes Jerome
 * init.php, created at Jan 14, 2015
 *
 */

global $dispatcher;


import('WebController.class.php');

$dispatcher->map('GET', '/web/bundle/css/[*:xmlid]', array('controller' => 'WebController' , 'action' => 'bundleCssAction', 'module' => 'web'), 'web_bundle_css_route');
$dispatcher->map('GET', '/web/bundle/js/[*:xml_id]', array('controller' => 'WebController' , 'action' => 'bundleJsAction', 'module' => 'web'), 'web_bundle_js_route');
