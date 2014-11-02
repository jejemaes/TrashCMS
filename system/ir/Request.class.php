<?php
/**
 * Maes Jerome
 * Request.class.php, created at Oct 30, 2014
 *
 */


namespace system\ir;

use system\ir\TrashView as TrashView;



class Request{
	
	private $_server;
	private $_request;
	
	private $_is_website;
	
	
	public function __construct($is_website = true){
		$this->_server = $_SERVER;
		$this->_request = $_REQUEST;
		
		$this->_is_website = $is_website;
	}
	
	
	/**
	 * render the view with the given values, and return it as a response
	 * @param string $view_name : xml_id of the view, as "module"."view_name".
	 * @param array $values : key-array of values for the view.
	 */
	public function render($view_name, $values=array()){
		$view = TrashView::apply_view_inheritance($view_name);
		if($this->_is_website){
			// TODO add website values (menuitems, ...) to values before rendering
		}
		// TODO render values on $views
		
		$this->make_response('text/html', $view);
	}
	
	
	/**
	 * make response
	 * @param string $header : type of the response (text/html, ....)
	 * @param array $values : key-array
	 */
	public function make_response($header, $values){
		if($header == "text/html"){
			header('Content-type: text/html; charset=utf-8');
			echo $values;
		}
	}
	
}