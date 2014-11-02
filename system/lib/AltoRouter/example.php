<?php

require '../../AltoRouter.php';


function test(){
	echo "zzzzzz";
}


class UserController{
	public static function indexAction(){
		echo "indexAction !!!! <hr> ";
	}

	public static function users_create($id){
		echo "zzzzzz : ".$id;
	}
}

$router = new AltoRouter();
$router->setBasePath('/Web%20Developpement/Test/AltoRouter/examples/basic');
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

}



page($match, $router);

function page($match, $router){
?>
<h1>AltoRouter</h1>

<h3>Current request: </h3>
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


<?php
}
?>
