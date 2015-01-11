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
		$styles = array('un' , 'deux', 'trois');
		$this->request->render('base.test1', array('caca' => (1 == 1), 'is_class' => FALSE, 'styles' => $styles));
	}
	
	public static function testAction($id){
		$this->request->render('base.test3');
	}
	
}