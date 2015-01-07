<?php
/**
 * Maes Jerome
 * iTemplateEngine.class.php, created at Jan 2, 2015
 *
 */

interface iTemplateEngine{
	
	/**
	 * Instanciate the template engine
	 * @param iTemplateLoader $loader : the default template loader to use during the rendering phase.
	 */
	public function __construct(iTemplateLoader $loader);
	
	/**
	 * render the asked template with the given values, using the given Loader
	 * @param string $template_name : the name of the template to render
	 * @param array $values : key-array containing the value to render the template with.
	 * @param iTemplateLoader $loader : the loader to use to render the template. By default, it will be the one given to instanciate the Engine.
	 */
	public function render($template_name, $values=array(),iTemplateLoader $loader=FALSE);
	
}