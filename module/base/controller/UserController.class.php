<?php
/**
 * Maes Jerome
 * UserController.class.php, created at Oct 27, 2014
 *
 */


namespace module\base\controller;
use system\ir\TrashController as TrashController;


class UserController extends TrashController{

	
	/**
	 * @route : /user/[i:id]
	 * @param int $id : the user id
	 */
	public static function userAction($id){
		echo "User Profil Action";
	}

}