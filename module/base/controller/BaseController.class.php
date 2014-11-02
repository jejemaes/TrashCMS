<?php
/**
 * Maes Jerome
 * BaseController.class.php, created at Oct 27, 2014
 *
 */


namespace module\base\controller;
use system\ir\TrashController as TrashController;


class BaseController extends TrashController{
		
	public static function indexAction($id){
		global $request;
		$request->render('base.test1');
	}
	
}