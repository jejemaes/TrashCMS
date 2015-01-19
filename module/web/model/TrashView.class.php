<?php
/**
 * Maes Jerome
 * TrashView.class.php, created at Jan 18, 2015
 *
 */


namespace module\web\model;
use system\core\TrashModel as TrashModel;

class TrashView extends TrashModel{

	static $table_name = 'ir.view';


	public static function render($view_name, $values=array(), $context=array()){
		if(isset($context['website']) && $context['website']){
			// TODO fetch website informations : menus, ...
			$website_values = array('website' => 'youpieeee', 'website_menu' => array());
			$values = array_merge($website_values, $values);
		}
		return parent::render($view_name, $values, $context);
	}

}