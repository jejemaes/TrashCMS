<?php
/**
 * Maes Jerome
 * BaseController.class.php, created at Oct 27, 2014
 *
 */

namespace module\base\controller;
use system\ir\TrashController as TrashController;

class BaseController extends TrashController{
		
	public function indexAction(){
		echo '<hr>indexACtion';
		$this->request->render('base.test3');
	}
	
	public static function testAction($id){
		$this->request->render('base.test3');
	}
	
}