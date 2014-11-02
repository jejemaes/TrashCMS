<?php
/**
 * Maes Jerome
 * User.class.php, created at May 29, 2014
 *
 */



class User extends TrashModel{
	
	static $_model = 'base.user';
	
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
	
}

