<?php
/**
 * Maes Jerome
 * User.class.php, created at Jan 18, 2015
 *
 */


namespace module\web\model;
use system\core\TrashModel as TrashModel;

class User extends TrashModel{

	static $table_name = 'res.user';

	static $_fields = array(
			'test'	=> array('label'=> 'Login', 'type' => 'string', 'length' => 64),
			'test2' => array('label'=> 'Password', 'type' => 'string'),
	);
	
	
	public function test(){
		$str = "BONJour " . $this->login;
		$str .= parent::test();
		return $str;
	}
	


}
