<?php
/**
 * Maes Jerome
 * init2.php, created at Oct 15, 2014
 *
 */


// define system directory constants
define('_DIR_SYS', __SITE_PATH . 'system/ir/');
define('_DIR_EXCEPTION', __SITE_PATH . 'system/exceptions/');
define('_DIR_LIB', __SITE_PATH . 'system/lib/');
define('_DIR_INTERFACE', __SITE_PATH . 'system/interfaces/');
define('_DIR_HELPER', __SITE_PATH . 'system/helpers/');
define('_DIR_INCLUDE', __SITE_PATH . 'system/includes/');
define('_DIR_MODULE', __SITE_PATH . 'module/');
define('_DIR_MEDIA', __SITE_PATH . 'media/');

// include files utils
//include _DIR_INCLUDE . 'autoload.inc.php';
//include _DIR_INCLUDE . 'functions.inc.php';

// autoload for interfaces, helpers, exceptions and system lib
// (external lib are loaded by the helpers using them)
/*
spl_autoload_register('interfaceLoader');
spl_autoload_register('helperLoader');
spl_autoload_register('exceptionLoader');
spl_autoload_register('systemLoader');
*/



class UserController{
	public static function indexAction(){
		echo "indexAction !!!! <hr> ";
	}

	public static function users_create($id){
		echo "zzzzzz : ".$id;
	}
}


include _DIR_LIB . 'AltoRouter/AltoRouter.php';

/*
include _DIR_HELPER . 'RouterHelper.class.php';
$r = new RouterHelper(__BASE_URL);
var_dump($r->match());
*/


echo rawurlencode(__BASE_PATH_URL) . '<br>';

$router = new AltoRouter();
$router->setBasePath( str_replace(" ", "%20", __BASE_PATH_URL));
$router->map('GET|POST','/', 'home#index', 'home');
$router->map('GET','/users/', array('c' => 'UserController', 'a' => 'indexAction'), 'users_index');
$router->map('GET','/users/[i:id]', 'controller::users_create', 'users_show');
$router->map('POST','/users/[i:id]/[delete|update:action]', 'usersController#doAction', 'users_do');

$router->map('GET','/[a:module]/[*]?', 'testController#doAction', 'mod_test');

// match current request
$match = $router->match();


if(is_array($match)){
	$fct = $match['target']["c"] . '::' . $match['target']["a"];
	echo $fct;
	//$fct();
	call_user_func($fct);
}else{
	echo "NONONO";
}

?>
<hr>
<pre>
	Target: <?php var_dump($match['target']); ?>
	Params: <?php var_dump($match['params']); ?>
	Name: 	<?php var_dump($match['name']); ?>
	POST: 	<?php var_dump($_REQUEST); ?>
</pre>


<h3>Try these requests: </h3>
<p><a href="<?php echo $router->generate('users_index'); ?>">GET <?php echo $router->generate('users_index'); ?></a></p>
<p><a href="<?php echo $router->generate('mod_test', array('module' => 'update')); ?>">GET <?php echo $router->generate('mod_test', array('module' => 'update')); ?></a></p>
<p><a href="<?php echo $router->generate('home'); ?>">GET <?php echo $router->generate('home'); ?></a></p>
<p><a href="<?php echo $router->generate('users_show', array('id' => 5)); ?>">GET <?php echo $router->generate('users_show', array('id' => 5)); ?></a></p>
<p><form action="<?php echo $router->generate('users_do', array('id' => 10, 'action' => 'update')); ?>" method="post">
		<input name="field" id="field" value="caca" type="text"/>
		<button type="submit"><?php echo $router->generate('users_do', array('id' => 10, 'action' => 'update')); ?></button>
	</form></p>

