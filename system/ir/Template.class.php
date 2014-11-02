<?php
/**
 * Maes Jerome
 * Template.class.php, created at Oct 30, 2014
 *
 */

namespace system\ir;

use system\ir\TrashModel;



class Template extends TrashModel{
	
	static $table_name = 'ir_template';
	
	static $attr_accessible = array(
			'id',
			'name', 		// string displayed to Users
			'web_arch', 	// text, the content of the template (website version)
			'mobile_arch',	// idem but for mobile
			'location',		// string, location (directory name) in _DIR_TEMPLATE
			'type',			// string, type of the template
			'is_default'	// boolean, is the template by default
	);
	
}