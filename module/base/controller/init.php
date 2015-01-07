<?php
/**
 * Maes Jerome
 * init.php, created at Jan 7, 2015
 *
 */

global $dispatcher;

$prefix = '\module\base\controller\\';
		
// BASE routes
$dispatcher->map('GET', '/', array('controller' => 'BaseController' , 'action' => 'indexAction', 'module' => 'base'), 'index');
$dispatcher->map('GET', '/base/[i:id]', array('controller' => 'BaseController' , 'action' => 'testAction', 'module' => 'base'), 'base_test_route');

// USER routes
$dispatcher->map('GET', '/user/', array('controller' => 'UserController' , 'action' => 'indexAction', 'module' => 'base'), 'user_index_route');
