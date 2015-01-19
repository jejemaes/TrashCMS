<?php
/**
 * Maes Jerome
 * WrongInputException.class.php, created at May 29, 2014
 *
 */
namespace system\exceptions;

class WrongInputException extends Exception{
	
	private $_received;
	private $_shouldbe;
	
	function __construct($message, $recieved, $shouldbe){
		parent::__construct($message);
		$this->_received = $recieved;
		$this->_shouldbe = $shouldbe;
	}
	
	 
}