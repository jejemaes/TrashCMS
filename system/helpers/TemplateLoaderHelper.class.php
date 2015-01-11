<?php
/**
 * Maes Jerome
 * TemplateLoaderHelper.class.php.php, created at Jan 7, 2015
 *
 */
namespace system\helpers;

use system\interfaces\iTemplateLoader as iTemplateLoader;
use system\ir\TrashView;

class TemplateLoaderHelper implements iTemplateLoader{
	
	/**
	 * Load the template named 'name', and return its code
	 * @param string $name : the name of the searched template
	 * @return code : the code (content) of the template
	 */
	public function load_template($name){
		$tmp = TrashView::apply_inheritance_arch($name);
		//echo htmlspecialchars($tmp);
		return $tmp;
	}
	
	/**
	 * Store the given template in the database
	 * @param string $name : the name of the template
	 * @param code $content : the content of the template
	*/
	public function add_template($name, $content){
		//TODO
	}
	
	/**
	 * remove (definitively) the given template
	 * @param string $name : the name of the template to remove
	*/
	public function remove_template($name){
		//TODO
	}
}