<?php
/**
 * Maes Jerome
 * dependencies.php, created at Jan 12, 2015
 *
 */

function generatePageTree($datas, $parent = 0, $limit=0){
	if($limit > 1000) return ''; // Make sure not to have an endless recursion
	
	$tree = '<ul>';
	for($i=0, $ni=count($datas); $i < $ni; $i++){
		if($datas[$i]['parent'] == $parent){
			$tree .= '<li>';
			$tree .= $datas[$i]['name'];
			$tree .= generatePageTree($datas, $datas[$i]['id'], $limit++);
			$tree .= '</li>';
		}
	}
	$tree .= '</ul>';
	return $tree;
}

function load_module($list, $module, &$loaded, $limit=0){
	echo '<hr>';
	$module_name = $module->name;
	if(!$list[$module_name]->is_loaded){
		$dependencies = $list[$module_name]->dependencies;
		echo count($dependencies);
		foreach ($dependencies as $dep_name){
			load_module($list, $list[$dep_name],$loaded, $limit++);
		}
		echo '<br> Load ' . $limit . " : " . $module_name;
		$list[$module_name]->is_loaded = true;
		$loaded[] = $module_name;
	}else{
		echo '<br> .... already ' . $module_name;
	}
}




$modules = array(
		'base' => array(),
		'web' => array('base'),
		'website' => array('mail', 'web'),
		'mail' => array(),
		'sale' => array('mail', 'base'),
		'account' => array('web'),
		'stock' => array('sale'),
		'mrp' => array('sale', 'purchase'),
		'test' => array('base'),
		'warehouse' => array('account', 'mrp', 'stock'),
		'purchase' => array('payment'),
		'payment' => array('base', 'account')
);


// build a list of module flags, using pseudo object
$module_list = array();
foreach ($modules as $module_name => $dep){
	$mod = new stdClass();
	$mod->name = $module_name;
	$mod->is_loaded = false;
	$mod->dependencies = $dep;
	$module_list[$module_name] = $mod;
}


$module_loaded = array();
foreach ($module_list as $module){
	load_module($module_list, $module, $module_loaded);
}

print_r($loaded);


foreach ($module_loaded as $module){
	// foreach models_of_module as $class_file
}




