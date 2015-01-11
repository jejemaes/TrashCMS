<?php
/**
 * Maes Jerome
 * TemplateEngineHelper.class.php, created at Jan 7, 2015
 *
 */

namespace system\helpers;

use system\interfaces\iTemplateEngine as iTemplateEngine;

class TemplateEngineHelper /*implements iTemplateEngine*/{
	
	public $loader;
	private $_engine;
	
	/**
	 * Instanciate the template engine
	 * @param iTemplateLoader $loader : the default template loader to use during the rendering phase.
	 */
	public function __construct($loader){
		require_once _DIR_LIB .'QWeb/loader.php';
		$this->loader = $loader;
		$this->_engine = new \QWebEngine($loader);
	}
	
	/**
	 * render the asked template with the given values, using the given Loader
	 * @param string $template_name : the name of the template to render
	 * @param array $values : key-array containing the value to render the template with.
	 * @param iTemplateLoader $loader : the loader to use to render the template. By default, it will be the one given to instanciate the Engine.
	*/
	public function render($template_name, $values, $loader=NULL){
		return $this->_engine->render($template_name, $values, $loader);
	}
}