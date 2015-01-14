<?php
/**
 * Maes Jerome
 * init.php, created at Jan 7, 2015
 *
 */

global $dispatcher;

// BASE controller
import('BaseController.class.php');

$dispatcher->map('GET', '/', array('controller' => 'BaseController' , 'action' => 'indexAction', 'module' => 'base'), 'index');
$dispatcher->map('GET', '/base/[i:id]', array('controller' => 'BaseController' , 'action' => 'testAction', 'module' => 'base'), 'base_test_route');

// USER controller
import('UserController.class.php');

$dispatcher->map('GET', '/user/', array('controller' => 'UserController' , 'action' => 'indexAction', 'module' => 'base'), 'user_index_route');
$dispatcher->map('GET', '/user/[i:id]', array('controller' => 'UserController' , 'action' => 'userAction', 'module' => 'base'), 'user_user_route');
