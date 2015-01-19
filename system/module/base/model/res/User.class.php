<?php
/**
 * Maes Jerome
 * User.class.php, created at May 29, 2014
 *
 */

namespace module\base\model\res;
use system\core\TrashModel as TrashModel;

class User extends TrashModel{
	
	static $table_name = 'res.user';
	
	static $_fields = array(
		'login'	=> array('label'=> 'Login', 'type' => 'string', 'length' => 64),
		'password' => array('label'=> 'Password', 'type' => 'string'),
		'name' => array('label'=> 'Nom', 'type' => 'string'),
		'firstname' => array('label'=> 'Prenom', 'type' => 'string'),
		'address' => array('label'=> 'Adresse', 'type' => 'string'),
		'age' => array('label' => 'Age', 'type' => 'integer', 'lenght' => 3),
		'cat' => array('label'=> 'Cat', 'type' => 'selection', 'selection' => array('Label' => 'label', 'Caca' => 'caca', 'Pipi' => 'PIPE')),
		'descr' => array('label'=> 'Descr', 'type' => 'text'),
	);
	
	public function test(){
		echo 'CACA';
		return 'pipi';
	}
	
}
