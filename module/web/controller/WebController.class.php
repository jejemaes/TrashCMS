<?php
/**
 * Maes Jerome
 * WebController.class.php, created at Jan 14, 2015
 *
 */

namespace module\web\controller;
use system\core\TrashController as TrashController;

class WebController extends TrashController{
	
	
	public function bundleCssAction($xmlid){
		echo $xmlid;
	}

	public function bundleJsAction($xml_id){
		
	}


}