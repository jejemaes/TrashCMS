<?php
/**
 * Maes Jerome
 * BaseController.class.php, created at Oct 27, 2014
 *
 */

namespace module\base\controller;
use system\core\TrashController as TrashController;
use system\core\TrashView;

class BaseController extends TrashController{
		
	
	public function indexAction(){
		$styles = array('un' , 'deux', 'trois');
		$this->request->render('base.test1', array('caca' => (1 == 1), 'is_class' => FALSE, 'styles' => $styles), array('website' => TRUE));
	}
	
	public function testAction(){
		echo realpath(dirname(__FILE__));
		$filename = realpath(dirname(__FILE__)) . '/../view/web_bundle.xml';
		$filename = str_replace('base', 'web', $filename);
		echo '<hr>'.$filename;
		TrashView::parseFiles(array($filename));
	}
	
	
}